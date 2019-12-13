<?php

$nav = $this->el('ul', [

    'class' => [

        'el-nav uk-slider-nav',

        // Style
        'uk-{nav}',

        // Alignment
        'uk-flex-{nav_align}',

    ],

    // Wrapping
    'uk-margin' => true,

]);

$nav_container = $this->el('div', [

    'class' => [

        // Margin
        'uk-margin[-{nav_margin}]-top',

        // Breakpoint
        'uk-visible@{nav_breakpoint}',

        // Color
        'uk-{nav_color}',
    ],

]);

?>

<?php if ($element['nav_color']) : ?>
<?= $nav_container($element->props, $nav($element->props, '')) ?>
<?php else : ?>
<?= $nav($element->props, $nav_container->attrs, '') ?>
<?php endif ?>
