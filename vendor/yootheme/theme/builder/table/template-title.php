<?php

if (!$item['title']) {
    return;
}

// Title
$el = $this->el('div', [
    'class' => [
        'el-title',
        'uk-{title_style}',
        'uk-text-{!title_color: |background}',
    ],
]);

if ($element['title_color'] === 'background') {
    $item['title'] = "<span class=\"uk-text-background\">{$item['title']}</span>";
}

echo $el($element->props, $item['title']);
