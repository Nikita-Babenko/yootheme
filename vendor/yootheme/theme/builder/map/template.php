<?php

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

$el->attr([

    'class' => [
        'uk-position-relative',
        'uk-position-z-index',
    ],

    'style' => [
        'width: {width}px {@!width_breakpoint}',
        'height: {height}px {@!width}',
    ],

    'uk-responsive' => [
        'width: {width}; height: {height}'
    ],

    'uk-map' => json_encode([
        'map' => $options
    ]),

]);

// Width and Height
$element['width'] = trim($element['width'], 'px');
$element['height'] = trim($element['height'] ?: '300', 'px');

?>

<?= $el($element->props, $element['attrs'], '') ?>
