<?php

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

// Subnav
$subnav = $this->el('ul', [

    'class' => [
        'uk-subnav uk-margin-remove-bottom [uk-subnav-{subnav_style}]',
        'uk-flex-{text_align}[@{text_align_breakpoint} [uk-flex-{text_align_fallback}]]',
    ],

    'uk-margin' => true,
]);

// Link
$link = $this->el('a', [

    'class' => [
        'el-link',
        'uk-link-{link_style}',
    ],

]);

?>

<?= $el($element->props, $element['attrs']) ?>

    <?= $subnav($element->props) ?>
        <?php foreach ($element as $item) : ?>
            <li class="el-item">

                <?php if ($item['link']) : ?>
                    <?= $link($element->props, [
                        'href' => $item['link'],
                        'uk-scroll' => strpos($item['link'], '#') === 0,
                        'target' => $item['link_target'] ? '_blank' : '',
                    ], $item['content']) ?>
                <?php else : ?>
                    <a class="el-content uk-disabled"><?= $item['content'] ?></a>
                <?php endif ?>

            </li>
        <?php endforeach ?>
    </ul>

</div>
