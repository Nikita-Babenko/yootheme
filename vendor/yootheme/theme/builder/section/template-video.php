<?php

// Video
if (!$element['video']) {
    return;
}

$attrs_video = [

    'class' => ['uk-blend-{media_blend_mode}'],
    'uk-cover' => true,
    'width' => ['{video_width}'],
    'height' => ['{video_height}'],

];

if ($iframe = $this->iframeVideo($element['video'])) {

    $attrs_video += [
        'src' => $iframe,
        'frameborder' => '0',
        'allowfullscreen' => true,
    ];

    echo $this->el('iframe', $attrs_video)->render($element->props, '');

} elseif ($element['video']) {

    $attrs_video += [
        'src' => $element['video'],
        'controls' => false,
        'loop' => true,
        'autoplay' => true,
        'muted' => true,
        'playsinline' => true,
    ];

    echo $this->el('video', $attrs_video)->render($element->props, '');
}
