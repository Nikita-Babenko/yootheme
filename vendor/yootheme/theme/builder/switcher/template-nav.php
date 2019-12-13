<?php

$nav = $this->el('ul', [

    'class' => [
        'el-nav',
        'uk-margin[-{switcher_margin}] {@switcher_position: top|bottom}',
        'uk-{switcher_style: thumbnav} [uk-flex-nowrap {@switcher_thumbnail_nowrap}]',
    ],

    $element['switcher_style'] == 'tab' ? 'uk-tab' : 'uk-switcher' => [
        'connect: #{connect};',
        'animation: uk-animation-{switcher_animation};',
        'media: @{switcher_breakpoint} {@switcher_position: left|right} {@switcher_style: tab};',
    ],

    'uk-margin' => ['1{@switcher_style: thumbnav} {@!switcher_thumbnail_nowrap}'],
]);

$nav_horizontal = [
    'uk-subnav {@switcher_style: subnav-.*}',
    'uk-{switcher_style: subnav.*}',
    'uk-tab-{switcher_position: bottom} {@switcher_style: tab}',
    'uk-flex-{switcher_align: right|center}',
    'uk-child-width-expand {@switcher_align: justify}',
];

$nav_vertical = [
    'uk-nav uk-nav-[primary {@switcher_style_primary}][default {@!switcher_style_primary}] [uk-text-left {@text_align}] {@switcher_style: subnav.*}',
    'uk-tab-{switcher_position} {@switcher_style: tab}',
    'uk-thumbnav-vertical {@switcher_style: thumbnav}',
];

$nav_switcher = in_array($element['switcher_position'], ['top', 'bottom'])
    ? ['class' => $nav_horizontal]
    : [
        'class' => $nav_vertical,
        'uk-toggle' => $element['switcher_style'] != 'tab' ? [
            "cls: {$this->expr(array_merge($nav_vertical, $nav_horizontal), $element->props)};",
            'mode: media;',
            'media: @{switcher_breakpoint};',
        ] : false,
    ];

?>

<?= $nav($element->props, $nav_switcher) ?>
    <?php foreach ($element as $item) :

        // Display
        if (!$element['show_title']) { $item['title'] = ''; }
        if (!$element['show_meta']) { $item['meta'] = ''; }
        if (!$element['show_content']) { $item['content'] = ''; }
        if (!$element['show_image']) { $item['image'] = ''; }
        if (!$element['show_link']) { $item['link'] = ''; }
        if (!$element['show_label']) { $item['label'] = ''; }
        if (!$element['show_thumbnail']) { $item['thumbnail'] = ''; }

        // Image
        $image = $this->el('image', [
            'src' => $item['thumbnail'] ?: $item['image'],
            'alt' => $item['label'] ?: $item['title'],
            'width' => $element['switcher_thumbnail_width'],
            'height' => $element['switcher_thumbnail_height'],
            'uk-svg' => (bool) $element['switcher_thumbnail_inline_svg'],
            'thumbnail' => true,
        ]);

        $thumbnail = $image->attrs['src'] && $element['switcher_style'] == 'thumbnav' ? $image() : '';
    ?>
    <li>
        <a href="#"><?= $thumbnail ?: $item['label'] ?: $item['title'] ?></a>
    </li>
    <?php endforeach ?>
</ul>
