
<h1 style="color:white;" >Curriculum Vitae</h1>
<hr/>
<div id="articles" class="isotope" >

	<?php foreach ($posts as $key => $post): ?>

		<div class="fr-view col-xs-12 col-sm-6 <?= isset($post->column) ? \Config::get($post->column) : 'col-md-4 col-lg-3' ?> article grid-item" data-bootstrap="col-xs-12 col-sm-6 <?= isset($post->column) ? \Config::get($post->column) : 'col-md-4 col-lg-3' ?>" >

			<h4 class="title-hover" ><?= $post->name ?></h4>

	    	<p><?= $post->summary ?></p>			

		</div>

	<?php endforeach; ?>

</div>
