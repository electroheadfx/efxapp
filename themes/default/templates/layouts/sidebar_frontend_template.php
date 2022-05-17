
<header class="navbar navbar-default <?= $navbar ?> navbar-<?= isset($navbarstate) ? $navbarstate : 'fixed' ?>-top" id="topbar" role="navigation" >

        <nav class="navbar navbar-default" role="navigation">

            <div class="navbar-right access">
                
                <?= \Theme::instance()->view('layouts/blocks/menus_setup'); ?>
                
            </div>

            <div class="navbar-left menus hidden-xs">
              
                <?= \Theme::instance()->view('layouts/blocks/menus'); ?>
              
            </div>

        <!-- </div> -->
        
            <div class="navbar-header">

                <?php // if (count($menu_cats) > 1): ?>
                    <button type="button" class="navbar-toggle x" data-toggle="collapse" data-target="#navbar-collapse-x" title="<?= __('application.switch_layout') ?>" data-tooltip="navbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                <?php // endif; ?>
                <div class="navbar-brand logo-navbar hidden-sm hidden-md hidden-lg bar navbar navbar-static-top">
                    <a href="<?= \Router::get('homepage'); ?>">
                        <?php echo \Theme::instance()->asset->img('logo-navbar.svg', array('alt' => \Config::get('application.seo.frontend.title') )); ?>
                    </a>
                </div>
            </div>

        </nav> <!-- end navbar -->
    
    <?php if(isset($pageTitle) && isset($titleicon) && \Auth::check() ): ?>

        <div class="navbar-left">
            <h4><i class="fa fa-<?= $titleicon; ?>"></i> <?= $pageTitle; ?></h4>
        </div>
          
    <?php endif; ?>

</header>

<!-- sidebar -->
<div class="collapse navbar-collapse" id="navbar-collapse-x">

    <div id="sidebar" class="col-sm-3 col-md-3 col-lg-3" >
        
        <?php if ( isset($bgsiderselect) ): ?>
            <?php if ( $bgsiderselect == 'video' ): ?>
                
                <div class="hidden-xs">
                    <div id="wrap">
                        <div id="sider-rasterbg"></div>
                        <video id="sider-video-background" playsinline autoplay muted loop >
                            <source src="<?= $bgsiderdata ?>" type="video/mp4">
                        </video>
                    </div>
                </div>

            <?php endif; ?>
        <?php endif; ?>
                                
        <div class="logo-sidebar hidden-xs">
            <a href="<?= \Router::get('homepage'); ?>">
                <?php
                    $options = [
                        "ssl" => [
                            "verify_peer"=>false,
                            "verify_peer_name"=>false
                        ]
                    ];

                 echo file_get_contents($logo, false, stream_context_create($options)); ?>
            </a>
        </div>

        <!-- active isotope sorts_control along menu -->
        <?php if (isset($sorts_default)): ?>
          <div style="display:<?= $sorts_control == "none" ? 'none' : 'block'; ?>;" id="frontend-control">
              <div class="btn-group" role="group" aria-label="Control">
                <button id="desc" href="<?= \Uri::base(false).$this->active_module; ?>#c=@+" data-filter="@+" type="button" class="btn btn-dark-theme btn-sm    <?= $sorts_default == 'desc' ? 'active' : '' ?>" title="<?= __('application.isotope_sorts_desc') ?>" data-toggle="tooltip-sort" ><i class="fa fa-sort-amount-desc" aria-hidden="true"></i></button>
                <button id="asc" href="<?= \Uri::base(false).$this->active_module; ?>#c=@-" data-filter="@-" type="button" class="btn btn-dark-theme btn-sm     <?= $sorts_default == 'asc' ? 'active' : '' ?>" title="<?= __('application.isotope_sorts_asc') ?>" data-toggle="tooltip-sort" ><i class="fa fa-sort-amount-asc" aria-hidden="true"></i></button>
                <button id="random" href="<?= \Uri::base(false).$this->active_module; ?>#c=~" data-filter="~" type="button" class="btn btn-dark-theme btn-sm    <?= $sorts_default == 'random' ? 'active' : '' ?>" title="<?= __('application.isotope_sorts_random') ?>" data-toggle="tooltip-sort" ><i class="fa fa-random" aria-hidden="true"></i></button>
                <button id="favorites" href="<?= \Uri::base(false).$this->active_module; ?>#c=~" data-filter="~" type="button" class="btn btn-dark-theme btn-sm <?= $sorts_default == 'favorites' ? 'active' : '' ?>" title="<?= __('application.isotope_sorts_favorites') ?>" data-toggle="tooltip-sort" ><i class="fa fa-heart" aria-hidden="true"></i></button>
              </div>
          </div>
        <?php endif; ?>
        
        <!-- categories menu here -->
        <?php if (!empty($menu_cats)): ?>
            <?php if (count($menu_cats) > 1): ?>

                <ul class="list-unstyled filters menu-de-navigation vertical" >

                    <?php foreach ($menu_cats as $cat): ?>
                        <?php if ($cat->visibility == 'visible'): ?>
                            <li data-toggle="collapse" data-target="#navbar-collapse.in" class="button-category" >
                                <?php if ( $cat->slug == 'all' ): ?>
                                    <a href="<?= \Uri::base(false).$this->active_module; ?>#c=*" data-filter="*" class="<?= strtolower($cat->slug); ?> active"><?= $cat->name; ?></a>
                                <?php else: ?>
                                    <?php if ( in_arrayi($cat->id, $actived_categories) ): ?> <?php // && $posts_count[$cat->id] > 0 ?>
                                        <a href="<?= \Uri::base(false).$this->active_module; ?>#c=.<?= strtolower($cat->slug) ?>" data-filter="<?= '.'.strtolower($cat->slug) ?>" class="<?= strtolower($cat->slug); ?>"><?= $cat->name; ?></a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </li>
                        <?php endif; ?>

                    <?php endforeach; ?>
                        
                </ul>

            <?php endif; ?>
        <?php endif; ?>
        <!-- end categories menu  -->
    
        <div class="footer footer-desktop hidden-xs">
            <?= \Theme::instance()->view('layouts/blocks/html_footer'); ?>
        </div>

    </div>

</div><!-- .navbar-collapse -->