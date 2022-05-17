
	<ul class="nav navbar-nav"> 

	  <?php foreach ( $navigations as $menu): ?>
		
		<?php if ( $menu['render'] ): ?>
			<?php if ($menu['modules'] == 'url'): ?>
		    	<li>
		    		<a class="<?= $menu['css'] ?>" href="<?= Uri::base(false).$menu['route']; ?>" 

		    			data-slicePoint="<?= $menu['slicePoint'] ?>" 
		    			target="<?= $menu['target'] ?>" 
		    			data-hover="<?= $menu['hover'] ?>"
		    			data-scrollto="<?= $menu['scrollto'] ?>" 
		    			data-scrollpausetime="<?= $menu['scrollpausetime'] ?>" 
		    			data-scrolltofeatured="<?= $menu['scrolltofeatured'] ?>" 
		    			data-mediaautoclose="<?= $menu['mediaautoclose'] ?>" 

		    		>
		    		 <i class="<?= $menu['icon'] ?>" aria-hidden="true"></i> <?= $menu['name'] ?></a>
		    	</li>

		    <?php else: ?>
		    	<li>
		    		<a class="<?= $menu['css'] ?>" href="<?= Uri::base(false).$menu['route']; ?>" 

		    			data-slicePoint="<?= $menu['slicePoint'] ?>" 
		    			target="<?= $menu['target'] ?>" 
		    			data-hover="<?= $menu['hover'] ?>"
		    			data-scrollto="<?= $menu['scrollto'] ?>" 
		    			data-scrollpausetime="<?= $menu['scrollpausetime'] ?>" 
		    			data-scrolltofeatured="<?= $menu['scrolltofeatured'] ?>" 
		    			data-mediaautoclose="<?= $menu['mediaautoclose'] ?>"

		    		>
		    		 <i class="<?= $menu['icon'] ?>" aria-hidden="true"></i> <?= $menu['name'] ?></a>
		    	</li>

			<?php endif; ?>
		<?php endif; ?>

	  <?php endforeach; ?>

	</ul>