<?php // echo \Theme::instance()->view('backend/template/block/nav');  ?>

<?php if($is_post): ?>

    <?= __('backend.post.empty'); ?>

<?php else: ?>
    
    <?= \Theme::instance()->view('backend/template/block/list_controls'); ?>

    <?= \Theme::instance()->view('backend/template/block/list_menus'); ?>
	
	<div id="admin-list-preview" class="row" >

		<script>
		    window.lazySizesConfig = window.lazySizesConfig || {};
		    //only for demo in production I would use normal expand option
		    lazySizesConfig.expand = 400;
		</script>

		<?php echo $body; ?>

	</div>

<?php endif; ?>