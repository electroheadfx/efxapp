
<?php echo \Theme::instance()->set_partial('header','layouts/blocks/header'); ?>


  <?php echo \Theme::instance()->view('layouts/sidebar_frontend_template'); ?>

    <!-- main view -->

    <div class="tpcontainer <?= isset($navbarstate) ? $navbarstate : 'fixed' ?>">
        
        <div class="row">

            <div class="message"><?php echo $messages; ?></div>

            <div class="navbar-left menus menu-xs hidden-sm hidden-md hidden-lg">

              <?= \Theme::instance()->view('layouts/blocks/menus'); ?>

            </div>
        
            <?= !empty($category_cms) && $summary_switch ? \Theme::instance()->view('project/frontend/cms/index')->set('category_cms', $category_cms) : ''; ?>

        </div>

        <div class="row">
              
            <div class="content">

               <?php if(isset($partials['content'])): ?>

                   <?= $partials['content']; ?>

               <?php endif; ?>

            </div>
    
    
      </div>
    
    </div>
    
  
    <!-- End main view -->

    <!-- footer view -->
        <div class="footer footer-mobile hidden-sm hidden-md hidden-lg">
            <?= \Theme::instance()->view('layouts/blocks/html_footer'); ?>
        </div>

        <?= \Theme::instance()->view('layouts/blocks/footer_frontend'); ?>
        
        <!-- google analytic -->
        <?= \Theme::instance()->view('layouts/blocks/ga'); ?>
        
    </body>
</html>