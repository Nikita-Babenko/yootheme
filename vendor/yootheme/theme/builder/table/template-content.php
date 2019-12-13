<?php

if (!$item['content']) {
    return;
}

// Content
$el = $this->el('div', [
    'class' => [
        'el-content',
        'uk-text-{content_style}',
    ],
]);

echo $el($element->props, $item['content']);
