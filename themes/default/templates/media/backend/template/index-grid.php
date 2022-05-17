<script>
    window.lazySizesConfig = window.lazySizesConfig || {};
    //only for demo in production I would use normal expand option
    lazySizesConfig.expand = 400;
</script>

<!-- Modal share video -->
<div class="modal fade" id="sharemodal" tabindex="-1" role="dialog" aria-labelledby="sharemodalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sharemodalLabel"><?= __('backend.share'); ?></h4>
      </div>
      <div id="sharecode" class="modal-body">
        <div class="row">
            <div class="form-group">
                <label for="inputShareURL" class="col-sm-12 control-label"><?= __('backend.link'); ?></label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="inputShareURL" placeholder="#">
                </div>
              </div>
        </div>
      </div>
        <div class="modal-footer">
          <a target="_blank" href="#" type="button" id="open" class="btn btn-default"><i class="fa fa-television"> <?= __('backend.view'); ?></i></a>
          <a target="_blank" href="#" type="button" id="facebook" class="btn btn-info" data-facebook="<?= \Config::get('server.social.share.facebook') ?>"><i class="fa fa-facebook"></i></a>
          <a target="_blank" href="#" type="button" id="twitter" class="btn btn-success" data-twitter="<?= \Config::get('server.social.share.twitter') ?>" ><i class="fa fa-twitter"></i></a>
          <a target="_blank" href="#" type="button" id="google" class="btn btn-warning" data-google="<?= \Config::get('server.social.share.google') ?>" ><i class="fa fa-google"></i></a>
          <a target="_blank" href="#" type="button" id="pinterest" class="btn btn-danger" data-pinterest="<?= \Config::get('server.social.share.pinterest') ?>" ><i class="fa fa-pinterest"></i></a>
          <button id="paste" class="btn btn-primary paste-url" data-clipboard-text="#" href="#" ><i class="fa fa-clipboard" ></i> <?= __('backend.copy_link'); ?></button>
        </div>

    </div>
  </div>
</div>

<?= \Theme::instance()->view('backend/template/block/nav');  ?>

     <?= \Theme::instance()->view('backend/template/block/list_controls'); ?>
     <?= \Theme::instance()->view('backend/template/block/list_menus'); ?>

<?php if(empty($posts)): ?>

    <p class="empty"><?= __('backend.post.empty'); ?></p>

