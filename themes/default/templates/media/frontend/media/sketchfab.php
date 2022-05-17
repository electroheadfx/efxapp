
    			<div class="js-media-player imagelowloaded col-xs-12 col-sm-12 col-md-12 col-lg-12">
					
						<div id="<?= $key ?>" class="js-sketchfab" >

					        <iframe class="sketchframe" src="" id="sketch<?= $post->id ?>" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" width="100%" height="100%" data-sketchloaded="no" ></iframe> 

					    </div>
    			
					<!-- CMS -->
					<?= \Theme::instance()->view('frontend/media/cms')->set('post',$post)->set('key',$key);  ?>

    		    </div>