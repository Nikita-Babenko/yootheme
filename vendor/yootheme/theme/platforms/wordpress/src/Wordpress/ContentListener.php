<?php

namespace YOOtheme\Theme\Wordpress;

use YOOtheme\EventSubscriber;
use YOOtheme\Theme\Builder;

class ContentListener extends EventSubscriber
{
    const PATTERN = '/<!--\s?(\{(?:.*?)\})\s?-->/';

    public $inject = [
        'admin' => 'app.admin',
        'routes' => 'app.routes',
        'customizer' => 'theme.customizer',
    ];

    public function onInit($theme)
    {
        if ($this->admin) {
            $this->routes->post('/page', [$this, 'savePage']);
        }
    }

    public function onSite($theme)
    {
        add_action('wp', function () {

            if (is_page()) {
                $this->app->trigger('content.prepare', [get_queried_object()]);
            }

        });
    }

    public function onContent($obj)
    {
        $obj->content = !post_password_required($obj) && isset($obj->post_content) && strpos($obj->post_content, '<!--') !== false && preg_match(self::PATTERN, $obj->post_content, $matches) ? json_decode($matches[1], true) : null;

        if (!$this->customizer->isActive()) {
            return;
        }

        $modified_date = isset($obj->post_modified) ? $this->toDate($obj->post_modified) : null;

        if ($page = get_theme_mod('page')) {
            if ($obj->ID === $page['id']) {
                $obj->content = $page['content'];
                $modified_date = $page['modified_date'];
            } else {
                unset($page);
            }
        }

        if ($obj->content) {
            $obj->content = Builder::encode($obj->content, false);
        }

        $modified = !empty($page);
        $collision = $modified ? $this->getCollision($page, $obj) : false;

        $data = [
            'id' => $obj->ID,
            'title' => $obj->post_title,
            'content' => $obj->content,
            'collision' => $collision,
            'modified' => $modified,
            'modified_date' => $modified_date,
        ];

        $this->customizer->addData('page', $data);
    }

    public function savePage($page, $overwrite = false, $response)
    {
        if (!$page or !$page = base64_decode($page) or !$page = json_decode($page, true)) {
            $this->app->abort(500, 'Something went wrong.');
        }

        if (!current_user_can('edit_post', $page['id'])) {
            $this->app->abort(403, 'Insufficient User Rights.');
        }

        if (!$overwrite and $collision = $this->getCollision($page, get_post($page['id']))) {
            return $response->withJSON(compact('collision'));
        }

        $updated = wp_update_post([
            'ID' => $page['id'],
            'post_content' => wp_slash(Builder::content($page['content']).'<!-- '.Builder::encode($page['content']).' -->'),
        ], true) and update_post_meta($page['id'], '_edit_last', get_current_user_id());

        if (is_wp_error($updated)) {
            $this->app->abort(500, 'Something went wrong.');
        }

        return $response->withJSON(['modified_date' => $this->toDate(get_post_field('post_modified', $updated))]);
    }

    protected function getCollision($page, $post)
    {
        $author = $this->getModifiedAuthor($post);
        if ($author and $author->ID != get_current_user_id() and $page['modified_date'] < ($modified_date = $this->toDate($post->post_modified))) {
            $modified_by = $author->data->display_name;
            return compact('modified_by', 'modified_date');
        }

        return false;
    }

    protected function toDate($date) {
        return date(DATE_W3C, strtotime($date));
    }

    protected function getModifiedAuthor($post)
    {
        $userId = get_post_meta($post->ID, '_edit_last', true) or
        $revs = wp_get_post_revisions($post->ID) and $lastRev = end($revs) and $userId = $lastRev->post_author;

        return get_userdata($userId);
    }

    public static function getSubscribedEvents()
    {
        return [
            'theme.init' => 'onInit',
            'theme.site' => 'onSite',
            'content.prepare' => ['onContent', 10],
        ];
    }
}
