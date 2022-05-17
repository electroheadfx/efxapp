<script>
    window.lazySizesConfig = window.lazySizesConfig || {};
    //only for demo in production I would use normal expand option
    lazySizesConfig.expand = 400;
</script>

<div id="articles" class="row isotope" <?= !empty($dataproduct) ? 'data-product="'.$dataproduct.'"' : ''; ?> >

	<?php foreach ($posts as $post): ?>
		<?php $key = $post->id; ?>
		<?php if ($post->permission == 'public' || ( $post->permission == 'private' && \Auth::check() )): ?>

			<?php if ( $post->status == 'published' ): ?>

				<?php // if ( ( isset($post->hd) && $post->module == "gallery" ) || ( $post->module == "video" ) ): ?>

					<div id="<?= $key.'-article'; ?>" class="<?= isset($post->column) ? \Config::get($post->column) : 'col-xs-6 col-sm-6 col-md-4 col-lg-3' ?> article <?= strtolower($post->albumName) ?> grid-item <?= $post->featured == 'yes' ? 'favorite' : ''; ?> <?= (!empty($post->summary) && $post->summary_switch ) || ( $post->title_expander == "expand" && !empty($post->hover) ) ? 'cms' : '' ?>" >

						<div class="thumb-container" style="<?php
							if ($post->summary_switch) {
								if ( $post->postbgselect != 'default') {
							        if ($post->postbgselectcolor) {
							        	if ($post->postborderselect == 'color')
							            	echo 'background-color: #'.$post->postbgdata.';';
							        	else
							            	echo 'background-color: '.$post->postbgdata.';';
							        }
							        if ( $post->postbgselect == 'textured' ) {
							            echo 'background: url(/assets/img/bg.png);';
							        }
							        if ( $post->postbgselect == 'transparent' ) {
							            echo 'background-color: transparent;';
							        }
							    }
							    if ($post->postborder) {
							    	if ($post->postborderselectcolor) {
							    		if ($post->postborderselect == 'color')
							        		echo 'border: 1px solid #'.$post->postborderdata.';';
							    		else
							        		echo 'border: 1px solid '.$post->postborderdata.';';
							        } else {
							        	echo 'border: 1px solid #444;';
							        }
							    }
							}
						?>">
						
							<!-- Isotope Wall : href+thumb+summary >>>>>> -->
								<div class="thumb <?= $post->featured == "yes" ? "featured" : ""; ?> <?= $post->locked == 'yes' ? 'locked' : ''; ?>" data-srchd="<?= isset($post->hd) ? $post->hd.'?'.rand() : '/assets/img/empty.jpg'; ?>"
									data-module="<?= $post->module ?>"
									data-id="<?= $key ?>"
									data-target="<?= $key ?>"
									data-fullscreen="<?= isset($post->fullscreen) ? $post->fullscreen : 'yes'; ?>"
									data-name="<?= \Security::strip_tags($post->name) ?>"
									data-slug="<?= $post->slug ?>"
									data-locked="<?= $post->locked ?>"
									data-date="<?= date('d/m/Y', $post->created_at); ?>"
									data-meta="<?= $post->meta ?>"
									data-category="<?= implode(' ', \Arr::pluck( \Model_Category::query()->related('posts')->where('posts.id', $post->id)->get(), 'slug')); ?>"
									data-bootstrap="col-xs-6 col-sm-6 <?= isset($post->column) ? \Config::get($post->column) : 'col-md-4 col-lg-3' ?>"
									data-column-open="<?= isset($post->column_open) ? \Config::get($post->column_open) : 'col-md-12 col-lg-9' ?>"
									
		    				    	<?php if ( isset($show_tooltip) ): ?>
			    				    	<?php if ( ! $show_tooltip ): ?>
											data-toggle="tooltip" data-placement="auto top" data-container="body"
			    				    	<?php endif; ?>
		    				    	<?php endif; ?>
									
									<?php if ($post->module == "gallery"): ?>
										
										data-width="<?= isset($post->width) ? $post->width : '' ?>"
										data-height="<?= isset($post->height) ? $post->height : '' ?>"

										data-gallery-width="<?= isset($post->gallery) ? $post->gallery->width : '' ?>"
										data-gallery-height="<?= isset($post->gallery) ? $post->gallery->height : '' ?>"

										data-ratio="<?= isset($post->ratio) ? $post->ratio : '' ?>"
										data-imageid="<?= isset($post->imageid) ? $post->imageid : '' ?>"
										data-flickity_nav="<?= $post->flickity_nav == "yes" ? true : false; ?>"
										data-flickity_play="<?= $post->flickity_play == "yes" ? true : false; ?>"
										data-flickity_delay="<?= $post->flickity_delay ?>"
		    				    	<?php endif; ?>
									<?php if ($post->module == "sketchfab"): ?>
										data-sktechid="<?= $post->id ?>" 
										data-sketchfab="<?= $post->sketchfab ?>"
		    				    	<?php endif; ?>
									>

								<!-- href click -->
									<?php if ( \Uri::segment(1) == 'media' ): ?>
										<!-- <a href="<?php // echo \Router::get('admin_media_'.$post->module.'_edit', array('id' => $post->id)); ?>"> -->
										<a href="<?= \Router::get('cms_product', array('id' => $post->slug)); ?>">
									<?php else: ?>
										<a href="<?= $post->locked == 'no' ? \Router::get('cms_product', array('id' => $post->slug)) : '#' ?>">
									<?php endif; ?>

		    			    			<!-- CMS text summary+title preview instead thumb -->
		    			    			<?php if ( (!empty($post->summary) && $post->image_output == 'text'  && $post->summary_switch ) || ( !empty($post->summary) && $post->image_output == 'text_image' && $post->summary_switch ) ): ?>
		    							    <div class="summary-text fr-view" style="<?= $post->summary_caesura == 'off' ? '-webkit-hyphens: none; -moz-hyphens: none; -ms-hyphens: none; -o-hyphens: none; hyphens: none;' : ''; ?>" >
		    				    				<?php if (!empty($post->hover) ) echo html_entity_decode($post->title); ?>
		    						    		<p><?= html_entity_decode($post->summary) ?></p>
		    						    	</div>

		    			    			<!-- Thumb preview -->
		    			    	    	<?php else: ?>
		    			    	    		<?php if ( $post->title_expander != "expand" && empty($post->summary) ): ?>
		    			    	    			<?php if ( !empty($post->hover) ): ?>
		    			    	    				<h4 class="title-hover" ><?= empty($post->short) ? empty($post->hover) ? '' : \Security::strip_tags($post->hover) : \Security::strip_tags($post->short); ?></h4>
		    			    	    			<?php endif; ?>
		    			    	    		<?php endif; ?>
		    			    	    		<?php if ( isset($media_ico) ): ?>
		    			    	    		<?php if ( ! $icon_media ): ?>
			    			    	    		<span class="pull-right media-ico media-preview"><i class="fa fa-<?= $media_ico[$post->module]['titleicon']; ?> fa-1x fa-module"></i></span>
		    			    	    		<?php endif; ?>
		    			    	    		<?php endif; ?>
		    			    	    		<div class="thumb-lazyloading">
												<img id="<?= $key; ?>-img-thumb" class="thumbnail wall img-responsive" data-src="<?= $post->cover ? $post->cover : '/assets/img/empty.jpg'; ?>" alt="<?= isset($post->meta) ? htmlentities($post->meta) : \Security::strip_tags($post->name); ?>">
											</div>
		    			    	    	<?php endif; ?>
									</a>

								</div>

								<!-- name, id, meta, featured, status -->
								<?= \Theme::instance()->view('frontend/media/media_meta',
								    [   'status'        => $post->status,
								        'date'          => date('d/m/Y', $post->created_at),
								        'category_slug' => $post->slug_categories,
								        'featured'      => $post->featured,
								        'permission'    => $post->permission,
								        'name'          => \Security::strip_tags($post->name),
								        'is_amorething' => $post->image_output == "text" ? true : false,
								        'exposition'    => $post->module,
								        'meta'          => isset($post->meta) ? htmlentities($post->meta) : '',
								        'id'            => $post->id,
								    ]);
								?>

							<!-- <<<< End Isotope Wall -->
							
							<!-- Title + Summary >>>>>> -->

								<?php if ($post->summary_switch): ?>
									<?php if ( $post->title_expander == "expand" || ( !empty($post->summary) && $post->summary_switch ) ): ?>

										<div class="summary_preview">
											<?php if ( $post->title_expander == "expand" && !empty($post->hover) && $post->image_output != 'text' ): ?>
												<?= html_entity_decode($post->title); ?>
											<?php endif; ?>

							    			<?php if ( !empty($post->summary) && $post->summary_switch && $post->image_output != 'text' && $post->image_output != 'text_image' ): ?>
											    <div data-close-summary="Fermer l'introduction" data-open-summary="Ouvrir l'introduction" class="summary fr-view <?= $post->summary_expander_ui == 'on' ? 'expander expander-summary' : ''; ?>" style="<?= $post->summary_caesura == 'off' ? '-webkit-hyphens: none; -moz-hyphens: none; -ms-hyphens: none; -o-hyphens: none; hyphens: none;' : ''; ?>" data-status_expander="<?= $post->summary_expander == "collapse" ? false : true; ?>" >
								    				<?php if (!empty($post->name) && $post->title_expander == "collapse" ) echo html_entity_decode($post->title); ?>
										    		<p><?= html_entity_decode($post->summary); ?></p>
										    	</div>
							    	    	<?php endif; ?>
							    	    	
						    	    	</div>
							    	
							    	<?php endif; ?>
						    	<?php endif; ?>

			    	    	<!-- <<<< End Title + Summary -->

						</div>
							
						<!-- Player UI -->
						<div id="<?= $key.'-player' ?>" class="player <?= $post->is_flickity === TRUE ? 'loaded' : '' ?>" style="<?php
							if ( $post->contentbgselect != 'default') {
						        if ($post->contentbgselectcolor) {
					        		if ($post->contentborderselect == 'color')
					        	    	echo 'background-color: #'.$post->contentbgdata.';';
					        		else
					        	    	echo 'background-color: '.$post->contentbgdata.';';
						        }
						        if ( $post->contentbgselect == 'textured' ) {
						            echo 'background: url(/assets/img/bg.png);';
						        }
						        if ( $post->contentbgselect == 'transparent' ) {
						            echo 'background-color: transparent;';
						        }
						    }
						    if ($post->contentborder) {
						    	if ($post->contentborderselectcolor) {
						    		if ($post->contentborderselect == 'color')
						        		echo 'border: 1px solid #'.$post->contentborderdata.';';
						    		else
						        		echo 'border: 1px solid '.$post->contentborderdata.';';
						        } else {
						        	echo 'border: 1px solid #444;';
						        }
						    }
						?>">

							<div class="ux-plyr" >
								<a class="gallery-close" href="#" title="<?= __('application.close_article') ?>" data-toggle="tooltip-close" data-container="body" ></a>
							</div>

							<div class="preview">
								<?php if ($post->image_output == 'thumb_image' || $post->image_output == 'text_image' ): ?>
									<img class="img-preview img-responsive lazyload" data-src="<?= $post->cover ? $post->cover : '/assets/img/empty.jpg'; ?>" >
								<?php else: ?>
									<?php if ($post->images): ?>
										<?php foreach ($post->images as $image): ?>
											<img class="img-preview img-responsive lazyload" data-src="<?= $image ? $image : '/assets/img/empty.jpg'; ?>" >
											<?php break; ?>
										<?php endforeach; ?>
									<?php endif; ?>
								<?php endif; ?>
							</div>
							
							<!-- Media context Content >>>>> -->
							<?= \Theme::instance()->view('frontend/media/'.$post->module)->set('post',$post)->set('key',$key);  ?>

					    </div>

					</div>

				<?php // endif; ?>

			<?php endif; ?>
		
		<?php endif; ?>

	<?php endforeach; ?>

</div>