<?php else: ?>

    <?php if (!empty($pagination->pages_render())): ?>
        <div class="pull-left"><?= $pagination; ?></div> <a class="pagination-all btn btn-default text-primary <?= \Input::get('pagination') == 'on' ? 'active' : ''; ?>" href="/media/admin/<?= $this->submodule; ?>?pagination=<?= \Input::get('pagination') == 'on' ? 'off' : 'on'; ?>" data-toggle="tooltip-media" title='<?= __('backend.show_all_without_pagination') ?>' ><i class="fa fa-stack-overflow" ></i></a>
    <?php endif; ?>
     
     <div class="container-fluid">

            <div id="listWithHandle" class="row isotope" data-delete-url="<?= \Router::get('admin_media_delete', array('module', 0))  ?>" >

            <?php foreach($posts as $post): ?>

                <?php $publish = ($post->status == 'published') ? 'success' : 'warning';  ?>

                <div class="pull-left element grid-item-backend <?= $post->slug_categories ?> <?= isset($post->meta) ? strtolower($post->meta) : '' ?>" id="<?= $post->id; ?>" >
                    
                    <div id="attributes" class="pull-right">
                        
                        <!-- status 'admin_media_attribute_module', array('media_cv', 'media_cv' -->
                        <span class="icon-state attribute <?= $by == 'status' ? 'active' : '' ?>">
                            <a class="attr-status" href="<?= \Router::get('admin_media_attribute_module', array('post', 'media_'.$this->submodule, $post->id,'status',$post->status)) ?>" data-attr="<?= $post->status ?>" data-attr-toggle="<?= \Config::get('server.attributes.status')[0] == $post->status ? \Config::get('server.attributes.status')[1] : \Config::get('server.attributes.status')[0] ?>" >
                                <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => ($post->status == 'published') ? 'chain' : 'chain-broken', 'title' => 'model.post.status', 'value' => 'model.post.attribute.status.'.$post->status )); ?>
                            </a>
                        </span>

                        <!-- permission -->
                        <span class="icon-state attribute <?= $by == 'permission' ? 'active' : '' ?>" >
                            <a class="attr-permission" href="<?= \Router::get('admin_media_attribute_module', array('post', 'media_'.$this->submodule, $post->id,'permission',$post->permission)) ?>" data-attr="<?= $post->permission ?>" data-attr-toggle="<?= \Config::get('server.attributes.permission')[0] == $post->permission ? \Config::get('server.attributes.permission')[1] : \Config::get('server.attributes.permission')[0] ?>" >
                                <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => ($post->permission == 'public') ? 'globe' : 'user', 'title' => 'model.post.permission', 'value' => 'model.post.attribute.permission.'.$post->permission )); ?>                            
                            </a>
                        </span>

                        <!-- allow_comments -->
                        <?php if ( isset($allow_comments) ): ?>
                            <span class="icon-state attribute <= $by == 'allow_comments' ? 'active' : '' ?>" >
                                <a href="<?= \Router::get('admin_media_attribute_module', array('post', 'media_'.$this->submodule, $post->id,'allow_comments',$post->allow_comments)) ?>"  >
                                    <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => ($post->allow_comments == 'yes') ? 'comments' : 'comments-o', 'title' => 'model.post.comment', 'value' => 'model.post.attribute.comment.'.$post->allow_comments )); ?>                                                        
                                </a>
                            </span>
                       <?php endif; ?>

                        <!-- featured -->
                        <span class="icon-feature attribute <?= $by == 'featured' ? 'active' : '' ?>" >
                            <a class="attr-featured" href="<?= \Router::get('admin_media_attribute_module', array('post', 'media_'.$this->submodule, $post->id,'featured',$post->featured)) ?>" data-attr="<?= $post->featured ?>" data-attr="<?= $post->permission ?>" data-attr-toggle="<?= \Config::get('server.attributes.featured')[0] == $post->featured ? \Config::get('server.attributes.featured')[1] : \Config::get('server.attributes.featured')[0] ?>" >
                                <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => ($post->featured == 'yes') ? 'heart' : 'heart-o', 'title' => 'model.post.featured', 'value' => 'model.post.attribute.featured.'.$post->featured )); ?>
                            </a>
                        </span>

                        <!-- locked -->
                        <span class="icon-feature attribute <?= $by == 'locked' ? 'active' : '' ?>" >
                            <a class="attr-locked" href="<?= \Router::get('admin_media_attribute_module', array('post', 'media_'.$this->submodule, $post->id,'locked',$post->locked)) ?>" data-attr="<?= $post->locked ?>" data-attr="<?= $post->permission ?>" data-attr-toggle="<?= \Config::get('server.attributes.locked')[0] == $post->locked ? \Config::get('server.attributes.locked')[1] : \Config::get('server.attributes.locked')[0] ?>" >
                                <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => ($post->locked == 'yes') ? 'lock' : 'unlock-alt', 'title' => 'model.post.locked', 'value' => 'model.post.attribute.locked.'.$post->locked )); ?>
                            </a>
                        </span>

                    </div>

                    <span class="fa fa-arrows icon-state attribute glyphicon-move"></span>
                    <span class="label label-default label-as-badge title-post-grid"><?= \Str::truncate(\Security::strip_tags($post->name), 25); ?></span>
                    <!-- category -->
                    <div>    <span class="category pull-right label label-default label-as-badge"><i class="fa fa-<?= isset($media_ico[$post->module]['titleicon']) ? $media_ico[$post->module]['titleicon'] : ''; ?> fa-1x"></i></span></div>

                    <!-- img -->
                    <div class="tooltip-post-thumb" 
                        data-trigger="click" 
                        data-toggle="tooltip" 
                        data-placement="auto right" 
                        data-original-title="<div style='text-align:left;'><?= empty($post->name) ? '<p>No title</p>' : '<h5>'.\Security::strip_tags($post->name).'</h5>'; ?><i>ID: <?= $post->id; ?><br/>Slug: <?= $post->slug; ?></i><br/><i>Type media: <?= $post->module; ?></br>Created: <?= date('d/m/Y', $post->created_at); ?><br/>Updated: <?= date('d/m/Y', $post->updated_at); ?><br/></i><?= isset($post->meta) ? '<i>Keywords:</i> <b>'.strtolower($post->meta) : '' ?></b></div><br/>"
                     >
                        <?php if ( $post->image_output == "text" ): ?>
                            <div class="img-thumbnail video-post-list" ><img class="lazyload" width="227" height="150" data-src="/assets/img/text.jpg" alt=""></div>
                        <?php else: ?>
                         <div class="img-thumbnail video-post-list" ><img class="lazyload" width="227" height="150" data-src="<?= $post->cover == NULL ? '/assets/img/empty-media.jpg' : $post->cover.'?'.rand() ?>" alt=""></div>
                        <?php endif; ?>
                    </div>

                    <!-- name, id, meta, featured, status -->
                    <?= \Theme::instance()->view('backend/template/block/media_meta',
                        [   'status'        => $post->status,
                            'date'          => date('d/m/Y', $post->created_at),
                            'category_slug' => $post->slug_categories,
                            'arr_categories'=> $post->arr_categories,
                            'featured'      => $post->featured,
                            'permission'    => $post->permission,
                            'name'          => \Security::strip_tags($post->name),
                            'is_amorething' => $post->image_output == "text" ? true : false,
                            'exposition'    => $post->module,
                            'module'        => $this->submodule,
                            'meta'          => isset($post->meta) ? htmlentities($post->meta) : '',
                            'id'            => $post->id,
                            'by'            => $by,
                            'categories'    => $categories,
                        ]);
                    ?>

                    <!-- action -->
                    <div class="btn-toolbar" role="toolbar" >
                      <div class="btn-group" role="group" >
                        <div class="toggle-grid" ><input class="btn btn-default btn-xs toggle-grid-admin-select" type="checkbox" data-post-slug="<?= $post->slug ?>" data-post-id="<?= $post->id ?>" data-toggle="toggle" data-size="mini" data-width="35" data-height="20" data-on="<i class='fa fa-check'></i>" data-off="<i class='fa fa-toggle-off'></i>" ></div>
                      </div>
                      <div class="btn-group" role="group" >
                        <?php if ($post->edit == 0): ?>                            
                            <?= \Html::anchor(\Router::get('admin_media_'.$post->module.'_edit', array('id' => $post->id)), '<i class="fa fa-wrench fa-4"> '.__('backend.edit').'</i>', array('class' => 'btn btn-default btn-xs', 'style' => 'width:131px')); ?>
                            <?= \Html::anchor( \Uri::base(false).'p/'.$post->slug, '<i class="fa fa-share-alt fa-4 editblog"></i>', array('class' => 'btn btn-success btn-xs share', 'style' => 'width:34px')); ?>
                            <?= \Html::anchor(\Router::get('admin_media_delete', array($this->submodule, $post->id)), '<i class="fa fa-trash-o fa-4 editblog"></i>', array('class' => 'btn btn-danger btn-xs delete-post', 'style' => 'width:34px', 'onclick' => "return confirm('".__('backend.are-you-sure')."')")); ?>

                        <?php else: ?>    
                            <?= \Html::anchor(\Router::get('admin_media_force', array($this->submodule, $post->id)), '<i class="fa fa-wrench fa-4" > '.__('backend.post_in_editing').'</i>', array('class' => 'btn btn-primary btn-xs')); ?>
                        <?php endif; ?>
                      </div>
                    </div>

                   

                </div>

            <?php endforeach; ?>

        </div> <!-- end row -->

    </div>

<?php endif; ?>