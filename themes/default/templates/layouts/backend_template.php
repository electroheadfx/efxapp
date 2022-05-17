
<?php echo \Theme::instance()->set_partial('header','layouts/blocks/header-backend'); ?>
    
    <div class="navbar-right access">
      <ul class="nav navbar-nav">            
          <!-- language switch -->
          <?php if ( $actionName !== 'add' ): ?>
            <?php foreach (\Config::get('server.application.lang-order') as $lang): ?>
              <li class="lang <?= \Cookie::get('lang', null) == $lang ? 'active' : ''; ?>" ><a href="/efx/lang/index/<?= $lang ?>"><img height="15" src="/assets/img/flag-<?= $lang ?>.svg" alt="<?= $lang ?>"></a></li>
            <?php endforeach; ?>
          <?php endif; ?>
          <li class="ico-btn" ><a href="/" title="Home"><i class="fa fa-home"></i></a></li>
          <?php if (!isset($logpage)): ?>
            <li class="ico-btn" ><a href="<?= \Router::get('logout') ?>"><i class="fa fa-user"></i> <?= __('application.logout'); ?></a></li> 
          <?php endif; ?>

      </ul>
    </div>  

	<?= \Theme::instance()->view('layouts/sidebar_backend_template'); ?>

    

    <!-- main view -->

    <div class="tpcontainer">
        
        <?php if ( $this->moduleName == 'media' && $actionName !== 'add' ): ?>
          <div class="row">
                <div class="navbar-left navbar-media">
                  <ul class="nav navbar-nav">
                    <?php foreach (\Config::get('server.modules') as $key => $media): ?>
                          <li class="ico-btn <?= $media['route'] ?> <?= $titleicon == $media['icon'] ? 'active' : ''; ?>" ><a href="<?= \Router::get('admin_media_'.$media['route']) ?>" data-toggle="tooltip-media" data-original-title="<?= __('module.media.backend.'.$media['route'].'.manage'); ?>" ><i class="fa fa-<?= $media['icon'] ?>"></i></a></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
          </div>

        <?php endif; ?>

      <div class="row">

          <div class="col-lg-12">
              <?php if (isset($pageTitle)): ?>
                <div><h1 class="media-title"><i class="fa fa-<?= isset($titleicon) ? $titleicon : 'plus'; ?>"></i> <?= $pageTitle ?><small><?= isset($IDpost) ? ' #'.$IDpost : ''; ?> <?= !empty($NAMEpost) ? ' / “'.$NAMEpost.'”' : ''; ?></small></h1></div>
              <?php endif; ?>
          </div>

            <!-- Begin messages -->
                                       
               <div class="col-lg-12 message"><?php echo $messages; ?></div>
                   
           <!-- End of messages -->

           <div class="content col-lg-12">

             <?php if(isset($partials['content'])): ?>

                 <?= $partials['content']; ?>

             <?php endif; ?>

            </div>
    
    
      </div>
    
    </div>
  
    <!-- End main view -->


    <!-- footer view -->
	
	<?= \Theme::instance()->view('layouts/blocks/footer'); ?>

        
    </body>

</html>