<?php

// Swicher
$switcher = $this->el('ul', [
    'id' => "js-{$this->uid()}",
    'class' => 'uk-switcher',
]);

// Switcher nav
$switcher_nav = $this->el('ul', [
    'class' => 'uk-dotnav uk-flex-center uk-margin',
    'uk-switcher' => "connect: #{$switcher->attrs['id']}; animation: uk-animation-fade;",
]);

?>

<?= $switcher() ?>

    <?php foreach ($element as $item) : ?>
    <li><?= $this->render('@builder/popover/template-item', compact('item')) ?></li>
    <?php endforeach ?>

</ul>

<?= $switcher_nav() ?>
    <?php foreach ($element as $item) : ?>
    <li><a href="#"></a></li>
    <?php endforeach ?>
</ul>
