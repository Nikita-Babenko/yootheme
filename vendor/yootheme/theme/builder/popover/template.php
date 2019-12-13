<?php

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

// Fix stacking context for drops if parallax is enabled
$el->attr('class', ['uk-position-relative uk-position-z-index {@animation: parallax}']);

// Image
$image = $this->el('image', [
    'src' => $element['background_image'],
    'alt' => $element['background_image_alt'],
    'width' => $element['background_image_width'],
    'height' => $element['background_image_height'],
    'uk-svg' => (bool) $element['image_inline_svg'],
    'thumbnail' => true,
]);

?>

<?= $el($element->props, $element['attrs']) ?>
    <div class="uk-inline">

        <?= $element['background_image'] ? $image() : '' ?>

        <div class="uk-visible@s">
        <?php foreach ($element as $item) : ?>
        <?= $this->render('@builder/popover/template-marker', compact('item')) ?>
        <?php endforeach ?>
        </div>

    </div>
    <div class="uk-margin uk-hidden@s">
        <?= $this->render('@builder/popover/template-fallback') ?>
    </div>
</div>
