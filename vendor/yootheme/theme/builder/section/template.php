<?php

// Resets
if (!($element['image'] || $element['video'])) {
    $element['media_overlay'] = false;
    $element['media_overlay_gradient'] = false;
}
if (!$element['height'] || $element['height'] == 'expand') { $element['vertical_align'] = false; }
if ($element['image']) { $element['video'] = false; }

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

$el->attr($element['attrs']);

$el->attr([

    'class' => [
        'uk-section-{style}',
        'uk-section-overlap {@overlap}',
        'uk-preserve-color {@style: primary|secondary}' => $element['preserve_color'],
        'uk-{text_color} {@!style: primary|secondary}' => $element['image'] || $element['video'],
        'uk-position-relative {@image}' => $element['media_overlay'] || $element['media_overlay_gradient'],
        'uk-cover-container {@video}',
    ],

    'style' => ['background-color: {media_background};{@video}'],

    'uk-scrollspy' => $element['animation'] ? [
        'target: [uk-scrollspy-class];',
        'cls: uk-animation-{animation};',
        'delay: {0};' => $element['animation_delay'] ? 200 : 'false',
    ] : false,

    'tm-header-transparent' => ['{header_transparent}'],
    'tm-header-transparent-placeholder' => $element['header_transparent'] && !$element['header_transparent_noplaceholder'],
]);

// Section
$attrs_section = [
    'class' => [
        'uk-section',
        'uk-section-{!padding: |none}',
        'uk-padding-remove-vertical {@padding: none}',
        'uk-padding-remove-top {@!padding: none} {@padding_remove_top}',
        'uk-padding-remove-bottom {@!padding: none} {@padding_remove_bottom}',
        'uk-flex [uk-flex-{vertical_align} {@!title}] {@vertical_align}',
    ],
];

// Image
$image = $element['image'] ? $this->el('div', $this->bgImage($element['image'], [
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
])) : null;

// Video
$element['video'] = $this->render('@builder/section/template-video');

// Height Viewport
$attrs_section['uk-height-viewport'] = $element['height'] == 'expand'
    ? 'expand: true;'
    : ($element['height']
        ? [
            'offset-top: true;',
            'offset-bottom: {0};' => $element['height'] == 'percent'
                ? '20'
                : ($element['height'] == 'section'
                    ? ($element['image'] ? '! +' : 'true')
                    : false),
        ]
        : false);

$overlay = ($element['media_overlay'] || $element['media_overlay_gradient']) && ($element['image'] || $element['video'])
    ? $this->el('div', [
        'class' => ['uk-position-cover'],
        'style' => [
            'background-color: {media_overlay};',
            // `background-clip` fixes sub-pixel issue
            'background-image: {media_overlay_gradient}; background-clip: padding-box',
        ],
    ]) : null;

$container = $element['width'] || $element['video'] || $overlay
    ? $this->el('div', ['class' => [
        'uk-container {@width}',
        'uk-container-{width: small|large|expand}',
        'uk-container-expand-{width_expand} {@width: default|small|large}',

        // Make sure overlay and video is always below content
        'uk-position-relative [{@!width} uk-panel]' => $overlay || $element['video'],
    ],
    ]) : null;

$title = $this->el('div', [
    'class' => [
        'tm-section-title',
        'uk-position-{title_position} uk-position-medium',
        !in_array($element['title_position'], ['center-left', 'center-right']) ? 'uk-margin-remove-vertical' : 'uk-text-nowrap',
        'uk-visible@{title_breakpoint}',
    ],
]);

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

?>

<?= $el($element->props, !$image ? $attrs_section : []) ?>

    <?php if ($element['image']) : ?>
    <?= $image($element->props, $attrs_section) ?>
    <?php endif ?>

        <?= $element['video'] ?>

        <?php if ($overlay) : ?>
        <?= $overlay($element->props, '') ?>
        <?php endif ?>

        <?php if ($element['title']) : ?>
        <?= $this->el('div', ['class' => [
            'uk-position-relative',
            'uk-flex-auto uk-flex uk-flex-{vertical_align}',
        ]])->render($element->props) ?>
        <?php endif ?>

            <?php if ($element['vertical_align']) : ?>
            <div class="uk-width-1-1">
            <?php endif ?>

                <?php if ($container) : ?>
                <?= $container($element->props, (string) $element) ?>
                <?php else : ?>
                <?= $element ?>
                <?php endif ?>

            <?php if ($element['vertical_align']) : ?>
            </div>
            <?php endif ?>

        <?php if ($element['title']) : ?>
            <?= $title($element->props) ?>
                <div class="<?= $element['title_rotation'] == 'left' ? 'tm-rotate-180' : '' ?>"><?= $element['title'] ?></div>
            </div>
        </div>
        <?php endif ?>

    <?php if ($element['image']) : ?>
    </div>
    <?php endif ?>

</div>
