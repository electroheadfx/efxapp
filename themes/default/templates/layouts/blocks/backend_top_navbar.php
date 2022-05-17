<header class="navbar <?= $navbar ?> navbar-static-top" id="top" role="banner" >
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= \Router::get('homepage'); ?>"><img src="<?= \Theme::instance()->img('logo-home.png') ?>" alt="<?= \Config::get('application.seo.frontend.title') ?>"></a>
        </div>

        <div class="collapse navbar-collapse navbar-ex1-collapse navbar-right">
            <ul class="nav navbar-nav">
                <li><a class="<?= \Router::get('admin') == $uri ? 'active' : ''  ?>" href="<?= \Router::get('admin'); ?>"><i class="fa fa-dashboard"></i> <?= __('application.dashboard') ?>         </a></li>
                <li><a href="<?= \Config::get("server.social.account.twitter") ?>" target="_blank" ><i class="fa fa-twitter"></i> <?= __('application.social.account.twitter') ?> </a></li>
                <li><a href="<?= \Config::get("server.social.account.facebook") ?>" target="_blank" ><i class="fa fa-facebook"></i> <?= __('application.social.account.facebook') ?> </a></li>
                <li><a href="<?= \Router::get('logout'); ?>"><i class="fa fa-power-off"></i> Logout</a></li>
            </ul>
        </div>

    </div><!-- /.container -->
</header>
