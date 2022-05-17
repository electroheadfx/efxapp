
<div id="articles" class="row isotope" >

	<?php foreach ($posts as $key => $post): ?>
			
		<?php if ($post->permission == 'public' || ( $post->permission == 'private' && \Auth::check() )): ?>

			<?php if ($post->status == 'published' ): ?>


				<div id="<?= $key.'-article'; ?>" class="<?= isset($post->column) ? \Config::get($post->column) : 'col-xs-6 col-sm-6 col-md-4 col-lg-3' ?> article <?= strtolower($post->albumName); ?> grid-item" data-bootstrap="col-xs-6 col-sm-6 <?= isset($post->column) ? \Config::get($post->column) : 'col-md-4 col-lg-3' ?>" >
					
					<div class="thumb" data-srchd="<?= isset($post->hd) ? $post->hd.'?'.rand() : '/assets/img/empty.jpg'; ?>" 
						data-target="<?= $key ?>" 
						data-slug="<?= $post->slug ?>" 
						data-width="<?= isset($post->width) ? $post->width : '' ?>" 
						data-height="<?= isset($post->height) ? $post->height : '' ?>" 
						data-ratio="<?= isset($post->ratio) ? $post->ratio : '' ?>" 
						data-sktechid="<?= $post->id ?>" 
						data-3d="<?= $post->b3d ?>"
						data-name="<?= $post->name ?>"
						data-meta="<?= str_replace(' ', ' | ', $post->meta) ?>"
						data-category="<?= $post->albumName ?>"
					>

						<a href="/gallery?id=<?= $post->id ?>">
							<h4 class="title-hover" ><?= $post->title; ?></h4>
							<img id="<?= $key; ?>-img-thumb" class="lazyload thumbnail img-responsive" src="<?= $post->cover ? $post->cover : '/assets/img/empty.jpg'; ?>" alt="<?= isset($post->meta) ? $post->meta : $post->name; ?>">
						</a>
					</div>
					
					<div id="<?= $key.'-player' ?>" class="player sketch" >

						<div class="ux-plyr" >
							<a class="gallery-close" href="#" title="Close Article"></a>
						</div>
						
						<?php if (!empty($post->name)): ?>
							<h4 class="title-article"><?= $post->name ?></h4>
						<?php endif; ?>
											
						<div id="<?= $key ?>" class="js-3d" >

					        <iframe class="sketchframe" src="" id="sketch<?= $post->id ?>" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" width="100%" height="550" data-sketchloaded="no" ></iframe> 

					    </div>
						
						<?php if (!empty($post->summary)): ?>
							<div class="info-bottom">
								
							    <div class="summary fr-view">
						    		<p><?= $post->summary ?></p>
						    	</div>
							
							</div>
						<?php endif; ?>

				    </div>

				</div>


			<?php endif; ?>
		
		<?php endif; ?>

	<?php endforeach; ?>

</div>
