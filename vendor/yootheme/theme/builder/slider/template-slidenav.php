<?php

$slidenav = $this->el('a', [
    'class' => [
        'el-slidenav',

        // Large
        'uk-slidenav-large {@slidenav_large}',

        'uk-position-{slidenav_margin} {@slidenav: default|outside}',
    ],
    'href' => '#',
]);

$attrs_slidenav_next = [
    'class' => [

        'uk-position-center-right {@slidenav: default}',
        'uk-position-center-right-out {@slidenav: outside}',

    ],
    'uk-slidenav-next' => true,
    'uk-slider-item' => 'next',
    'uk-toggle' => [
        'cls: uk-position-center-right-out uk-position-center-right; mode: media; media: @{slidenav_outside_breakpoint} {@slidenav: outside}',
    ],
];

$attrs_slidenav_previous = [
    'class' => [

        'uk-position-center-left {@slidenav: default}',
        'uk-position-center-left-out {@slidenav: outside}',

    ],
    'uk-slidenav-previous' => true,
    'uk-slider-item' => 'previous',
    'uk-toggle' => [
        'cls: uk-position-center-left-out uk-position-center-left; mode: media; media: @{slidenav_outside_breakpoint} {@slidenav: outside}',
    ],
];

$slidenav_container = $this->el('div', [
    'class' => [

        // Hover
        'uk-hidden-hover uk-hidden-touch {@slidenav_hover}',

        // Breakpoint
        'uk-visible@{slidenav_breakpoint}',
        'uk-slidenav-container uk-position-{!slidenav: default|outside} [uk-position-{slidenav_margin}]',

    ],
]);

if ($element['slidenav'] == 'outside' && ($element['slidenav_color'] != $element['slidenav_outside_color'])) {
    $slidenav_container->attr([
        'class' => [
            // Color
            'js-color-state uk-{slidenav_outside_color} {@!slidenav_color}',
            'js-color-state {@!slidenav_outside_color}',
        ],
        'uk-toggle' => [
            !$element['slidenav_color'] ?
                'cls: js-color-state uk-{slidenav_outside_color}; mode: media; media: @{slidenav_outside_breakpoint}' :
                (!$element['slidenav_outside_color'] ?
                    'cls: js-color-state uk-{slidenav_color}; mode: media; media: @{slidenav_outside_breakpoint}' :
                    'cls: uk-{slidenav_outside_color} uk-{slidenav_color}; mode: media; media: @{slidenav_outside_breakpoint}'),
        ],
    ]);

} else {
    $slidenav_container->attr('class', ['uk-{slidenav_color}']);
}

?>

<?= $slidenav_container($element->props) ?>
    <?= $slidenav($element->props, $attrs_slidenav_previous, '') ?>
    <?= $slidenav($element->props, $attrs_slidenav_next, '') ?>
</div>
