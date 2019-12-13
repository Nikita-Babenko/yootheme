<?php

// Display
if (!$element['show_image'] || !$item['image']) {
    return;
}

// Image
echo $this->el('image', [

    'class' => [
        'el-image',
        'uk-border-{image_border}',
    ],

    'src' => $item['image'],
    'alt' => $item['image_alt'],
    'width' => $element['image_width'],
    'height' => $element['image_height'],
    'uk-svg' => (bool) $element['image_inline_svg'],
    'thumbnail' => true,

])->render($element->props);
