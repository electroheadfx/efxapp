
<?= \Form::open(); ?>

    <p>
        <div class="group-separator">
            <div class="btn-group">
                <?php if (!$isUpdate): ?>
                    <a id="back" href="<?= \Router::get('admin_'.$moduleName.'_menu_exit_without'); ?>" type="button" class="btn btn-default" ><i class="fa fa-mail-reply"></i> <?= __('backend.back-to-menu'); ?></a>
                    <button type="submit" class="btn btn-success input-button" id="form_add" name="add" value="<?= __('backend.add') ?>" ><i class='fa fa-pencil-square-o'></i> <?= __('backend.add') ?></button>
                <?php endif; ?>
                
                <?php if ($isUpdate): ?>
                    <a id="back" data-toggle="tooltip" title="<?= __('application.quit') ?>" href="<?= \Router::get('admin_'.$moduleName.'_menu_exit_without'); ?>" type="button" class="btn btn-default" ><i class="fa fa-mail-reply"></i></a>
                    <button type="submit" data-toggle="tooltip" title="<?= __('application.save_and_quit') ?>" class="btn btn-success input-button" id="form_add" name="add" value="<?= __('application.save_and_quit') ?>" ><i class="fa fa-caret-left"></i> <i class='fa fa-floppy-o'></i></button>
                    <button type="submit" title="<?= __('application.save_in_place') ?>" class="btn btn-primary input-button" id="form_add" name="add" value="<?= __('application.save') ?>" ><i class='fa fa-refresh'></i> <?= __('application.save_in_place') ?></button>
                <?php endif; ?>
            </div>
        </div>
    </p>
    
    <hr/>
    
    <!-- Nav tabs -->
      <ul class="nav nav-tabs tab-menu" role="tablist">
        <li class="active" ><a href="#setup" data-toggle="tab"><?= __('module.project.backend.menu_content') ?></a></li>
        <li><a href="#theme" data-toggle="tab"><?= __('module.project.backend.theme.theme') ?></a></li>
        <li><a href="#featured" data-toggle="tab"><?= __('application.featured_managment') ?></a></li>
        <li><a href="#cms" data-toggle="tab"><?= __('module.project.backend.theme.cms') ?></a></li>
        <li><a href="#color" data-toggle="tab"><?= __('module.project.backend.theme.themecolor') ?></a></li>
        <li><a href="#various" data-toggle="tab"><?= __('application.various') ?></a></li>
      </ul>
    
