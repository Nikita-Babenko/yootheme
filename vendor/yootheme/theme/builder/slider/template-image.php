<?php

if (!$item['image']) {
    return;
}

// Image
echo $this->el('image', [

    'class' => [
        'el-image',
        'uk-blend-{0}' => $item['media_blend_mode'],
        'uk-transition-{image_transition} uk-transition-opaque' => !($element['slider_width'] && $element['slider_height']),
    ],

    'src' => $item['image'],
    'alt' => $item['image_alt'],
    'width' => $element['image_width'],
    'height' => $element['image_height'],
    'uk-img' => 'target: !.uk-slider-items',
    'uk-cover' => $element['slider_width'] && $element['slider_height'],
    'thumbnail' => true,

])->render($element->props);
