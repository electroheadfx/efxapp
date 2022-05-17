<script>
    window.lazySizesConfig = window.lazySizesConfig || {};
    //only for demo in production I would use normal expand option
    lazySizesConfig.expand = 2;
</script>

<div id="articles" class="row isotope" >

	<?php foreach ($posts as $key => $post): ?>
			
		<?php if ($post->permission == 'public' || ( $post->permission == 'private' && \Auth::check() )): ?>

			<?php if ($post->status == 'published' ): ?>

				<?php if (isset($post->hd)): ?>

				<div id="<?= $key.'-article'; ?>" class="<?= isset($post->column) ? \Config::get($post->column) : 'col-xs-6 col-sm-6 col-md-4 col-lg-3' ?> article <?= strtolower($post->albumName) ?> grid-item <?= $post->featured == 'yes' ? 'favorite' : ''; ?>" >
					
					<div class="thumb-title">
						
						<?php if (!empty($post->name)): ?>
							
							<h4 class="title-article"><?= htmlentities($post->name) ?></h4>

				    	<?php endif; ?>

					</div>

					<div class="thumb" data-srchd="<?= isset($post->hd) ? $post->hd.'?'.rand() : '/assets/img/empty.jpg'; ?>"
							data-target="<?= $key ?>"
							data-name="<?= htmlentities($post->name) ?>"
							data-slug="<?= $post->slug ?>"
							data-width="<?= isset($post->width) ? $post->width : '' ?>"
							data-height="<?= isset($post->height) ? $post->height : '' ?>"
							data-ratio="<?= isset($post->ratio) ? $post->ratio : '' ?>"
							data-imageid="<?= $post->imageid ?>"
							data-meta="<?= str_replace(' ', ' | ', $post->meta) ?>"
							data-category="<?= implode(' ', \Arr::pluck( \Model_Category::query()->related('posts')->where('posts.id', $post->id)->get(), 'slug')); ?>"
							data-bootstrap="col-xs-6 col-sm-6 <?= isset($post->column) ? \Config::get($post->column) : 'col-md-4 col-lg-3' ?>"
							data-column-open="<?= isset($post->column_open) ? \Config::get($post->column_open) : 'col-md-12 col-lg-9' ?>"
						>
						<a class="title-cms" href="/#cms?id=<?= $post->imageid ?>">
							<h4 class="title-hover" ><?= empty($post->short) ? empty($post->title) ? '' : htmlentities($post->title) : htmlentities($post->short); ?></h4>
							<img id="<?= $key; ?>-img-thumb" class="lazyload thumbnail wall img-responsive" data-src="<?= $post->cover ? $post->cover : '/assets/img/empty.jpg'; ?>" alt="<?= isset($post->meta) ? htmlentities($post->meta) : htmlentities($post->name); ?>">
						</a>

					</div>

					<div class="thumb-summary">
						
						<?php if (!empty($post->summary)): ?>

						    <div class="summary fr-view">
					    		<p><?= $post->summary ?></p>
					    	</div>

				    	<?php endif; ?>

					</div>

					<div id="<?= $key.'-player' ?>" class="player">
						
					<p>
			    	</p>

						<div class="ux-plyr" >
							<a class="gallery-close" href="#" title="Close Article"></a>
						</div>

						<div id="<?= $key ?>" class="js-media-player imagelowloaded col-xs-12 col-sm-12 col-md-12 col-lg-12" >
							
							<a class="close-article" href="#">
					        	<img id="<?= $key; ?>-img-hd" class="lazyload thumbnail img-responsive hd-cms" data-src="<?= isset($post->hd) ? $post->hd.'?'.rand() : '/assets/img/empty.jpg'; ?>" alt="<?= isset($post->meta) ? htmlentities($post->meta) : htmlentities($post->name); ?>" > 
					    	</a>
							
							<div class="cms-expanded">

								<?php if (!empty($post->name)): ?>
									<h1 class="title-article"><?= htmlentities($post->name) ?></h1>
						    	<?php endif; ?>

								<?php if (!empty($post->summary)): ?>

								    <div class="summary fr-view">
							    		<p><?= $post->summary ?></p>
							    	</div>

						    	<?php endif; ?>

								<?php if (!empty($post->content)): ?>
									<br/>
								    <div class="content fr-view">
							    		<p><?= $post->content ?></p>
							    	</div>

						    	<?php endif; ?>
					    	
							</div>

					    </div>
							
				    </div>

				</div>

			<?php endif; ?>

			<?php endif; ?>
		
		<?php endif; ?>

	<?php endforeach; ?>

</div>

