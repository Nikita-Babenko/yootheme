<?php

$site = $theme->get('site', []);

?>

<div class="tm-toolbar uk-visible@<?= $theme->get('mobile.breakpoint') ?>">
    <div class="uk-container uk-flex uk-flex-middle <?= $site['toolbar_fullwidth'] ? 'uk-container-expand' : '' ?> <?= $site['toolbar_center'] ? 'uk-flex-center' : '' ?>">

        <?php if (is_active_sidebar('toolbar-left') || ($site['toolbar_center'] && is_active_sidebar('toolbar-right'))) : ?>
        <div>
            <div class="uk-grid-medium uk-child-width-auto uk-flex-middle" uk-grid="margin: uk-margin-small-top">

                <?php if (is_active_sidebar('toolbar-left')) : ?>
                <?php dynamic_sidebar("toolbar-left:cell") ?>
                <?php endif ?>

                <?php if ($site['toolbar_center'] && is_active_sidebar('toolbar-right')) : ?>
                <?php dynamic_sidebar("toolbar-right:cell") ?>
                <?php endif ?>

            </div>
        </div>
        <?php endif ?>

        <?php if (!$site['toolbar_center'] && is_active_sidebar('toolbar-right')) : ?>
        <div class="uk-margin-auto-left">
            <div class="uk-grid-medium uk-child-width-auto uk-flex-middle" uk-grid="margin: uk-margin-small-top">
                <?php dynamic_sidebar("toolbar-right:cell") ?>
            </div>
        </div>
        <?php endif ?>

    </div>
</div>
