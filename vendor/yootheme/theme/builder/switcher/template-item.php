<?php

// Display
if (!$element['show_title']) { $item['title'] = ''; }
if (!$element['show_meta']) { $item['meta'] = ''; }
if (!$element['show_content']) { $item['content'] = ''; }
if (!$element['show_image']) { $item['image'] = ''; }
if (!$element['show_link']) { $item['link'] = ''; }
if (!$element['show_label']) { $item['label'] = ''; }
if (!$element['show_thumbnail']) { $item['thumbnail'] = ''; }

// Image
$image = $this->render('@builder/switcher/template-image', compact('item'));

// Image Align
$grid = $this->el('div', [

    'class' => [
        'uk-child-width-expand',
        'uk-grid-{image_gutter}',
        'uk-flex-middle {@image_vertical_align}',
    ],

    'uk-grid' => true,
]);

$cell = $this->el('div', [

    'class' => [
        'uk-width-{image_grid_width}[@{image_breakpoint}]',
        'uk-flex-last{@image_align: right}[@{image_breakpoint}]',
    ],

]);

?>

<?php if ($image && in_array($element['image_align'], ['left', 'right'])) : ?>

<?= $grid($element->props) ?>
    <?= $cell($element->props, $image) ?>
    <div><?= $this->render('@builder/switcher/template-content', compact('item')) ?></div>
</div>

<?php else : ?>

<?= $element['image_align'] == 'top' ? $image : '' ?>
<?= $this->render('@builder/switcher/template-content', compact('item')) ?>
<?= $element['image_align'] == 'bottom' ? $image : '' ?>

<?php endif ?>
