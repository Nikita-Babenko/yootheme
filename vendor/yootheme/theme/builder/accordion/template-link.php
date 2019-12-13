<?php

if (!$element['show_link'] || !$item['link'] || !$element['link_text']) {
    return;
}

// Link
$link = $this->el('a', [

    'class' => [
        'el-link',
        'uk-{link_style: link-\w+}',
        'uk-button uk-button-{!link_style: |link-\w+} [uk-button-{link_size}]',
    ],

    'href' => $item['link'],
    'target' => ['_blank {@link_target}'],
    'uk-scroll' => strpos($item['link'], '#') === 0,
]);

?>

<p><?= $link($element->props, $element['link_text']) ?></p>
