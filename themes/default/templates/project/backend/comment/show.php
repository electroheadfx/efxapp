
<p>
    <div class="group-separator">
        <a href="<?= \Router::get('admin_comment'); ?>" type="button" class="btn btn-default" ><span class="fa fa-mail-reply"></span> <?= __($lang.'backend.back-to-comments'); ?></a>
    </div>
</p>


<?php if(empty($comment)): ?>

    <?= __($lang.'backend.comment.missing'); ?>

<?php else: ?>
    
    <h4 class="comment-show" ><?= ' @' . $comment->username ?> <small>(<?= $comment->mail ?>)</small> a écrit sur <a href="<?php echo \Router::get('show_post', array('segment' => $comment->post->slug)); ?>" target="_blank" ><?= $comment->post->name ?></a></h4>

    <!-- published -->
    <pre>
<?= $comment->content; ?>
    </pre>

    <hr/>

    <div class="btn-group">

        <a class="btn btn-<?= ($comment->published == 'on') ? 'success' : 'warning' ?> btn-sm" href="<?= \Router::get('admin_comment_attribute', array($comment->id,'published',$comment->published)) ?>">
            <i class="fa fa-<?= ($comment->published == 'on') ? 'chain' : 'chain-broken' ?> fa-4" ></i>
            <?= __('model.comment.attribute.published.'.$comment->published); ?>
        </a>
    
        <?= \Html::anchor(\Router::get('admin_comment_delete', array('id' => $comment->id)), '<i class="fa fa-trash-o fa-4"></i> Effacer', array('class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('".__($lang.'backend.are-you-sure')."')")); ?>
    
    </div>

<?php endif; ?>

