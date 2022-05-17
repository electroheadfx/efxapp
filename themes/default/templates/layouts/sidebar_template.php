
<header class="navbar navbar-default <?= $navbar ?> navbar-static-top" id="topbar" role="navigation" >

        <div class="navbar-header">
            
            <button type="button" class="navbar-toggle collapsed" >
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>

        <div class="logo-navbar hidden-sm hidden-md hidden-lg bar navbar navbar-static-top">
            <a href="<?= \Router::get('homepage'); ?>">
                <?php echo \Theme::instance()->asset->img('logo-navbar.svg', array('alt' => \Config::get('application.seo.frontend.title') )); ?>
            </a>
        </div>
    
    <?php if(isset($pageTitle) && isset($titleicon) && \Auth::check() ): ?>

        <div class="navbar-left">
            <h4><i class="fa fa-<?= $titleicon; ?>"></i> <?= $pageTitle; ?></h4>
        </div>
          
    <?php endif; ?>
            
    <div class="collapse navbar-collapse navbar-right">
    

        <div id="sidebar" class="bar navbar-right col-sm-3 col-md-3 col-lg-3" >
            
            <div class="logo-sidebar hidden-xs">
                <a href="<?= \Router::get('homepage'); ?>">
                    <?php echo \Theme::instance()->asset->img('logo-sidebar.svg', array('alt' => \Config::get('application.seo.frontend.title') )); ?>
                </a>
            </div>
            <?php if (isset($menu_cats)): ?>
                <!-- categories menu here -->
                <div class="menu-de-navigation vertical">

                    <ul class="list-unstyled filters" >

                        <?php if ( count($menu_cats) > 1 ): ?>

                            <?php foreach ($menu_cats as $cat): ?>

                                <li class="button-category" >
                                    <?php if ( $cat->slug == 'all'): ?>
                                        <a href="<?= $this->active_module; ?>#filter=*" data-filter="*" class="<?= strtolower($cat->slug); ?> active"><?= $cat->name; ?></a>
                                    <?php else: ?>
                                        <a href="<?= $this->active_module; ?>#filter=.<?= strtolower($cat->slug) ?>" data-filter="<?= '.'.strtolower($cat->slug) ?>" class="<?= strtolower($cat->slug); ?>"><?= $cat->name; ?></a>
                                    <?php endif; ?>
                                </li>

                            <?php endforeach; ?>
                            
                        <?php endif; ?>

                    </ul>
                </div>
            <?php endif; ?>

        </div>
    
<!--  -->
    </div>
  

</header>