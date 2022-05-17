		<div class="custom-mentions">

            <?php if ( \Config::get('application.setup.footer') !== NULL ): ?>
            	<?php foreach (\Config::get('application.setup.footer') as $footer): ?>
					
					<?php if (!empty($footer)): ?>
            			<?= $footer ?><br/>
        			<?php endif; ?>
				
				<?php endforeach; ?>
        	<?php endif; ?>

        </div>            	

    	<div class="mentions">
          	
	        <div class="efx-mentions">

	        	<?= \Config::get('application.seo.frontend.copyright') ?>

	        </div>

          	<div class="copy">
            	Development/Design: <a href="http://efxdesign.fr">Laurent Marques</a><br/><br/>
			</div>

        </div>