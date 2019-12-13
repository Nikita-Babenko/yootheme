<?php

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

$el->attr('class', [
    'uk-panel {@!style}',
    'uk-card uk-card-body uk-{style}',
    'tm-child-list [tm-child-list-{list_style}] [uk-link-{link_style}] {@is_list}',
]);

// Title
$title = $this->el('h3', [

    'class' => [
        'el-title',
        'uk-{title_style}',
        'uk-heading-{title_decoration}',
        'uk-card-title {@style} {@!title_style}',
        'uk-text-{!title_color: |background}',
    ],

]);

?>

<?= $el($element->props, $element['attrs']) ?>

    <?php if ($element['showtitle']) : ?>
        <?php if ($element['title_color'] == 'background') : ?>
            <?= $title($element->props) ?><span class="uk-text-background"><?= $element->title ?></span><h3>
        <?php elseif ($element['title_decoration'] == 'line') : ?>
            <?= $title($element->props) ?><span><?= $element->title ?></span></h3>
        <?php else: ?>
            <?= $title($element->props, $element->title) ?>
        <?php endif ?>
    <?php endif ?>

    <?= $element ?>

</div>
