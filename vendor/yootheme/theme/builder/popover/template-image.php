<?php

if (!$item['image']) {
    return;
}

echo $this->el('image', [

    'class' => [
        'el-image',
        'uk-margin-auto',
        'uk-display-block',
        'uk-border-{image_border} {@!image_card}',
    ],

    'src' => $item['image'],
    'alt' => $item['image_alt'],
    'width' => $element['image_width'],
    'height' => $element['image_height'],
    'uk-svg' => (bool) $element['image_inline_svg'],
    'thumbnail' => true,

])->render($element->props);
