<?php

if (!$item['content']) {
    return;
}

// Content
$content = $this->el('div', [

    'class' => [
        'el-content',
        'uk-text-{content_style}',
    ],

]);

// Link
$link = $this->el('a', [
    'class' => [
        'uk-link-{0}' => $element['link_style'],
    ],
    'href' => ['{link}'],
    'target' => ['_blank {@link_target}'],
    'uk-scroll' => strpos($item['link'], '#') === 0,
]);

echo $content($element->props, $item['link'] ? $link($item->props, $item['content']) : $item['content']);
