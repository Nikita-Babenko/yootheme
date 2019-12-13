<?php

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

// Grid
$grid = $this->el('div', [

    'class' => [
        'uk-flex-middle [uk-grid-{gutter}]',
        'uk-child-width-{0}' => $element['fullwidth'] ? '1-1' : 'auto',
        'uk-flex-{text_align}[@{text_align_breakpoint} [uk-flex-{text_align_fallback}]] {@!fullwidth}',
    ],

    'uk-grid' => true,
]);

?>

<?= $el($element->props, $element['attrs']) ?>

    <?php if (count($element) > 1) : ?>
    <?= $grid($element->props) ?>
    <?php endif ?>

    <?php foreach ($element as $item) : ?>

        <?php if (count($element) > 1) : ?>
        <div class="el-item">
        <?php endif ?>

        <?php $item['id'] = "js-{$this->uid()}" ?>
        <?= $this->render('@builder/button/template-item', compact('item')) ?>
        <?= $this->render('@builder/button/template-lightbox', compact('item')) ?>

        <?php if (count($element) > 1) : ?>
        </div>
        <?php endif ?>

    <?php endforeach ?>

    <?php if (count($element) > 1) : ?>
    </div>
    <?php endif ?>

</div>
