<?php

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

?>

<?= $el($element->props, $element['attrs'], $element['content']) ?>