<p>
    <div class="group-separator">
        <div class="btn-group">
            <a href="<?= \Router::get('admin'); ?>" type="button" class="btn btn-default" ><span class="fa fa-dashboard"></span> <?= __('application.back-to-dashboard'); ?></a>
            <a href="<?= \Router::get('admin_project_category'); ?>" class="btn btn-info" ><i class="fa fa-folder-open"></i> <?= __('model.post.categories') ?></a>

        </div>
        <div class="btn-group pull-right">
            <a href="<?= \Router::get('admin_'.$moduleName.'_cv_add'); ?>" class="btn btn-primary"><i class="fa fa-pencil-square-o fa-5"></i> <?= __('backend.post.add');?></a>
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
                    
                    <th class="order <?= $by == 'order_id' ? 'active' : '' ?>" ><a href="<?= \Router::get('admin_'.$moduleName.'_cv_by', array('order_id', $desc)) ?>">
                        id
                        </a>
                    </th>

                    <th class="order <?= $by == 'status' ? 'active' : '' ?> round-top-left" ><a href="<?= \Router::get('admin_'.$moduleName.'_cv_by', array('status', $desc)) ?>">
                        <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => 'chain', 'title' => __('model.post.status'), 'value' => '' )); ?>
                      </a>
                    </th>

                    <th class="order <?= $by == 'permission' ? 'active' : '' ?>" ><a href="<?= \Router::get('admin_'.$moduleName.'_cv_by', array('permission', $desc)) ?>">
                        <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => 'globe', 'title' => __('model.post.permission'), 'value' => '' )); ?>
                      </a>
                    </th>

                    <th class="order <?= $by == 'featured' ? 'active' : '' ?>" ><a href="<?= \Router::get('admin_'.$moduleName.'_cv_by', array('featured', $desc)) ?>">
                        <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => 'heart', 'title' => __('model.post.featured'), 'value' => '' )); ?>
                      </a>
                    </th>
                    
                    <th></th>
                    <!--  -->

                    <th style="width:30%" class="order <?= $by == 'name' ? 'active' : '' ?>" ><a href="<?= \Router::get('admin_'.$moduleName.'_cv_by', array('name', $desc)) ?>">
                        <?= __('model.post.name'); ?>
                      </a>
                    </th>

                    <th style="width:20%" >
                        <?= __('model.column.label'); ?>
                    </th>
                                    
                    <th style="width:10%" class="order <?= $by == 'created_at' ? 'active' : '' ?>" ><a href="<?= \Router::get('admin_'.$moduleName.'_cv_by', array('created_at', $desc)) ?>">
                        <?= __('application.date'); ?>
                        </a>
                    </th>
                    <th style="width:15%" class="round-top-right order" ><a href="<?= \Router::get('admin_'.$moduleName.'_cv_by', array($by, $desc_inv)) ?>">
                        <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => 'sort-amount-'.$desc, 'title' => __('model.post.desc'), 'value' => '' )); ?>
                        </a>
                    </th>
            </thead>
            <tbody id="listWithHandle" >
            	<?php foreach($posts as $post): ?>

                    <?php $publish = ($post->status == 'published') ? 'success' : 'warning';  ?>
    	            <tr class="element" id="<?= $post->id; ?>" >
                        
                        <td class="icon-state attribute glyphicon-move" ><span class="fa fa-arrows"></span></td>

                        <!-- status -->
                        <td class="icon-state attribute <?= $by == 'status' ? 'active' : '' ?>">
                            <a id="attr-status" href="<?= \Router::get('admin_media_attribute_module', array('media_cv', 'media_cv', $post->id,'status',$post->status)) ?>">
                                <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => ($post->status == 'published') ? 'chain' : 'chain-broken', 'title' => __('model.post.status'), 'value' => __('model.post.attribute.status.'.$post->status) )); ?>
                            </a>
                        </td>

                        <!-- permission -->
                        <td class="icon-state attribute <?= $by == 'permission' ? 'active' : '' ?>" >
                            <a id="attr-permission" href="<?= \Router::get('admin_media_attribute_module', array('media_cv', 'media_cv', $post->id,'permission',$post->permission)) ?>">
                                <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => ($post->permission == 'public') ? 'globe' : 'user', 'title' => __('model.post.permission'), 'value' => __('model.post.attribute.permission.'.$post->permission) )); ?>                            
                            </a>
                        </td>


                        <!-- featured -->
                        <td class="icon-feature attribute <?= $by == 'featured' ? 'active' : '' ?>" >
                            <a id="attr-featured" href="<?= \Router::get('admin_media_attribute_module', array('media_cv', 'media_cv', $post->id,'featured',$post->featured)) ?>">
                                <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => ($post->featured == 'yes') ? 'heart' : 'heart-o', 'title' => __('model.post.featured'), 'value' => __('model.post.attribute.featured.'.$post->featured) )); ?>                                                                                    
                            </a>
                        </td>
                        
                        <td></td>
                        <!-- name -->
                        <td class="<?= $by == 'name' ? 'active' : '' ?>"><?= $post->name; ?></td>

                        <td>
                            <?= __('model.column.'.str_replace('app-thumb.bootstrap.', '', $post->column)) ?>
                        </td>

                        <!-- date -->
                        <td class="icon-date <?= $by == 'created_at' ? 'active' : '' ?>" ><?= date('d/m/Y', $post->created_at); // H:i:s = heure ?></td>

                        <!-- action -->
    	                <td>
        	               <div class="btn-group">
                                
                                    <?php if ($post->edit == 0): ?>
                                        <?= \Html::anchor(\Router::get('admin_media_cv_edit', array('id' => $post->id)), '<i class="fa fa-wrench fa-4" > '.__('backend.edit').'</i>', array('class' => 'btn btn-primary btn-xs btn-block')); ?>
                                        <?= \Html::anchor(\Router::get('admin_media_cv_delete', array('id' => $post->id)), '<i class="fa fa-trash-o fa-4 tooltip-post editblog" data-toggle="tooltip" data-placement="bottom" data-original-title="'.__('backend.delete').'""> '.__('backend.delete').'</i>', array('class' => 'btn btn-success btn-xs edit btn-block', 'onclick' => "return confirm('".__('backend.are-you-sure')."')")); ?>
                                    <?php else: ?>    
                                        <?= \Html::anchor(\Router::get('admin_media_cv_force', array('id' => $post->id)), '<i class="fa fa-wrench fa-4" > '.__('backend.post_in_editing').'</i>', array('class' => 'btn btn-primary btn-xs btn-block')); ?>
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