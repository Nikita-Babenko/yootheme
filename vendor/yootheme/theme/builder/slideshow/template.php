<?php

$el = $this->el('div', [

    'id' => $element['id'],
    'class' => $element['class'],

    'uk-slideshow' => $this->expr([
        'ratio: {slideshow_ratio}; {@!slideshow_height}',
        'minHeight: {slideshow_min_height}; {@!slideshow_height}',
        'maxHeight: {slideshow_max_height}; {@!slideshow_height}',
        'animation: {slideshow_animation};',
        'velocity: {slideshow_velocity};',
        'autoplay: {slideshow_autoplay}; [pauseOnHover: false; {!slideshow_autoplay_pause}; ] [autoplayInterval: {slideshow_autoplay_interval}000;]',
    ], $element->props) ?: true,

]);

// Container
$container = $this->el('div', [

    'class' => [
        'uk-position-relative',
        'uk-visible-toggle {@slidenav} {@slidenav_hover}',
    ],

]);

// Box decoration
$decoration = $this->el('div', [

    'class' => [
        'uk-box-shadow-bottom uk-display-block {@slideshow_box_decoration: shadow}',
        'tm-mask-default {@slideshow_box_decoration: mask}',
        'tm-box-decoration-{slideshow_box_decoration: default|primary|secondary}',
        'tm-box-decoration-inverse {@slideshow_box_decoration_inverse} {@slideshow_box_decoration: default|primary|secondary}',
    ],

]);

// Items
$items = $this->el('ul', [

    'class' => [
        'uk-slideshow-items',
        'uk-box-shadow-{slideshow_box_shadow}',
    ],

    'uk-height-viewport' => $element['slideshow_height'] ? [
        'offset-top: true;',
        'minHeight: {slideshow_min_height};',
        'offset-bottom: 20; {@slideshow_height: percent}',
        'offset-bottom: !.uk-section +; {@slideshow_height: section}',
    ] : false,

]);

?>

<?= $el($element->props, $element['attrs']) ?>

    <?= $container($element->props) ?>

        <?php if ($element['slideshow_box_decoration']) : ?>
        <?= $decoration($element->props) ?>
        <?php endif ?>

            <?= $items($element->props) ?>
                <?php foreach ($element as $i => $item) : ?>
                <li class="el-item" <?= $item['media_background'] ? "style=\"background-color: {$item['media_background']};\"" : '' ?>>
                    <?= $this->render('@builder/slideshow/template-item', compact('item', 'i')) ?>
                </li>
                <?php endforeach ?>
            </ul>

        <?php if ($element['slideshow_box_decoration']) : ?>
        </div>
        <?php endif ?>

        <?php if ($element['slidenav']) : ?>
        <?= $this->render('@builder/slideshow/template-slidenav') ?>
        <?php endif ?>

        <?php if ($element['nav'] && !$element['nav_below']) : ?>
        <?= $this->render('@builder/slideshow/template-nav') ?>
        <?php endif ?>

    </div>

    <?php if ($element['nav'] && $element['nav_below']): ?>
    <?= $this->render('@builder/slideshow/template-nav') ?>
    <?php endif ?>

</div>
