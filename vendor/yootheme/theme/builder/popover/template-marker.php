<?php

// Marker
$marker = $this->el('a', [
    'class' => 'el-marker uk-position-absolute uk-transform-center',
    'style' => [
        'top: {0};' => (is_numeric(rtrim($item['position_y'], '%')) ? (float) $item['position_y'] : 50).'%',
        'left: {0};' => (is_numeric(rtrim($item['position_x'], '%')) ? (float) $item['position_x'] : 50).'%',
    ],
    'uk-marker' => true,
    'href' => '#',
]);

// Drop
$drop = $this->el('div', [
    'style' => [
        'width: {0}px;' => rtrim($element['drop_width'], 'px') ?: 300,
    ],
    'uk-drop' => [
        'pos: {0};' => $item['drop_position'] ?: $element['drop_position'],
        'mode: click;' => $element['drop_mode'] == 'click',
    ],
]);

?>

<?= $marker($element->props, '') ?>

<?= $drop($element->props) ?>
    <?= $this->render('@builder/popover/template-item', compact('item')) ?>
</div>
