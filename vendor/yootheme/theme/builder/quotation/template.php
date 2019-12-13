<?php

// Link
$link = $this->el('a', [
    'class' => [
        'uk-link-{link_style}',
    ],

    'href' => ['{link}'],
    'target' => ['_blank {@link_target}'],
]);

$el = $this->el('blockquote', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

?>

<?= $el($element->props, $element['attrs']) ?>

    <?= $element ?>

    <?php if ($element['footer'] || $element['author']) : ?>
    <footer class="el-footer">

        <?= $element['footer'] ?>

        <?php if ($element['author']) : ?>

            <?php if ($element['link']) : ?>
            <cite class="el-author"><?= $link($element->props, $element['author']) ?></cite>
            <?php else : ?>
            <cite class="el-author"><?= $element['author'] ?></cite>
            <?php endif ?>

        <?php endif ?>

    </footer>
    <?php endif ?>

</blockquote>
