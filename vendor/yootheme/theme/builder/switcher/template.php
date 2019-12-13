<?php

$element['connect'] = "js-{$this->uid()}";

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

// Nav Alignment
$grid = $this->el('div', [

    'class' => [
        'uk-child-width-expand',
        'uk-grid-{switcher_gutter}',
        'uk-flex-middle {@switcher_vertical_align}',
    ],

    'uk-grid' => true,
]);

$cell = $this->el('div', [

    'class' => [
        'uk-width-{switcher_grid_width}@{switcher_breakpoint}',
        'uk-flex-last@{switcher_breakpoint} {@switcher_position: right}',
    ],

]);

// Content
$content = $this->el('ul', [
    'id' => ['{connect}'],
    'class' => 'uk-switcher',
    'uk-height-match' => ['row: false {@switcher_height}'],
]);

?>

<?= $el($element->props, $element['attrs']) ?>

    <?php if (in_array($element['switcher_position'], ['left', 'right'])) : ?>

        <?= $grid($element->props) ?>
            <?= $cell($element->props, $this->render('@builder/switcher/template-nav')) ?>
            <div>

                <?= $content($element->props) ?>
                    <?php foreach ($element as $item) : ?>
                    <li class="el-item"><?= $this->render('@builder/switcher/template-item', compact('item')) ?></li>
                    <?php endforeach ?>
                </ul>

            </div>
        </div>

    <?php else : ?>

        <?php if ($element['switcher_position'] == 'top') : ?>
        <?= $this->render('@builder/switcher/template-nav') ?>
        <?php endif ?>

        <?= $content($element->props) ?>
            <?php foreach ($element as $item) : ?>
            <li class="el-item"><?= $this->render('@builder/switcher/template-item', compact('item')) ?></li>
            <?php endforeach ?>
        </ul>

        <?php if ($element['switcher_position'] == 'bottom') : ?>
        <?= $this->render('@builder/switcher/template-nav') ?>
        <?php endif ?>

    <?php endif ?>

</div>
