<?php

// Display
if (!$element['show_image']) {
    $item['image'] = '';
    $item['icon'] = '';
}

if (!$element['show_link']) {
    $item['link'] = '';
}

// Image Align
$grid = $this->el('div', [

    'class' => [
        'uk-grid-small uk-child-width-expand uk-flex-nowrap',
        'uk-flex-middle {@image_vertical_align}',
    ],

    'uk-grid' => true,
]);

$cell = $this->el('div', [

    'class' => [
        'uk-width-auto',
        'uk-flex-last {@image_align: right}',
    ],

]);

// Image
if ($item['image']) {

    $image = $this->el('image', [

        'class' => [
            'el-image',
            'uk-border-{image_border}',
        ],

        'src' => $item['image'],
        'alt' => $item['image_alt'],
        'width' => $element['image_width'],
        'height' => $element['image_height'],
        'uk-svg' => (bool) $element['image_inline_svg'],
        'thumbnail' => true,
    ]);

    $item['image'] = $image($element->props);

} elseif ($item['icon'] || $element['icon']) {

    $icon = $this->el('span', [

        'class' => [
            'el-image',
            'uk-text-{icon_color}',
        ],

        'uk-icon' => [
            'icon: {icon};',
            'ratio: {icon_ratio};',
        ],

    ]);

    $item['image'] = $icon(array_merge($element->props, array_filter($item->props)), '');
}

// Content
$content = $this->el('div', [

    'class' => [
        'el-content',
        'uk-[text-{@content_style: bold|muted}]{content_style}',
    ],

]);

// Link
if ($item['link']) {

    $link = $this->el('a', [

        'class' => [
            'el-link',
            'uk-link-{0}' => $element['link_style'],
        ],

        'href' => ['{link}'],
        'target' => ['_blank {@link_target}'],
        'uk-scroll' => strpos($item['link'], '#') === 0,
    ]);

    $item['content'] = $link($item->props, $item['content'] ?: '');

    if ($item['image']) {

        $link = $this->el('a', [
            'class' => ['uk-link-reset'],
            'href' => ['{link}'],
        ]);

        $item['image'] = $link($item->props, $item['image']);
    }
}

?>

<?php if ($item['image']) : ?>
    <?= $grid($element->props) ?>
        <?= $cell($element->props, $item['image']) ?>
        <div>
            <?= $content($element->props, $item['content'] ?: '') ?>
        </div>
    </div>
<?php else : ?>
    <?= $content($element->props, $item['content'] ?: '') ?>
<?php endif ?>
