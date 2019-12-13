<?php

$element['overlay_cover'] = $element['overlay_style'] && $element['overlay_mode'] == 'cover';

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],
    'uk-filter' => ['.js-filter {@tags}'],
]);

// Grid
$grid = $this->el('div', [

    'class' => [
        'js-filter {@tags}',
        'uk-child-width-1-{grid_default}',
        'uk-child-width-1-{grid_small}@s',
        'uk-child-width-1-{grid_medium}@m',
        'uk-child-width-1-{grid_large}@l',
        'uk-child-width-1-{grid_xlarge}@xl',
        'uk-grid-{gutter}',
        'uk-grid-divider {@divider}',
    ],

    'uk-grid' => $this->expr([
        'masonry: {grid_masonry};',
        'parallax: {grid_parallax};',
    ], $element->props) ?: true,

    'uk-lightbox' => [
        'toggle: a[data-type];' => $element['lightbox'],
    ],

]);

// Orientation
$cell = $this->el('div', [

    'class' => [
        'uk-flex uk-flex-center uk-flex-middle {@image_orientation}',
    ],

]);

// Filter
$filter_grid = $this->el('div', [

    'class' => [
        'uk-child-width-expand',
        'uk-grid-{filter_gutter}',
    ],

    'uk-grid' => true,
]);

$filter_cell = $this->el('div', [

    'class' => [
        'uk-width-{filter_grid_width}@{filter_breakpoint}',
        'uk-flex-last@{filter_breakpoint} {@filter_position: right}',
    ],

]);

?>

<?php if ($element['tags']) : ?>
<?= $el($element->props, $element['attrs']) ?>

    <?php if ($filter_horizontal = in_array($element['filter_position'], ['left', 'right'])) : ?>
    <?= $filter_grid($element->props) ?>
        <?= $filter_cell($element->props) ?>
    <?php endif ?>

        <?= $this->render('@builder/gallery/template-nav') ?>

    <?php if ($filter_horizontal) : ?>
        </div>
        <div>
    <?php endif ?>

        <?= $grid($element->props) ?>
        <?php foreach ($element as $item) : ?>
        <?= $cell($element->props, ['data-tag' => $item['tags']], $this->render('@builder/gallery/template-item', compact('item'))) ?>
        <?php endforeach ?>
        </div>

    <?php if ($filter_horizontal) : ?>
        </div>
    </div>
    <?php endif ?>

</div>
<?php else : ?>
<?= $el($element->props, $element['attrs']) ?>

    <?= $grid($element->props) ?>
    <?php foreach ($element as $item) : ?>
    <?= $cell($element->props, $this->render('@builder/gallery/template-item', compact('item'))) ?>
    <?php endforeach ?>
    </div>

</div>
<?php endif ?>
