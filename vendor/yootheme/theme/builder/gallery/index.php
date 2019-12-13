<?php

return [

    'name' => 'yootheme/builder-gallery',

    'builder' => 'gallery',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {

        // Deprecated
        if ($element['grid_parallax'] === null && $element['grid_mode'] == 'parallax' && $element['grid_parallax_y']) {
            $element['grid_parallax'] = $element['grid_parallax_y'];
        }
        if ($element['show_hover_image'] === null) {
            $element['show_hover_image'] = $element['show_image2'];
        }
        if ($element['image_box_decoration'] === null && $element['image_box_shadow_bottom'] === true) {
            $element['image_box_decoration'] = 'shadow';
        }
        if ($element['meta_color'] === null && $element['meta_style'] == 'muted') {
            $element['meta_style'] = '';
            $element['meta_color'] = 'muted';
        }

        foreach ($element as $child) {

            // Deprecated
            if ($child['hover_image'] === null) {
                $child['hover_image'] = $child['image2'];
            }

            if (empty($child['image']) && empty($child['hover_image'])) {
                $child['image'] = $this->app->url('@assets/images/element-image-placeholder.png');
            }
        }

        // Filter tags
        $filter = function ($item) {

            $tags = array_filter(array_map('trim', explode(',', $item['tags'])));

            return $item['tags'] = array_combine(array_map(function ($tag) {
                return str_replace(' ', '-', $tag);
            }, $tags), $tags);
        };

        $tags = $element['filter'] ? array_unique(call_user_func_array('array_replace', array_map($filter, $element->children))) : [];
        natsort($tags);
        $element['tags'] = $tags;

        return $this->view->render('@builder/gallery/template', compact('element'));
    },

    'config' => [

        'element' => true,
        'defaults' => [

            'show_title' => true,
            'show_meta' => true,
            'show_content' => true,
            'show_link' => true,
            'show_hover_image' => true,

            'grid_default' => '1',
            'grid_medium' => '3',

            'filter_style' => 'tab',
            'filter_all' => true,
            'filter_position' => 'top',
            'filter_align' => 'left',
            'filter_grid_width' => 'auto',
            'filter_breakpoint' => 'm',

            'overlay_mode' => 'cover',
            'overlay_position' => 'center',
            'overlay_transition' => 'fade',

            'title_element' => 'h3',
            'meta_style' => 'meta',
            'meta_align' => 'bottom',

            'text_align' => 'center',
            'margin' => 'default',

            'item_animation' => '',

        ],

    ],

    'default' => [

        'children' => array_fill(0, 3, [
            'type' => 'gallery_item',
        ]),

    ],

    'include' => [

        'yootheme/builder-gallery-item' => [

            'builder' => 'gallery_item',

        ],

    ],

];
