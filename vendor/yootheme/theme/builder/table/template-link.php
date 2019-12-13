<?php

$item['link_text'] = $item['link_text'] ?: $element['link_text'];

if (!$item['link'] || !$item['link_text']) {
    return;
}

// Link
$el = $this->el('a', [
    'class' => [
        'el-link',
        'uk-{link_style: link-\w+}',
        'uk-button uk-button-{!link_style: |link-\w+} [uk-button-{link_size}]',
        '{0} {@!link_style: |text|link-\w+} {@link_fullwidth}' => $element['table_responsive'] == 'responsive' ? 'uk-width-auto uk-width-1-1@m' : 'uk-width-1-1',
    ],

    'href' => $item['link'],
    'target' => ['_blank {@link_target}'],
    'uk-scroll' => strpos($item['link'], '#') === 0,
]);

echo $el($element->props, $item['link_text']);
