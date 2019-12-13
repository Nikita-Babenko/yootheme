<?php

$el = $this->el('pre', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

?>

<?= $el($element->props, $element['attrs']) ?>
    <code class="el-content"><?= str_replace("\n", '', $this->apply($element, 'e|nl2br')) ?></code>
</pre>
