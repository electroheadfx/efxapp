<p>
    <div class="group-separator">
        <div class="btn-group">
            <a href="<?= \Router::get('admin'); ?>" type="button" class="btn btn-default" ><span class="fa fa-dashboard"></span> <?= __('application.back-to-dashboard'); ?></a>
            <a href="<?= \Router::get('admin_project_menu'); ?>" class="btn btn-menu" data-toggle="tooltip-menu" title="<?= __('module.project.default.menus') ?>" ><i class="fa fa-list"></i></a>
        </div>
        <div class="btn-group pull-right">
            <a href="<?= \Router::get('admin_'.$moduleName.'_category_add').'?menu='.\Input::get('menu'); ?>" class="btn btn-primary" data-toggle="tooltip-menu" title="<?= __('backend.category.add'); ?>" ><i class="fa fa-plus"></i> <i class="fa fa-folder-open"> <?= __('backend.category.category'); ?></i></a>
        </div>
    </div>
</p>

    
    <!-- Menus -->
        <div class="row">
            <div class="col-md-12">
                <hr class="hr-menu" />
            </div>
            <div class="col-md-12">
                <div class="btn-group margin-menu">
                    <a href="<?= \Uri::base(false). 'project/admin/category?menu=all' ?>" class="btn btn-default <?= $activedmenu == 'all' ? 'active' : ''; ?>" ><?= __('application.all_menus'); ?></a>
                </div>
                <?php foreach ($menus as $menu): ?>
                    
                    <!-- Split button -->
                    <div class="btn-group margin-menu">
                      <a href="<?= \Uri::base(false). 'project/admin/category?menu='. $menu->id ?>" class="btn btn-default text-default <?= $activedmenu == $menu->id ? 'active' : ''; ?>" data-toggle="tooltip-menu" data-title="Menu <?= $menu->name; ?> (<?= ucfirst($menu->route) ?>)" ><?= $menu->name ?> <span class="badge categorized badge-<?= $menu->route; ?>" style="margin-left: 3px;" ><?= $menu['count']; ?></span></a>
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu">
                        <?php if ($activedmenu !== $menu->id): ?>
                            <li><a href="<?= \Uri::base(false). 'project/admin/category?menu='. $menu->id ?>" ><i class="fa fa-folder-open text-<?= $menu->route ?>"></i> <?= __('backend.menu.show_categories').' "'.$menu->name.'"'; ?></a></li>
                        <?php endif; ?>
                        <li><a href="<?= \Router::get('admin_'.$moduleName.'_menu_add').'/'.$menu->id ?>"><i class="fa fa-list text-<?= $menu->route ?>"></i> <?= __('backend.menu.edit'); ?></a></li>
                        <li><a href="<?= \Router::get('admin_media_'.$menu->route).'?menu='.$menu->id ?>"><i class="fa fa-search fa-5 text-<?= $menu->route ?>"></i> <?= __('application.view_post') ?> "<?= $menu->name ?>"</a></li>
                      </ul>
                    </div>

                <?php endforeach; ?>
            </div>
            <div class="col-md-12">
                <hr/>
            </div>
        </div>
    <!-- end Menus -->

    <div class="table-responsive admin" >
    	<table class="table table-striped table-condensed">
            <thead>
                <tr>
                    <th style="width:1%" class="order">id</th>
                    <th style="width:1%"> </th>
                    <th style="width:1%"> </th>
                    <th style="width:4%"> </th>
                    <th style="width:25%; text-align:center;" class="order" ><?= __('model.category.name'); ?></th>
                    <th class="order" style="width:4%; text-align: center;">Media</th>
                    <th style="text-align:center;" class="order" ><?= __('model.category.slug'); ?></th>
                    <th class="order" style="width:3%" ><i class="fa fa-square-o"></i></th>
                    <th class="order" style="width:3%" ><i class="fa fa-folder-open-o"></i></th>
                    <th class="order" style="width:5%" ><i class="fa fa-check-square-o"></i></th>
                    <th style="width:10%; text-align:center;" class="order" ><?= __('application.date'); ?></th>
                    <th class="order round-top-right" > </th>
                </tr>
            </thead>
            <tbody id="listWithHandle">

                <?php if ( isset($categories) ): ?>                    
                	
                    <?php foreach($categories as $category): ?>
                        
                        <?php $publish = ($category->status == 'published') ? 'success' : 'warning';  ?>
        	            <tr class="element <?= $category->slug == 'all' ? 'specialcat' : '' ?> <?= $category->slug == 'uncategorized' ? 'uncategorized' : '' ?>" id="<?= $category->id; ?>" >
                            <td class="icon-state attribute glyphicon-move" ><span class="fa fa-arrows"></span></td>
                            <!-- status -->
                            <td class="icon-state attribute ">
                                <a class="attr-status" href="<?= \Router::get('admin_media_attribute_module', array('_','category', $category->id,'status',$category->status)) ?>">
                                    <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => ($category->status == 'published') ? 'chain' : 'chain-broken', 'title' => __('model.category.status'), 'value' => __('model.category.attribute.status.'.$category->status) )); ?>
                                </a>
                            </td>

                            <!-- permission -->
                            <td class="icon-state attribute" >
                                <a class="attr-permission" href="<?= \Router::get('admin_media_attribute_module', array('_','category', $category->id,'permission',$category->permission)) ?>">
                                    <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => ($category->permission == 'public') ? 'globe' : 'user', 'title' => __('model.category.permission'), 'value' => __('model.category.attribute.permission.'.$category->permission) )); ?>                            
                                </a>
                            </td>
                            
                            <!-- visibility -->
                            <td class="icon-state attribute" >
                                <a class="attr-visibility" href="<?= \Router::get('admin_media_attribute_module', array('_','category', $category->id,'visibility',$category->visibility)) ?>">
                                    <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => ($category->visibility == 'visible') ? 'eye' : 'eye-slash', 'title' => __('model.category.visibility'), 'value' => __('model.category.attribute.visibility.'.$category->visibility) )); ?>                            
                                </a>
                            </td>

                            <!-- name/module exposition -->
                                <td class="menu-name text-<?= $category->exposition ?>" style="text-align:center;" ><?= \Str::truncate($category->name, 28); ?></td>
                            
                            <!-- create media -->
                            <td class="icon-state attribute" style="text-align: center;" >
                                
                                <!-- for uncategorized -->
                                <?php if ($category->slug == 'uncategorized'): ?>
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-default dropdown-toggle dropdown-toggle-category" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><i class="fa fa-th fa-5 "></i> <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu">
                                        <?php foreach( $modules as $key => $mod): ?>
                                            <?php if ($key != 'CMS' && $key != 'Curriculum Vitae'): ?>
                                                <li><a href="<?= \Router::get($mod); ?>"><i class="fa fa-plus fa-5 text-<?= strtolower($key); ?>"></i> <i class="fa fa-<?= \Config::get('modules_config.media.backend.'.strtolower($key).'.titleicon'); ?> fa-5 text-<?= strtolower($key); ?>"></i> <?= __('backend.category.create_post_'.strtolower($key)).'“'.__('model.category.uncategorized').'”'; ?></a></li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                      </ul>

                                    </div>
                                <?php endif; ?>
                                                                        
                                <!-- for media -->
                                <?php if ($category->slug != 'all' && $category->slug != 'uncategorized' && $category->exposition != 'cms' ): ?>
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-default dropdown-toggle dropdown-toggle-category" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-<?= \Config::get('modules_config.media.backend.'.$category->exposition.'.titleicon'); ?> fa-5"></i> </i> <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu">
                                            <li><a href="<?= \Router::get('admin_media_'.$category->exposition.'_add', array('cat' => $category->slug) ); ?>"><i class="fa fa-plus fa-5 text-<?= $category->exposition; ?>"></i> <?= __('backend.category.create_post_'.$category->exposition).'“'.$category->slug.'”'; ?></a></li>
                                      </ul>

                                    </div>
                                <?php endif; ?>
                                <!-- for CMS -->
                                <?php if ( $category->exposition == 'cms' ): ?>
                                    <div class="btn-group">
                                      <button type="button" class="btn btn-default dropdown-toggle dropdown-toggle-category" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-<?= \Config::get('modules_config.media.backend.'.$category->exposition.'.titleicon'); ?> fa-5"></i> <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu">
                                        <?php foreach( $modules as $key => $mod): ?>
                                            <?php if ($key != 'CMS' && $key != 'Curriculum Vitae'): ?>
                                                <li><a href="<?= \Router::get($mod, array('cat' => $category->slug) ); ?>"><i class="fa fa-plus fa-5 text-<?= $category->exposition; ?>"></i> <?= __('backend.category.create_post_'.strtolower($key)).'“'.$category->slug.'”'; ?></a></li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                      </ul>

                                    </div>
                                <?php endif; ?>
                            </td>

                            <!-- slug -->
        	                <td style="text-align:center;" ><?= $category->slug; ?></td>
                            
                            <!-- Post count -->
                            <td>
                                <?php if ($category->exposition != 'all' && isset($uncategorized[$category->exposition]) ): ?>
                                    <span class="badge uncategorized"><?= $uncategorized[$category->exposition]['count']; ?></span>
                                <?php endif; ?>
                            </td>

                            <!-- here the folder button to call admin_media_categorize -->
                            <?php if ($category->exposition != 'cms' ): ?>
                                <?php if (isset($uncategorized[$category->exposition])): ?>
                                    
                                    <td><a href="<?= \Router::get('admin_media_categorize', array($category->id, $category->exposition, $uncategorized_id)); ?>" data-title="<?= $uncategorized[$category->exposition]['count'] ?>" ><i class="fa fa-arrow-right"></i></a></td>
                                    
                                <?php else: ?>
                                    
                                    <td></td>

                                <?php endif; ?>
                            <?php else: ?>
                                    <td></td>
                            <?php endif; ?>

                            <!-- Post count -->
                            <td><span class="badge categorized btn-<?= $category->exposition ?>"><?= $category->post_count; ?></span></td>

                            <!-- date -->
        	                <td style="text-align:center;" ><?= date('d/m/Y', $category->created_at); ?></td>

                            <!-- action -->
        	                <td>
                                   <div class="btn-toolbar-category">
                                        <div class="btn-group">
                                                                                    
                                            <!-- for all -->
                                                <?php if ($category->slug == 'all'): ?>
                                                    <!-- edit -->
                                                    <?= \Html::anchor(\Router::get('admin_'.$moduleName.'_category_edit', array('id' => $category->id)), '<i class="fa fa-wrench fa-6"></i> ', array('class' => 'toolbar', 'data-toggle'=>'tooltip', 'data-title'=>__('backend.category.edit_this').'“'.$category->slug.'”')); ?>
                                                <?php endif; ?>

                                            <!-- for uncategorized -->
                                                <?php if ($category->slug == 'uncategorized'): ?>

                                                    <div class="btn-group">
                                                    <?= \Html::anchor(\Router::get('admin_'.$moduleName.'_category_edit', array('id' => $category->id)), '<i class="fa fa-wrench fa-6"></i> ', array('class' => 'toolbar', 'data-toggle'=>'tooltip', 'data-title'=>__('backend.category.edit_this').'“'.__('model.category.uncategorized').'”')); ?>

                                                    </div>
                                                    
                                                <?php endif; ?>
                                            
                                            <!-- for media -->
                                                <?php if ($category->slug != 'all' && $category->slug != 'uncategorized' && $category->exposition != 'cms' ): ?>
                                                    
                                                    <!-- edit -->
                                                    <?= \Html::anchor(\Router::get('admin_'.$moduleName.'_category_edit', array('id' => $category->id)), '<i class="fa fa-wrench fa-6"></i> ', array('class' => 'toolbar', 'data-toggle'=>'tooltip', 'data-title'=>__('backend.category.edit_this').'“'.$category->slug.'”')); ?>

                                                    <!-- view -->
                                                    <?php if (isset($category['menu_id'])): ?>
                                                        <?= \Html::anchor(\Router::get('admin_media_'.$category->exposition).'?menu='.$category['menu_id'].'&cat='.$category->slug.'&category='.$category->id.'#filter=.'.strtolower($category->slug), '<i class="fa fa-search fa-6"></i>', array('class' => 'toolbar', 'data-toggle'=>'tooltip', 'data-title'=>__('application.view_post').'“'.$category->slug.'”')); ?>
                                                    <?php endif; ?>
                                                    <!-- Add media -->
                                                    
                                                    <!-- Delete media -->
                                                    <?= \Html::anchor(\Router::get('admin_'.$moduleName.'_category_delete', array('id' => $category->id)), '<i class="fa fa-trash-o fa-6"></i>', array('class' => 'toolbar', 'onclick' => "return confirm('".__('backend.are-you-sure')."')", 'data-toggle'=>'tooltip', 'data-title'=>__('backend.category.delete_this').'“'.$category->slug.'”')); ?>
                                                
                                                <?php endif; ?>
                                            
                                            <!-- for CMS -->
                                                <?php if ( $category->exposition == 'cms' ): ?>
                                                    
                                                    <!-- edit -->
                                                    <?= \Html::anchor(\Router::get('admin_'.$moduleName.'_category_edit', array('id' => $category->id)), '<i class="fa fa-wrench fa-6"></i> ', array('class' => 'toolbar', 'data-toggle'=>'tooltip', 'data-title'=>__('backend.category.edit_this').'“'.$category->slug.'”')); ?>
                                                        
                                                    <!-- view -->                                                
                                                    <?php if (isset($category['menu_id'])): ?>
                                                        <?= \Html::anchor(\Router::get('admin_media_'.$category->exposition).'?menu='.$category['menu_id'].'&cat='.$category->slug.'&category='.$category->id.'#filter=.'.strtolower($category->slug), '<i class="fa fa-search fa-6"></i>', array('class' => 'toolbar', 'data-toggle'=>'tooltip', 'data-title'=>__('application.view_post').'“'.$category->slug.'”')); ?>
                                                    <?php endif; ?>

                                                    </div>
                                                    
                                                    <!-- Delete media -->
                                                    <?= \Html::anchor(\Router::get('admin_'.$moduleName.'_category_delete', array('id' => $category->id)), '<i class="fa fa-trash-o fa-6"></i>', array('class' => 'toolbar', 'onclick' => "return confirm('".__('backend.are-you-sure')."')", 'data-toggle'=>'tooltip', 'data-title'=>__('backend.category.delete_this').'“'.$category->slug.'”')); ?>

                                                <?php endif; ?>

                                        </div>
                                    </div>                             
                            </td>

        	            </tr>

                	<?php endforeach; ?>
                
                <?php else: ?>
                    <h5><?= __('application.no-categories-found'); ?></h5>
                <?php endif; ?>
            
            </tbody>
        </table>
    </div>

    <?= $pagination; ?>

