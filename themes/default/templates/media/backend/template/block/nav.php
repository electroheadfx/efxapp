<p>
    <div class="group-separator">
        <div class="btn-group">
            <a href="<?= \Router::get('admin'); ?>" type="button" class="btn btn-default" ><span class="fa fa-dashboard"></span> <?= __('application.back-to-dashboard'); ?></a>
            <a href="<?= \Router::get('admin_project_category'); ?>" class="btn btn-info" data-toggle="tooltip-project" data-original-title="<?= __('model.post.categories') ?>" ><i class="fa fa-folder-open"></i></a>
            <a href="<?= \Router::get('admin_project_menu'); ?>" class="btn btn-menu" data-toggle="tooltip-project" data-original-title="<?= __('module.project.default.menus') ?>" ><i class="fa fa-list"></i></a>
        </div>
        <?php if ( $this->submodule !== 'cms'): ?>
            <div class="btn-group pull-right">
                <a href="<?= \Router::get('admin_'.$moduleName.'_'.$this->submodule.'_add').'?cat='.\Input::get('category'); ?>" class="<?= $nojs ? '' : 'create'; ?> btn btn-<?= $this->submodule ?>" data-toggle="tooltip-project" data-original-title="<?= __('backend.post.add_'.$this->submodule); ?>" ><i class="fa fa-plus fa-5"></i> <i class="fa fa-<?= \Config::get('modules_config.media.backend.'.$this->submodule.'.titleicon'); ?> fa-5"></i> <?= __('backend.post.'.$this->submodule);?></a>
           </div>
        <?php else: ?>
            <div class="btn-group pull-right">
                <?php if ( \Config::get('server.modules.video.route') == 'video' ): ?>
                    <a href="<?= \Router::get('admin_'.$moduleName.'_video_add').'?cat='.\Input::get('category'); ?>" class="<?= $nojs ? '' : 'create'; ?> btn btn-video" data-toggle="tooltip-project" data-original-title="<?= __('backend.post.add_video');?>" ><i class="fa fa-plus fa-5"></i> <i class="fa fa-<?= \Config::get('modules_config.media.backend.video.titleicon'); ?> fa-5"></i> <?= __('backend.post.video');?></a>
                <?php endif; ?>
                <?php if ( \Config::get('server.modules.gallery.route') == 'gallery' ): ?>
                    <a href="<?= \Router::get('admin_'.$moduleName.'_gallery_add').'?cat='.\Input::get('category'); ?>" class="<?= $nojs ? '' : 'create'; ?> btn btn-gallery" data-toggle="tooltip-project" data-original-title="<?= __('backend.post.add_gallery');?>" ><i class="fa fa-plus fa-5"></i> <i class="fa fa-<?= \Config::get('modules_config.media.backend.gallery.titleicon'); ?> fa-5"></i> <?= __('backend.post.gallery');?></a>
                <?php endif; ?>
                <?php if ( \Config::get('server.modules.sketchfab.route') == 'sketchfab' ): ?>
                    <a href="<?= \Router::get('admin_'.$moduleName.'_sketchfab_add').'?cat='.\Input::get('category'); ?>" class="<?= $nojs ? '' : 'create'; ?> btn btn-sketchfab" data-toggle="tooltip-project" data-original-title="<?= __('backend.post.add_sketchfab');?>" ><i class="fa fa-plus fa-5"></i> <i class="fa fa-<?= \Config::get('modules_config.media.backend.sketchfab.titleicon'); ?> fa-5"></i> <?= __('backend.post.sketchfab');?></a>            
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <hr/>
</p>