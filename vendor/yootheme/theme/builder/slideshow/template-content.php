<?php

// Title
$title = $this->el($element['title_element'], [

    'class' => [
        'el-title uk-margin',
        'uk-{title_style}',
        'uk-heading-{title_decoration}',
        'uk-text-{!title_color: |background}',
        'uk-margin-remove-adjacent [uk-margin-{meta_margin}-bottom] {@meta_align: bottom}' => $item['meta'],
    ],

    'uk-slideshow-parallax' => $element['parallaxOptions']('title'),
]);

// Meta
$meta = $this->el('div', [

    'class' => [
        'el-meta uk-margin',
        'uk-[text-{@meta_style: meta}]{meta_style}',
        'uk-text-{meta_color}',
        'uk-margin-remove-adjacent [uk-margin-{meta_margin}-bottom] {@meta_align: top}',
    ],

    'uk-slideshow-parallax' => $element['parallaxOptions']('meta'),
]);

// Content
$content = $this->el('div', [

    'class' => [
        'el-content uk-margin',
        'uk-text-{content_style}',
    ],

    'uk-slideshow-parallax' => $element['parallaxOptions']('content'),
]);

// Link
$link = $this->el('a', [

    'class' => [
        'el-link',
        'uk-{link_style: link-(muted|text)}',
        'uk-button uk-button-{!link_style: |link-(muted|text)} [uk-button-{link_size}]',
    ],

    'href' => $item['link'],
    'target' => ['_blank {@link_target}'],
    'uk-scroll' => strpos($item['link'], '#') === 0,

    'uk-slideshow-parallax' => $element['parallaxOptions']('link'),
]);

?>

<?php if ($item['meta'] && $element['meta_align'] == 'top') : ?>
<?= $meta($element->props, $item['meta']) ?>
<?php endif ?>

<?php if ($item['title']) : ?>
<?= $title($element->props) ?>
    <?php if ($element['title_color'] == 'background') : ?>
    <span class="uk-text-background"><?= $item['title'] ?></span>
    <?php elseif ($element['title_decoration'] == 'line') : ?>
    <span><?= $item['title'] ?></span>
    <?php else : ?>
    <?= $item['title'] ?>
    <?php endif ?>
<?= $title->end() ?>
<?php endif ?>

<?php if ($item['meta'] && $element['meta_align'] == 'bottom') : ?>
<?= $meta($element->props, $item['meta'] ?: '') ?>
<?php endif ?>

<?php if ($item['content']) : ?>
<?= $content($element->props, $item['content']) ?>
<?php endif ?>

<?php if ($item['link'] && ($item['link_text'] || $element['link_text'])) : ?>
<p><?= $link($element->props, $item['link_text'] ?: $element['link_text']) ?></p>
<?php endif ?>
