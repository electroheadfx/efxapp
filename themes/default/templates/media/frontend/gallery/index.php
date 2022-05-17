<script>
    window.lazySizesConfig = window.lazySizesConfig || {};
    //only for demo in production I would use normal expand option
    lazySizesConfig.expand = 2;
</script>

<div id="articles" class="row isotope" >

	<?php foreach ($posts as $key => $post): ?>

		<?php if ($post->permission == 'public' || ( $post->permission == 'private' && \Auth::check() )): ?>

			<?php if ( $post->status == 'published' ): ?>

				<?php if ( ( isset($post->hd) && $post->module == "gallery" ) || ( $post->module == "video" ) ): ?>

					<div id="<?= $key.'-article'; ?>" class="<?= isset($post->column) ? \Config::get($post->column) : 'col-xs-6 col-sm-6 col-md-4 col-lg-3' ?> article <?= strtolower($post->albumName) ?> grid-item <?= $post->featured == 'yes' ? 'favorite' : ''; ?> <?= !empty($post->summary) ? 'cms' : '' ?>" >
						
						<div class="thumb-container">
						
							<!-- for video : data-id="$key"  - for gallery : data-target="$key" -->

							<div class="thumb <?= $post->featured == "yes" ? "featured" : ""; ?>" data-srchd="<?= isset($post->hd) ? $post->hd.'?'.rand() : '/assets/img/empty.jpg'; ?>"
								data-module="<?= $post->module ?>"
								data-id="<?= $key ?>"
								data-target="<?= $key ?>"
								data-fullscreen="<?= isset($post->fullscreen) ? $post->fullscreen : 'yes'; ?>"
								data-name="<?= htmlentities($post->name) ?>"
								data-slug="<?= $post->slug ?>"

								data-meta="<?= str_replace(' ', ' | ', $post->meta) ?>"
								data-category="<?= implode(' ', \Arr::pluck( \Model_Category::query()->related('posts')->where('posts.id', $post->id)->get(), 'slug')); ?>"
								data-bootstrap="col-xs-6 col-sm-6 <?= isset($post->column) ? \Config::get($post->column) : 'col-md-4 col-lg-3' ?>"
								data-column-open="<?= isset($post->column_open) ? \Config::get($post->column_open) : 'col-md-12 col-lg-9' ?>"
								
								data-title_align="<?= $post->title_align ?>"
								data-toggle="tooltip" data-placement="auto top"
								
								<?php if ($post->module == "gallery"): ?>
									data-width="<?= isset($post->width) ? $post->width : '' ?>"
									data-height="<?= isset($post->height) ? $post->height : '' ?>"
									data-ratio="<?= isset($post->ratio) ? $post->ratio : '' ?>"
									data-imageid="<?= $post->imageid ?>"
									data-flickity_nav="<?= $post->flickity_nav == "yes" ? true : false; ?>"
									data-flickity_play="<?= $post->flickity_play == "yes" ? true : false; ?>"
									data-flickity_delay="<?= $post->flickity_delay ?>"
	    				    	<?php endif; ?>

								>
								
								<!-- gallery thumb -->
								<?php if ($post->module == "gallery"): ?>

									<a href="/#gallery?id=<?= $post->imageid ?>">
		    			    			<?php if ( (!empty($post->summary) && $post->image_output == 'text') || ( !empty($post->summary) && $post->image_output == 'text_image' ) ): ?>
		    							    <div class="summary-text fr-view" >
		    				    				<?php if (!empty($post->title)): ?>
		    				    					<h3 class="title-hover-text" ><?= htmlentities($post->title); ?></h3>
		    				    	    		<?php endif; ?>
		    						    		<p><?= $post->summary ?></p>
		    						    	</div>
		    			    	    	<?php else: ?>
											<img id="<?= $key; ?>-img-thumb" class="lazyload thumbnail wall img-responsive" data-src="<?= $post->cover ? $post->cover : '/assets/img/empty.jpg'; ?>" alt="<?= isset($post->meta) ? htmlentities($post->meta) : htmlentities($post->name); ?>">
		    			    	    	<?php endif; ?>
									</a>

	    				    	<?php endif; ?>
								
								<!-- video thumb -->
								<?php if ($post->module == "video"): ?>

									<a href="/#video?id=<?= $post->idvideo ?>" >
										<?php if (!empty($post->title)): ?>
											<h4 class="title-hover" ><?= empty($post->short) ? empty($post->title) ? '' : htmlentities($post->title) : htmlentities($post->short); ?></h4>
										<?php endif; ?>
										<img id="<?= $post->slug; ?>-img-thumb" class="lazyload video-thumbnail img-responsive" data-src="<?= $post->cover ? $post->cover.'?'.rand() : '/assets/img/empty.jpg'; ?>" alt="<?= isset($post->meta) ? htmlentities($post->meta) : htmlentities($post->name); ?>">
									</a>

	    				    	<?php endif; ?>

							</div>

							<div class="summary_preview">
				    			<?php if (!empty($post->summary) && $post->image_output != 'text' && $post->image_output != 'text_image' ): ?>
								    <div class="summary fr-view" >
					    				<?php if (!empty($post->title)): ?>
					    					<h3 class="title-hover" ><?= htmlentities($post->title); ?></h3>
					    	    		<?php endif; ?>
							    		<p><?= $post->summary ?></p>
							    	</div>
				    	    	<?php endif; ?>
			    	    	</div>

						</div>

						<div id="<?= $key.'-player' ?>" class="player">

							<div class="ux-plyr" >
								<a class="gallery-close" href="#" title="<?= __('application.close_article') ?>" data-toggle="tooltip-close" ></a>
							</div>

							<div class="preview">
								<?php if ($post->image_output == 'thumb_image' || $post->image_output == 'text_image' ): ?>
									<img class="img-preview img-responsive" src="<?= $post->cover ? $post->cover : '/assets/img/empty.jpg'; ?>" >
								<?php else: ?>
									<?php if ($post->images): ?>
										<?php foreach ($post->images as $image): ?>
											<img class="img-preview img-responsive" src="<?= $image ? $image : '/assets/img/empty.jpg'; ?>" >
											<?php break; ?>
										<?php endforeach; ?>
									<?php endif; ?>
								<?php endif; ?>
							</div>

							<?php if ($post->module == "gallery"): ?>

								<div id="<?= $key ?>" class="js-media-player imagelowloaded col-xs-12 col-sm-12 col-md-12 col-lg-12" >

									<div class="carousel">
										
										<?php if ($post->image_output == 'thumb_image' || $post->image_output == 'text_image'): ?>
							    			<div class="carousel-cell" >
							        			<img id="<?= $key; ?>-img-hd" class="carousel-cell-image" data-flickity-lazyload="<?= isset($post->hd) ? $post->hd.'?'.rand() : '/assets/img/empty.jpg'; ?>" alt="<?= isset($post->meta) ? htmlentities($post->meta) : htmlentities($post->name); ?>" > 
							        		</div>
						        		<?php endif; ?>
										
										<?php if ($post->images): ?>
							        		<?php foreach ($post->images as $nth => $image): ?>
								        		<div class="carousel-cell" >
								        			<img id="<?= $key.$nth; ?>-img-hd" class="carousel-cell-image" data-flickity-lazyload="<?= $image.'?'.rand(); ?>" alt="<?= isset($post->meta) ? htmlentities($post->meta) : htmlentities($image->name); ?>" > 
								        		</div>
							        		<?php endforeach; ?>
								 		<?php endif; ?>

								    </div>

									<?php if (!empty($post->content || !empty($post->name))): ?>
										
										<?php if ($post->title_expander == "expand"): ?>

							    				<h1 class="title-article-expose" style="text-align: <?= $post->title_align ?>;" ><?= htmlentities($post->name) ?></h1>

										<?php endif; ?>

									    <div class="content fr-view" data-content_expander="<?= $post->content_expander == "expand" ? true : false; ?>"  >
							    			<?php if (!empty($post->name) && $post->title_expander == "collapse" ): ?>
							    				<h1 class="title-article-expose" style="text-align: <?= $post->title_align ?>;" ><?= htmlentities($post->name) ?></h1>
							    	    	<?php endif; ?>
							    			<?php if (!empty($post->content)): ?>
								    			<p><?= $post->content ?></p>
							    	    	<?php endif; ?>
								    	</div>

							    	<?php endif; ?>

							    </div>

						    <?php endif; ?>

						    <?php if ($post->module == "video"): ?>

					    			<div class="js-media-player imagelowloaded col-xs-12 col-sm-12 col-md-12 col-lg-12">

					    				<?php if (!empty($post->name)): ?>
					    					<h4 class="title-article"><?= htmlentities($post->name) ?></h4>
					    				<?php endif; ?>

					    				<div id="<?= $key ?>" class="js-media-plyr" >

					    			        <div data-type="<?= $post->enginevideo ?>" data-video-id="<?= $post->idvideo; ?>"></div>  

					    			    </div>
					    			
					    				<?php if (!empty($post->summary)): ?>
					    				    <div class="summary fr-view">

					    			    		<p><?= $post->summary ?></p>

					    			    	</div>
					    		    	<?php endif; ?>
					    		    
					    		    </div>
								
						    <?php endif; ?>

					    </div>

					</div>

				<?php endif; ?>

			<?php endif; ?>
		
		<?php endif; ?>

	<?php endforeach; ?>

</div>
