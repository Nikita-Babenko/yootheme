<?php

if ($item['link_target'] != 'modal') {
    return;
}

$link = $this->el('image', [
    'src' => $item['link'],
    'width' => $item['lightbox_width'],
    'height' => $item['lightbox_height'],
]);

if ($this->isImage($item['link'])) {

    $lightbox = $link($element->props, ['thumbnail' => true]);

} else {

    $video = $this->isVideo($item['link']);
    $iframe = $this->iframeVideo($item['link'], [], false);
    $lightbox = $video && !$iframe ? $link($element->props, [

        // Video
        'controls' => true,
        'uk-video' => true,

    ], '', 'video') : $link($element->props, [

        // Iframe
        'src' => $iframe ?: $item['link'],
        'frameborder' => 0,
        'uk-video' => $video || $iframe,
        'uk-responsive' => true,

    ], '', 'iframe');

}

?>

<?php // uk-flex-top is needed to make vertical margin work for IE11 ?>
<div id="<?= $item['id'] ?>" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
        <button class="uk-modal-close-outside" type="button" uk-close></button>
        <?= $lightbox ?>
    </div>
</div>
