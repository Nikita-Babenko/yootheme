<?php

$nav = $this->el('ul', [
    'class' => [

        'el-nav',
        'uk-{nav} [uk-flex-nowrap {@nav: thumbnav} {@thumbnav_nowrap}]',

        // Alignment
        'uk-flex-{nav_align} {@nav_below}',

        // Vertical
        'uk-{nav}-vertical {@nav_vertical} {@!nav_below}',

        // Wrapping
        'uk-flex-right {@!nav_vertical} {@!nav_below} {@nav_position: .*-right}',
        'uk-flex-center {@!nav_vertical} {@!nav_below} {@nav_position: bottom-center}',

    ],

    'uk-margin' => !$element['nav_vertical'],
]);

$container = $this->el('div', [
    'class' => [

        // Margin
        'uk-margin[-{nav_margin}]-top {@nav_below}',

        // Color
        'uk-{nav_color} {@nav_below}',

        // Position
        'uk-position-{nav_position} {@!nav_below}',

        // Margin
        'uk-position-{nav_position_margin} {@!nav_below}',

        // Text Color
        'uk-{text_color} {@!nav_below}',

        // Breakpoint
        'uk-visible@{nav_breakpoint}',
    ],
]);

?>

<?php if (!$element['nav_below'] || ($element['nav_below'] && $element['nav_color'])) : ?>
<?= $container($element->props) ?>
<?php endif ?>

<?= $nav($element->props, $element['nav_below'] && !$element['nav_color'] ? $container->attrs : []) ?>
    <?php foreach ($element as $i => $item) :

        // Display
        if (!$element['show_title']) { $item['title'] = ''; }
        if (!$element['show_thumbnail']) { $item['thumbnail'] = ''; }

        // Image
        $image = $this->el('image', [
            'src' => $item['thumbnail'] ?: $item['image'],
            'alt' => $item['image_alt'],
            'width' => $element['thumbnav_width'],
            'height' => $element['thumbnav_height'],
            'uk-svg' => (bool) $element['thumbnav_inline_svg'],
            'thumbnail' => true,
        ]);

        $thumbnail = $image->attrs['src'] && $element['nav'] == 'thumbnav' ? $image() : '';
    ?>
    <li uk-slideshow-item="<?= $i ?>">
        <a href="#"><?= $thumbnail ?: $item['title'] ?></a>
    </li>
    <?php endforeach ?>
</ul>

<?php if (!$element['nav_below'] || ($element['nav_below'] && $element['nav_color'])) : ?>
</div>
<?php endif ?>
