<?php

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

// Sidebar
$layout = $element['layout'] == 'stack' ? 'grid-stack' : 'grid';

?>

<?= $el($element->props, $element['attrs']) ?>
    <?php dynamic_sidebar($element.":{$layout}") ?>
</div>
