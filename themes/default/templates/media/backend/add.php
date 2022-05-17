
<!-- Modal vimeo video -->
<div class="modal fade" id="vimeomodal" tabindex="-1" role="dialog" aria-labelledby="vimeomodalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="vimeomodalLabel">ID Vimeo correct</h4>
      </div>
      <div id="vimeocode" class="modal-body">
            
      </div>
      <div class="modal-footer">
        <button id="validatevimeo" type="button" class="btn btn-primary">Ok</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal sketchfab video -->
<div class="modal fade" id="sketchfabmodal" tabindex="-1" role="dialog" aria-labelledby="sketchfabmodalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sketchfabmodalLabel">Sketchfab vizualizer</h4>
      </div>
      <div id="sketchfabcode" class="modal-body">
            
      </div>
      <div class="modal-footer">
        <button id="validatesketchfab" type="button" class="btn btn-primary">Ok</button>
      </div>
    </div>
  </div>
</div>

<div class="pull-right" style="text-align: center;">
    <?php if ( $post->image_output == "text" ): ?>
        <img height="124" src="/assets/img/text.jpg" alt="">
    <?php else: ?>
        <img height="124" src="<?= $image_thumb; ?>" alt="">
    <?php endif; ?>
</div>

<?= \Form::open(array('class' => '')); ?>
    
    <?= \Form::hidden('back', $back_to_cms); ?>

    <p>
        <div class="group-separator">
            <div class="btn-group">
                <a href="<?= \Router::get('admin_media_exit', array($media, $id, false)); ?>" class="btn btn-default"><i class="fa fa-mail-reply"></i></a>
                <button type="submit" data-toggle="tooltip" title="<?= __('application.save_and_quit') ?>" class="btn btn-success input-button" id="form_add" name="add" value="<?= __('application.save_and_quit') ?>" ><i class="fa fa-caret-left"></i> <i class='fa fa-floppy-o'></i></button>
                <button type="submit" title="<?= __('application.save_in_place') ?>" class="btn btn-primary input-button" id="form_add" name="add" value="<?= __('application.save') ?>" ><i class='fa fa-refresh'></i> <?= __('application.save_in_place') ?></button>
            </div>
            <div class="btn">
                <?= \Html::anchor(\Router::get('admin_media_delete', array($this->submodule, $post->id)), '<i class="fa fa-trash-o fa-4 editblog"> '.__('backend.delete').'</i>', array('class' => 'btn btn-danger edit', 'onclick' => "return confirm('".__('backend.are-you-sure')."')")); ?>
            </div>
        </div>
    </p>

    
    <br/>


    <!-- Nav tabs -->
      <ul class="nav nav-tabs nav-tabs-post" role="tablist">
        <li class="active"><a href="#title" data-toggle="tab"><?= __('backend.post.tabs.setup') ?></a></li>
        <li><a href="#thumb" data-toggle="tab"><?= __('backend.post.tabs.thumb') ?></a></li>
        <?php if ($media == "gallery"): ?>
            <li><a href="#media" data-toggle="tab"><?= __('backend.post.tabs.gallery') ?></a></li>
        <?php endif ?>
        <?php if ($media == "sketchfab"): ?>
            <li><a href="#media" data-toggle="tab"><?= __('backend.post.tabs.sketchfab') ?></a></li>
        <?php endif ?>
        <?php if ($media == "video"): ?>
            <li><a href="#media" data-toggle="tab"><?= __('backend.post.tabs.video') ?></a></li>
        <?php endif ?> 
        <li role="presentation"><a href="#cms_summary" data-toggle="tab"><?= __('backend.post.tabs.summmary') ?></a></li>
        <li role="presentation"><a href="#cms_content" data-toggle="tab"><?= __('backend.post.tabs.content') ?></a></li>
        <li role="presentation"><a href="#options" data-toggle="tab"><?= __('backend.post.tabs.options') ?></a></li>
      </ul>

    <div class="tab-content">

        <!--                 -->
        <!--     info tab    -->
        <!--                 -->
        <!-- Tab title panes -->
        <div role="tabpanel" class="tab-pane fade in active" id="title">

            <h3 class="grey" ><?= __('backend.post.tabs.title') ?></h3>

            <div class="row">

                <div class="col-md-2">
                    <?= $form->field('title_expander')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
                </div>

                <div class="col-md-4">

                    <!-- short localisation -->
                    <div class="input-group">
                        <?php foreach (\Config::get('server.application.lang-order') as $lang): ?>
                            <?php if ( \Config::get('server.application.language') == $lang ): ?>
                                <div class="localisation <?= $lang ?>">
                                    <?= $form->field('short')->set_attribute(array('class' => 'form-control')); ?>
                                </div>
                            <?php else: ?>
                                <div class="localisation <?= $lang ?> hidden">
                                    <?= $form->field('short_'.$lang )->set_attribute(array('class' => 'form-control')); ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <div class="input-group-btn">
                            <div class="control-label">
                                <label id="label_flag" for="flag">Localisation</label>
                            </div>
                            <?php foreach (\Config::get('server.application.lang-order') as $lang): ?>
                                <a type="button" href="<?= $lang ?>" class="lang-switcher btn btn-default <?= \Config::get('server.application.language') == $lang ? 'active' : ''; ?>" aria-label="Normal"><img height="18" src="/assets/img/flag-<?= $lang ?>.svg" alt="<?= $lang ?>" ></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- end short localisation -->

                </div>

                <div class="col-md-3">
                    <?= $form->field('slug')->set_attribute(array('class' => 'form-control')); ?>
                </div>

                <!-- name localisation -->
                <div class="froala col-md-12">
                    
                    <div class="control-label">
                        <label id="label_name" for="name"><?= __('model.post.name') ?></label>
                    </div>

                    <ul style="margin-bottom: 6px;" class="nav nav-tabs nav-tabs-translation" role="tablist">
                        <?php foreach (\Config::get('server.application.lang-order') as $lang): ?>
                            <li class="tab-froala-local <?= \Config::get('server.application.language') == $lang ? 'active' : '' ?>"><a href="<?= $lang ?>" class="lang-switcher-textarea" aria-label="Normal"><img height="15" src="/assets/img/flag-<?= $lang ?>.svg" alt="<?= $lang ?>" > <?= __('application.lang.'.$lang) ?></a></li>
                        <?php endforeach; ?>
                    </ul>

                    <?php foreach (\Config::get('server.application.lang-order') as $lang): ?>
                        <?php if ( \Config::get('server.application.language') == $lang ): ?>
                                <section class="name localisation <?= $lang ?>" id="name">
                                    <?= $form->field('name')->set_attribute(array( 'id' => 'edit_name', 'class' => 'form-control edit_froala_name' )) ?>
                                </section>
                        <?php else: ?>
                                <section class="name localisation <?= $lang ?> hidden" id="name_<?= $lang ?>">
                                    <?= $form->field('name_'.$lang)->set_attribute(array( 'id' => 'edit_name_'.$lang, 'class' => 'form-control edit_froala_name' )) ?>
                                </section>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <hr/>
                </div>
                <!-- end name localisation -->

            </div>

            <div class="col-md-3">
                <?= $form->field('locked')->set_attribute(array('class' => 'form-control selectpicker', 'data-style' => 'btn-danger')); ?>
            </div>
        
        </div>
        <!-- end title tab  -->


        <!--               -->
        <!--     thumb     -->
        <!--               -->
        <div role="tabpanel" class="tab-pane fade" id="thumb">

            <div class="row">
                
                <div class="col-md-12">

                    <h3 class="grey" ><?= __('backend.post.tabs.thumb') ?></h3>

                </div>
                
                <div class="col-md-5">

                    <div class="form-group">
                        <div class="control-label"><label id="label_name" for="form_name"><?= __('backend.post.visual'); ?></label></div>
                        <div id="my-slim" class="slim <?= $isUpdate ? '' : 'newpost'; ?>"
                                data-media="<?= $media ?>"
                                data-thumb-width="<?= \Config::get('app-thumb.gallery.thumb.width') ?>"
                                data-thumb-height="<?= \Config::get('app-thumb.gallery.thumb.height') ?>"
                              
                                data-thumb-single-width="<?= \Config::get('app-thumb.gallery.column.single.width') ?>"
                                data-thumb-single-height="<?= \Config::get('app-thumb.gallery.column.single.height') ?>"

                                data-thumb-double-width="<?= \Config::get('app-thumb.gallery.column.double.width') ?>"
                                data-thumb-double-height="<?= \Config::get('app-thumb.gallery.column.double.height') ?>"

                                data-thumb-triple-width="<?= \Config::get('app-thumb.gallery.column.triple.width') ?>"
                                data-thumb-triple-height="<?= \Config::get('app-thumb.gallery.column.triple.height') ?>"

                                data-thumb-full-width="<?= \Config::get('app-thumb.gallery.column.full.width') ?>"
                                data-thumb-full-height="<?= \Config::get('app-thumb.gallery.column.full.height') ?>"

                                data-webhd-width="<?= \Config::get('app-thumb.gallery.web_hd.width') ?>"
                                data-webhd-height="<?= \Config::get('app-thumb.gallery.web_hd.height') ?>"
                                data-meta-post-id="<?= $id ?>"
                                data-meta-post-slug="<?= $slug ?>"
                                data-service="<?= $gallery_slim_cover ?>"
                                data-serviceadd="<?= $gallery_slim_add ?>"
                                <?php if (isset($cover)): ?>
                                    data-cover-width=<?= $cover_width ?>,
                                    data-cover-height=<?= $cover_height ?>,
                                    data-imageid="<?= isset($cover->id) ? $cover->id : '' ?>"
                                    data-crop= "<?= $slimCrop ?>"
                                    data-rotation= "<?= $rotation ?>"
                                <?php else: ?>
                                    data-crop= "0,0,0,0"
                                    data-rotation= "0"
                                <?php endif; ?>
                                >
                            <?php if (isset($cover)): ?>
                                <img src="<?= Config::get('base_url') . $cover->path.'original'.$imagesrc_cover.'?'.rand(); ?>" alt=""/>
                            <?php endif; ?>
                            <input type="file" class="form-control input-slim"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    
                    <div class="col-md-6  nopadding-left">
                        <?= $form->field('image_output')->set_attribute(array('class' => 'form-control selectpicker')); ?>
                    </div>

                    <div class="col-md-6 nopadding-left">
                        <?= $form->field('column')->set_attribute(array('class' => 'form-control selectpicker', 'data-style' => 'btn-success')); ?>
                    </div>

                    <div class="col-md-6 nopadding-left">
                        <?= $form->field('column_open')->set_attribute(array('class' => 'form-control selectpicker', 'data-style' => 'btn-success')); ?>
                    </div>

                    <div id="cropsetup_thumb">
                        
                        <div id="cropsetup_form">
                            <div class="col-md-6 nopadding-left">

                                <?= $form->field('crop_presets')->set_attribute(array('class' => 'form-control selectpicker', 'data-style' => 'btn-default')); ?>

                            </div>

                            <div class="col-md-6 nopadding-left">
                                <?= $form->field('orientation')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
                            </div>

                        </div>

                    </div>

                    <div class="clearfix"></div>
                    <div id="fullscreen_thumb">

                        <div id="fullscreen_form" class="col-md-6 nopadding-left">
                            <?= $form->field('fullscreen')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
                        </div>

                    </div>

                </div>

            </div>
        
        </div>
        <!-- end thumb tab  -->


        <!--                    -->
        <!--     info media     -->
        <!--                    -->

        <div role="tabpanel" class="tab-pane fade" id="media">

            <?php if ($media == "gallery"): ?> 
                
                <div class="row">
                
                <!-- 
                    ////////////////////////////////////
                           G A L L E R Y  M E D I A
                    ////////////////////////////////////
                -->

                    <div class="col-md-12">

                        <h3 class="grey" ><?= __('backend.post.tabs.gallery') ?></h3>

                    </div>
                
                    <div class="col-md-12">
                            <a class="addimage" href="#"><i class="fa fa-plus-circle"></i> <?= __('module.media.backend.addimage_setup') ?></a>
                            <hr class="empty" />
                    </div>
                    
                    <div id="moreimage">

                        <div class="col-md-12 image-setup">

                            <div class="col-md-3 nopadding-left">
                        
                                <?= $form->field('crops')->set_attribute(array('class' => 'form-control selectpicker', 'data-style' => 'btn-default')); ?>
                        
                            </div>

                            <div id="cropsetup_media">


                            </div>

                        </div>
                                                
                        <div class="col-md-12 nopadding-left gallery-thumbs">
                            <?php foreach ($addimages as $key => $image): ?>
                                <div class="col-md-3 glyphicon-move">
                                    <span class="fa fa-arrows"> Image <?= $key ?></span>
                                    <div id="my-slim-add<?= $key ?>" class="slim-add"
                                        data-nth="<?= $key ?>"
                                        data-service="<?= $gallery_slim_add ?>/<?= $image->name ?>"
                                        data-imageid="<?= isset($image->id) ? $image->id : '' ?>"
                                        data-crop= "<?= $image->slimcrop ?>"
                                        data-rotation= "<?= $rotation ?>"
                                        data-cover-width= "<?= $image->cover['width'] ?>"
                                        data-cover-height= "<?= $image->cover['height'] ?>"

                                    >
                                        <img src="<?= Config::get('base_url') . $image->path.'original/'.$image->name.'?'.rand(); ?>" alt=""/>
                                        <input type="file" class="form-control input-slim-add" />
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-md-12"><br/></div>
                        <div class="col-md-3">
                            
                            <div class="control-label"><label id="label_crops" for="form_crops"><?= __('model.crops.auto_crop') ?></label></div>
                            <button id="run_crop" class="btn btn-primary"><i class="fa fa-crop"></i> <?= __('model.crops.run_crop') ?></button>
                        
                        </div>

                        <div class="col-md-12 gallery-controls">
                            
                            <div class="col-md-12 nopadding-left">
                                <hr/>
                            </div>

                            <div id="fullscreen_media">

                            </div>

                            <div class="col-md-2 nopadding-left">
                                <?= $form->field('flickity_nav')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
                            </div>

                            <div class="col-md-2 nopadding-left">
                                    
                                <?php // $form->field('flickity_play')->set_attribute(array('class' => 'form-control selectpicker', 'data-style' => 'btn-warning')); ?>
                                <?= $form->field('flickity_play')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
                            </div>

                            <div class="col-md-2 nopadding-left">
                                    
                                <?= $form->field('flickity_delay')->set_attribute(array('class' => 'form-control')); ?>

                            </div>

                        </div>

                    </div>

                </div>
                
            <?php endif; ?>
            
            <!-- end gallery -->


            <?php if ($media == "video"): ?>
                
                <div class="row">

                <!-- 
                    ////////////////////////////////////
                           V I D E O   M E D I A
                    ////////////////////////////////////
                 -->

                    <div class="col-md-12">

                        <h3 class="grey" ><?= __('backend.post.tabs.video') ?></h3>

                    </div>
                    
                    <div class="col-md-3">
                        
                        <?= $form->field('enginevideo')->set_attribute(array('class' => 'form-control')); ?>

                    </div>

                    <div class="col-md-4">

                        <div class="control-label"><label id="label_name" for="form_name"><?= __('backend.verify_video'); ?></label></div>
                        <div class="input-group">
                          <input type="text" value="<?= $idvideo ?>" id="idvideo" class="form-control" name="idvideo">
                          <span class="input-group-btn">
                            <button id="checkvideo" class="btn btn-warning" type="button" data-toggle="modal" data-target="#vimeomodal" >
                                <?= __('backend.run_video'); ?>
                            </button>
                          </span>
                        </div>

                    </div>
                

                </div>

            <?php endif; ?>
            
            <!-- end video -->


            <?php if ($media == "sketchfab"): ?>
                
                <div class="row">
                     
                <!-- 
                    ////////////////////////////////////
                        S K E T C H F A B   M E D I A
                    ////////////////////////////////////
                -->

                    <div class="col-md-12">
                        <h3 class="grey" ><?= __('backend.post.tabs.sketchfab') ?></h3>
                    </div>

                    <div class="col-md-5">

                        <div class="control-label"><label id="label_name" for="form_name"><?= __('backend.verify_video'); ?></label></div>
                        <div class="input-group">
                          <input type="text" value="<?= $idsketchfab ?>" id="idsketchfab" class="form-control" name="sketchfab">
                          <span class="input-group-btn">
                            <button id="checksketchfab" class="btn btn-warning" type="button" data-toggle="modal" data-target="#sketchfabmodal" >
                                <?= __('backend.run_video'); ?>
                            </button>
                          </span>
                        </div>

                    </div>

                <!-- end sketchfab -->

                </div>

            <?php endif; ?>

        </div>
        <!-- end media tab  -->


        <!--                   -->
        <!--     CMS summary   -->
        <!--                   -->
        <div role="tabpanel" class="tab-pane fade" id="cms_summary">
                
            <!-- summary CMS -->
            <div class="row">

                <div class="col-md-12">
                    <h3 class="grey" ><?= __('backend.post.tabs.summmary') ?></h3>
                </div>
                
                <div class="froala col-md-3">
                    
                    <?= $form->field('summary_switch')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>

                </div>

                <div class="clearfix"></div>

                <div class="col-md-12">

                    <!-- summary localisation -->
                    <div id="froala-summary" class="froala">
                        
                        <div class="control-label">
                            <label id="label_summary" for="summary"><?= __('model.post.summary') ?></label>
                        </div>

                        <ul style="margin-bottom: 6px;" class="nav nav-tabs nav-tabs-translation" role="tablist">
                            <?php foreach (\Config::get('server.application.lang-order') as $lang): ?>
                                <li class="tab-froala-local <?= \Config::get('server.application.language') == $lang ? 'active' : '' ?>"><a href="<?= $lang ?>" class="lang-switcher-textarea" aria-label="Normal"><img height="15" src="/assets/img/flag-<?= $lang ?>.svg" alt="<?= $lang ?>" > <?= __('application.lang.'.$lang) ?></a></li>
                            <?php endforeach; ?>
                        </ul>

                        <?php foreach (\Config::get('server.application.lang-order') as $lang): ?>
                            <?php if ( \Config::get('server.application.language') == $lang ): ?>
                                    <section class="localisation <?= $lang ?>" id="summary">
                                        <?= $form->field('summary')->set_attribute(array(
                                            'id'            => 'edit_summary',
                                            'class'         => 'form-control edit_froala_summary',
                                            'data-upload'   => \Uri::base(false).\Config::get('server.cdn.action.upload'),
                                            'data-gallery'  => \Uri::base(false).\Config::get('server.cdn.action.gallery'),
                                            'data-delete'   => \Uri::base(false).\Config::get('server.cdn.action.delete'),
                                            'data-folder'   => $froala_folder,
                                            'data-crop'     => \Config::get('app-thumb.default')['crop'],
                                            'data-size'     => \Config::get('app-thumb.default')['size'],
                                            'data-algorythm'=> \Config::get('app-thumb.default')['algorythm'],
                                            'data-lang'     => \Cookie::get('lang'),
                                            )) ?>
                                    </section>
                            <?php else: ?>
                                <section class="localisation <?= $lang ?> hidden" id="summary_<?= $lang ?>">
                                        <?= $form->field('summary_'.$lang)->set_attribute(array(
                                            'id'            => 'edit_summary_'.$lang,
                                            'class'         => 'form-control edit_froala_summary',
                                            )) ?>
                                    </section>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <hr/>
                        
                        <div class="clearfix"></div>
                        
                        <div class="col-md-2 nopadding-left">
                            <?= $form->field('summary_expander_ui')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
                        </div>
                        <div class="col-md-2 nopadding-left">
                            <?= $form->field('summary_expander')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
                        </div>
                        <div class="froala col-md-3">
                            <?= $form->field('summary_to_content')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
                        </div>
                        <div class="col-md-2 nopadding-left">
                            <?= $form->field('summary_caesura')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
                        </div>

                        <div class="clearfix"></div>
                            
                        <!-- Summmary BG color background -->
                        <div class="col-md-3 nopadding-left">

                            <?= $form->field('postbgselect')->set_attribute(array('class' => 'form-control selectpicker', 'data-style'=>'btn-default')); ?>
                                <div id="postbgdata_wrapper" data-type="postbg" data-<?= $form->field('postbgselect')->get_attribute('value') ?>="<?= $form->field('postbgdata')->get_attribute('value') ?>" ></div>
                            </div>
                        
                        </div>

                        <div class="col-md-2 nopadding-left">
                            <?= $form->field('postborder')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
                        </div>

                        <!-- Border summary color -->
                        <div id="bordercolorfield" class="col-md-3 nopadding-left">

                            <?= $form->field('postborderselect')->set_attribute(array('class' => 'form-control selectpicker', 'data-style'=>'btn-default')); ?>
                                <div id="postborderdata_wrapper" data-type="postborder" data-<?= $form->field('postborderselect')->get_attribute('value') ?>="<?= $form->field('postborderdata')->get_attribute('value') ?>" ></div>
                            </div>
                        
                        </div>
                            
                    </div>

                    <!-- end summary localisation -->
                    

                    <div id="image-resize-summary" class="row">
                        <div id="setup-image-resize">
                            <div class="col-md-12">
                                <h3 class="grey" ><?= __('backend.imageupload_setup') ?></h3>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field('media')->set_attribute(array('class' => 'form-control selectpicker foldermedia', 'data-style' => 'btn-default')); ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field('crop')->set_attribute(array('class' => 'form-control selectpicker crop', 'data-style' => 'btn-default')); ?>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-3">
                                <?= $form->field('size')->set_attribute(array('class' => 'form-control selectpicker size', 'data-style' => 'btn-default')); ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field('algorythm')->set_attribute(array('class' => 'form-control selectpicker algorythm', 'data-style' => 'btn-default')); ?>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
        <!-- end summary CMS -->

        <!--                   -->
        <!--     CMS content   -->
        <!--                   -->
        <div role="tabpanel" class="tab-pane fade" id="cms_content">

            <!-- content CMS -->
            <div class="row">

                <div class="col-md-12">
                    <h3 class="grey" ><?= __('backend.post.tabs.content') ?></h3>
                </div>
                
                <div class="froala col-md-3">
                    
                    <?= $form->field('content_switch')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>

                </div>

                <div class="clearfix"></div>

                <!-- content localisation -->
                <div id="froala-content" class="froala col-md-12">
                    
                    <div class="control-label">
                        <label id="label_content" for="content"><?= __('model.post.content') ?></label>
                    </div>

                    <ul style="margin-bottom: 6px;" class="nav nav-tabs nav-tabs-translation" role="tablist">
                        <?php foreach (\Config::get('server.application.lang-order') as $lang): ?>
                            <li class="tab-froala-local <?= \Config::get('server.application.language') == $lang ? 'active' : '' ?>"><a href="<?= $lang ?>" class="lang-switcher-textarea" aria-label="Normal"><img height="15" src="/assets/img/flag-<?= $lang ?>.svg" alt="<?= $lang ?>" > <?= __('application.lang.'.$lang) ?></a></li>
                        <?php endforeach; ?>
                    </ul>

                    <?php foreach (\Config::get('server.application.lang-order') as $lang): ?>
                        <?php if ( \Config::get('server.application.language') == $lang ): ?>
                                <section class="localisation <?= $lang ?>" id="content">
                                    <?= $form->field('content')->set_attribute(array(
                                        'id'            => 'edit_content',
                                        'class'         => 'form-control edit_froala_content',
                                        )) ?>
                                </section>
                        <?php else: ?>
                            <section class="localisation <?= $lang ?> hidden" id="content_<?= $lang ?>">
                                    <?= $form->field('content_'.$lang)->set_attribute(array(
                                        'id'            => 'edit_content_'.$lang,
                                        'class'         => 'form-control edit_froala_content',
                                        )) ?>
                                </section>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <hr/>
                    
                    <div class="clearfix"></div>

                    <div class="col-md-2 nopadding-left">
                        <?= $form->field('content_expander_ui')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
                    </div>
                    <div class="col-md-2 nopadding-left">                    
                        <?= $form->field('content_expander')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
                    </div>
                    <div class="col-md-3">                    
                        <?= $form->field('content_caesura')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
                    </div>

                    <!-- Summmary BG color background -->
                    <div class="col-md-3 nopadding-left">

                        <?= $form->field('contentbgselect')->set_attribute(array('class' => 'form-control selectpicker', 'data-style'=>'btn-default')); ?>
                            <div id="contentbgdata_wrapper" data-type="contentbg" data-<?= $form->field('contentbgselect')->get_attribute('value') ?>="<?= $form->field('contentbgdata')->get_attribute('value') ?>" ></div>
                        </div>
                    
                    </div>

                    <div class="col-md-2 nopadding-left">
                        <?= $form->field('contentborder')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
                    </div>

                    <!-- Border summary color -->
                    <div id="content_bordercolorfield" class="col-md-3 nopadding-left">

                        <?= $form->field('contentborderselect')->set_attribute(array('class' => 'form-control selectpicker', 'data-style'=>'btn-default')); ?>
                            <div id="contentborderdata_wrapper" data-type="contentborder" data-<?= $form->field('contentborderselect')->get_attribute('value') ?>="<?= $form->field('contentborderdata')->get_attribute('value') ?>" ></div>
                        </div>
                    
                    </div>

                </div>
                <!-- end content localisation -->

                <div id="image-resize-content" class="row">
                </div>
                
            </div>

        </div>
        <!-- end content CMS -->

        <!--                -->
        <!--     options     -->
        <!--                -->
        <div role="tabpanel" class="tab-pane fade" id="options">

                <div class="row">
                    
                    <div class="col-md-12">
                        <h3 class="grey" ><?= __('backend.post.tabs.options') ?></h3>
                    </div>

                    <div class="col-md-12">
                        
                        <?= $form->field('meta')->set_attribute(array('class' => 'form-control')); ?>

                    </div>
                    
                    <div class="col-md-12">
                        <h3 class="grey" ><?= __('application.status'); ?></h3>
                    </div>

                    <div class="col-md-3">
                        
                        <?= $form->field('user_id')->set_attribute(array('class' => 'form-control selectpicker', 'data-style' => 'btn-default')); ?>

                    </div>

                    <div class="col-md-3">
                        <?= $form->field('allow_comments')->set_attribute(array('class' => 'form-control selectpicker', 'data-style' => 'btn-default')); ?>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-md-2">
                        <?= $form->field('status')->set_attribute(array('class' => 'form-control selectpicker', 'data-style' => 'btn-warning')); ?>
                    </div>

                    <div class="col-md-2">
                        <?= $form->field('permission')->set_attribute(array('class' => 'form-control selectpicker', 'data-style' => 'btn-warning')); ?>
                    </div>
                    <div class="col-md-2">
                        <?= $form->field('featured')->set_attribute(array('class' => 'form-control selectpicker', 'data-style' => 'btn-warning')); ?>
                    </div>
                    
                    <?= $form->field('module')->set_attribute(array('class' => 'form-control'))->set_value('gallery')->set_type('hidden'); ?>

                </div>
        </div> <!-- end option -->


    </div> <!-- end content tab -->

<?= \Form::close(); ?>

    <div class="bb-alert alert alert-info content success" style="display: none;" >
        <span>Texte contenu sauvegardé</span>
    </div>

    <div class="bb-alert alert alert-danger error" style="display: none;" >
        <span>Attention ! erreur dans la sauvegarde, problème de connection.</span>
    </div>

    <div class="bb-alert alert alert-info summary" style="display: none;" >
        <span>Texte résumé sauvegardé</span>
    </div>








