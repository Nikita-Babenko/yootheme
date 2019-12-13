<?php

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

$el->attr('class', [
    'uk-alert',
    'uk-alert-{alert_style}',
    'uk-padding {@alert_size}',
]);

?>

<?= $el($element->props, $element['attrs']) ?>

    <?php if ($element['title']) : ?>
    <h3 class="el-title"><?= $element['title'] ?></h3>
    <?php endif ?>

    <div class="el-content"><?= $element ?></div>

</div>
