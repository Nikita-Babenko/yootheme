<?php

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

$el->attr('class', [
    'uk-text-{text_style}',
    'uk-text-{text_size} {@!text_style}',
    'uk-text-{text_color} {@!text_style}',
    'uk-dropcap {@dropcap}',
    'uk-column-{column}[@{column_breakpoint}]',
    'uk-column-divider {@column} {@column_divider}',
]);

// Column
$breakpoints = ['xl', 'l', 'm', 's', ''];

if ($element['column'] && false !== $index = array_search($element['column_breakpoint'], $breakpoints)) {

    list(, $columns) = explode('-', $element['column']);

    foreach (array_splice($breakpoints, $index + 1, 4) as $breakpoint) {

        if ($columns < 2) {
            break;
        }

        $el->attr('class', [
            'uk-column-1-'.(--$columns).($breakpoint ? "@{$breakpoint}" : ''),
        ]);
    }
}

echo $el($element->props, $element['attrs'], $element);
