<?php

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],

    'uk-slider' => $this->expr([
        'sets: {slider_sets};',
        'center: {slider_center};',
        'finite: {slider_finite};',
        'velocity: {slider_velocity};',
        'autoplay: {slider_autoplay}; [pauseOnHover: false; {@!slider_autoplay_pause}] [autoplayInterval: {slider_autoplay_interval}000;]',
    ], $element->props) ?: true,
]);

// Slider Items
$slider_items = $this->el('ul', [
    'class' => [

        'uk-slider-items',
        'uk-grid [uk-grid-{!slider_gutter: default}] {@slider_gutter}',
        'uk-grid-divider {@slider_gutter} {@slider_divider}',
        'uk-grid-match {@slider_width} {@slider_height}',

    ],

    // Height Viewport
    'uk-height-viewport' => $element['slider_width'] && $element['slider_height'] ? [

        'offset-top: true;',
        'minHeight: {slider_min_height};',
        'offset-bottom: 20; {@slider_height: percent}',
        'offset-bottom: !.uk-section +; {@slider_height: section}',

    ] : false,
]);

$slider_item = $this->el('li', [
    'class' => [

        'el-item',

        'uk-width-{slider_width_default} {@slider_width}',
        'uk-width-{slider_width_small}@s {@slider_width}',
        'uk-width-{slider_width_medium}@m {@slider_width}',
        'uk-width-{slider_width_large}@l {@slider_width}',
        'uk-width-{slider_width_xlarge}@xl {@slider_width}',

    ],
]);

// Container
$container = $this->el('div', [
    'class' => [

        'uk-position-relative',
        'uk-visible-toggle {@slidenav} {@slidenav_hover}',

    ],
]);

?>

<?= $el($element->props, $element['attrs']) ?>

    <?= $container($element->props) ?>

        <?php if ($element['slidenav'] == 'outside') : ?>
        <div class="uk-slider-container">
        <?php endif ?>

            <?= $slider_items($element->props) ?>

                <?php foreach ($element as $item) : ?>
                <?= $slider_item($element->props, $this->render('@builder/slider/template-item', compact('item'))) ?>
                <?php endforeach ?>

            </ul>

        <?php if ($element['slidenav'] == 'outside') : ?>
        </div>
        <?php endif ?>

        <?php if ($element['slidenav']) : ?>
        <?= $this->render('@builder/slider/template-slidenav') ?>
        <?php endif ?>

    </div>

    <?php if ($element['nav']): ?>
    <?= $this->render('@builder/slider/template-nav') ?>
    <?php endif ?>

</div>
