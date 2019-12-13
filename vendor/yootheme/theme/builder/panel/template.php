<?php

// Resets
if ($element['icon'] && !$element['image']) { $element['image_card'] = ''; }
if ($element['panel_style'] || !$element['image']) { $element['image_box_decoration'] = ''; }

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

// Image
$element['image'] = $this->render('@builder/panel/template-image');

// Card
$el->attr('class', [

    'uk-panel {@!panel_style}',
    'uk-card uk-{panel_style} [uk-card-{panel_size}]',
    'uk-card-hover {@!panel_style: |card-hover} {@link_style: panel} {@link}',
    'uk-card-body {@panel_style}' => !$element['image'] || !$element['image_card'] || $element['image_align'] == 'between',

]);

// Image align
$grid = $this->el('div', [

    'class' => [
        'uk-child-width-expand',
        $element['panel_style'] && $element['image_card'] ? 'uk-grid-collapse uk-grid-match' : 'uk-grid-{image_gutter}',
        'uk-flex-middle {@image_vertical_align}',
    ],

    'uk-grid' => true,
]);

$cell_image = $this->el('div', [

    'class' => [
        'uk-width-{image_grid_width}[@{image_breakpoint}]',
        'uk-flex-last[@{image_breakpoint}] {@image_align: right}',
    ],

]);

// Content
$content = $this->el('div', ['class' => ['uk-card-body']]);

// Card media
if ($element['panel_style'] && $element['image'] && $element['image_card'] && $element['image_align'] != 'between') {
    $element['image'] = $this->el('div', ['class' => [
        'uk-card-media-{image_align}',
        'uk-cover-container{@image_align: left|right}',
    ]], $element['image'])->render($element->props);
}

// Link
if ($element['link']) {

    $link = $this->el('a', [

        'class' => [
            'el-link',

            'uk-position-cover uk-position-z-index uk-margin-remove-adjacent {@link_style: panel} {@panel_style}',

            'uk-box-shadow-bottom {@image_box_decoration: shadow} {@link_style: panel}',
            'tm-mask-default {@image_box_decoration: mask} {@link_style: panel}',
            'tm-box-decoration-{image_box_decoration: default|primary|secondary} {@link_style: panel}',
            'tm-box-decoration-inverse {@image_box_decoration_inverse} {@image_box_decoration: default|primary|secondary} {@link_style: panel}',
            'uk-inline {@!image_box_decoration: |shadow} {@link_style: panel}',

            'uk-{link_style: link-(muted|text)}',

            'uk-button uk-button-{!link_style: |panel|link-muted|link-text} [uk-button-{link_size}]',
        ],

        'href' => ['{link}'],
        'target' => ['_blank {@link_target}'],
        'uk-scroll' => strpos($element['link'], '#') === 0,
    ]);

    if ($element['link_style'] == 'panel' && !$element['panel_style'] && $element['image']) {
        $element['image'] = $link($element->props, $element['image']);
    }

}

// Box decoration
if ($element['image_box_decoration'] && (!$element['link'] || ($element['link'] && $element['link_style'] != 'panel'))) {

    $decoration = $this->el('div', [

        'class' => [
            'uk-box-shadow-bottom {@image_box_decoration: shadow}',
            'tm-mask-default {@image_box_decoration: mask}',
            'tm-box-decoration-{image_box_decoration: default|primary|secondary}',
            'tm-box-decoration-inverse {@image_box_decoration_inverse} {@image_box_decoration: default|primary|secondary}',
            'uk-inline {@!image_box_decoration: |shadow}',
        ],

    ]);

    $element['image'] = $decoration($element->props, $element['image']);
}

?>

<?= $el($element->props, $element['attrs']) ?>

    <?php if ($element['link'] && $element['link_style'] == 'panel' && $element['panel_style']) : ?>
    <?= $link($element->props, '') ?>
    <?php endif ?>

    <?php if ($element['image'] && in_array($element['image_align'], ['left', 'right'])) : ?>

        <?= $grid($element->props) ?>
            <?= $cell_image($element->props, $element['image']) ?>
            <div>

                <?php if ($element['panel_style'] && $element['image_card']) : ?>
                    <?= $content($element->props, $this->render('@builder/panel/template-content', compact('link'))) ?>
                <?php else : ?>
                    <?= $this->render('@builder/panel/template-content', compact('link')) ?>
                <?php endif ?>

            </div>
        </div>

    <?php else : ?>

        <?php if ($element['image_align'] == 'top') : ?>
        <?= $element['image'] ?>
        <?php endif ?>

        <?php if ($element['panel_style'] && $element['image'] && $element['image_card'] && in_array($element['image_align'], ['top', 'bottom'])) : ?>
            <?= $content($element->props, $this->render('@builder/panel/template-content', compact('link'))) ?>
        <?php else : ?>
            <?= $this->render('@builder/panel/template-content', compact('link')) ?>
        <?php endif ?>

        <?php if ($element['image_align'] == 'bottom') : ?>
        <?= $element['image'] ?>
        <?php endif ?>

    <?php endif ?>

</div>
