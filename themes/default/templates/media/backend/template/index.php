<script>
    window.lazySizesConfig = window.lazySizesConfig || {};
    //only for demo in production I would use normal expand option
    lazySizesConfig.expand = 400;
</script>

    <?= \Theme::instance()->view('backend/template/block/nav');  ?>
    
    <?= \Theme::instance()->view('backend/template/block/list_controls'); ?>
    
    <?= \Theme::instance()->view('backend/template/block/list_menus'); ?>

    <?php if(empty($posts)): ?>
        <?= __('backend.post.empty'); ?>
    <?php else: ?>

    <div class="table-responsive admin">
        

        <table class="table table-striped table-condensed">
            <thead>
                <tr>
                    
                    <th class="order <?= $by == 'order_id' ? 'active' : '' ?>" ><a href="<?= \Router::get('admin_'.$moduleName.'_'.$submodule.'_list'); ?>">
                        ID
                        </a>
                    </th>
                    
                    <th></th>

                    <th></th>

                    <th class="order <?= $by == 'status' ? 'active' : '' ?> round-top-left" ><a href="<?= \Router::get('admin_'.$moduleName.'_'.$submodule.'_by', array('index', 'status', $desc)) ?>">
                        <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => 'chain', 'title' => __('model.post.status'), 'value' => '' )); ?>
                      </a>
                    </th>

                    <th class="order <?= $by == 'permission' ? 'active' : '' ?>" ><a href="<?= \Router::get('admin_'.$moduleName.'_'.$submodule.'_by', array('index', 'permission', $desc)) ?>">
                        <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => 'globe', 'title' => __('model.post.permission'), 'value' => '' )); ?>
                      </a>
                    </th>
                    
                    <?php if ( isset($allow_comments) ): ?>
                        <th class="order <= $by == 'allow_comments' ? 'active' : '' ?>" ><a href="<= \Router::get('admin_'.$moduleName.'_'.$submodule.'_by', array('index', 'allow_comments', $desc)) ?>">
                            <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => 'comments', 'title' => __('model.post.comment'), 'value' => '' )); ?>
                          </a>
                        </th>
                    <?php endif; ?>

                    <th class="order <?= $by == 'featured' ? 'active' : '' ?>" ><a href="<?= \Router::get('admin_'.$moduleName.'_'.$submodule.'_by', array('index', 'featured', $desc)) ?>">
                        <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => 'heart', 'title' => __('model.post.featured'), 'value' => '' )); ?>
                      </a>
                    </th>
                    
                    <th></th>
                    <!--  -->

                    <th style="width:5%" class="order" >Media</th>

                    <th style="width:20%" class="order <?= $by == 'name' ? 'active' : '' ?>" ><a href="<?= \Router::get('admin_'.$moduleName.'_'.$submodule.'_by', array('index', 'name', $desc)) ?>">
                        <?= __('model.post.name'); ?>
                      </a>
                    </th>
                                                
                    <th style="width:20%" class="order" >Keywords</th>

                    <th style="width:20%" class="order <?= $by == 'category_id' ? 'active' : '' ?>" ><a href="<?= \Router::get('admin_'.$moduleName.'_'.$submodule.'_by', array('index', 'category_id', $desc)) ?>">
                        <?= __('model.post.category'); ?>
                        </a>
                    </th>
                    <th style="width:10%" class="order <?= $by == 'created_at' ? 'active' : '' ?>" ><a href="<?= \Router::get('admin_'.$moduleName.'_'.$submodule.'_by', array('index', 'created_at', $desc)) ?>">
                        <?= __('application.date'); ?>
                        </a>
                    </th>
                    <th style="width:15%" class="round-top-right order" ><a href="<?= \Router::get('admin_'.$moduleName.'_'.$submodule.'_by', array('index', $by, $desc_inv)) ?>">
                        <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => 'sort-amount-'.$desc, 'title' => __('model.post.desc'), 'value' => '' )); ?>
                        </a>
                    </th>
            </thead>
            <tbody id="listWithHandle" >
            	
                <?php foreach($posts as $post): ?>
                    
                    <?php $publish = ($post->status == 'published') ? 'success' : 'warning';  ?>
    	            
                    <tr class="element <?= $post->slug_categories; ?> <?= isset($post->meta) ? strtolower($post->meta) : '' ?>" id="<?= $post->id; ?>" >
                        
                        <td class="icon-state attribute <?php if ($by == 'order_id') echo 'glyphicon-move'; ?>" ><?php if ($by == 'order_id'): ?><span class="fa fa-arrows"></span><?php endif; ?></td>

                        <!-- id -->
                        <td><?= $post->id; ?></td>

                        <!-- img -->
                        <th>
                            <?php if ( $post->image_output == "text" ): ?>
                                <div class="img-thumbnail video-post-list" ><img class="lazyload" width="83" height="56" data-src="/assets/img/text.jpg" alt=""></div>
                            <?php else: ?>
                                <div class="img-thumbnail video-post-list" ><img class="lazyload" width="83" height="56" data-src="<?= $post->cover == NULL ? '/assets/img/empty-media.jpg' : $post->cover.'?'.rand() ?>"></div>
                            <?php endif; ?>
                        </th>

                        <!-- status -->
                        <td class="icon-state attribute <?= $by == 'status' ? 'active' : '' ?>">
                            <a id="attr-status" href="<?= \Router::get('admin_media_attribute_module', array('post', 'media_'.$this->submodule, $post->id,'status',$post->status)) ?>" >
                                <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => ($post->status == 'published') ? 'chain' : 'chain-broken', 'title' => __('model.post.status'), 'value' => __('model.post.attribute.status.'.$post->status) )); ?>
                            </a>
                        </td>

                        <!-- permission -->
                        <td class="icon-state attribute <?= $by == 'permission' ? 'active' : '' ?>" >
                            <a id="attr-permission" href="<?= \Router::get('admin_media_attribute_module', array('post', 'media_'.$this->submodule, $post->id,'permission',$post->permission)) ?>" >
                                <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => ($post->permission == 'public') ? 'globe' : 'user', 'title' => __('model.post.permission'), 'value' => __('model.post.attribute.permission.'.$post->permission) )); ?>                            
                            </a>
                        </td>
                        
                        <?php if ( isset($allow_comments) ): ?>
                            <!-- allow_comments -->
                            <td class="icon-state attribute <?= $by == 'allow_comments' ? 'active' : '' ?>" >
                                <a href="<?= \Router::get('admin_media_attribute_module', array('post', 'media_'.$this->submodule, $post->id,'allow_comments',$post->allow_comments)) ?>">
                                    <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => ($post->allow_comments == 'yes') ? 'comments' : 'comments-o', 'title' => __('model.post.comment'), 'value' => __('model.post.attribute.comment.'.$post->allow_comments) )); ?>                                                        
                                </a>
                            </td>
                        <?php endif; ?>

                        <!-- featured -->
                        <td class="icon-feature attribute <?= $by == 'featured' ? 'active' : '' ?>" >
                            <a id="attr-featured" href="<?= \Router::get('admin_media_attribute_module', array('post', 'media_'.$this->submodule, $post->id,'featured',$post->featured)) ?>" >
                                <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => ($post->featured == 'yes') ? 'heart' : 'heart-o', 'title' => __('model.post.featured'), 'value' => __('model.post.attribute.featured.'.$post->featured) )); ?>                                                                                    
                            </a>
                        </td>
                        
                        <td></td>

                        <!-- media type -->
                        <td><i class="fa fa-<?= $media_ico[$post->module]['titleicon']; ?> fa-1x"></i></td>

                        <!-- name -->
                        <td class="<?= $by == 'name' ? 'active' : '' ?>"><?= empty($post->name) ? __('model.post.no_name') : \Security::strip_tags($post->name); ?></td>

                        <!-- meta -->
                         <td><?= isset($post->meta) ? strtolower(htmlentities($post->meta)) : ""; ?></td>
                        
                        <!-- category -->
                        <td class="<?= $by == 'category_id' ? 'active' : '' ?>"><?= $post->name_categories; ?></td>

                        <!-- date -->
                        <td class="icon-date <?= $by == 'created_at' ? 'active' : '' ?>" ><?= date('d/m/Y', $post->created_at); // H:i:s = heure ?></td>

                        <!-- action -->
    	                <td>
        	               <div class="btn-toolbar-list">
                                
                                    <?php if ($post->edit == 0): ?>
                                        <?= \Html::anchor(\Router::get('admin_media_'.$this->submodule.'_edit', array('id' => $post->id)), '<i class="fa fa-wrench fa-4" > '.__('backend.edit').'</i>', array('class' => 'btn btn-default btn-xs btn-block')); ?>
                                        <?= \Html::anchor(\Router::get('admin_media_delete', array($this->submodule, $post->id)), '<i class="fa fa-trash-o fa-4 editblog"> '.__('backend.delete').'</i>', array('class' => 'btn btn-success btn-xs edit btn-block', 'onclick' => "return confirm('".__('backend.are-you-sure')."')")); ?>
                                    <?php else: ?>    
                                        <?= \Html::anchor(\Router::get('admin_media_force', array($this->submodule, $post->id)), '<i class="fa fa-wrench fa-4" > '.__('backend.post_in_editing').'</i>', array('class' => 'btn btn-primary btn-xs btn-block')); ?>
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