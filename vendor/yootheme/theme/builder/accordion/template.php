<?php

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],
    'uk-accordion' => [
        'multiple: {multiple};',
        'collapsible: {0};' => $element['collapsible'] ? 'true' : 'false',
    ],
]);

?>

<?= $el($element->props, $element['attrs']) ?>

    <?php foreach ($element as $item) : ?>
    <div class="el-item">

        <a class="el-title uk-accordion-title" href="#"><?= $item['title'] ?></a>

        <div class="uk-accordion-content">
            <?= $this->render('@builder/accordion/template-item', compact('item')) ?>
        </div>

    </div>
    <?php endforeach ?>

</div>