<div class="tab-content">
    
    <!-- Tab setup panes -->
    <div role="tabpanel" class="tab-pane fade in active" id="setup">
    <!-- 
        
        SETUP MENU
            
     -->

        <h3 class="grey" ><?= __('module.project.backend.menu_content') ?></h3>
        
        <div class="row">
            
            <div class="col-md-3">
                <div>
                    <div class="control-label">
                        <?= $form->field('modules')->set_attribute(array('class' => 'form-control selectpicker', 'data-style'=>'btn-info')); ?>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <?= $form->field('route')->set_attribute(array('class' => 'form-control')); ?>
            </div>
            
            <div class="col-md-2">
                <?= $form->field('render')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
            </div>
            <div class="col-md-3">
                <?= $form->field('target')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
            </div>

            <div class="clearfix"></div>

            <div class="col-md-4">

                <!-- name localisation -->
                <div class="input-group">
                    <?php foreach (\Config::get('server.application.lang-order') as $lang): ?>
                        <?php if ( \Config::get('server.application.language') == $lang ): ?>
                            <div class="localisation <?= $lang ?>">
                                <?= $form->field('name')->set_attribute(array('class' => 'form-control')); ?>
                            </div>
                        <?php else: ?>
                            <div class="localisation <?= $lang ?> hidden">
                                <?= $form->field('name_'.$lang )->set_attribute(array('class' => 'form-control')); ?>
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
                <!-- end name localisation -->
            
            </div>

            <div class="col-md-2">
                <?= $form->field('uri_state')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
            </div>

            <div id="uri_wrapper" class="col-md-3">
                <?= $form->field('uri')->set_attribute(array('class' => 'form-control')); ?>
            </div>

        </div>
        
        <div class="row">
            
            <div class="col-md-4">
                
                <div class="control-label">
                    <label id="label_icon" for="meta"><?= __('module.project.backend.menu.fa') ?></label>
                </div>
                <select id="select" name="faiconchoosen" class="fa-select" data-model-faicon="<?= $faicon ?>"></select>

            </div>
            
        </div>

        <div class="row">
            <div class="col-md-12 chosen-cat">
                            
               <div class="control-label">
                   <label id="label_icon" for="chosen-categories"><?= __('module.menu.backend.chosen-categories') ?></label>
               </div>

               <select data-placeholder="<?= __('module.menu.backend.chosen-categories-select') ?>" multiple class="chosen-categories" id="chosen-categories" name="chosen-categories[]" tabindex="8">
                   
                   <option value=""></option>
                
                    <!-- setup 'uncategorized' category -->
                    
                    <?php if ( in_arrayi($uncategorized['id'], $actived_categories) ): ?>
                        
                            <option selected class="uncategorized" value="<?= $uncategorized['id'] ?>" ><?= $uncategorized['name'] ?></option>
                                                        
                    <?php else: ?>
                        
                        <option class="uncategorized" value="<?= $uncategorized['id'] ?>" ><?= $uncategorized['name'] ?></option>

                    <?php endif; ?>


                    <!-- setup others cats -->
                    <?php if (isset($categories)):  ?>
                        <?php foreach ($categories as $key => $module): ?>

                           <?php foreach ($module as $slug => $category): ?>
                                
                                <?php if ( in_arrayi($slug, $actived_categories) ): ?>
                                    
                                        <option selected class="<?= $key ?>" value="<?= $category['id'] ?>" ><?= $category['name'] ?> (<?= $category['exposition'] ?>)</option>
                                                                    
                                <?php else: ?>
                                    
                                    <?php if ( $menu_routing !== 'cms' ): ?>
                                        <option <?= $menu_routing != $key ? 'disabled' : '' ?> class="<?= $key ?>" value="<?= $category['id'] ?>" ><?= $category['name'] ?> (<?= $category['exposition'] ?>)</option>
                                    <?php else: ?>
                                        <option class="<?= $key ?>" value="<?= $category['id'] ?>" ><?= $category['name'] ?> (<?= $category['exposition'] ?>)</option>
                                    <?php endif; ?>

                                <?php endif; ?>

                           <?php endforeach; ?>

                        <?php endforeach; ?>
                    <?php endif; ?>

               </select>

            </div>

        </div>
        
    </div>  
    
     <!-- Tab theme panes -->
    <div role="tabpanel" class="tab-pane fade" id="theme">

        <!-- 
            
            SETUP TEMPLATE
                
         -->

        <h3 class="grey" ><?= __('module.project.backend.theme.template') ?></h3>
                
        <div class="row">
            
            <div class="col-md-3">
                <div class="control-label">
                    <?= $form->field('hoverthumb')->set_attribute(array('class' => 'form-control selectpicker')); ?>
                </div>
            </div>

            <div class="col-md-2">
                <?= $form->field('navbarmargin')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
            </div>
            <div class="col-md-2">
                <?= $form->field('navbarstate')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
            </div>
            <div class="col-md-3">
                <?= $form->field('slicePoint')->set_attribute(array('class' => 'form-control selectpicker', 'data-style'=>'btn-default')); ?>
            </div>
        </div>

        <div class="row">
            
            <div class="col-md-2">
                <?= $form->field('titletransform')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
            </div>

            <div class="col-md-2">
                <div class="control-label">
                    <?= $form->field('iconvisibility')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
                </div>
            </div>

            <div class="col-md-2">
                <div class="control-label">
                    <?= $form->field('iconmedia')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
                </div>
            </div>

            <div class="col-md-2">
                <?= $form->field('sidercategories')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
            </div>

            <div class="col-md-2">
                <?= $form->field('tooltip')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
            </div>

        </div>
        <div class="row">
            <div class="col-md-2">
                <?= $form->field('mediaautoclose')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
            </div>
        </div>

        <h3 class="grey" ><?= __('module.project.backend.theme.sort') ?></h3>
        
        <div class="row">

            <div class="col-md-2">
                <?= $form->field('sorts_default')->set_attribute(array('class' => 'form-control selectpicker', 'data-style'=>'btn-info')); ?>
            </div>
            <div class="col-md-2">
                <?= $form->field('sorts_control')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
            </div>

            <div class="col-md-2">
                <?= $form->field('postselect')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
            </div>
            <div class="col-md-2 postmax_wrapper">
                <?= $form->field('postmax')->set_attribute(array('class' => 'form-control')); ?>
            </div>

        </div>

    </div>
        

    <!-- Tab featured panes -->
    <div role="tabpanel" class="tab-pane fade" id="featured">

        <!-- 
            
            SETUP FEATURED
                
         -->
        
            <div class="featured">
                
                <h3 class="grey" ><?= __('application.featured_managment') ?></h3>

                <div class="row">

                    <div class="col-md-3">
                        <?= $form->field('featured_order')->set_attribute(array('class' => 'form-control selectpicker', 'data-style'=>'btn-info')); ?>
                    </div>
            
                    <div class="col-md-3">
                        <?= $form->field('featured_max')->set_attribute(array('class' => 'form-control selectpicker', 'data-style'=>'btn-primary')); ?>
                    </div>

                </div>
                
                <div class="row">

                    <div class="col-md-3">
                        <?= $form->field('selectmode')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
                    </div>

                    <div class="col-md-3">
                        <?= $form->field('scrollto')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>
                    </div>

                    <div class="col-md-3">
                        <?= $form->field('scrollpausetime')->set_attribute(array('class' => 'form-control selectpicker', 'data-style'=>'btn-default')); ?>
                    </div>

                </div>

                <div class="row">
                    
                    <div class="col-md-12 scrolltofeatured_wrapper">
                        <div class="control-label">
                            <div class="form-group">
                                <div class="controls">
                                    <select multiple="multiple" data-placeholder="Choisissez des publications ..." id="scrolltofeatured" class="form-control" data-style="btn-primary" name="scrolltofeatured[]">
                                        <optgroup id="scrolltofeatured_featured" label="<?= __('module.project.backend.menu.all_featured') ?>">
                                            <?php foreach ($featuredPosts as $key => $post): ?>
                                                <option <?= in_arrayi($post->id, $scrolltofeatured) ? 'selected="selected"' : ''; ?> data-img-src="<?= $post->cover ?>" value="<?= $post->id; ?>">ID<?= $post->id; ?></option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                        <?php if (isset($nofeaturedPosts)): ?>
                                            <optgroup id="scrolltofeatured_all" label="<?= __('module.project.backend.menu.all_posts') ?>">
                                                <?php foreach ($nofeaturedPosts as $key => $post): ?>
                                                    <option <?= in_arrayi($post->id, $scrolltofeatured) ? 'selected="selected"' : ''; ?> data-img-src="<?= $post->cover ?>" value="<?= $post->id; ?>">ID<?= $post->id; ?></option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        <?php endif; ?>
                                    </select> 
                                </div>
                            </div>
                        </div> <!-- end -->
                    </div>
                    
                </div>
                
            </div>

    </div>
    
    
    <!-- Tab cms panes -->
    <div role="tabpanel" class="tab-pane fade" id="cms">

        <!-- 
            
            SETUP CMS
                
         -->

        <h3 class="grey" ><?= __('module.project.backend.theme.cms') ?></h3>

        <div class="row">
            
            <div class="froala col-md-3">
                
                <?= $form->field('summary_switch')->set_attribute(array('data-toggle'=>'toggle', 'class' => 'form-toggle')); ?>

            </div>

            <div class="clearfix"></div>

            <!-- summary localisation -->
            <div id="froala-summary" class="froala col-md-12">
                
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
                            <section class="name localisation <?= $lang ?>" id="summary">
                                <?= $form->field('summary')->set_attribute(array(
                                    'id'            => 'edit_summary',
                                    'class'         => 'form-control edit_froala_summary',
                                    'data-upload'   => \Uri::base(false).\Config::get('server.cdn.action.upload'),
                                    'data-gallery'  => \Uri::base(false).\Config::get('server.cdn.action.gallery'),
                                    'data-delete'   => \Uri::base(false).\Config::get('server.cdn.action.delete'),
                                    'data-folder'   => 'menu',
                                    'data-crop'     => '0:0',
                                    'data-size'     => 1500,
                                    'data-algorythm'=> 'entropy',
                                    'data-lang'     => \Cookie::get('lang'),
                                    )) ?>
                            </section>
                    <?php else: ?>
                        <section class="name localisation <?= $lang ?> hidden" id="summary_<?= $lang ?>">
                                <?= $form->field('summary_'.$lang)->set_attribute(array(
                                    'id'            => 'edit_summary_'.$lang,
                                    'class'         => 'form-control edit_froala_summary',
                                    )) ?>
                            </section>
                    <?php endif; ?>
                <?php endforeach; ?>
                
            </div>
            <!-- end summary localisation -->
                    
        </div> <!-- end row -->

        <div id="image-resize-summary" class="row">
            <div id="setup-image-resize">
                <div class="col-md-12">
                    <h3 class="grey" ><?= __('backend.imageupload_setup') ?></h3>
                </div>
                <div class="col-md-3">
                    <?= $form->field('media')->set_attribute(array('class' => 'form-control selectpicker foldermedia', 'data-style'=>'btn-default')); ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field('crop')->set_attribute(array('class' => 'form-control selectpicker crop', 'data-style'=>'btn-default')); ?>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3">
                    <?= $form->field('size')->set_attribute(array('class' => 'form-control selectpicker size', 'data-style'=>'btn-default')); ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field('algorythm')->set_attribute(array('class' => 'form-control selectpicker algorythm', 'data-style'=>'btn-default')); ?>
                </div>
            </div>
        </div>

    </div> <!-- end cms pane -->

    <!-- Tab cms panes -->
    <div role="tabpanel" class="tab-pane fade" id="color">

        <!-- 
            
            SETUP THEME COLOR
                
         -->

        <h3 class="grey" ><?= __('module.project.backend.theme.themecolor') ?></h3>

        <div class="theme">
            
            <div class="row">
                <!-- Logo color 2 -->
                <div class="col-md-3">

                    <?= $form->field('logoselect')->set_attribute(array('class' => 'form-control selectpicker', 'data-style'=>'btn-primary')); ?>
                        <div id="logodata_wrapper" data-type="logo" data-<?= $form->field('logoselect')->get_attribute('value') ?>="<?= $form->field('logodata')->get_attribute('value') ?>" ></div>
                    </div>
                
                </div>
                <!-- Logo color 2 -->
                <div class="col-md-3">

                    <?= $form->field('logo2select')->set_attribute(array('class' => 'form-control selectpicker', 'data-style'=>'btn-primary')); ?>
                        <div id="logo2data_wrapper" data-type="logo2" data-<?= $form->field('logo2select')->get_attribute('value') ?>="<?= $form->field('logo2data')->get_attribute('value') ?>" ></div>
                    </div>
                
                </div>
                <!-- Media color -->
                <div class="col-md-3">

                    <?= $form->field('mediaselect')->set_attribute(array('class' => 'form-control selectpicker', 'data-style'=>'btn-default')); ?>
                        <div id="mediadata_wrapper" data-type="media" data-<?= $form->field('mediaselect')->get_attribute('value') ?>="<?= $form->field('mediadata')->get_attribute('value') ?>" ></div>
                    </div>
                
                </div>
            </div>
            
            <div class="row">
                
                <!-- BG background -->
                <div class="col-md-3">

                    <?= $form->field('bgselect')->set_attribute(array('class' => 'form-control selectpicker', 'data-style'=>'btn-info')); ?>
                        <div id="bgdata_wrapper" data-type="bg" data-<?= $form->field('bgselect')->get_attribute('value') ?>="<?= $form->field('bgdata')->get_attribute('value') ?>" ></div>
                    </div>
                
                </div>

                <!-- BG background sider -->
                <div class="col-md-3">

                    <?= $form->field('bgsiderselect')->set_attribute(array('class' => 'form-control selectpicker', 'data-style'=>'btn-info')); ?>
                        <div id="bgsiderdata_wrapper" data-type="bgsider" data-<?= $form->field('bgsiderselect')->get_attribute('value') ?>="<?= $form->field('bgsiderdata')->get_attribute('value') ?>" ></div>
                    </div>
                
                </div>

                <!-- Navbar background -->
                <div class="col-md-3">

                    <?= $form->field('navselect')->set_attribute(array('class' => 'form-control selectpicker', 'data-style'=>'btn-info')); ?>
                        <div id="navdata_wrapper" data-type="nav" data-<?= $form->field('navselect')->get_attribute('value') ?>="<?= $form->field('navdata')->get_attribute('value') ?>" ></div>
                    </div>
                
                </div>

                <!-- Navopt background -->
                <div class="col-md-3">

                    <?= $form->field('navrightselect')->set_attribute(array('class' => 'form-control selectpicker', 'data-style'=>'btn-info')); ?>
                        <div id="navrightdata_wrapper" data-type="navright" data-<?= $form->field('navrightselect')->get_attribute('value') ?>="<?= $form->field('navrightdata')->get_attribute('value') ?>" ></div>
                    </div>
                
                </div>
                
            </div>

            <div class="row">
                <!-- UI text color -->
                <div class="col-md-3">

                    <?= $form->field('uitextselect')->set_attribute(array('class' => 'form-control selectpicker', 'data-style'=>'btn-success')); ?>
                        <div id="uitextdata_wrapper" data-type="uitext" data-<?= $form->field('uitextselect')->get_attribute('value') ?>="<?= $form->field('uitextdata')->get_attribute('value') ?>" ></div>
                    </div>
                
                </div>

                <!-- UI text hover color -->
                <div class="col-md-3">

                    <?= $form->field('uitexthoverselect')->set_attribute(array('class' => 'form-control selectpicker', 'data-style'=>'btn-success')); ?>
                        <div id="uitexthoverdata_wrapper" data-type="uitexthover" data-<?= $form->field('uitexthoverselect')->get_attribute('value') ?>="<?= $form->field('uitexthoverdata')->get_attribute('value') ?>" ></div>
                    </div>
                
                </div>

                <!-- UI block hover color -->
                <div class="col-md-3">

                    <?= $form->field('uiblockhoverselect')->set_attribute(array('class' => 'form-control selectpicker', 'data-style'=>'btn-success')); ?>
                        <div id="uiblockhoverdata_wrapper" data-type="uiblockhover" data-<?= $form->field('uiblockhoverselect')->get_attribute('value') ?>="<?= $form->field('uiblockhoverdata')->get_attribute('value') ?>" ></div>
                    </div>
                
                </div>

                <!-- UI text active color -->
                <div class="col-md-3">

                    <?= $form->field('uitextactiveselect')->set_attribute(array('class' => 'form-control selectpicker', 'data-style'=>'btn-success')); ?>
                        <div id="uitextactivedata_wrapper" data-type="uitextactive" data-<?= $form->field('uitextactiveselect')->get_attribute('value') ?>="<?= $form->field('uitextactivedata')->get_attribute('value') ?>" ></div>
                    </div>
                
                </div>
            </div>

            <div class="row">
                <!-- UI sider text color -->
                <div class="col-md-3">

                    <?= $form->field('uisidertextselect')->set_attribute(array('class' => 'form-control selectpicker')); ?>
                        <div id="uisidertextdata_wrapper" data-type="uisidertext" data-<?= $form->field('uisidertextselect')->get_attribute('value') ?>="<?= $form->field('uisidertextdata')->get_attribute('value') ?>" ></div>
                    </div>
                
                </div>

                <!-- UI sider text hover color -->
                <div class="col-md-3">

                    <?= $form->field('uisidertexthoverselect')->set_attribute(array('class' => 'form-control selectpicker')); ?>
                        <div id="uisidertexthoverdata_wrapper" data-type="uisidertexthover" data-<?= $form->field('uisidertexthoverselect')->get_attribute('value') ?>="<?= $form->field('uisidertexthoverdata')->get_attribute('value') ?>" ></div>
                    </div>
                
                </div>

                <!-- UI sider text active color -->
                <div class="col-md-3">

                    <?= $form->field('uisidertextactiveselect')->set_attribute(array('class' => 'form-control selectpicker')); ?>
                        <div id="uisidertextactivedata_wrapper" data-type="uisidertextactive" data-<?= $form->field('uisidertextactiveselect')->get_attribute('value') ?>="<?= $form->field('uisidertextactivedata')->get_attribute('value') ?>" ></div>
                    </div>
                
                </div>
            </div>

        </div>

    </div>

    <!-- Tab cms panes -->
    <div role="tabpanel" class="tab-pane fade" id="various">

        <!-- 
            
            SETUP SEO GOOGLE
                
         -->
        
        <h3 class="grey" >Google</h3>
        
        <div class="row">

            <div class="col-md-12">

                <?= $form->field('meta')->set_attribute(array('class' => 'form-control selectpicker', 'data-style'=>'btn-default')); ?>

            </div>
            
        </div>

        <h3 class="grey" ><?= __('application.status'); ?></h3>

        <div class="row">
            
            <div class="col-md-2">
                <?= $form->field('status')->set_attribute(array('class' => 'form-control selectpicker', 'data-style' => 'btn-warning')); ?>
            </div>
            <div class="col-md-2">
                <?= $form->field('permission')->set_attribute(array('class' => 'form-control selectpicker', 'data-style' => 'btn-warning')); ?>
            </div>
            <div class="col-md-2">
                <?= $form->field('featured')->set_attribute(array('class' => 'form-control selectpicker', 'data-style' => 'btn-warning')); ?>
            </div>
            <div class="col-md-2">
                <?= $form->field('faicon')->set_attribute(array('class' => 'form-control selectpicker', 'data-style' => 'btn-warning', 'id' => 'modelfaicon')); ?>
            </div>

        </div>
        
        <hr/>

        <br/><br/><br/><br/>

        <!-- end parameters -->

        </div>

    <?= \Form::close(); ?>

</div>

    <div class="bb-alert alert alert-info content success" style="display: none;" >
        <span>Texte contenu sauvegardé</span>
    </div>

    <div class="bb-alert alert alert-danger error" style="display: none;" >
        <span>Attention ! erreur dans la sauvegarde, problème de connection.</span>
    </div>

    <div class="bb-alert alert alert-info summary" style="display: none;" >
        <span>Texte résumé sauvegardé</span>
    </div>








