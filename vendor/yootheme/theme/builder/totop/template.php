<?php

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

// Link
$link = $this->el('a', [
    'href' => '#',
    'title' => ['{link_title}'],
    'uk-totop' => true,
    'uk-scroll' => true,
]);

echo $el($element->props, $element['attrs'], $link($element->props, ''));
