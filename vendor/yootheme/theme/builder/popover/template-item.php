<?php

// Display
foreach (['title', 'meta', 'content', 'image', 'link'] as $key) {
    if (!$element["show_{$key}"]) { $item[$key] = ''; }
}

// Item
$el = $this->el('div', [
    'class' => [
        'el-item',
        'uk-card uk-card-{card_style}',
        'uk-card-{card_size}',
        'uk-card-hover {@link_style: card}' => $item['link'],
        'uk-card-body' => !($item['image'] && $element['image_card']),
    ],
]);

// Link
$link = $this->el('a', [
    'class' => [
        'el-link',
        'uk-position-cover uk-margin-remove-adjacent {@link_style: card}',
        'uk-{link_style: link-\w+}',
        'uk-button uk-button-{!link_style: |link-\w+} [uk-button-{link_size}] {@!link_style: card}',
    ],

    'href' => $item['link'],
    'target' => ['_blank {@link_target}'],
    'uk-scroll' => strpos($item['link'], '#') === 0,
]);

?>

<?= $el($element->props) ?>

    <?php if ($item['link'] && $element['link_style'] == 'card') : ?>
    <?= $link($element->props, '') ?>
    <?php endif ?>

    <?= $this->render('@builder/popover/template-image', compact('item')) ?>

    <?php if ($item['image'] && $element['image_card']) : ?>
        <div class="uk-card-body">
            <?= $this->render('@builder/popover/template-content', compact('item', 'link')) ?>
        </div>
    <?php else : ?>
        <?= $this->render('@builder/popover/template-content', compact('item', 'link')) ?>
    <?php endif ?>

</div>
