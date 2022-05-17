<?php  echo \Theme::instance()->set_partial('header','blocks/header'); ?>

        <?= \Theme::instance()->view('user/blocks/top_navbar'); ?>

        <!-- Begin messages -->
        
        <div class="message"><?php echo $messages; ?></div>
            
        <!-- End of messages -->

        <div class="container">
            
            <?php if(isset($pageTitle)): ?>

                <h1><?= $pageTitle; ?></h1>

            <?php endif; ?>


            <?php if(isset($partials['content'])): ?>

                <?= $partials['content']; ?>

            <?php endif; ?>

        </div> <!-- /container -->

<?= \Theme::instance()->view('blocks/footer'); ?>