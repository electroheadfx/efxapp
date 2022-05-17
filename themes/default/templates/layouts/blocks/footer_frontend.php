
        
        <!-- Core Footer JS -->
        <?= \Theme::instance()->asset->render('footer'); ?>
        <?= \Theme::instance()->asset->render('script'); ?>
		
        
        <?php if ( isset($bgselect) ): ?>
	        <?php if ( $bgselect == 'vimeo' ): ?>
		        
		        <script src="https://f.vimeocdn.com/js/froogaloop2.min.js"></script>

	        <?php endif; ?>
        <?php endif; ?>
		
    </body>
</html>