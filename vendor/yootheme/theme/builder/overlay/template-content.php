<?php

// Title
$title = $this->el($element['title_element'], [

    'class' => [
        'el-title uk-margin',
        'uk-{title_style}',
        'uk-heading-{title_decoration}',
        'uk-text-{title_color} {@!title_color: background}',
        'uk-transition-{title_transition} {@overlay_hover}',
        'uk-margin-remove-adjacent [uk-margin-{meta_margin}-bottom] {@meta_align: bottom} {@meta}',
    ],

]);

// Meta
$meta = $this->el('div', [

    'class' => [
        'el-meta uk-margin',
        'uk-transition-{meta_transition} {@overlay_hover}',
        'uk-[text-{@meta_style: meta}]{meta_style}',
        'uk-text-{meta_color}',
        'uk-margin-remove-adjacent [uk-margin-{meta_margin}-bottom] {@meta_align: top}',
    ],

]);

// Content
$content = $this->el('div', [

    'class' => [
        'el-content uk-margin',
        'uk-text-{content_style}',
        'uk-transition-{content_transition} {@overlay_hover}',
    ],

]);

?>

<?= $element['meta'] && $element['meta_align'] == 'top' ? $meta($element->props, $element['meta']) : '' ?>

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

<?= $element['meta'] && $element['meta_align'] == 'bottom' ? $meta($element->props, $element['meta']) : '' ?>
<?= $element['image_align'] == 'between' ? $element['image'] : '' ?>
<?= $element['content'] ? $content($element->props, $element['content']) : '' ?>
