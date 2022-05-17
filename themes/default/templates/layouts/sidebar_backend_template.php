
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
            
    <div class="collapse navbar-collapse navbar-right">

        <div id="sidebar" class="bar navbar-right col-sm-3 col-md-3 col-lg-3" >
            
            <div class="logo-sidebar hidden-xs">
                <a href="<?= \Router::get('homepage'); ?>">
                    <?php echo file_get_contents($logo); ?>
                </a>
            </div>

            <?php if (isset($menu_cats)): ?>
                <!-- categories menu here -->
                <div class="menu-de-navigation vertical">

                    <ul class="list-unstyled filters" >

                        <?php if ( count($menu_cats) > 1 ): ?>
                            
                            <?php if ( isset($nojs) ): ?>
                                <?php if ($nojs): ?>
                                    <?php foreach ($menu_cats as $cat): ?>

                                        <li class="button-category-nojs" >
                                            <?php if ( $cat->slug == 'all'): ?>
                                                <a href="<?= \Uri::current(); ?>?category=all&menu=<?= $activedmenu ?>" data-filter="*" data-id="<?= $cat->id ?>" class="<?= $activedcategory == "all" ? 'active' : ''; ?>"><?= $cat->name; ?></a><sup> (<?= $count_global; ?>)</sup>
                                            <?php else: ?>
                                                <a href="<?= \Uri::current(); ?>?category=<?= strtolower($cat->id) ?>&menu=<?= $activedmenu ?>" data-id="<?= $cat->id ?>" class="<?= strtolower($cat->id) == $activedcategory ? 'active' : ''; ?>"><?= $cat->name; ?></a> <sup>(<?= \DB::select('post_id')->from('categories_posts')->where('category_id', $cat->id)->distinct()->execute()->count(); ?>)</small></sup>
                                            <?php endif; ?>
                                        </li>

                                    <?php endforeach; ?>

                                <?php else: ?>

                                    <?php foreach ($menu_cats as $cat): ?>

                                        <li class="button-category" >
                                            <?php if ( $cat->slug == 'all'): ?>
                                                <a href="<?= \Uri::current(); ?>#filter=*" data-filter="*" data-id="<?= $cat->id ?>" class="<?= strtolower($cat->slug); ?> active"><?= $cat->name; ?></a><sup> (<?= $count_global; ?>)</sup>
                                            <?php else: ?>
                                                <a href="<?= \Uri::current(); ?>#filter=.<?= strtolower($cat->slug) ?>" data-filter="<?= '.'.strtolower($cat->slug) ?>" data-id="<?= $cat->id ?>" class="<?= strtolower($cat->slug); ?>"><?= $cat->name; ?></a> <sup>(<?= \DB::select('post_id')->from('categories_posts')->where('category_id', $cat->id)->distinct()->execute()->count(); ?>)</small></sup>
                                            <?php endif; ?>
                                        </li>

                                    <?php endforeach; ?>

                                <?php endif; ?>
                            <?php endif; ?>
                            
                        <?php endif; ?>

                    </ul>
                </div>
            <?php endif; ?>

        </div>
    
<!--  -->
    </div>
  

</header>