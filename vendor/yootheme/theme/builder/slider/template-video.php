<?php

if (!$item['video'] || $item['image']) {
    return;
}

$hasWidthAndHeight = $element['slider_width'] && $element['slider_height'];

$attrs = [

    'class' => [

        'el-image',

        // Blend mode
        'uk-blend-{0}' => $item['media_blend_mode'],

        'uk-transition-{image_transition} uk-transition-opaque' => !$hasWidthAndHeight,

    ],

    'width' => $element['image_width'],
    'height' => $element['image_height'],

    'uk-cover' => $hasWidthAndHeight,
    'uk-video' => ['automute: true' => !$hasWidthAndHeight],

];

if ($iframe = $this->iframeVideo($item['video'])) {

    $video = $this->el('iframe', [

        'class' => ['uk-disabled'],
        'src' => $iframe,
        'frameborder' => '0',
        'allowfullscreen' => true,
        'uk-responsive' => !$hasWidthAndHeight,

    ]);

    echo $video($element->props, $attrs, '');

} elseif ($item['video']) {

    $video = $this->el('video', [

        'src' => $item['video'],
        'controls' => false,
        'loop' => true,
        'autoplay' => true,
        'muted' => true,
        'playsinline' => true,

    ]);

    echo $video($element->props, $attrs, '');
}
