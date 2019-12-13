<?php

return [

    'name' => 'yootheme/builder-map',

    'builder' => 'map',

    'inject' => [

        'view' => 'app.view',
        'styles' => 'app.styles',
        'scripts' => 'app.scripts',

    ],

    'render' => function ($element) {

        // Deprecated
        if ($element['width_breakpoint'] === null && $element['width_max'] === false) {
            $element['width_breakpoint'] = true;
        }

        $center = [];
        $markers = [];

        foreach ($element as $marker) {

            if ($marker['hide'] || !$marker['location']) {
                continue;
            }

            list($lat, $lng) = explode(',', $marker['location']);

            if (empty($center)) {
                $center = ['lat' => (float) $lat, 'lng' => (float) $lng];
            }

            $markers[] = [
                'lat' => (float) $lat,
                'lng' => (float) $lng,
                'title' => $marker['title'],
                'content' => $this->view->render('@builder/map/template-marker', compact('element', 'marker')),
                'show_popup' => !empty($marker['show_popup']),
            ];
        }

        $options = $element->pick(['type', 'zoom', 'zooming', 'dragging', 'controls', 'styler_invert_lightness', 'styler_hue', 'styler_saturation', 'styler_lightness', 'styler_gamma', 'popup_max_width'])->filter(function ($value) { return isset($value); });
        $options['center'] = $center ?: ['lat' => 53.5503, 'lng' => 10.0006];
        $options['markers'] = $markers;
        $options['lazyload'] = $this->theme->get('lazyload');

        // add scripts, styles
        $leaflet = 'https://cdn.jsdelivr.net/npm/leaflet@1.3.4/dist';

        if ($key = $this->theme->get('google_maps')) {
            $this->scripts->add('google-api', 'https://www.google.com/jsapi', [], ['defer' => true]);
            $this->scripts->add('google-maps', "var \$google_maps = '{$key}';", [], ['defer' => true, 'type' => 'string']);
        } else {
            $this->styles->add('leaflet', "{$leaflet}/leaflet.css", [], ['defer' => true]);
            $this->scripts->add('leaflet', "{$leaflet}/leaflet.js", [], ['defer' => true]);
        }

        $this->scripts->add('builder-map', '@builder/map/app/map.min.js', [], ['defer' => true]);

        return $this->view->render('@builder/map/template', compact('element', 'options'));
    },

    'config' => [

        'element' => true,
        'defaults' => [

            'show_title' => true,
            'type' => 'roadmap',
            'zoom' => 10,
            'controls' => true,
            'zooming' => false,
            'dragging' => false,

        ],

    ],

    'include' => [

        'yootheme/builder-map-marker' => [

            'builder' => 'map_marker',

        ],

    ],

];
