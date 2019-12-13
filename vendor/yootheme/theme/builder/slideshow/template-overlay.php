<?php

// Overlay
$overlay = $this->el('div', [
    'class' => [
        'el-overlay',
        'uk-flex-1 {@overlay_position: top|bottom}',
        'uk-panel {@!overlay_style}',
        'uk-overlay uk-{overlay_style}',
        'uk-padding-{overlay_padding} {@overlay_style}',
        'uk-width-{overlay_width} {@!overlay_position: top|bottom}',

        // Animation
        'uk-transition-{overlay_animation} {@!overlay_animation: |parallax}',
    ],

    'uk-slideshow-parallax' => $element['parallaxOptions']('overlay'),
]);

// Text Color
if (!$element['overlay_style']) {
    $overlay->attr('class', ['uk-{0}' => $item['text_color'] ?: $element['text_color']]);
}

echo $overlay($element->props);
