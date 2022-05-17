
<?php foreach ($modules as $key => $module): ?>

	<h3><?= __('module.'.$key.'.backend.'.$key) != '' ? __('module.'.$key.'.backend.'.$key) : 'module.'.$key.'.backend.'.$key; ?></h3>

	<div class="row">
		
		<?php foreach ($module as $tool): ?>

			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">

				<div class="panel panel-<?= $tool['style']; ?>">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-<?= $tool['titleicon']; ?> fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<p class="announcement-heading"><?= $tool['count']; ?></p>
								<p class="announcement-text"><?= $tool['title']; ?></p>
							</div>
						</div>
					</div>
					<a class="dashboard-link" href="<?= \Router::get($tool['route']).$tool['menu']; ?>">
						<div class="panel-footer announcement-bottom">
							<div class="row">
								<div class="col-xs-10 panel-desc">
									<?= $tool['desc']; ?>
								</div>
								<div class="col-xs-2 text-right">
									<i class="fa fa-arrow-circle-right"></i>
								</div>
							</div>
						</div>
					</a>
				</div>
				<!-- end panel -->
			</div>

		<?php endforeach; ?>

	</div>

<?php endforeach; ?>