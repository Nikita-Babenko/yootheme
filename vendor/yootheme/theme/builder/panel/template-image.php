<?php

// Image
if ($element['image']) {

    $image = $this->el('image', [

        'class' => [
            'el-image',
            'uk-border-{image_border} {@!panel_style}',
            'uk-box-shadow-{image_box_shadow} {@!panel_style}',
            'uk-box-shadow-hover-{image_hover_box_shadow} {@!panel_style} {@link_style: panel}' => $element['link'],
        ],

        'src' => $element['image'],
        'alt' => $element['image_alt'],
        'width' => $element['image_width'],
        'height' => $element['image_height'],
        'uk-svg' => (bool) $element['image_inline_svg'],
        'uk-cover' => $element['panel_style'] && $element['image_card'] && in_array($element['image_align'], ['left', 'right']),
        'thumbnail' => true,
    ]);

    echo $image($element->props, []);

    // Placeholder image if card and layout left or right
    if ($image->attrs['uk-cover']) {
        echo $image($element->props, [
            'class' => ['uk-invisible'],
            'uk-cover' => false,
        ]);
    }

// Icon
} elseif ($element['icon']) {

    $icon = $this->el('span', [

        'class' => [
            'el-image',
            'uk-text-{icon_color}',
        ],

        'uk-icon' => [
            'icon: {0};' => $element['icon'],
            'ratio: {icon_ratio};',
        ],

    ]);

    echo $icon($element->props, '');

}
