<?php

if (!$element['image'] && !$element['hover_image']) {
    return;
}

$image = $this->el('image', [
    'src' => $element['image'],
    'alt' => $element['image_alt'],
    'class' => ['el-image'],
    'uk-cover' => (bool) $element['image_min_height'],
    'uk-img' => true,
    'uk-gif' => $this->isImage($element['image']) == 'gif',
    'thumbnail' => [$element['image_width'], $element['image_height']],
    'width' => $element['image_width'],
    'height' => $element['image_height'],
]);

// Transition
$container_image = false;
$container_hover_image = false;
$transition = 'uk-transition-'.($element['image_transition'] ?: 'fade');

if ($element['hover_image'] && !$element['image']) {

    $image->attr('src', $element['image'] = $element['hover_image']);
    $element['hover_image'] = '';

    if ($element['image_min_height']) {
        $container_image = $transition;
    } else {
        $image->attr('class', [$transition]);
    }

} elseif ($element['hover_image']) {

    $container_hover_image = $transition;

} elseif ($element['image_transition']) {

    $transition = "uk-transition-opaque uk-transition-{$element['image_transition']}";
    if ($element['image_min_height']) {
        $container_image = $transition;
    } else {
        $image->attr('class', [$transition]);
    }

}

// Placeholder and min height
$placeholder = '';
if ($element['image_min_height']) {

    $width = $element['image_width'];
    $height = $element['image_height'];

    if (!$width || !$height) {
        if ($placeholder = $app['image']->create($element['image'], false)) {
            if ($width || $height) {
                $placeholder = $placeholder->thumbnail($width, $height);
            }
            $width = $placeholder->getWidth();
            $height = $placeholder->getHeight();
        }
    }

    if ($width && $height) {
        echo "<canvas width=\"{$width}\" height=\"{$height}\"></canvas>";
    }

}

// Image
$element['image'] = $image($element->props);

if ($container_image) {
    $element['image'] = "<div class=\"uk-position-cover {$container_image}\">{$element['image']}</div>";
}

echo $element['image'];

// Hover Image
if ($element['hover_image']) {

    $element['hover_image'] = $this->el('image', [
        'src' => $element['hover_image'],
        'class' => 'el-hover-image',
        'alt' => true,
        'uk-cover' => true,
        'uk-img' => true,
        'thumbnail' => [$element['image_width'], $element['image_height']],
        'width' => $element['image_width'],
        'height' => $element['image_height'],
    ])->render();

    if ($container_hover_image) {
        $element['hover_image'] = "<div class=\"uk-position-cover {$container_hover_image}\">{$element['hover_image']}</div>";
    }

    echo $element['hover_image'];

}
