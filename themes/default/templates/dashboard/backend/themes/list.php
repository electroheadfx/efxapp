
<br />

<p>
    <div class="group-separator">

        <div class="btn">

            <a href="<?= \Router::get('admin'); ?>" type="button" class="btn btn-default" ><span class="fa fa-mail-reply"></span> <?= __('application.back-to-dashboard'); ?></a>

        </div>
    </div>
</p>

<?php if(empty($themes)): ?>

    <?= __('module.dashboard.backend.themes.empty'); ?>

<?php else: ?>
    
    <!-- 1-TAB : SIDE -->
    <ul class="nav nav-tabs" role="tablist" id="tabside" >
        
        <?php foreach ($themes as $key => $sidethemes): ?>
            
            <li class="<?= $cssTabFirst[$key] ?>">

                <a href="#<?= $key ?>" role="tab" data-toggle="tab">
                    <h5><?= __('module.dashboard.backend.themes.'.$key) ?></h5>
                </a>

            </li>

        <?php endforeach; ?>

    </ul>
    
    <!-- SIDES CONTENT (TAB 1) -->
    <div id="tabsideContent" class="tab-content">

        <?php foreach ($themes as $key =>  $sidethemes): ?>
            
            <div class="tab-pane fade <?= $cssTabFirst[$key] ?>" id="<?= $key ?>">
                
                <!-- 2-TAB : THEME -->
                <ul class="nav nav-tabs" role="tablist" id="tabtheme">

                    <?php foreach ($sidethemes as $tokey => $theme): ?>

                        <li class="<?= $cssTabFirst[$tokey] ?>">

                            <a href="#<?= $key.'-'.$tokey ?>" role="tab" data-toggle="tab">
                                <h5><?= __('module.dashboard.backend.themes.'.$tokey); ?></h5>
                            </a>

                        </li>

                    <?php endforeach; ?>

                </ul>
                
                <!-- THEMES CONTENT (TAB 2) -->
                <div id="tabthemeContent" class="tab-content">

                    <?php foreach ($sidethemes as $tokey => $theme): ?>

                        <div class="tab-pane fade <?= $cssTabFirst[$tokey] ?>" id="<?= $key.'-'.$tokey ?>">

                            <div class="table-responsive">
                                <table class="table table-striped table-condensed">
                                    <thead>
                                        <tr class="success">
                                            <th class="round-top-left"> </th>
                                            <th class="alert alert-info" ><?= __('module.dashboard.backend.themes.theme') ?></th>
                                            <th class="alert alert-info" ><?= __('module.dashboard.backend.themes.author') ?></th>
                                            <th class="alert-info round-top-right" ><?= __('module.dashboard.backend.themes.version') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach($theme as $template): ?>

                                            <tr>
                                                <!-- theme status -->
                                                <td class="icon-state attribute <?= $template['css_theme'] ?>">

                                                    <a href="<?= \Router::get('change_theme', array($template['name'], $key, $tokey)) ?>">
                                                        <i class="tooltip-post <?= $template['icon'] ?>" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?= $template['status'] ?>"></i>
                                                    </a>

                                                </td>

                                                <!-- theme name -->
                                                <td class="<?= $template['css_theme'] ?>" >
                                                    <?= $template['i18n'] ?>
                                                </td>

                                                <!-- theme author -->
                                                <td class="<?= $template['css_theme'] ?>" ><?= $template['author'] ?></td>

                                                <!-- theme version -->
                                                <td class="<?= $template['css_theme'] ?>" ><?= $template['version'] ?></td>
                                            </tr>

                                        <?php endforeach; ?>
                                        
                                    </tbody>
                                </table>

                            </div>

                        </div>

                    <?php endforeach; ?>
        
                </div> <!-- end tab-content -->
    
            </div>

        <?php endforeach; ?>

    </div> <!-- end tabside-content -->

<?php endif; ?>
