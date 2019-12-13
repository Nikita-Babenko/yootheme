<?php

if (!$item['image']) {
    return;
}

$image = $this->el('image', [

    'class' => [
        'el-image',
        'uk-border-{image_border}',
        'uk-box-shadow-{image_box_shadow}',
        'uk-box-shadow-hover-{image_hover_box_shadow} {@link}',
    ],

    'src' => $item['image'],
    'alt' => $item['image_alt'],
    'width' => $element['image_width'],
    'height' => $element['image_height'],
    'uk-svg' => (bool) $element['image_inline_svg'],
    'thumbnail' => true,
]);

$item['image'] = $image($element->props);

// Box decoration
if ($element['image_box_decoration']) {

    $decoration = $this->el('div', [

        'class' => [
            'uk-box-shadow-bottom {@image_box_decoration: shadow}',
            'tm-mask-default {@image_box_decoration: mask}',
            'tm-box-decoration-{image_box_decoration: default|primary|secondary}',
            'tm-box-decoration-inverse {@image_box_decoration_inverse} {@image_box_decoration: default|primary|secondary}',
            'uk-inline {@!image_box_decoration: |shadow}',
        ],

    ]);

    $item['image'] = $decoration($element->props, $item['image']);
}

echo $item['image'];
