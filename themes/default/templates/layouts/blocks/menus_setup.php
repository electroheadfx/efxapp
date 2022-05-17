	<ul class="nav navbar-nav">            
        
        <li class="ico-btn" title="<?= __('application.home') ?>" data-tooltip="navbar" ><a href="/" title="Home"><i class="fa fa-home"></i></a></li>
            
            
            <?php if (strpos($body, 'backend') !== false): ?>

                <li class="ico-btn" title="<?= __('application.logout') ?>" data-tooltip="navbar" ><a href="<?= \Router::get('logout') ?>"><i class="fa fa-user"></i> <?= __('application.logout'); ?></a></li>
                
            <?php else: ?>
                
                <?php foreach (\Config::get("server.social.account") as $key => $value): ?>
                  
                  <li class="ico-btn" title="<?= $key == "sendmail" ? __('application.send') : __('application.social'). ' '.$key ?>" data-tooltip="navbar" ><a class="<?= \Uri::segment(3) == $key ? 'active' : ''; ?>" href="<?= $value ?>" ><i class="fa fa-<?= $key == "sendmail" ? 'send' : $key ?>"></i></a> <?= __('application.social.account.'.$key) ?> </li>
                        
                <?php endforeach; ?>

                <?php if (\Auth::check()): ?>

                    <li class="ico-btn" title="<?= __('application.go_to_admin') ?>" data-tooltip="navbar" ><a href="<?= \Router::get('admin') ?>"><i class="fa fa-user"></i></a></li>

                <?php else: ?>

                    <li class="ico-btn" title="<?= __('application.login') ?>" data-tooltip="navbar" ><a href="<?= \Router::get('login') ?>"><i class="fa fa-user"></i></a></li>

                <?php endif; ?>

            <?php endif; ?>
            
            <?php foreach (\Config::get('server.application.lang-order') as $lang): ?>
              <li class="lang <?= \Cookie::get('lang', null) == $lang ? 'active' : ''; ?>" ><a href="/efx/lang/index/<?= $lang ?>"><img height="15" src="/assets/img/flag-<?= $lang ?>.svg" alt="<?= $lang ?>"></a></li>
            <?php endforeach; ?>

        </li>

    </ul>