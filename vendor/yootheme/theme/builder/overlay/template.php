<?php

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

$element['overlay_cover'] = $element['overlay_mode'] == 'cover' && $element['overlay_style'];

// Container
$container = $this->el('div', [

    'class' => [
        'el-container',

        'uk-box-shadow-{image_box_shadow}' => $element['image'] || $element['hover_image'],
        'uk-box-shadow-hover-{image_hover_box_shadow}' => $element['image'] || $element['hover_image'],

        'uk-box-shadow-bottom {@image_box_decoration: shadow}',
        'tm-mask-default {@image_box_decoration: mask}',
        'tm-box-decoration-{image_box_decoration: default|primary|secondary}',
        'tm-box-decoration-inverse {@image_box_decoration_inverse} {@image_box_decoration: default|primary|secondary}',
        'uk-inline {@!image_box_decoration: |shadow}',
        'uk-inline-clip {@!image_box_decoration}',

        'uk-{text_color}' => !$element['overlay_style'] || $element['overlay_cover'],
    ],

    'style' => ['min-height: {image_min_height}px'],

]);

// Style, Padding, Position and Width
$content = $this->el('div', [
    'class' => [

        $element['overlay_style'] ? 'uk-overlay' : 'uk-panel',

        // Padding
        'uk-padding {@!overlay_padding} {@!overlay_style}',
        'uk-padding-remove {@overlay_padding: none} {@overlay_style}',
        'uk-padding-{!overlay_padding: |none}',

        // Position
        'uk-position-{!overlay_position: .*center.*} [{@overlay_style} uk-position-{overlay_margin}]',

        // Width
        'uk-width-{overlay_maxwidth} {@!overlay_position: top|bottom}',

        'uk-transition-{overlay_transition}' => $element['overlay_hover'] && !($element['overlay_transition_background'] && $element['overlay_cover']),

    ],
]);

$overlay = $this->el('div', [
    'class' => [

        'uk-transition-{overlay_transition} {@overlay_hover}',
        'uk-{overlay_style}',

        'el-overlay uk-position-cover {@overlay_cover}',
        'uk-position-{overlay_margin} {@overlay_cover}',
    ],
]);

if (!$element['overlay_cover']) {
    $content->attr($overlay->attrs);
}

$center = $this->el('div', [
    'class' => ['uk-position-{overlay_position: .*center.*} [{@overlay_style} uk-position-{overlay_margin}]'],
]);

// Transition
if ($element['overlay_hover'] || $element['image_transition'] || $element['hover_image']) {
    $container->attr([
        'class' => ['uk-transition-toggle'],
        'tabindex' => 0,
    ]);
}

// Inverse text color on hover
if (!$element['overlay_style'] && $element['hover_image'] || $element['overlay_cover'] && $element['overlay_hover'] && $element['overlay_transition_background']) {
    $container->attr('uk-toggle', ['cls: uk-light uk-dark; mode: hover {@text_color_hover}']);
}

// Link
$link = $this->el('a', [

    'class' => 'uk-position-cover',
    'href' => ['{link}'],
    'target' => ['_blank {@link_target}'],
    'uk-scroll' => strpos($element['link'], '#') === 0,

]);

?>

<?= $el($element->props, $element['attrs']) ?>
    <?= $container($element->props) ?>

        <?php if ($element['image_box_decoration']) : ?>
        <div class="uk-inline-clip">
        <?php endif ?>

        <?= $this->render('@builder/overlay/template-image') ?>

        <?php if ($element['overlay_cover']) : ?>
        <?= $overlay($element->props, '') ?>
        <?php endif ?>

        <?php if ($element['title'] || $element['meta'] || $element['content']) : ?>

            <?php if ($this->expr($center->attrs['class'], $element->props)) : ?>
            <?= $center($element->props, $content($element->props, $this->render('@builder/overlay/template-content'))) ?>
            <?php else : ?>
            <?= $content($element->props, $this->render('@builder/overlay/template-content')) ?>
            <?php endif ?>

        <?php endif ?>

        <?php if ($element['link']) : ?>
        <?= $link($element->props, '') ?>
        <?php endif ?>

        <?php if ($element['image_box_decoration']) : ?>
        </div>
        <?php endif ?>

    </div>
</div>
