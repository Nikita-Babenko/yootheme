<?php

// Display
foreach (['title', 'meta', 'content', 'link', 'hover_image'] as $key) {
    if (!$element["show_{$key}"]) { $item[$key] = ''; }
}

$el = $this->el('div', [

    'class' => [
        'el-item',

        'uk-margin-auto uk-width-{item_maxwidth}',

        'uk-box-shadow-{image_box_shadow}' => $item['image'] || $item['hover_image'],
        'uk-box-shadow-hover-{image_hover_box_shadow}' => $item['image'] || $item['hover_image'],

        'uk-box-shadow-bottom {@image_box_decoration: shadow}',
        'tm-mask-default {@image_box_decoration: mask}',
        'tm-box-decoration-{image_box_decoration: default|primary|secondary}',
        'tm-box-decoration-inverse {@image_box_decoration_inverse} {@image_box_decoration: default|primary|secondary}',
        'uk-inline {@!image_box_decoration: |shadow}',
        'uk-inline-clip {@!image_box_decoration}',

        'uk-{0}' => !$element['overlay_style'] || $element['overlay_mode'] == 'cover'
            ? ($item['text_color'] ?: $element['text_color'])
            : false,

        'uk-transition-toggle' => $isTransition = $element['overlay_hover'] || $element['image_transition'] || $item['hover_image'],
    ],

    'style' => [
        'min-height: {image_min_height}px;' => $item['image'] || $item['hover_image'],
    ],

    'tabindex' => $isTransition ? 0 : null,
]);

// Animation
if ($element['item_animation'] != 'none' && $element->parent('section', 'animation') && $element->parent->type == 'column') {
    $el->attr('uk-scrollspy-class', $element['item_animation'] ? "uk-animation-{$element['item_animation']}" : true);
}

// Inverse text color on hover
if ((!$element['overlay_style'] && $item['hover_image']) || ($element['overlay_cover'] && $element['overlay_hover'] && $element['overlay_transition_background'])) {
    $el->attr('uk-toggle', [
        'cls: uk-light uk-dark; mode: hover' => $item['text_color_hover'] || $element['text_color_hover'],
    ]);
}

$overlay = $this->el('div', [

    'class' => [
        'uk-{overlay_style}',
        'uk-transition-{overlay_transition} {@overlay_hover} {@overlay_cover}',
    ],

]);

$content = $this->el('div', [

    'class' => [
        'uk-{0}' => $element['overlay_style'] ? 'overlay' : 'panel',
        'uk-padding {@!overlay_padding} {@!overlay_style}',
        'uk-padding-{!overlay_padding: |none}',
        'uk-padding-remove {@overlay_padding: none} {@overlay_style}',
        'uk-width-{overlay_maxwidth} {@!overlay_position: top|bottom}',
        'uk-position-{!overlay_position: .*center.*} [uk-position-{overlay_margin} {@overlay_style}]',
        'uk-transition-{overlay_transition} {@overlay_hover}' => !$element['overlay_transition_background'] || !$element['overlay_cover'],
    ],

]);

// Position
$center = strpos($element['overlay_position'], 'center') !== false ? $this->el('div', [

    'class' => [
        'uk-position-{overlay_position}',
        'uk-position-{overlay_margin} {@overlay_style}',
    ],

]) : null;

// Link
$link = $this->el('a', [
    'href' => $item['link'],
    'class' => ['uk-position-cover'],
]);

// Link and Lightbox
if ($element['lightbox']) {

    // If link is not set use the default image for the lightbox
    if (!$item['link']) {
        $link->attr('href', $item['link'] = $item['image']);
    }

    if ($type = $this->isImage($item['link'])) {

        if (($element['lightbox_image_width'] || $element['lightbox_image_height']) && $type !== 'svg') {
            $item['link'] = "{$item['link']}#thumbnail={$element['lightbox_image_width']},{$element['lightbox_image_height']},{$element['lightbox_image_orientation']}";
        }

        $link->attr([
            'href' => $app['image']->getUrl($item['link']),
            'data-alt' => $item['image_alt'],
            'data-type' => 'image',
        ]);

    } elseif ($this->isVideo($item['link'])) {
        $link->attr('data-type', 'video');
    } elseif (!$this->iframeVideo($item['link'])) {
        $link->attr('data-type', 'iframe');
    } else {
        $link->attr('data-type', true);
    }

    $caption = '';

    if ($item['title'] && $element['title_display'] != 'item') {

        $caption .= "<h4 class='uk-margin-remove'>{$item['title']}</h4>";

        if ($element['title_display'] == 'lightbox') {
            $item['title'] = '';
        }
    }

    if ($item['content'] && $element['content_display'] != 'item') {

        $caption .= $item['content'];

        if ($element['content_display'] == 'lightbox') {
            $item['content'] = '';
        }
    }

    if ($caption) {
        $link->attr('data-caption', $caption);
    }

} else {

    $link->attr([
        'target' => ['_blank {@link_target}'],
        'uk-scroll' => strpos($item['link'], '#') === 0,
    ]);

}

?>

<?= $el($element->props) ?>

    <?php if ($element['image_box_decoration']) : ?>
    <div class="uk-inline-clip">
    <?php endif ?>

    <?= $item['image'] || $item['hover_image'] ? $this->render('@builder/gallery/template-image') : '' ?>
    <?= $element['overlay_cover'] ? $overlay($element->props, ['class' => ['uk-position-cover [uk-position-{overlay_margin}]']], '') : '' ?>

    <?php if ($item['title'] || $item['meta'] || $item['content']) : ?>
        <?php $content = $content($element->props, !$element['overlay_cover'] ? $overlay->attrs : [], $this->render('@builder/gallery/template-content')) ?>
        <?= $center ? $center($element->props, $content) : $content ?>
    <?php endif ?>

    <?= $item['link'] ? $link($element->props, '') : '' ?>

    <?php if ($element['image_box_decoration']) : ?>
    </div>
    <?php endif ?>

</div>
