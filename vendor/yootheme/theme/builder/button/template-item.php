<?php

// Button
$button = $this->el('a', [

    'class' => $this->expr([
        'el-content',
        'uk-width-1-1 {@fullwidth}',
        'uk-{button_style: link-\w+}' => ['button_style' => $item['button_style']],
        'uk-button uk-button-{!button_style: |link-\w+} [uk-button-{button_size}]' => ['button_style' => $item['button_style']],
    ], $element->props),

    'title' => ['{link_title}'],

]);

$button->attr($item['link_target'] == 'modal' ? [
    'href' => ['#{id}'],
    'uk-toggle' => true,
] : [
    'href' => ['{link}'],
    'target' => ['_blank {@link_target}'],
    'uk-scroll' => strpos($item['link'], '#') === 0,
]);

?>

<?= $button($item->props) ?>

    <?php if ($item['icon']) : ?>

        <?php if ($item['icon_align'] == 'left') : ?>
        <span uk-icon="<?= $item['icon'] ?>"></span>
        <?php endif ?>

        <span class="uk-text-middle"><?= $item['content'] ?></span>

        <?php if ($item['icon_align'] == 'right') : ?>
        <span uk-icon="<?= $item['icon'] ?>"></span>
        <?php endif ?>

    <?php else : ?>
    <?= $item['content'] ?>
    <?php endif ?>

</a>


