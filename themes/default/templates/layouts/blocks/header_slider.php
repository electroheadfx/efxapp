<!DOCTYPE html>

<html lang="fr">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="<?= \Config::get('application.seo.frontend.keywords') ?>">
        <meta name="author" content="<?= \Config::get('application.seo.frontend.author') ?>">
        <meta name="description" content="<?= isset($google_description) ? $google_description : \Config::get('application.seo.frontend.description') ?>">

        <title><?= $title; ?></title>

        <!-- Core Header CSS -->
        <?= \Theme::instance()->asset->render('css_core'); ?>
        <?= \Theme::instance()->asset->render('header'); ?>

        <style>
            
            .top .homeSlide.slide01 .slide-img {
              background: url(/themes/cru2vie-oldstyle/img/sliders/<?= \Config::get('slider.master.background') ?>.jpg) no-repeat bottom center;
              background-size: cover;
            }

            <?php for ($key=0; $key < $nth; $key++): ?>

              .top .homeSlide.slide<?= sprintf("%02d", $key+2) ?> .slide-img {
                background: url(/themes/cru2vie-oldstyle/img/sliders/<?= \Config::get('slider.sliders.'.$slides[$key].'.background') ?>.jpg) no-repeat bottom center;
                background-size: cover;
              }

            <?php endfor; ?>

        </style>

    </head>

    <body class="is-loading <?= $body ?>" >
