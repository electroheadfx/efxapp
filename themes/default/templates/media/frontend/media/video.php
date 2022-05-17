
    			<div class="js-media-player imagelowloaded col-xs-12 col-sm-12 col-md-12 col-lg-12">
					
					<!-- Video -->
	    				<div id="plyr<?= $key ?>" class="js-media-plyr" >

	    			        <!-- <div data-type="<?php // echo $post->enginevideo ?>" data-video-id="<?php // echo $post->idvideo; ?>"></div>   -->
	    			        <div id="plyr-instance-<?= $key ?>" data-plyr-provider="<?= $post->enginevideo ?>" data-plyr-embed-id="<?= $post->idvideo; ?>"></div>

	    			    </div>
					<!-- end Video -->
    			
					<!-- CMS -->
					<?= \Theme::instance()->view('frontend/media/cms')->set('post',$post)->set('key',$key);  ?>

    		    </div>