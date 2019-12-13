<?php

return [

    'name' => 'yootheme/builder-panel',

    'builder' => 'panel',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {

        // Deprecated
        if ($element['image_box_decoration'] === null && $element['image_box_shadow_bottom'] === true) {
            $element['image_box_decoration'] = 'shadow';
        }
        if ($element['meta_color'] === null && $element['meta_style'] == 'muted') {
            $element['meta_style'] = '';
            $element['meta_color'] = 'muted';
        }

        return $this->view->render('@builder/panel/template', compact('element'));
    },

    'config' => [

        'element' => true,
        'defaults' => [

            'link_text' => 'Read more',

            'title_element' => 'h3',
            'meta_style' => 'meta',
            'meta_align' => 'bottom',
            'icon_ratio' => 4,
            'image_align' => 'top',
            'image_grid_width' => '1-2',
            'image_breakpoint' => 'm',
            'link_style' => 'default',

            'margin' => 'default',

        ],

    ],

    'default' => [

        'props' => [
            'title' => 'Panel',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        ],

    ],

];
