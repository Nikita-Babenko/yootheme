<?php

namespace YOOtheme\Theme;

use YOOtheme\EventSubscriberInterface;
use YOOtheme\Module;
use YOOtheme\Theme\Wordpress\Breadcrumbs;
use YOOtheme\Theme\Wordpress\ChildThemeListener;
use YOOtheme\Theme\Wordpress\ContentListener;
use YOOtheme\Theme\Wordpress\CustomizerListener;
use YOOtheme\Theme\Wordpress\SystemCheck;
use YOOtheme\Theme\Wordpress\UpgradeListener;
use YOOtheme\Theme\Wordpress\UrlListener;
use YOOtheme\Util\Collection;
use YOOtheme\Util\Str;

class Wordpress extends Module implements EventSubscriberInterface
{
    /**
     * Query information.
     *
     * @var string[]
     */
    public $query;

    /**
     * {@inheritdoc}
     */
    public function __invoke($app)
    {
        $app->subscribe(new ChildThemeListener())
            ->subscribe(new ContentListener())
            ->subscribe(new CustomizerListener())
            ->subscribe(new UrlListener())
            ->subscribe(new UpgradeListener());

        $app->locator->addPath("{$this->path}/assets", 'assets');

        $app['systemcheck'] = function () {
            return new SystemCheck();
        };

        $app['trans'] = $app->protect(function ($id) {
            return __($id, 'yootheme');
        });
    }

    public function onInit()
    {
        $config = get_theme_mod('config', '{}');
        $config = json_decode($config, true);

        // Deprecated Blog settings
        if (!empty($config) && !isset($config['post']['image_margin'])) {

            $config = new Collection($config);

            if ($config->get('post.meta_align') == 'top') {
                $config->set('post.meta_margin', $config->get('post.image_align') == 'top' ? 'large' : 'medium');
            }

            if ($config->get('post.meta_align') == 'bottom') {
                $config->set('post.title_margin', $config->get('post.image_align') == 'top' ? 'large' : 'medium');
            }

            if ($config->get('post.content_width') === true) {
                $config->set('post.content_width', 'small');
            }

            if ($config->get('post.content_width') === false) {
                $config->set('post.content_width', '');
            }

            if ($config->get('post.header_align') === true) {
                $config->set('blog.header_align', 1);
            }

        }

        // set defaults
        $this->theme->merge($this->config['defaults'], true);
        $this->theme->merge($config, true);

        $this->url->addResolver(function ($path, $parameters, $secure, $next) {

            $uri = $next($path, $parameters, $secure, $next);

            if (Str::startsWith($uri->getQueryParam('p'), 'theme/') && $this->theme->customizer->isActive()) {

                $query = $uri->getQueryParams();
                $query['wp_customize'] = 'on';

                $uri = $uri->withQueryParams($query);
            }

            return $uri;
        });

        if (!$this->admin) {
            $this->app->trigger('theme.site', [$this->theme]);
        } elseif ($this->customizer->isActive()) {
            $this->app->trigger('theme.admin', [$this->theme]);
        }

        add_filter('upload_mimes', function ($mimes) {

            $mimes['svg|svgz'] = 'image/svg+xml';

            return $mimes;
        });

        add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {

            if (empty($data['type']) && substr($filename, -4) === '.svg') {
                $data['ext'] = 'svg';
                $data['type'] = 'image/svg+xml';
            }

            return $data;

        }, 10, 4);

    }

    public function onSite($theme)
    {
        $theme
            ->set('direction', is_rtl() ? 'rtl' : 'lrt')
            ->set('site_url', rtrim(get_bloginfo('url'), '/'))
            ->set('page_class', ''); // TODO: implement page class builder

        if ($theme->get('disable_wpautop')) {
            remove_filter('the_content', 'wpautop');
            remove_filter('the_excerpt', 'wpautop');
        }

        add_filter('wp_title', function ($title, $sep) {

            if (is_feed()) {
                return $title;
            }

            // add the site name.
            $title .= get_bloginfo('name', 'display');

            // add the site description for the home/front page.
            $site_description = get_bloginfo('description', 'display');
            if ($site_description && (is_home() || is_front_page())) {
                $title = "$title $sep $site_description";
            }

            return $title;
        }, 10, 2);

        $this->sections->add('breadcrumbs', function () {
            return $this->view->render('breadcrumbs', ['items' => Breadcrumbs::getItems()]);
        });

        $this->builder->addRenderer(function ($element, $type, $next) {
            return do_shortcode($next($element, $type));
        });
    }

    public function onContent($obj)
    {
        if (!$this->sections->exists('builder') && isset($obj->content)) {
            $this->sections->set('builder', function () use ($obj) {
                $result = $this->builder->render($obj->content, 'page');
                $this->app->trigger('content', [$result]);
                return $result;
            });
        }

        $this->theme->set('builder', $this->sections->exists('builder'));
    }

    public static function getSubscribedEvents()
    {
        return [
            'theme.init' => ['onInit', -5],
            'theme.site' => ['onSite', 10],
            'content.prepare' => 'onContent',
        ];
    }
}
