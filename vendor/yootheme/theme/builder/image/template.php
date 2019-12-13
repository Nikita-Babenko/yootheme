<?php

$element['image_hover_box_shadow']  = $element['link'] ? $element['image_hover_box_shadow'] : false;

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

// Image
$image = $this->el('image', [

    'class' => [
        'el-image',
        'uk-border-{image_border}',
        'uk-box-shadow-{image_box_shadow}',
        'uk-box-shadow-hover-{image_hover_box_shadow}',
    ],

    'src' => $element['image'],
    'alt' => $element['image_alt'],
    'width' => $element['image_width'],
    'height' => $element['image_height'],
    'uk-svg' => (bool) $element['image_inline_svg'],
    'thumbnail' => true,
]);

// Box decoration
$decoration = $this->el('div', [

    'class' => [
        'uk-box-shadow-bottom {@image_box_decoration: shadow}',
        'tm-mask-default {@image_box_decoration: mask}',
        'tm-box-decoration-{image_box_decoration: default|primary|secondary}',
        'tm-box-decoration-inverse {@image_box_decoration_inverse} {@image_box_decoration: default|primary|secondary}',
        'uk-inline {@!image_box_decoration: |shadow}',
    ],

]);

// Link and Lightbox
$link = $this->el('a', [

    'class' => [
        'el-link',

        'uk-box-shadow-bottom {@image_box_decoration: shadow}',
        'tm-mask-default {@image_box_decoration: mask}',
        'tm-box-decoration-{image_box_decoration: default|primary|secondary}',
        'tm-box-decoration-inverse {@image_box_decoration_inverse} {@image_box_decoration: default|primary|secondary}',
        'uk-inline {@!image_box_decoration: |shadow}',
    ],

    'href' => ['{link}'],
    'target' => ['_blank {@link_target: blank}'],
    'uk-scroll' => strpos($element['link'], '#') === 0,

    // Target Modal?
    'uk-toggle' => $element['link_target'] === 'modal',
]);

if ($element['link_target'] === 'modal') {

    $target = $this->el('image', [
        'src' => $element['link'],
        'width' => $element['lightbox_width'],
        'height' => $element['lightbox_height'],
    ]);

    if ($this->isImage($element['link'])) {

        $lightbox = $target($element->props, [
            'thumbnail' => true,
        ]);

    } else {

        $video = $this->isVideo($element['link']);
        $iframe = $this->iframeVideo($element['link']);
        $lightbox = $video && !$iframe ? $target($element->props, [

            // Video
            'controls' => true,
            'uk-video' => true,

        ], '', 'video') : $target($element->props, [

            // Iframe
            'src' => $iframe ?: $element['link'],
            'frameborder' => 0,
            'uk-video' => $video || $iframe,

        ], '', 'iframe');

    }

    $connect_id = "js-{$this->uid()}";
    $element['link'] = "#{$connect_id}";
}

?>

<?= $el($element->props, $element['attrs']) ?>

    <?php if ($element['link']) : ?>
    <?= $link($element->props, $image($element->props)) ?>
    <?php elseif ($element['image_box_decoration']) : ?>
    <?= $decoration($element->props, $image($element->props)) ?>
    <?php else : ?>
    <?= $image($element->props) ?>
    <?php endif ?>

    <?php if ($element['link_target'] === 'modal') : ?>
    <?php // uk-flex-top is needed to make vertical margin work for IE11 ?>
    <div id="<?= $connect_id ?>" class="uk-flex-top" uk-modal>
        <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
            <button class="uk-modal-close-outside" type="button" uk-close></button>
            <?= $lightbox ?>
        </div>
    </div>
    <?php endif ?>

</div>
