<?php

// Image
$image = $this->render('@builder/accordion/template-image', compact('item'));

// Grid
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
        'uk-width-{image_grid_width}@{image_breakpoint}',
        'uk-flex-last@{image_breakpoint} {@image_align: right}',
    ],

]);

?>

<?php if ($image && in_array($element['image_align'], ['left', 'right'])) : ?>

    <?= $grid($element->props) ?>
        <?= $cell($element->props, $image) ?>
        <div>
            <?= $this->render('@builder/accordion/template-content', compact('item')) ?>
            <?= $this->render('@builder/accordion/template-link', compact('item')) ?>
        </div>
    </div>

<?php else : ?>

    <?= $element['image_align'] == 'top' ? $image : '' ?>
    <?= $this->render('@builder/accordion/template-content', compact('item')) ?>
    <?= $this->render('@builder/accordion/template-link', compact('item')) ?>
    <?= $element['image_align'] == 'bottom' ? $image : '' ?>

<?php endif ?>
