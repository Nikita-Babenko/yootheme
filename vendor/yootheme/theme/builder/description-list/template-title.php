<?php

if (!$item['title']) {
    return;
}

// Title
$title = $this->el('span', [

    'class' => [
        'el-title',
        'uk-display-block {@title_style: |strong}',
        'uk-text-{!title_color: |background}',
    ],

]);

// Leader
if ($element['leader'] && $element['layout'] == 'grid-2-m' && $element['width'] == 'expand') {
    $title->attr('uk-leader', $element['breakpoint'] ? "media: @{$element['breakpoint']}" : true);
}

// Color
if ($element['title_color'] == 'background') {
    $item['title'] = "<span class=\"uk-text-background\">{$item['title']}</span>";
}

// Colon
if ($element['title_colon']) {
    $item['title'] .= ':';
}

?>

<?php if ($element['title_style'] == 'strong') : ?>
    <?= $title($element->props, [], $item['title'], 'strong') ?>
<?php elseif (preg_match('/^h[1-6]$/', $element['title_style'])) : ?>
    <?= $title($element->props, ['class' => ['uk-{title_style} uk-margin-remove']], $item['title'], 'h3') ?>
<?php else : ?>
    <?= $title($element->props, $item['title']) ?>
<?php endif ?>
