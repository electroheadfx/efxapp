

<br/>

<?= \Form::open(); ?>

	<p>
	    <div class="group-separator">
	        <div class="btn-group">
	            <a href="<?= \Router::get('admin'); ?>" type="button" class="btn btn-default" ><span class="fa fa-dashboard"></span> <?= __('application.back-to-dashboard'); ?></a>
	            <input type="submit" value="<?= __('application.edit') ?>" class="btn btn-warning" id="form_add" name="add">
	        </div>
	    </div>
	</p>

<br/>

	<!-- Nav tabs 1 -->
	<ul class="nav nav-tabs" role="tablist" id="tabside" >

		<?php foreach($application as $key => $value): ?>

			<li class="<?= $key == array_keys($application)[0] ? 'active' : '' ?>">

                <a href="#<?= $key ?>" role="tab" data-toggle="tab">
                    <span><?= $value['LANG'] ?></span>
                </a>

            </li>

		<?php endforeach; ?>

	</ul>
	
	<!-- Tab panes 1 -->
	<div id="tabsideContent" class="tab-content">

		<?php foreach($application as $key => $value): ?>


			<div class="tab-pane fade <?= $key == array_keys($application)[0] ? 'active in' : '' ?>" id="<?= $key ?>">
				
				<!-- Nav tabs 2 -->
				<ul class="nav nav-tabs" role="tablist" id="tabtheme" >
					<?php foreach($value['CONTENT'] as $name => $data): ?>

						<li class="<?= $name == array_keys($value['CONTENT'])[0] ? 'active' : '' ?>">

			                <a href="#<?= $key.'-'.$name ?>" role="tab" data-toggle="tab">
			                    <span><?= $data['LANG'] ?></span>
			                </a>

			            </li>
					<?php endforeach; ?>
		        </ul>
				
				<!-- Tab panes 2 -->
				<div id="tabthemeContent" class="tab-content">

		        	<?php if ($value['FOLDER']): ?>

			             <?php foreach($value['CONTENT'] as $name => $data): ?>
							
							<div class="tab-pane fade <?= $name == array_keys($value['CONTENT'])[0] ? 'active in' : '' ?>" id="<?= $key.'-'.$name ?>">
							
								<?php if ($data['FOLDER']): ?>

									<!-- Tab 2 -->
									<?php foreach ($data['CONTENT'] as $subname => $subdata): ?>
										
										<p>
							                <div class="group-control">
							                	<label class="control-label label label-default" for="<?= $subdata['POST'] ?>"><?= $subdata['LANG'] ?></label>
							                	
							                	<?php if (strlen($subdata['DATA']) < 200) {
							                				echo \Form::input($subdata['POST'], $subdata['DATA'], array('class' => 'form-control'));
							                			} else {
							                				echo \Form::textarea($subdata['POST'], $subdata['DATA'], array('rows' => 3, 'cols' => 8, 'class' => 'form-control'));
							                			}
							                	?>
							                </div>
						                </p>

									<?php endforeach; ?>

								<?php else: ?>

									<p>
						                <div class="group-control">
						                	<h4><?= $data['LANG'] ?></h4>
						                	<?php echo \Form::input($data['POST'], $data['DATA'], array('class' => 'form-control')); ?>
						                </div>
					                </p>


								<?php endif; ?>

							</div> <!-- end tab-pane -->

			             <?php endforeach; ?>


			        <?php else: ?>

						<div><p>No data</p></div>

			        <?php endif; ?>

				</div> <!-- end tabthemeContent -->

	    	</div> <!-- end tab-pane -->
		
		<?php endforeach; ?>

	</div> <!-- end tabsideContent -->
		
<?= \Form::close(); ?>

<br/><br/>

