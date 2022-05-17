			<?php // if ( !empty($post->name) && !empty($post->content) && ( !empty($post->summary) && $post->summary_to_content == 'no' ) ): ?>
			<?php // if ( !empty($post->name) &&  ( $post->image_output == 'text' || ( $post->image_output == 'thumb' || count($post->images) == 0 ) ) ): ?>
				<!-- <div class="content fr-view" > -->
				
					<?php // echo html_entity_decode($post->title); ?>

				<!-- </div> -->

	    	<?php // endif; ?>

	    	<div class="summary summary-content fr-view">
		    		
		    		<?php if (!empty($post->name)) echo html_entity_decode($post->title); ?>
	    		
	    	</div>
	
			<?php if ( $post->summary_to_content == "yes" && !empty($post->summary) && $post->summary_switch ): ?>

			    <div data-close-summary="Fermer l'introduction" data-open-summary="Ouvrir l'introduction" class="summary summary-content fr-view <?= $post->summary_expander_ui == 'on' ? 'expander expander-summary' : ''; ?>" style="<?= $post->summary_caesura == 'off' ? '-webkit-hyphens: none; -moz-hyphens: none; -ms-hyphens: none; -o-hyphens: none; hyphens: none;' : ''; ?>" data-status_expander="<?= $post->summary_expander == "collapse" ? false : true; ?>"  >
		    		<p><?= html_entity_decode($post->summary) ?></p>
		    	</div>

	    	<?php endif; ?>

			<?php if ( !empty($post->content) ): ?>
				
			    <div data-close-content="Fermer l'introduction" data-open-content="Ouvrir l'introduction" class="content content-content fr-view <?= $post->content_expander_ui == 'on' ? 'expander expander-content' : ''; ?>" style="<?= $post->content_caesura == 'off' ? '-webkit-hyphens: none; -moz-hyphens: none; -ms-hyphens: none; -o-hyphens: none; hyphens: none;' : ''; ?>" data-status_expander="<?= $post->content_expander == "collapse" ? false : true; ?>"  >
	    			<?php if (!empty($post->content) && $post->content_switch ): ?>
		    			<p><?= html_entity_decode($post->content) ?></p>
	    	    	<?php endif; ?>
		    	</div>
			
	    	<?php endif; ?>
			
			<div class="share pull-right">
				<a target="_blank" title="<?= __('application.share_facebook') ?>" data-toggle="tooltip-close" data-container="body" href="<?= \Config::get('server.social.share.facebook').\Uri::base(false).'p/'.$post->slug ?>" ><i class="fa fa-facebook"></i></a>
				<a target="_blank" title="<?= __('application.share_twitter') ?>" data-toggle="tooltip-close" data-container="body" href="<?= \Config::get('server.social.share.twitter').\Uri::base(false).'p/'.$post->slug ?>" ><i class="fa fa-twitter"></i></a>
				<a target="_blank" title="<?= __('application.share_google') ?>" data-toggle="tooltip-close" data-container="body" href="<?= \Config::get('server.social.share.google').\Uri::base(false).'p/'.$post->slug ?>" ><i class="fa fa-google"></i></a>
				<a target="_blank" title="<?= __('application.share_pinterest') ?>" data-toggle="tooltip-close" data-container="body" href="<?= \Config::get('server.social.share.pinterest').\Uri::base(false).'p/'.$post->slug ?>" ><i class="fa fa-pinterest"></i></a>
			</div>