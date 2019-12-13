<?php

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

// Countdown
$el->attr([

    'class' => [
        'uk-child-width-auto',
        'uk-grid-{gutter}',
        'uk-flex-{text_align}[@{text_align_breakpoint} [uk-flex-{text_align_fallback}]]',
    ],

    'uk-countdown' => [
        'date: {0}' => $element['date'] ?: date('Y-m-d', strtotime('+1 week')),
    ],

    'uk-grid' => true,

]);

// Label
$label = $this->el('div', [

    'class' => [
        'uk-countdown-label',
        'uk-text-center',
        'uk-visible@s',
        'uk-margin[-{label_margin}]',
    ],

]);

?>

<?= $el($element->props, $element['attrs']) ?>

    <?php foreach (['days', 'hours', 'minutes', 'seconds'] as $unit) : ?>

    <div>

        <div class="uk-countdown-number uk-countdown-<?= $unit ?>"></div>

        <?php if ($element['show_label']) : ?>
            <?= $label($element->props, $element["label_{$unit}"] ?: ucfirst($unit)) ?>
        <?php endif ?>

    </div>

    <?php if ($element['show_separator'] && $unit !== 'seconds') : ?>
        <div class="uk-countdown-separator">:</div>
    <?php endif ?>

    <?php endforeach ?>

</div>
