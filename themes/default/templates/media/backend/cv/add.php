
<?= \Form::open(); ?>

    <p>
        <div class="group-separator">
            <div class="btn-group">
                <a id="back" href="<?= \Router::get('admin_'.$moduleName.'_cv_exit_1', array($id)); ?>" type="button" class="btn btn-default" ><span class="fa fa-mail-reply"></span> <?= __('application.back'); ?></a>
                <?php if ($isUpdate): ?>
                    <a href="<?= \Router::get('admin_'.$moduleName.'_cv_exit', array($id, true)); ?>" class="btn btn-info"><i class="fa fa-folder-open"></i> <?= __('model.post.category') ?></a>
                <?php else: ?>
                    <a href="<?= \Router::get('admin_project_category'); ?>" class="btn btn-info"><i class="fa fa-folder-open"></i> <?= __('model.post.category') ?></a>
                <?php endif; ?>
            </div>
            <div class="btn">
                <?php if ($isUpdate): ?>
                    <span class="btn btn-primary btn-fa">
                        <i class="fa fa-pencil-square-o"></i> <input type="submit" value="<?= __('application.save') ?>" id="form_add" name="add" >
                    </span>
                <?php else: ?>
                    <span class="btn btn-primary btn-fa">
                        <i class="fa fa-pencil-square-o"></i> <input type="submit" value="<?= __('backend.create') ?>" id="form_add" name="add" >
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </p>
    
    
        <hr/>
        <h3 class="grey" ><?= __('backend.post_content') ?></h3>

    <div class="row">

        <div class="col-md-12">

            <?= $form->field('name')->set_attribute(array('class' => 'form-control')) ?>

        </div>
    
    </div>

    <div class="row">

        <div id="fr-column" class="<?= $column; ?>"> 
            <?= $form->field('status')->set_attribute(array('class' => 'form-control'))->set_type('hidden'); ?>
            <?= $form->field('permission')->set_attribute(array('class' => 'form-control'))->set_type('hidden'); ?>
            <?= $form->field('featured')->set_attribute(array('class' => 'form-control'))->set_type('hidden'); ?>


                <div class="froala">

                    <section id="summary">

                        <?= $form->field('summary')->set_attribute(array(
                            'id'            => 'edit_summary',
                            'class'         => 'form-control',
                            // autosave desactived for cv
                            // 'data-id'       => $id,
                            // 'data-save'     => \Uri::base(false).\Config::get('server.cdn.action.save'),

                            'data-upload'   => \Uri::base(false).\Config::get('server.cdn.action.upload'),
                            'data-gallery'  => \Uri::base(false).\Config::get('server.cdn.action.gallery'),
                            'data-delete'   => \Uri::base(false).\Config::get('server.cdn.action.delete'),
                            'data-folder'   => 'cv', // should be category slug (public/uploads/cv)
                            'data-crop'     => '0:0',
                            'data-size'     => 700,
                            'data-algorythm'=> 'entropy',
                            'data-bootstrap-single' => \Config::get('app-thumb.bootstrap.single'),
                            'data-bootstrap-double' => \Config::get('app-thumb.bootstrap.double'),
                            'data-bootstrap-triple' => \Config::get('app-thumb.bootstrap.triple'),
                            'data-bootstrap-full'   => \Config::get('app-thumb.bootstrap.full'),

                            )) ?>

                    </section>

                </div>
            
            <?= $form->field('column')->set_attribute(array('class' => 'form-control selectpicker')); ?>
            <?= $form->field('user_id')->set_attribute(array('class' => 'form-control selectpicker')); ?>

        </div>


    </div>


    <!-- end parameters -->


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








