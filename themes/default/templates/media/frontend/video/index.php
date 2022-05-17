<script>
    window.lazySizesConfig = window.lazySizesConfig || {};
    //only for demo in production I would use normal expand option
    lazySizesConfig.expand = 2;
</script>

<div id="articles" class="row isotope" >

	<?php foreach ($posts as $key => $post): ?>
		

		<?php if ($post->permission == 'public' || ( $post->permission == 'private' && \Auth::check() )): ?>

			<?php if ($post->status == 'published' ): ?>

				<div id="<?= $key ?>-video" class="<?= isset($post->column) ? \Config::get($post->column) : 'col-xs-6 col-sm-6 col-md-4 col-lg-3' ?> article <?= strtolower($post->albumName) ?> grid-item">
					
					<div class="thumb" 	data-id="<?= $key ?>"
										data-name="<?= htmlentities($post->name) ?>"
										data-meta="<?= str_replace(' ', ' | ', htmlentities($post->meta)) ?>"
										data-category="<?= $post->albumName ?>"
										data-bootstrap="<?= isset($post->column) ? \Config::get($post->column) : 'col-md-4 col-lg-3' ?>"
										data-column-open="<?= isset($post->column_open) ? \Config::get($post->column_open) : 'col-md-12 col-lg-9' ?>"
										data-fullscreen="<?= isset($post->fullscreen) ? $post->fullscreen : 'yes'; ?>"
					>
						<a href="/#video?id=<?= $post->idvideo ?>" >
							<?php if (!empty($post->title)): ?>
								<h4 class="title-hover" ><?= empty($post->short) ? empty($post->title) ? '' : htmlentities($post->title) : htmlentities($post->short); ?></h4>
							<?php endif; ?>
							<img id="<?= $post->slug; ?>-img-thumb" class="lazyload video-thumbnail img-responsive" data-src="<?= $post->cover ? $post->cover.'?'.rand() : '/assets/img/empty.jpg'; ?>" alt="<?= isset($post->meta) ? htmlentities($post->meta) : htmlentities($post->name); ?>">
						</a>
					</div>
					
					<div class="player">
						
						<div class="ux-plyr" >
							<a class="gallery-close" href="#" title="Close Article"></a>
						</div>
							
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

							<?php if (!empty($post->name)): ?>
								<h4 class="title-article"><?= htmlentities($post->name) ?></h4>
							<?php endif; ?>

							<div id="<?= $key ?>" class="js-media-player" >

						        <div data-type="<?= $post->enginevideo ?>" data-video-id="<?= $post->idvideo; ?>"></div>  

						    </div>
						
							<?php if (!empty($post->summary)): ?>
							    <div class="summary fr-view">

						    		<p><?= $post->summary ?></p>

						    	</div>
					    	<?php endif; ?>
					    
					    </div>
						
				    </div>

				</div>

			<?php endif; ?>

		<?php endif; ?>

	<?php endforeach; ?>

</div>
