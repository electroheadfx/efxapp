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
        
        <?php if (isset($navbarmargin)) echo \Theme::instance()->view('layouts/blocks/customcss'); ?>

    </head>

    <body class="<?= $body ?>" >

        <?php if ( isset($bgselect) ): ?>
            <?php if ( $bgselect == 'vimeo' ): ?>
                
                <div class="hidden-xs">
                    <div id="bg-rasterbg"></div>
                    <div class="wrap-video-background">
                        <div class="wrap-video-foreground">
                          <iframe id="vimeo-video-background" src="https://player.vimeo.com/video/<?= $bgdata ?>?background=1" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            
            <?php endif; ?>

            <?php if ( $bgselect == 'video' ): ?>

                <div id="wrap" class="hidden-xs">
                    <div id="bg-rasterbg"></div>
                    <video id="video-background" playsinline autoplay muted loop >
                        <source src="<?= $bgdata ?>" type="video/mp4">
                    </video>
                </div>

            <?php endif; ?>
        <?php endif; ?>

