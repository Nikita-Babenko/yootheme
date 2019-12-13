<?php

// Display
if (!$element['show_title']) { $item['title'] = ''; }
if (!$element['show_meta']) { $item['meta'] = ''; }
if (!$element['show_content']) { $item['content'] = ''; }
if (!$element['show_image']) { $item['image'] = $item['icon'] = ''; }
if (!$element['show_link']) { $item['link'] = ''; }

// Resets
if ($item['icon'] && !$item['image']) { $element['image_card'] = ''; }
if ($element['panel_style'] || !$element['show_image']) { $element['image_box_shadow_bottom'] = ''; }

// If link is not set use the default image for the lightbox
if (!$item['link'] && $element['lightbox']) {
    $item['link'] = $item['image'];
}

// Image
$item['image'] = $this->render('@builder/grid/template-image', compact('item'));

// Card
$el = $this->el('div', [

    'class' => [
        'el-item',
        'uk-margin-auto uk-width-{item_maxwidth}',

        'uk-panel {@!panel_style}',
        'uk-card uk-{panel_style} [uk-card-{panel_size}]',
        'uk-card-hover {@!panel_style: |card-hover} {@link_style: panel}' => $item['link'],
        'uk-card-body {@panel_style}' => !$item['image'] || !$element['image_card'] || $element['image_align'] == 'between',
    ],

]);

// Animation
if ($element['item_animation'] != 'none' && $element->parent('section', 'animation') && $element->parent->type == 'column') {
    $el->attr('uk-scrollspy-class', !$element['item_animation'] ?: ['uk-animation-{item_animation}']);
}

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
if ($element['panel_style'] && $item['image'] && $element['image_card'] && $element['image_align'] != 'between') {
    $item['image'] = $this->el('div', ['class' => [
        'uk-card-media-{image_align}',
        'uk-cover-container{@image_align: left|right}',
    ]], $item['image'])->render($element->props);
}

// Link
$this->render('@builder/grid/template-link', compact('item'));

if ($item['link'] && $element['link_style'] == 'panel' && !$element['panel_style'] && $item['image']) {
    $item['image'] = $item['link']($element->props, $item['image']);
}

// Box decoration
if ($element['image_box_decoration'] && (!$item['link'] || ($item['link'] && $element['link_style'] != 'panel'))) {

    $decoration = $this->el('div', [

        'class' => [
            'uk-box-shadow-bottom {@image_box_decoration: shadow}',
            'tm-mask-default {@image_box_decoration: mask}',
            'tm-box-decoration-{image_box_decoration: default|primary|secondary}',
            'tm-box-decoration-inverse {@image_box_decoration_inverse} {@image_box_decoration: default|primary|secondary}',
            'uk-inline {@!image_box_decoration: |shadow}',
        ],

    ]);

    $item['image'] = $decoration($element->props, $item['image']);
}

?>

<?= $el($element->props); ?>

    <?php if ($item['link'] && $element['link_style'] == 'panel' && $element['panel_style']) : ?>
    <?= $item['link']->render($element->props, '') ?>
    <?php endif ?>

    <?php if ($item['image'] && in_array($element['image_align'], ['left', 'right'])) : ?>

        <?= $grid($element->props) ?>
            <?= $cell_image($element->props, $item['image']); ?>
            <div>

                <?php if ($element['panel_style'] && $element['image_card']) : ?>
                    <?= $content($element->props, $this->render('@builder/grid/template-content', compact('item'))); ?>
                <?php else : ?>
                    <?= $this->render('@builder/grid/template-content', compact('item')) ?>
                <?php endif ?>

            </div>
        </div>

    <?php else : ?>

        <?php if ($element['image_align'] == 'top') : ?>
        <?= $item['image'] ?>
        <?php endif ?>

        <?php if ($element['panel_style'] && $item['image'] && $element['image_card'] && in_array($element['image_align'], ['top', 'bottom'])) : ?>
            <?= $content($element->props, $this->render('@builder/grid/template-content', compact('item'))); ?>
        <?php else : ?>
            <?= $this->render('@builder/grid/template-content', compact('item')) ?>
        <?php endif ?>

        <?php if ($element['image_align'] == 'bottom') : ?>
        <?= $item['image'] ?>
        <?php endif ?>

    <?php endif ?>

</div>
