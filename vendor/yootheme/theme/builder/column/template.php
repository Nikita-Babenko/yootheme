<?php

// Resets
if (!$element['image']) {
    $element['media_overlay'] = false;
    $element['media_overlay_gradient'] = false;
}

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

// Width
$breakpoints = ['s', 'm', 'l', 'xl'];
$breakpoint = $element->parent['breakpoint'];

// Above Breakpoint
$width = $element['widths'][0] ?: 'expand';
$width = $width === 'fixed' ? $element->parent['fixed_width'] : $width;

$el->attr('class', [
    "uk-width-{$width}".($breakpoint ? "@{$breakpoint}" : ''),

    // Vertical alignment
    // Can't use `uk-flex` and `uk-width-1-1` instead of `uk-grid-item-match` because it doesn't work with grid divider (it removes the ::before)
    'uk-grid-item-match uk-flex-{vertical_align} {@!style} {@!image}',

    // Text color
    'uk-{text_color} {@!style: primary|secondary}' => !$element['style'] || $element['image'],

    'uk-grid-item-match'  => $element['style'] || $element['image'],
]);

// Intermediate Breakpoint
if (isset($element['widths'][1]) && $pos = array_search($breakpoint, $breakpoints)) {
    $breakpoint = $breakpoints[$pos - 1];
    $width = $element['widths'][1] ?: 'expand';
    $el->attr('class', ["uk-width-{$width}".($breakpoint ? "@{$breakpoint}" : '')]);
}

// Order
if (!isset($element->parent->children[$element->index + 1]) && $element->parent['order_last']) {
    $el->attr('class', ["uk-flex-first@{$breakpoint}"]);
}

// Visibility
$visible = $element->count() ? 4 : false;
$visibilities = ['xs', 's', 'm', 'l', 'xl'];

foreach ($element as $ele) {
    $visible = min(array_search($ele['visibility'], $visibilities), $visible);
}

if ($visible) {
    $element['visibility'] = $visibilities[$visible];
    $el->attr('class', ["uk-visible@{$visibilities[$visible]}"]);
}

// Column options

// Overlay
$overlay = $element['media_overlay'] || $element['media_overlay_gradient']
    ? $this->el('div', [
    'class' => ['uk-position-cover'],
    'style' => [
        'background-color: {media_overlay};',
        // `background-clip` fixes sub-pixel issue
        'background-image: {media_overlay_gradient}; background-clip: padding-box',
    ],
    ]) : null;

// Tile
$tile = $element['style'] || $element['image']
    ? $this->el('div', [
    'class' => [
        'uk-tile',

        // Padding
        'uk-padding-remove {@padding: none}',
        'uk-tile-{!padding: |none}',

        // Vertical alignment
        // Can't use `uk-flex` and `uk-width-1-1` instead of `uk-grid-item-match` because it doesn't work with grid divider (it removes the ::before)
        'uk-grid-item-match uk-flex-{vertical_align}',
    ],
    ]) : null;

$tile_container = $this->el('div', [
    'class' => [
        'uk-tile-{style}',

        'uk-grid-item-match {@image}',

        // Overlay
        'uk-position-relative' => $overlay,

        // Text color
        'uk-preserve-color {@preserve_color} {@style: primary|secondary}',
    ],
]);

// Image
if ($element['image']) {

    $tile->attr($this->bgImage($element['image'], [
        'width' => $element['image_width'],
        'height' => $element['image_height'],
        'size' => $element['image_size'],
        'position' => $element['image_position'],
        'visibility' => $element['image_visibility'],
        'blend_mode' => $element['media_blend_mode'],
        'background' => $element['media_background'],
        'effect' => $element['image_effect'],
        'parallax_bgx_start' => $element['image_parallax_bgx_start'],
        'parallax_bgy_start' => $element['image_parallax_bgy_start'],
        'parallax_bgx_end' => $element['image_parallax_bgx_end'],
        'parallax_bgy_end' => $element['image_parallax_bgy_end'],
        'parallax_breakpoint' => $element['image_parallax_breakpoint'],
    ]));

}

// Fix margin if container
$container = $element['vertical_align'] || $overlay
    ? $this->el('div', [
    'class' => [
        'uk-panel',

        // Make sure overlay is always below content
        'uk-position-relative' => $overlay,
    ],
    ]) : null;

?>

<?= $el($element->props, $element['attrs']) ?>

    <?php if ($tile) : ?>
    <?= $tile_container($element->props, !$element['image'] ? $tile->attrs : []) ?>
    <?php endif ?>

        <?php if ($element['image']) : ?>
        <?= $tile($element->props) ?>
        <?php endif ?>

            <?php if ($overlay) : ?>
            <?= $overlay($element->props, '') ?>
            <?php endif ?>

            <?php if ($container) : ?>
            <?= $container($element->props) ?>
            <?php endif ?>

                <?= $element ?>

            <?php if ($container) : ?>
            </div>
            <?php endif ?>

        <?php if ($element['image']) : ?>
        </div>
        <?php endif ?>

    <?php if ($tile) : ?>
    </div>
    <?php endif ?>

</div>
