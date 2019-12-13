<?php

// Display
foreach (['title', 'meta', 'content', 'link'] as $key) {
    if (!$element["show_{$key}"]) { $item[$key] = ''; }
}

// Mode
$overlay = $this->el('div', [
    'class' => [
        'uk-position-cover [uk-position-{overlay_margin}] {@overlay_mode: cover} {@overlay_style}',
        'uk-{overlay_style}',
        'uk-transition-{overlay_transition} {@overlay_hover}',
    ],
]);

$content = $this->el('div', [
    'class' => [
        'uk-panel {@!overlay_style}',
        'uk-overlay {@overlay_style}',

        // Padding
        'uk-padding {@!overlay_padding} {@!overlay_style}',
        'uk-padding-remove {@overlay_padding: none} {@overlay_style}',
        'uk-padding-{!overlay_padding: |none}',

        // Position
        'uk-position-{!overlay_position: .*center.*} [{@overlay_style} uk-position-{overlay_margin}]',

        // Width
        'uk-width-{overlay_maxwidth} {@!overlay_position: top|bottom}',

        // Overlay Hover
        'uk-transition-{overlay_transition} {@overlay_hover}' => !($element['overlay_transition_background'] && $element['overlay_mode'] == 'cover' && $element['overlay_style']),
    ],
]);

$centered = $this->expr([
    // Position
    'uk-position-{overlay_position: .*center.*} [{@overlay_style} uk-position-{overlay_margin}]',
], $element->props);

$center = $centered ? $this->el('div', ['class' => $centered]) : null;

// Background Color
$el = $this->el('div', [
    'class' => ['uk-cover-container'],
    'style' => ['background-color: {media_background};'],
]);

// Transition
if ($element['overlay_hover'] || $element['image_transition']) {
    $el->attr([
        'class' => ['uk-transition-toggle'],
        'tabindex' => 0,
    ]);
}

// Text color
if (!$element['overlay_style'] || ($element['overlay_mode'] == 'cover' && $element['overlay_style'])) {
    $el->attr('class', ['uk-{0}' => $item['text_color'] ?: $element['text_color']]);
}

// Inverse text color on hover
if ($element['overlay_style'] && $element['overlay_mode'] == 'cover' && $element['overlay_transition_background']) {
    $el->attr('uk-toggle', [
        $item['text_color_hover'] || $element['text_color_hover'] ? 'cls: uk-light uk-dark; mode: hover' : false,
    ]);
}

$link = $this->el('a', [

    'class' => [
        'uk-position-cover',
    ],

    'href' => $item['link'],
    'target' => ['_blank {@link_target}'],
    'uk-scroll' => strpos($item['link'], '#') === 0,

]);

?>

<?= $el($item->props) ?>

    <?php if ($element['slider_width'] && $element['slider_height'] && $element['image_transition']) : ?>
    <div class="uk-position-cover <?= $element['image_transition'] ? "uk-transition-{$element['image_transition']} uk-transition-opaque" : '' ?>">
    <?php endif ?>

        <?= $this->render('@builder/slider/template-image', ['item' => $item]) ?>
        <?= $this->render('@builder/slider/template-video', ['item' => $item]) ?>

    <?php if ($element['slider_width'] && $element['slider_height'] && $element['image_transition']) : ?>
    </div>
    <?php endif ?>

    <?php if ($item['media_overlay']) : ?>
    <div class="uk-position-cover" style="background-color:<?= $item['media_overlay'] ?>"></div>
    <?php endif ?>

    <?php if ($element['overlay_mode'] == 'cover' && $element['overlay_style']) : ?>
    <?= $overlay($element->props, '') ?>
    <?php endif ?>

    <?php if ($item['title'] || $item['meta'] || $item['content']) : ?>

        <?php $content = $content($element->props, !($element['overlay_mode'] == 'cover' && $element['overlay_style']) ? $overlay->attrs : [], $this->render('@builder/slider/template-content')) ?>
        <?php if ($centered) : ?>
            <?= $center($element->props, $content)?>
        <?php else : ?>
            <?= $content ?>
        <?php endif ?>
    <?php endif ?>

    <?php if ($item['link']) : ?>
    <?= $link($element->props, '') ?>
    <?php endif ?>

</div>
