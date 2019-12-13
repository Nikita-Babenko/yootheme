<?php

// Title
$title = $this->el($element['title_element'], [

    'class' => [
        'el-title',
        'uk-margin',
        'uk-{title_style}',
        'uk-card-title {@panel_style} {@!title_style}',
        'uk-heading-{title_decoration}',
        'uk-text-{!title_color: |background}',
        'uk-margin-remove-adjacent [uk-margin-{meta_margin}-bottom] {@meta_align: bottom}' => $element['meta'],
    ],

]);

// Meta
$meta = $this->el('div', [

    'class' => [
        'el-meta',
        'uk-margin',
        'uk-[text-{@meta_style: meta}]{meta_style}',
        'uk-text-{meta_color}',
        'uk-margin-remove-adjacent [uk-margin-{meta_margin}-bottom] {@meta_align: top}',
    ],

]);

// Content
$content = $this->el('div', [

    'class' => [
        'el-content',
        'uk-margin',
        'uk-text-{content_style}',
    ],

]);

?>

<?php if ($element['meta'] && $element['meta_align'] == 'top') : ?>
<?= $meta($element->props, $element['meta']) ?>
<?php endif ?>

<?php if ($element['title']) : ?>
<?= $title($element->props) ?>
    <?php if ($element['title_color'] == 'background') : ?>
    <span class="uk-text-background"><?= $element['title'] ?></span>
    <?php elseif ($element['title_decoration'] == 'line') : ?>
    <span><?= $element['title'] ?></span>
    <?php else : ?>
    <?= $element['title'] ?>
    <?php endif ?>
<?= $title->end() ?>
<?php endif ?>

<?php if ($element['meta'] && $element['meta_align'] == 'bottom') : ?>
<?= $meta($element->props, $element['meta']) ?>
<?php endif ?>

<?php if ($element['image_align'] == 'between') : ?>
<?= $element['image'] ?>
<?php endif ?>

<?php if ($element['content']) : ?>
<?= $content($element->props, $element) ?>
<?php endif ?>

<?php if ($element['link'] && $element['link_style'] != 'panel' && $element['link_text']) : ?>
<p><?= $link($element->props, $element['link_text']) ?></p>
<?php endif ?>
