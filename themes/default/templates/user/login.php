

<?= \Form::open(array('class' => 'form-signin')); ?>

	<h4 class="form-signin-heading"><?= __('module.user.default.login.please-signin'); ?></h4>
	<div class="input-group margin-bottom-sm">
		<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
		<input class="form-control" type="text" name="username" placeholder="<?= __('module.user.model.user.username'); ?>" autofocus="">
	</div>
	<div class="input-group margin-bottom-sm">
		<span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
		<input class="form-control" type="password" name="password" placeholder="<?= __('module.user.model.user.password'); ?>">
	</div>
	
	<button class="btn btn-primary" type="submit"><?= __('module.user.default.login.sign-in'); ?></button>

<?= \Form::close(); ?>
