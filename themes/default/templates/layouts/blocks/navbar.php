
<header class="navbar navbar-default <?= $navbar ?> navbar-static-top" id="top" role="navigation" >

        <div class="navbar-header">

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <?php if(isset($pageTitle) && \Auth::check() ): ?>

                <h4><i class="fa fa-<?= $titleicon; ?>"></i> <?= $pageTitle; ?></h4>

            <?php endif; ?>

        </div>

        <div class="collapse navbar-collapse navbar-right">
            
            <ul class="nav navbar-nav">            

                <li class="ico-btn" ><a href="/" title="Home"><i class="fa fa-home"></i></a></li>
                    
                    
                    <?php if (strpos($body, 'backend') !== false): ?>

                        <li class="ico-btn" ><a href="<?= \Router::get('logout') ?>"><i class="fa fa-user"></i> <?= __('application.logout'); ?></a></li>
                        
                    <?php else: ?>

                        <!-- <li><a href="<= \Config::get("server.social.account.twitter") ?>" target="_blank" ><i class="fa fa-twitter"></i></a>  </li> -->
                        <li class="ico-btn" ><a href="<?= \Config::get("server.social.account.facebook") ?>" target="_blank" ><i class="fa fa-facebook"></i></a> <!--  <?= __('application.social.account.facebook') ?> --> </li>
                        <li class="ico-btn" ><a href="mailto:<?= \Config::get('application.setup.services.contact') ?>" title="Contact"><i class="fa fa-envelope"></i></a> </li>

                        <?php if (\Auth::check()): ?>

                            <li class="ico-btn" ><a href="<?= \Router::get('admin') ?>"><i class="fa fa-user"></i> <?= __('application.admin'); ?></a></li>

                        <?php else: ?>

                            <li class="ico-btn" ><a href="<?= \Router::get('login') ?>"><i class="fa fa-user"></i></a></li>

                        <?php endif; ?>

                    <?php endif; ?>

                </li>

            </ul>

        </div>

</header>
