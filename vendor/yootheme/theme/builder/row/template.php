<?php

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

$el->attr($element['attrs']);

$el->attr([

    'class' => [
        'uk-grid-{gutter}',
        'uk-grid-divider {@divider} {@!gutter: collapse}',
    ],

    'uk-grid' => true,

    // Height Viewport
    'uk-height-viewport' => [
        'offset-top: true; {@height}',
        'offset-bottom: 20; {@height: percent}',
    ],

    // Match height if single panel element inside cell
    'uk-height-match' => ['target: .uk-card; row: false {@match}'],
]);

// Visibility
$visibilities = ['xs', 's', 'm', 'l', 'xl'];
$visible = $element->count() ? 4 : false;

foreach ($element as $ele) {
    $visible = min(array_search($ele['visibility'], $visibilities), $visible);
}

if ($visible) {
    $element['visibility'] = $visibilities[$visible];
    $el->attr('class', ["uk-visible@{$visibilities[$visible]}"]);
}

// Margin
$margin = $this->el('div', [
    'class' => [

        'uk-grid-margin[-{gutter}] {@!margin} {@gutter: |small|medium|large}',

        'uk-margin {@margin: default}',
        'uk-margin-{!margin: |default}',
        'uk-margin-remove-top {@margin_remove_top}{@!margin: remove-vertical}',
        'uk-margin-remove-bottom {@margin_remove_bottom}{@!margin: remove-vertical}',

        'uk-container {@width}',
        'uk-container-{width}{@width: small|large|expand}',
        'uk-container-expand-{width_expand} {@width: default|small|large}',
    ],
]);

?>

<?php if ($element['width']) : ?>

<?= $margin($element->props, $el($element->props, $element)) ?>

<?php else : ?>

<?= $el($element->props, $margin->attrs, $element) ?>

<?php endif ?>

