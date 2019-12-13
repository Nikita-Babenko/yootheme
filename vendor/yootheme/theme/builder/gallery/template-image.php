<?php

// Image
$image = $this->el('image', [
    'class' => ['el-image'],
    'src' => $item['image'] ?: $item['hover_image'],
    'alt' => $item['image_alt'],
    'width' => $element['image_width'],
    'height' => $element['image_height'],
    'uk-cover' => (bool) $element['image_min_height'],
    'thumbnail' => [$element['image_width'], $element['image_height'], $element['image_orientation']],
]);

// Hover Image
$image_hover = $item['image'] && $item['hover_image'] ? $this->el('image', [
    'class' => ['el-hover-image'],
    'src' => $item['hover_image'],
    'width' => $element['image_width'],
    'height' => $element['image_height'],
    'uk-cover' => true,
    'thumbnail' => [$element['image_width'], $element['image_height'], $element['image_orientation']],
]) : null;

// Container
$container = $this->el('div', [
    'class' => ['uk-position-cover'],
]);

// Transition
if (!$element['image_transition'] && $item['hover_image']) {
    $element['image_transition'] = 'fade';
}

$transition = $this->expr([
    'uk-transition-{image_transition}' => !$item['image'] && $item['hover_image'],
    'uk-transition-{image_transition} uk-transition-opaque' => $item['image'] && !$item['hover_image'],
], $element->props);

// Placeholder and min height
$placeholder = '';
if ($element['image_min_height']) {

    $width = $element['image_width'];
    $height = $element['image_height'];

    if ((!$width || !$height) and $placeholder = $app['image']->create($item['image'], false)) {

        if ($width || $height) {
            $placeholder = $placeholder->thumbnail($width, $height);
        }

        $width = $placeholder->getWidth();
        $height = $placeholder->getHeight();
    }

    if ($width && $height) {
        $placeholder = "<canvas width=\"{$width}\" height=\"{$height}\"></canvas>";
    }

    echo $placeholder.($transition ? $container($element->props, ['class' => [$transition]], $image($element->props)) : $image($element->props));

} else {
    echo $image($element->props, ['class' => [$transition]]);
}

if ($image_hover) {
    echo $container($element->props, ['class' => ['uk-transition-{image_transition}']], $image_hover($element->props));
}
