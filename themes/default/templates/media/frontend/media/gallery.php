

			<div id="<?= $key ?>" class="js-media-player imagelowloaded col-xs-12 col-sm-12 col-md-12 col-lg-12" >
				
					<?php if ($post->is_flickity === TRUE): ?>
						<!-- flickity Gallery  >>>>> -->
							<div class="carousel">
								
								<?php if ($post->image_output == 'thumb_image' || $post->image_output == 'text_image'): ?>
					    			<div class="carousel-cell carousel-cell-lazyloading" >
					        			<img id="<?= $key; ?>-img-hd" class="carousel-cell-image lazyload" data-flickity-lazyload="<?= isset($post->hd) ? $post->hd.'?'.rand() : '/assets/img/empty.jpg'; ?>" alt="<?= isset($post->meta) ? htmlentities($post->meta) : htmlentities($post->name); ?>" > 
					        		</div>
				        		<?php endif; ?>
								
								<?php if ($post->images): ?>
					        		<?php foreach ($post->images as $nth => $image): ?>
						        		<div class="carousel-cell carousel-cell-lazyloading" >
						        			<img id="<?= $key.$nth; ?>-img-hd" class="carousel-cell-image lazyload" data-id="<?= $post->id ?>" data-flickity-lazyload="<?= $image.'?'.rand(); ?>" alt="<?= isset($post->meta) ? htmlentities($post->meta) : htmlentities($image->name); ?>" > 
						        		</div>
					        		<?php endforeach; ?>
						 		<?php endif; ?>

						    </div>
						<!-- <<<<<< Carousel Gallery -->

				<?php endif; ?>
				
				<!-- CMS -->
				<?= \Theme::instance()->view('frontend/media/cms')->set('post',$post)->set('key',$key);  ?>

		    </div>
