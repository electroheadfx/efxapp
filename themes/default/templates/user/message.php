<?php if (\Message::any()): ?>
    <br/>
    <?php foreach (array('success', 'info', 'warning', 'error') as $type): ?>
		<?php $class = ($type == 'error') ? 'danger' : $type; ?>
        <?php foreach (\Message::instance()->get($type) as $message): ?>
            <div class="alert alert-<?= $class; ?>"><?= $message['body']; ?></div>
        <?php endforeach; ?>

    <?php endforeach; ?>
    <?php \Message::reset(); ?>
<?php endif; ?>