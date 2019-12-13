<?php

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

// Icon
$icon = $this->el('span', [

    'class' => [
        'uk-text-{icon_color} {@!link}',
    ],

    'uk-icon' => [
        'icon: {icon};',
        'ratio: {icon_ratio}; {@!link_style: button}',
    ],

], '');

// Link
$link = [

    'class' => [
        'uk-icon-link {@!link_style}',
        'uk-icon-button {@link_style: button}',
        'uk-link-{link_style: muted|text|reset}',
    ],

    'href' => ['{link}'],
    'target' => ['_blank {@link_target}'],
    'uk-scroll' => strpos($element['link'], '#') === 0,

];

echo $el($element->props, $element['attrs'], $element['link'] ? $icon($element->props, $link, '', 'a') : $icon($element->props));
