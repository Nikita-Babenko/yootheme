<?php

$config = [

    'name' => 'yootheme/wordpress-posts',

    'events' => [

        'theme.init' => function ($theme) {

            add_action('admin_enqueue_scripts', function ($hook) {

                // is edit page?
                if (!in_array($hook, ['post.php', 'post-new.php']) || empty($post = get_post()) || $post->post_type != 'page') {
                    return;
                }

                $url = get_template_directory_uri();
                $link = add_query_arg(['url' => urlencode(get_permalink($post->ID)), 'autofocus[section]' => 'builder'], wp_customize_url());

                // redirect to customizer?
                if ($hook == 'post-new.php' && isset($_GET['yootheme-builder'])) {
                    wp_redirect($link); exit;
                }

                add_action('edit_form_after_title', function ($post) use ($link) {
                    printf('<div class="tm-editor" hidden><a href="%s" class="tm-button">%s</a><a href class="tm-link">%s</a></div>', $link, __('YOOtheme Builder', 'yootheme'), __('&#8592; Back to Classic Editor', 'yootheme'));
                });

                add_action('media_buttons_context', function ($context) use ($link) {
                    return $context.sprintf('<a href="%s" class="button button-primary">%s</a>', $link, __('YOOtheme Builder', 'yootheme'));
                });

                add_filter('wp_editor_settings', function ($settings) use ($post) {

                    if (preg_match('/<!--\s?\{/', ($post->post_content))) {
                        $settings['default_editor'] = 'html';
                    }

                    return $settings;
                });

                printf('<script>var $customizer = %s;</script>', json_encode(compact('link')));
                wp_enqueue_script('posts-builder', "{$url}/vendor/yootheme/theme/platforms/wordpress-posts/app/posts.min.js", [], false, true);
            });

            add_action('customize_controls_init', function () {

                global $wp_customize;

                $url = $wp_customize->get_preview_url();
                $post = get_post(url_to_postid($url));

                // is auto-draft?
                if ($post && $post->post_status == 'auto-draft') {

                    // update post
                    wp_update_post([
                        'ID' => $post->ID,
                        'post_status' => 'draft',
                        'post_title' => __('Draft')." #{$post->ID}",
                    ], true);

                    // update return url
                    $wp_customize->set_return_url(get_edit_post_link($post->ID));
                }

            });

            add_filter('display_post_states', function ($post_states, $post) {

                // is builder?
                if ($post->builder = preg_match('/<!--\s?\{/', $post->post_content)) {

                    // remove gutenberg?
                    $key = array_search('Gutenberg', $post_states);

                    if ($key !== false) {
                        unset($post_states[$key]);
                    }

                    $post_states['yootheme'] = __('YOOtheme', 'yootheme');
                }

                return $post_states;

            }, 15, 2);

            add_filter('page_row_actions', function ($actions, $post) {

                // is builder?
                if (!empty($post->builder)) {

                    $link = add_query_arg(['url' => urlencode(get_permalink($post->ID)), 'autofocus[section]' => 'builder'], wp_customize_url());
                    $actions['yootheme'] = sprintf('<a href="%s" class="tm-button">%s</a>', $link, __('YOOtheme Builder', 'yootheme'));

                    // remove classic?
                    unset($actions['classic']);
                }

                return $actions;

            }, 15, 2);

            add_filter('use_block_editor_for_post_type', $filter = function () {

                $post = get_post();
                $screen = get_current_screen();

                return $screen->base != 'post' || !preg_match('/<!--\s?\{/', ($post->post_content));
            });

            // for Wordpress < 5 beta, Gutenberg < 4.1
            add_filter('gutenberg_can_edit_post_type', $filter);

        },

    ],

];

return defined('WPINC') ? $config : false;
