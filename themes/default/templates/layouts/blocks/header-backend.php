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

    </head>

    <body class="<?= $body ?>" >