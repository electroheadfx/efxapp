<p>
    <div class="group-separator">
        <div class="btn">
            <a href="<?= \Router::get('admin'); ?>" type="button" class="btn btn-default" ><span class="fa fa-dashboard"></span> <?= __('application.back-to-dashboard'); ?></a>
        </div>
    </div>
</p>


<?php if(empty($comments)): ?>
	<?= __('backend.post.empty'); ?>
<?php else: ?>
	<div class="table-responsive">
        <table class="table table-striped table-condensed">
            <thead>
                <tr class="success">
                    <th class="round-top-left"> </th>
                    <th class="alert alert-info" ><?= __('model.post.category'); ?></th>
                    <th class="alert alert-info" ><?= __('model.comment.username'); ?></th>
                    <th class="alert alert-info" ><?= __('model.comment.mail'); ?></th>
                    <th class="alert alert-info" ><?= __('model.publication-date'); ?></th>
                    <th class="round-top-right" > </th>
                </tr>
            </thead>
            <tbody>
            	<?php foreach($comments as $comment): ?>

                    <?php 
                            if ($comment->published == 'on') {
                                $view_publish = 'success';
                                $chain_publish = 'chain';
                            } else {
                                $view_publish = 'warning';
                                $chain_publish = 'chain-broken';

                            }
                    ?>

    	            <tr>
                        <!-- published -->
                        <td class="icon-state attribute">
                            <a href="<?= \Router::get('admin_'.$moduleName.'comment_attribute', array($comment->id,'published',$comment->published)) ?>">
                                <?= \Theme::instance()->view('backend/template/block/icon-fa', array('fa' => $chain_publish, 'title' => __('model.comment.published'), 'value' => __('model.comment.attribute.published.'.$comment->published) )); ?>
                            </a>
                        </td>
                        
                        <!-- name -->
                        <td><?= $comment->post->category->slug; ?></td>

                        <!-- name -->
                        <td><?= $comment->username; ?></td>

                        <!-- comment -->
                        <td><?= $comment->mail; ?></td>

                        <!-- date -->
                        <td><?= date('d/m/Y', $comment->created_at); // H:i:s = heure ?></td>

                        <!-- action -->
    	                <td>
        	               <div class="btn-toolbar">
                                <div class="btn-group" >
                                    <?= \Html::anchor(\Router::get('admin_'.$moduleName.'_comment_comment_show', array('id' => $comment->id)), '<i class="fa fa-wrench fa-4"></i> '.__('backend.read-comment'), array('class' => 'btn btn-'.$view_publish.' btn-xs')); ?>
                                    <?= \Html::anchor(\Router::get('admin_'.$moduleName.'_comment_comment_delete', array('id' => $comment->id)), '<i class="fa fa-trash-o fa-4"></i> Effacer', array('class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".__('backend.are-you-sure')."')")); ?>
                                </div>
                            </div>
    	                </td>

    	            </tr>
            	<?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?= $pagination; ?>
<?php endif; ?>

