<?php

return [

    'name' => 'yootheme/builder-column',

    'builder' => 'column',

    'inject' => [

        'view' => 'app.view',

    ],

    'render' => function ($element) {

        // Deprecated
        if ($element['vertical_align'] === null && $element->parent['vertical_align'] === true) {
            $element['vertical_align'] = 'middle';
        }

        // Deprecated
        if (!$element['widths']) {
            $element['widths'] = array_map(function ($widths) use ($element) {
                return explode(',', $widths)[$element->index];
            }, explode('|', $element->parent['layout']));
        }

        return $this->view->render('@builder/column/template', compact('element'));
    },

    'config' => [

        'defaults' => [

            'image_position' => 'center-center',

        ],

    ],

];
