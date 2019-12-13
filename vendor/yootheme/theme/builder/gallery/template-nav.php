<?php

$nav = $this->el('ul', [

    'class' => [
        'el-nav',
        'uk-margin[-{filter_margin}] {@filter_position: top}',
    ],

    'uk-tab' => [
        'media: @{filter_breakpoint}; {@filter_position: left|right} {@filter_style: tab}',
    ],

]);

$nav_horizontal = [
    'uk-subnav {@filter_style: subnav-.*}',
    'uk-{filter_style}',
    'uk-flex-{filter_align: right|center}',
    'uk-child-width-expand {@filter_align: justify}',
];

$nav_vertical = [
    'uk-nav uk-nav-{0} [uk-text-left {@text_align}] {@filter_style: subnav.*}' => $element['filter_style_primary'] ? 'primary' : 'default',
    'uk-tab-{filter_position} {@filter_style: tab}',
];

$nav_attrs = $element['filter_position'] === 'top'
    ? ['class' => $nav_horizontal]
    : ['class' => $nav_vertical,
        'uk-toggle' => $element['filter_style'] != 'tab'
            ? [
            "cls: {$this->expr(array_merge($nav_vertical, $nav_horizontal), $element->props)};",
            'mode: media;',
            'media: @{filter_breakpoint};',
        ] : false,
    ];

?>

<?= $nav($element->props, $nav_attrs) ?>

    <?php if ($element['filter_all']) : ?>
    <li class="uk-active" uk-filter-control><a href><?= $element['filter_all_label'] ?: 'All' ?></a></li>
    <?php endif ?>

    <?php $tags = $element['tags']; $first = key($tags); ?>
    <?php foreach ($tags as $tag => $name) : ?>
    <li<?= (string) $tag === $first && !$element['filter_all'] ? ' class="uk-active"' : '' ?> uk-filter-control="[data-tag~='<?= $tag ?>']">
        <a href="#"><?= ucwords($name) ?></a>
    </li>
    <?php endforeach ?>

</ul>
