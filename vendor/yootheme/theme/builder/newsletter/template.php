<?php

$el = $this->el('div', [
    'id' => $element['id'],
    'class' => $element['class'],
]);

// Layout
$grid = $this->el('div', [
    'class' => [
        'uk-grid-{gutter}',
        'uk-child-width-expand@s {@layout: grid}',
        'uk-child-width-1-1 {@layout: stacked(-name)?}',
    ],

    'uk-grid' => true,
]);

// Input
$input = $this->el('input', [
    'class' => [
        'el-input',
        'uk-input',
        'uk-form-{form_size}',
        'uk-form-{form_style}',
    ],
]);

// Button
$button = $this->el('button', [
    'class' => $element['button_mode'] == 'button' ? [
        'el-button',
        'uk-button uk-button-{button_style}',
        'uk-button-{form_size} {@!button_style: text}',
        'uk-width-1-1 {@button_fullwidth} {@!layout: grid}',
        'uk-margin[-small{@!button_margin: default}]-{0} {@show_name} {@button_margin}' => $element['layout'] == 'grid' ? 'left' : 'top',
    ] : 'el-button uk-form-icon uk-form-icon-flip',

    'uk-icon' => [
        'icon: {button_icon}; {@!button_mode: button}',
    ],
]);

?>

<?= $el($element->props, $element['attrs']) ?>

    <form class="uk-form uk-panel js-form-newsletter" method="post"<?= $this->attrs($attrs_form) ?>>

        <?= $grid($element->props) ?>

            <?php if ($element['show_name']) : ?>

                <?php if ($element['layout'] == 'stacked-name') : ?>
                <div>
                    <div class="uk-child-width-1-2@s <?= $element['gutter'] ? "uk-grid-{$element['gutter']}" : '' ?>" uk-grid>
                <?php endif ?>

                <div><?= $input($element->props, ['name' => 'first_name', 'placeholder' => ['{label_first_name}']]) ?></div>
                <div><?= $input($element->props, ['name' => 'last_name', 'placeholder' => ['{label_last_name}']]) ?></div>

                <?php if ($element['layout'] == 'stacked-name') : ?>
                    </div>
                </div>
                <?php endif ?>

            <?php endif ?>

            <?php if ($element['button_mode'] == 'button') : ?>

                <div><?= $input($element->props, ['type' => 'email', 'name' => 'email', 'placeholder' => ['{label_email}'], 'required' => true]) ?></div>
                <?= $this
                    ->el('div', ['class' => ['uk-width-auto@s {@layout: grid}']], $button($element->props, ['type' => 'submit'], $element['label_button'] ?: ''))
                    ->render($element->props) ?>

            <?php endif ?>

            <?php if ($element['button_mode'] == 'icon') : ?>
            <div class="uk-position-relative">
                <?= $button($element->props, ['title' => ['{label_button}']], '') ?>
                <?= $input($element->props, ['type' => 'email', 'name' => 'email', 'placeholder' => ['{label_email}'], 'required' => true]) ?>
            </div>
            <?php endif ?>

        </div>

        <input type="hidden" name="settings" value="<?= $settings ?>">
        <div class="message uk-margin uk-hidden"></div>

    </form>

</div>
