
<?= \Form::open(array('role' => 'form')); ?>

    <p>
    <div class="group-separator">
        <div class="btn-group">            
            <a href="<?= \Router::get('admin_media_exit', array('false', 'false', 'true')); ?>" class="btn btn-default"><i class="fa fa-mail-reply"></i> <?= __('backend.back-to-category'); ?></a>
            <input type="submit" value="<?= $isUpdate == true ? __('backend.edit') : __('backend.add') ?>" class="btn btn-success" id="form_add" name="add">
        </div>
    </div>
    </p>
    <br/>
    
    <div class="row">
        <div class="col-md-6">

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
    </div>
    <br/>
    <?php if ($isUpdate): ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field('slug')->set_attribute(array('class' => 'form-control')) ?>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-md-4">
            <?= $form->field('exposition')->set_attribute(array('class' => 'form-control selectpicker')); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <?= $form->field('status')->set_attribute(array('class' => 'form-control selectpicker')); ?>
        </div>
        <div class="col-md-2">
            <?= $form->field('permission')->set_attribute(array('class' => 'form-control selectpicker')); ?>
        </div>
        
    </div>

<?= \Form::close(); ?>