
	<div class="row">

		<div class="col-xs-5 col-sm-5 col-md-4 col-lg-4 pull-right" >
            <div class="btn-group pull-right">
                <a href="<?= \Router::get('admin_media_'.$this->submodule.'_list').'?menu=all'; ?>" class="view btn btn-default <?= \Uri::segment(4) == 'index' ? 'active' : ''  ?>"><i class="fa fa-th-list"></i> <?= __('backend.list') ?></a>
                <a href="<?= \Router::get('admin_media_'.$this->submodule).'?menu=all'; ?>" class="view btn btn-default <?= \Uri::segment(4) == '' ? 'active' : ''  ?>"><i class="fa fa-th-large"></i> <?= __('backend.grid') ?></a>
                <?php // if ( \Input::get('menu') != 'all' ) : ?>
                    <?php // if (!empty(\Input::get('menu'))): ?>
                        <!-- <a id="preview-input" href="<?php // echo \Router::get('admin_media_'.$this->submodule.'_preview').'/'.\Input::get('menu'); ?>" class="view btn btn-default <?php // echo \Uri::segment(4) == 'preview' ? 'active' : ''  ?>"><i class="fa fa-search"></i> <?= __('backend.preview') ?></a> -->
                    <?php // else: ?>
                        <!-- <a id="preview-cookie" href="<?php // echo \Router::get('admin_media_'.$this->submodule.'_preview').'/'.\Cookie::get($this->submodule.'_menu_id'); ?>" class="view btn btn-default <?php // echo \Uri::segment(4) == 'preview' ? 'active' : ''  ?>"><i class="fa fa-search"></i> <?php // echo __('backend.preview') ?></a> -->
                    <?php // endif; ?>
                <?php // endif; ?>
                <?php if ( \Input::get('menu') == 'all' || $list_mode != '/preview' ): ?>
                    <a id="view" target='_blank' href="<?= \Uri::base(false); ?>" class="view btn btn-default"><i class="fa fa-desktop"></i></a>
                <?php else: ?>
                    <a target='_blank' href="<?= \Uri::base(false).$this->submodule.'/'.\Input::get('menu'); ?>" class="view btn btn-default"><i class="fa fa-desktop"></i></a>
                <?php endif; ?>
            </div>
        </div>
		
		<?php if( \Uri::segment(4) != 'index' ): ?>

        <div class="col-xs-7 col-sm-7 col-md-6 col-lg-5 pull-right" >
            <div class="input-group">
              <input type="text" class="form-control isotope-search" placeholder="<?= __('backend.search_by_keywords'); ?>">
              <span class="input-group-btn">
                <button class="btn btn-default remove" type="submit">
                    <i class="fa fa-search"></i>
                </button>
              </span>

            </div>
        </div>
        
        <?php endif; ?>

    </div>