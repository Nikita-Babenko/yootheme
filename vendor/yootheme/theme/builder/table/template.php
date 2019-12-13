<?php

use YOOtheme\Util\Arr;

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

$el->attr($element['attrs']);

$el->attr('class', [
    // Responsive
    'uk-overflow-auto {@table_responsive: overflow}',
]);

$text_fields = ['title', 'meta', 'content'];

switch ($element['table_order'] ?: 1) {
    case 1:
        $fields = ['meta', 'image', 'title', 'content', 'link'];
        break;
    case 2:
        $fields = ['title', 'image', 'meta', 'content', 'link'];
        break;
    case 3:
        $fields = ['image', 'title', 'content', 'meta', 'link'];
        break;
    case 4:
        $fields = ['image', 'title', 'meta', 'content', 'link'];
        break;
    case 5:
        $fields = ['title', 'meta', 'content', 'link', 'image'];
        break;
    case 6:
        $fields = ['meta', 'title', 'content', 'link', 'image'];
        break;
}

// Find empty fields
$filtered = array_values(Arr::filter($fields, function ($field) use ($element) {
    return $element["show_{$field}"] && Arr::some($element->children, function ($item) use ($field) {
        return $item[$field];
    });
}));

$table = $this->el('table', [
    'class' => [

        // Style
        'uk-table',
        'uk-table-{table_style}',
        'uk-table-hover {@table_hover}',
        'uk-table-justify {@table_justify}',

        // Size
        'uk-table-{table_size}',

        // Vertical align
        'uk-table-middle {@table_vertical_align}',

        // Responsive
        'uk-table-responsive {@table_responsive: responsive}',
    ],
]);

?>

<?php if ($element['table_responsive'] == 'overflow') : ?>
<?= $el($element->props) ?>
    <?= $table($element->props) ?>
<?php else : ?>
    <?= $table($element->props, $el->attrs) ?>
<?php endif ?>

        <?php if (Arr::some($filtered, function ($field) use ($element) { return $element["table_head_{$field}"]; })) : ?>
        <thead>
            <tr>

                <?php foreach ($filtered as $i => $field) {

                    echo $this->el('th', [

                        'class' => [
                            // Last column alignment
                            'uk-text-{table_last_align}[@m {@table_responsive: responsive}]' => $i !== 0 && !isset($filtered[$i + 1]),

                            'uk-text-nowrap' => $field == 'link' || in_array($field, $text_fields) && $element["table_width_{$field}"] == 'shrink',
                        ],

                    ], $element["table_head_{$field}"])->render($element->props);

                } ?>

            </tr>
        </thead>
        <?php endif ?>

        <tbody>

        <?php foreach ($element as $i => $item) : ?>

            <tr class="el-item">

                <?php foreach ($filtered as $j => $field) {

                    echo $this->el('td', [
                        'class' => [

                            'uk-text-nowrap' => $field === 'link',

                            "uk-text-nowrap {@table_width_{$field}: shrink}" => in_array($field, $text_fields),

                            // Last column alignment
                            'uk-text-{table_last_align}[@m {@table_responsive: responsive}]' => array_search($field, $fields) > 1 && !isset($filtered[$j + 1]),

                            // Widths
                            "uk-[table {@table_width_{$field}: shrink}][width {@!table_width_{$field}: shrink}]-{table_width_{$field}}" => $i == 0 && in_array($field, $text_fields),
                            'uk-table-shrink' => $i == 0 && in_array($field, ['image', 'link']),

                        ],
                    ], $this->render("@builder/table/template-{$field}", compact('item')))->render($element->props);

                } ?>

            </tr>

        <?php endforeach ?>
        </tbody>

    </table>

<?php if ($element['table_responsive'] == 'overflow') : ?>
</div>
<?php endif ?>
