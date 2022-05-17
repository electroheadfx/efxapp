<header class="navbar navbar-inverse navbar-static-top" id="top" role="banner" >
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= \Router::get('homepage'); ?>"><img src="<?= \Theme::instance()->img('logo-post.png') ?>" alt="<?= \Config::get('application.seo.frontend.title') ?>"></a>
        </div>

        <div class="collapse navbar-collapse navbar-ex1-collapse navbar-right">
            <ul class="nav navbar-nav">
                <li><a href="<?= \Router::get('homepage'); ?>"><i class="fa fa-angle-left"></i> <?= __('application.back-to-front') ?></a></li>
            </ul>
        </div>

    </div><!-- /.container -->
</header>