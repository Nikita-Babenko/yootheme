<?php

if (!$item['content']) {
    return;
}

// Content
echo $this->el('div', [

    'class' => [
        'el-content uk-margin',
        'uk-text-{content_style}',
    ],

])->render($element->props, $item['content']);
