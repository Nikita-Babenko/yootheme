<?php

$el = $this->el('ul', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

$el->attr('class', [
    'uk-list',
    'uk-list-{list_style}',
    'uk-list-large {@list_size}',
]);

?>

<?= $el($element->props, $element['attrs']) ?>
    <?php foreach ($element as $item) : ?>
    <li class="el-item"><?= $this->render('@builder/list/template-item', compact('item')) ?></li>
    <?php endforeach ?>
</ul>
