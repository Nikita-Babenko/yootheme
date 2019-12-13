<?php

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

// Video
$video = $this->el('video', [
    'class' => ['uk-box-shadow-{video_box_shadow}'],
    'width' => ['{video_width}'],
    'height' => ['{video_height}'],
], '');

// Iframe?
if ($iframe = $this->iframeVideo($element['video'], [], false)) {

    $iframe = $video($element->props, [
        'src' => $iframe,
        'frameborder' => 0,
        'allowfullscreen' => true,
        'uk-responsive' => true,
    ], '', 'iframe');

} else {

    $video->attr([
        'src' => ['{video}'],
        'controls' => $element['video_controls'],
        'loop' => $element['video_loop'],
        'muted' => $element['video_muted'],
        'playsinline' => $element['video_playsinline'],
        'preload' => ['none {@video_lazyload}'],
        'poster' => $element['video_poster'] && ($element['video_width'] || $element['video_height'])
            ? $app['image']->getUrl("{$element['video_poster']}#thumbnail={$element['video_width']},{$element['video_height']}")
            : $element['video_poster'],
        $element['video_autoplay'] === 'inview' ? 'uk-video' : 'autoplay' => $element['video_autoplay'],
    ]);

}

// Box decoration
$decoration = $this->el('div', [

    'class' => [
        'uk-box-shadow-bottom {@video_box_decoration: shadow}',
        'tm-mask-default {@video_box_decoration: mask}',
        'tm-box-decoration-{video_box_decoration: default|primary|secondary}',
        'tm-box-decoration-inverse {@video_box_decoration_inverse} {@video_box_decoration: default|primary|secondary}',
        'uk-inline {@!video_box_decoration: |shadow}',
    ],

]);

?>

<?= $el($element->props, $element['attrs']) ?>

    <?php if ($element['video_box_decoration']) : ?>
    <?= $decoration($element->props) ?>
    <?php endif ?>

    <?= $iframe ?: $video($element->props) ?>

    <?php if ($element['video_box_decoration']): ?>
    </div>
    <?php endif ?>

</div>
