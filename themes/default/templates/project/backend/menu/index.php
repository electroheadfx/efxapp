<p>
    <div class="group-separator">
        <div class="btn-group">
            <a href="<?= \Router::get('admin'); ?>" type="button" class="btn btn-default" ><span class="fa fa-dashboard"></span> <?= __('application.back-to-dashboard'); ?></a>
            <a href="<?= \Router::get('admin_project_category'); ?>" class="btn btn-info" data-toggle="tooltip" title="<?= __('model.post.categories') ?>" ><i class="fa fa-folder-open"></i></a>
        </div>
        <div class="btn-group pull-right">
            <a href="<?= \Router::get('admin_'.$moduleName.'_menu_add'); ?>" class="btn btn-primary" data-toggle="tooltip"  title="<?= __('backend.menu.add') ?>" ><i class="fa fa-plus fa-5"></i> <i class="fa fa-pencil-square-o fa-5"></i> <?= __('backend.menu.menu') ?></a>
        </div>
    </div>
</p>


<?php if(empty($posts)): ?>
	<?= __('backend.post.empty'); ?>
<?php else: ?>
	<div class="table-responsive admin">
        <table class="table table-striped table-condensed">
            <thead>
                <tr>
                    
                    <th style="width:5%; text-align: center;" class="order <?= $by == 'order_id' ? 'active' : '' ?>" ><span class="fa fa-arrows"></span></th>
                    
                    <th style="width:2%;text-align: center;" >ID</th>

                    <th style="width:1%" class="round-top-left" >
                        <i class="fa fa-eye fa-5 tooltip-post" data-toggle="tooltip" data-placement="top" title="<?= __('application.menu_visibility') ?>" ></i>
                    </th>

                    <th style="width:1%" class="<?= $by == 'status' ? 'active' : '' ?> round-top-left" >
                        <i class="fa fa-chain fa-5 tooltip-post" data-toggle="tooltip" data-placement="top" title="<?= __('model.post.status') ?>" ></i>
                    </th>

                    <th style="width:1%" class="<?= $by == 'permission' ? 'active' : '' ?>" >
                        <i class="fa fa-globe fa-5 tooltip-post" data-toggle="tooltip" data-placement="top" title="<?= __('model.post.permission') ?>" ></i>
                    </th>

                    <th style="width:1%" class="<?= $by == 'featured' ? 'active' : '' ?>" >
                        <i class="fa fa-heart fa-5 tooltip-post" data-toggle="tooltip" data-placement="top" title="<?= __('model.post.featured') ?>" ></i>
                    </th>

                    <th style="width:2%" ></th>
                    
                    <th style="width:1%; text-align: center;" ><i class="fa fa-television" data-toggle="tooltip" data-placement="top" title="<?= __('application.goto_menu_frontend'); ?>" ></i></th>
                    
                    <th style="width:1%;text-align: center;" ><i class="fa fa-paperclip" data-toggle="tooltip" data-placement="top" title="<?= __('application.menu_share') ?>" ></i></th>
                    
                    <th style="width:2%" ></th>

                    <th style="width:20%" class="order <?= $by == 'name' ? 'active' : '' ?>" ><?= __('application.name_menu'); ?></th>
                    
                    <th style="width:5%" class="order" >Count</th>

                    <th style="width:15%" class="order" >URI</th>
                                        
                    <th class="order" style="width:15%" >Module</th>
                                                        
                    <th style="width:35%" class="round-top-right order" ></th>
            </thead>
            <tbody id="listWithHandle" >
            	<?php foreach($posts as $post): ?>

                    <?php $publish = ($post->status == 'published') ? 'success' : 'warning';  ?>
    	            <tr class="element" id="<?= $post->id; ?>" >
                        
                        <td class="icon-state attribute glyphicon-move" style="text-align: center;" ><span class="fa fa-arrows"></span></td>

                        <!-- ID -->
                        <td class="icon-state attribute" style="text-align: center;" ><?= $post->id; ?></td>

                        <!-- visibility -->
                        <td class="icon-state attribute <?= $by == 'render' ? 'active' : '' ?>">
                            <a class="attr-render" href="<?php echo \Router::get('admin_project_attribute_menu', array( $post->id, $post->render)) ?>">
                            <!-- <a class="attr-visibility" href="<?php // \Router::get('admin_media_attribute_module', array( 'project_menu', 'project_menu', $post->id,'render',$post->render) ) ?>"> -->
                                <i style="opacity:<?= ($post->render == 'menu') ? '1' : '0'; ?>" class="fa fa-<?= ($post->render == 'menu') ? 'eye' : 'eye-slash'; ?> fa-5 tooltip-post" data-toggle="tooltip" data-placement="top" title="<?= ($post->render == 'menu') ? __('application.change_menu_visibility_to_invisible') : __('application.change_menu_visibility_to_visible') ?>" ></i>
                            </a>
                        </td>

                        <!-- status -->
                        <td class="icon-state attribute <?= $by == 'status' ? 'active' : '' ?>">
                            <a class="attr-status" href="<?= \Router::get('admin_media_attribute_module', array( 'project_menu', 'project_menu', $post->id,'status',$post->status)) ?>">
                                <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => ($post->status == 'published') ? 'chain' : 'chain-broken', 'title' => __('model.post.status'), 'value' => __('model.post.attribute.status.'.$post->status) )); ?>
                            </a>
                        </td>

                        <!-- permission -->
                        <td class="icon-state attribute <?= $by == 'permission' ? 'active' : '' ?>" >
                            <a class="attr-permission" href="<?= \Router::get('admin_media_attribute_module', array( 'project_menu', 'project_menu', $post->id,'permission',$post->permission)) ?>">
                                <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => ($post->permission == 'public') ? 'globe' : 'user', 'title' => __('model.post.permission'), 'value' => __('model.post.attribute.permission.'.$post->permission) )); ?>                            
                            </a>
                        </td>


                        <!-- featured -->
                        <td class="icon-feature attribute <?= $by == 'featured' ? 'active' : '' ?>" >
                            <a class="attr-featured" href="<?= \Router::get('admin_media_attribute_module', array( 'project_menu', 'project_menu', $post->id,'featured',$post->featured)) ?>">
                                <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => ($post->featured == 'yes') ? 'heart' : 'heart-o', 'title' => __('model.post.featured'), 'value' => __('model.post.attribute.featured.'.$post->featured) )); ?>                                                                                    
                            </a>
                        </td>
                        
                        <td></td>

                        <!-- icon link -->
                        <td style="text-align: center;" class="attribute" >
                            <a target="_blank" href="<?= \Uri::base(false).$post->route.'/'.$post->id; ?>" data-toggle="tooltip" title="<?= __('application.goto_menu_frontend'); ?>" >
                                <?php if ( $post->faicon !== 'none' || empty($post->faicon) ): ?>
                                    <i class="<?= $post->faicon ?> text-<?= $post->route ?>" ></i>
                                <?php else: ?>
                                    <i class="fa fa-file-o text-<?= $post->route ?>" ></i>
                                <?php endif; ?>
                            </a>
                        </td>
                        <!-- pasteboard link -->
                        <td class="icon-state" style="text-align: center;" >
                            <?php if ( isset($post->uri_state) && isset($post->uri) ): ?>
                                <a class="pasteboard" data-clipboard-text="<?= $post->uri_state == 'on' && !empty($post->uri) ? \Uri::base(false).$post->uri :\Uri::base(false).$post->route.'/'.$post->id; ?>" href="#" data-toggle="tooltip-pasteboard" data-placement="top" data-trigger="click" title="<?= $post->uri_state == 'on' && !empty($post->uri) ? \Uri::base(false).$post->uri.'<br/>'.__('application.copy_menulink_to_pastboard') : \Uri::base(false).$post->route.'/'.$post->id.'<br/>'.__('application.copy_menulink_to_pastboard'); ?>" ><i class="fa fa-paperclip" ></i></a>
                            <?php else: ?> 
                                <a class="pasteboard" data-clipboard-text="<?=  \Uri::base(false).$post->route.'/'.$post->id; ?>" href="#" data-toggle="tooltip-pasteboard" data-placement="top" data-trigger="click" title="<?= \Uri::base(false).$post->route.'/'.$post->id.'<br/>'.__('application.copy_menulink_to_pastboard') ?>" ><i class="fa fa-paperclip" ></i></a>
                            <?php endif; ?>
                        </td>

                        <td></td>
                        
                        <!-- name -->
                        <td class="<?= $by == 'name' ? 'active' : '' ?> menu-name text-<?= $post->route ?>"><?= $post->name; ?></td>
                        
                        <td class="menu-nth text-<?= $post->route ?>"><?= isset($post->postselect) ? $post->postselect == 'max' ? '<i class="fa fa-search-plus"></i>' : '<i class="fa fa-list-ul"></i>' : '<i class="fa fa-list-ul"></i>'; ?></td>
                        
                        <!-- URI -->
                        <?php if ( isset($post->uri_state) && isset($post->uri) ): ?>
                            <td><?= $post->uri_state == 'on' ? '/'.$post->uri : '/'.$post->route.'/'.$post->id; ?></td>
                        <?php else: ?>                     
                            <td>URI error please re-edit&save</td>
                        <?php endif; ?>

                        <!-- module -->
                        <td><?= $post->route; ?></td>                        

                        <!-- action -->
    	                <td>
                           <div class="btn-toolbar-menu">

                                <?php if ($post->edit == 0): ?>
                                    <?php $cssText = $post->route == 'sketchfab' || $post->route == '3d' || $post->route == 'gallery' || $post->route == 'cms' || $post->route == 'video' ? $post->route : 'default';  ?>                                        
                                    <?= \Html::anchor(\Router::get('admin_project_menu_edit', array('id' => $post->id)), '<i class="fa fa-wrench fa-6" ></i>', array('class' => 'toolbar', 'data-toggle' => 'tooltip', 'title' => __('application.edit_menu').' '.$post->name )); ?>
                                    <?= \Html::anchor(\Router::get('admin_media_'.$post->route).'?menu='.$post->id, '<i class="fa fa-search fa-6" ></i>', array('class' => 'toolbar', 'data-toggle' => 'tooltip', 'title' => __('application.view_post').' '.$post->name )); ?>
                                    <?= \Html::anchor(\Uri::base(false). 'project/admin/category?menu='.$post->id, '<i class="fa fa-folder-open-o fa-6" ></i>', array('class' => 'toolbar', 'data-toggle' => 'tooltip', 'title' => __('application.view_menu_folders').' '.$post->name )); ?>
                                    <?= \Html::anchor(\Router::get('admin_project_menu_delete', array('id' => $post->id)), '<i class="fa fa-trash-o fa-6 tooltip-post editblog" ></i>', array('class' => 'toolbar', 'data-toggle' => 'tooltip', 'title' => __('application.delete_menu').' '.$post->name, 'onclick' => "return confirm('".__('backend.are-you-sure')."')")); ?>
                                <?php else: ?>   
                                    <?= \Html::anchor(\Router::get('admin_project_menu_force', array('id' => $post->id)), '<i class="fa fa-wrench fa-6" ></i>', array('class' => 'toolbar', 'data-toggle' => 'tooltip' )); ?>
                                <?php endif; ?>
                                
                            </div>
    	                </td>

    	            </tr>
            	<?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?= $pagination; ?>
<?php endif; ?>