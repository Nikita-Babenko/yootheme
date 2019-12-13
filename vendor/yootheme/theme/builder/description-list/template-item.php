<?php

// Display
foreach (['title', 'meta', 'content', 'link'] as $key) {
    if (!$element["show_{$key}"]) { $item[$key] = ''; }
}

// Layout
$grid = $this->el('div', [

    'class' => [
        'uk-child-width-{0}[@{breakpoint}]' => $element['width'] == 'expand' ? 'auto' : 'expand',
    ],

    'uk-grid' => true,
]);

$cell = $this->el('div', [

    'class' => [
        'uk-width-{width}[@{breakpoint}]',
        'uk-text-break {@width: small|medium}',
    ],

]);

?>

<?php if ($element['layout'] == 'stacked') : ?>

    <?php if ($element['meta_align'] == 'top-title') : ?>
    <?= $this->render('@builder/description-list/template-meta', compact('item')) ?>
    <?php endif ?>

    <?= $this->render('@builder/description-list/template-title', compact('item')) ?>

    <?php if (in_array($element['meta_align'], ['bottom-title', 'top-content'])) : ?>
    <?= $this->render('@builder/description-list/template-meta', compact('item')) ?>
    <?php endif ?>

    <?= $this->render('@builder/description-list/template-content', compact('item')) ?>

    <?php if ($element['meta_align'] == 'bottom-content') : ?>
    <?= $this->render('@builder/description-list/template-meta', compact('item')) ?>
    <?php endif ?>

<?php elseif ($element['layout'] == 'grid-2') : ?>

    <?= $grid($element->props, ['class' => ['uk-grid-{gutter}']]) ?>
        <?= $cell($element->props) ?>

            <?php if ($element['meta_align'] == 'top-title') : ?>
            <?= $this->render('@builder/description-list/template-meta', compact('item')) ?>
            <?php endif ?>

            <?= $this->render('@builder/description-list/template-title', compact('item')) ?>

            <?php if ($element['meta_align'] == 'bottom-title') : ?>
            <?= $this->render('@builder/description-list/template-meta', compact('item')) ?>
            <?php endif ?>

        </div>
        <div>

            <?php if ($element['meta_align'] == 'top-content') : ?>
            <?= $this->render('@builder/description-list/template-meta', compact('item')) ?>
            <?php endif ?>

            <?= $this->render('@builder/description-list/template-content', compact('item')) ?>

            <?php if ($element['meta_align'] == 'bottom-content') : ?>
            <?= $this->render('@builder/description-list/template-meta', compact('item')) ?>
            <?php endif ?>

        </div>
    </div>

<?php else : ?>

    <?= $grid($element->props, ['class' => [$element['leader'] && $element['width'] == 'expand' ? 'uk-grid-small uk-flex-bottom' : 'uk-flex-middle [uk-grid-{gutter}]']]) ?>
        <?= $cell($element->props) ?>
            <?= $this->render('@builder/description-list/template-title', compact('item')) ?>
        </div>
        <div>
            <?= $this->render('@builder/description-list/template-meta', compact('item')) ?>
        </div>
    </div>

    <?= $this->render('@builder/description-list/template-content', compact('item')) ?>

<?php endif ?>
