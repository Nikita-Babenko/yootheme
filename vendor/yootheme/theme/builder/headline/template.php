<?php

$el = $this->el($element['title_element'], [
    'id' => $element['id'],
    'class' => $element['class'],
]);

$el->attr('class', [
    'uk-{title_style}',
    'uk-heading-{title_decoration}',
    'uk-text-{!title_color: |background}',
]);

// Link
$link = $element['link'] ? $this->el('a', [

    'class' => [
        'el-link',
        'uk-link-{0}' => $element['link_style'] ? 'heading' : 'reset',
    ],

    'href' => ['{link}'],
    'target' => ['_blank {@link_target}'],
    'uk-scroll' => strpos($element['link'], '#') === 0,

], $element['content']) : null;

?>

<?= $el($element->props, $element['attrs']) ?>
    <?php if ($element['title_color'] == 'background') : ?>
    <span class="uk-text-background"><?= $link ? $link($element->props) : $element ?></span>
    <?php elseif ($element['title_decoration'] == 'line') : ?>
    <span><?= $link ? $link($element->props) : $element ?></span>
    <?php else : ?>
    <?= $link ? $link($element->props) : $element ?>
    <?php endif ?>
<?= $el->end() ?>
