
<div class="row">
	<div class="col-sm-8 col-sm-offset-2">
	    <div class="well" style="margin-top: 35px;">
	    <h1 class="sendme" ><?= __('application.sendmail.send_a_message') ?></h1>

	    <?= \Form::open(array(
	    	'id'=>'contactForm', 'class'=>'shake',
	    	'data-toggle'=>'validator',
	    	'data-properly'=>  __('application.sendmail.properly'),
	    	'data-submitted'=>  __('application.sendmail.submitted'),
	   	)); ?>

	        <div class="row">
	            <div class="form-group col-sm-6">
	                <label for="name" class="h5"><?= __('application.sendmail.name') ?></label>
	                <input type="text" class="form-control" name="name" id="for_name" placeholder="<?= __('application.sendmail.enter_name') ?>" required data-error="<?= __('application.sendmail.new_error_message') ?>">
	                <div class="help-block with-errors"></div>
	            </div>
	            <div class="form-group col-sm-6">
	                <label for="email" class="h5"><?= __('application.sendmail.email') ?></label>
	                <input type="email" class="form-control" name="email" id="for_email" placeholder="<?= __('application.sendmail.enter_email') ?>" required>
	                <div class="help-block with-errors"></div>
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="message" class="h5 "><?= __('application.sendmail.message') ?></label>
	            <textarea name="message" id="for_message" class="form-control" rows="5" placeholder="<?= __('application.sendmail.enter_your_message') ?>" required></textarea>
	            <div class="help-block with-errors"></div>
	        </div>
	        <button type="submit" name="add" value="<?= __('application.sendmail.submit') ?>" id="form-submit" class="btn btn-success pull-right "><?= __('application.sendmail.submit') ?></button>
	        <div id="msgSubmit" class="text-center hidden"></div>
	        <div class="clearfix"></div>

	    <?= \Form::close(); ?>

	    </div>
	</div>
</div>