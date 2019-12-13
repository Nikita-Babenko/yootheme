<?php

$el = $this->el($element['divider_element'], [
    'id' => $element['id'],
    'class' => $element['class'],
]);

$el->attr('class', [
    'uk-divider-{divider_style}',
    'uk-hr {!divider_style} {@divider_element: div}',
    'uk-text-{divider_align}[@{divider_align_breakpoint} [uk-text-{divider_align_fallback}] {@!divider_align: justify}] {@divider_style: small}',
]);

echo $el($element->props, $element['attrs'], '');
