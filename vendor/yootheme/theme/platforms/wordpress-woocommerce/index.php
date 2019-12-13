<?php

use YOOtheme\Util\File;

$config = [

    'name' => 'yootheme/wordpress-woocommerce',

    'inject' => [

        'styler' => 'yootheme/styler.config',

    ],

    'events' => [

        'theme.init' => function () {

            include_once ABSPATH.'wp-admin/includes/plugin.php';

            // ignore files from being compiled into theme.css
            if (!is_plugin_active('woocommerce/woocommerce.php')) {
                $this->styler->merge(['ignore_less' => ['woocommerce.less']]);
            }

        },

        'theme.site' => function () {

            // remove woocommerce general style
            add_filter('woocommerce_enqueue_styles', function ($styles) {
                unset($styles['woocommerce-general']);
                return $styles;
            });

            // with woocommerce 3.3.x, setting is available in the WP customizer
            add_filter('loop_shop_per_page', function ($items) {
                return $this->theme->get('woocommerce.items') ?: $items;
            }, 20);
        },

        'theme.admin' => function ($theme) {

            // check if theme css needs to be updated
            $style = new File("@theme/css/theme{.{$theme->id},}.css");
            $compiled = strpos($style->getContents(), '.woocommerce');

            if (is_plugin_active('woocommerce/woocommerce.php') xor $compiled) {
                $this->styler->set('section.update', true);
            }

        },

    ],

];

return defined('WPINC') ? $config : false;
