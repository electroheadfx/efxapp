    <style type="text/css">

        <?php if ($navbarmargin): ?>
            /* navbar left margin */
             @media(min-width:767px){
                nav.navbar.navbar-default {
                    margin-left: <?= $navbarmargin ?>;
                }
            }
        <?php endif; ?>
        
        <?php if ( $bgselect != 'default'): ?>
            /* Background page */
            body.home {
                <?php if ($bgselectcolor): ?>
                    background: none;
                    background-color: <?= $bgdata; ?>;
                <?php endif; ?>

                <?php if ( $bgselect == 'textured' ): ?>
                    background: url(/assets/img/bg.png);
                <?php endif; ?>
                
            }
        <?php endif; ?>
        
        <?php if ( $mediaselect != 'default'): ?>
            /* Background media */
            #articles .article.active .player, #articles .article.pending .player {
                <?php if ($mediaselectcolor): ?>
                    background-color: <?= $mediadata; ?>;
                <?php endif; ?>

                <?php if ( $mediaselect == 'textured' ): ?>
                    background: url(/assets/img/bg.png);
                <?php endif; ?>

                <?php if ( $mediaselect == 'transparent' ): ?>
                    background-color: transparent;
                <?php endif; ?>
            }
        <?php endif; ?>
        
            <?php if ($logoselectcolor): ?>
                /* Logo color */        
                #sidebar .logo-sidebar .st0 {
                    fill:<?= $logodata; ?>;
                }
            <?php endif; ?>

            <?php if ($logo2selectcolor): ?>
                /* Logo color */        
                #sidebar .logo-sidebar .st1 {
                    fill:<?= $logo2data; ?>;
                }
            <?php endif; ?>
        
        <?php if ( $bgsiderselect != 'default'): ?>
            /* Background Sidebar */
           #sidebar, .navbar-default .navbar-brand {
                <?php if ($bgsiderselectcolor): ?>
                    background: none;
                    background-color: <?= $bgsiderdata; ?>;
                <?php endif; ?>

                <?php if ( $bgsiderselect == 'textured' ): ?>
                    background: url(/assets/img/bg.png);
                <?php endif; ?>

                <?php if ( $bgsiderselect == 'transparent' ): ?>
                    background-color: transparent;
                <?php endif; ?>

            }
        <?php endif; ?>
        
        <?php if ( $navselect != 'default'): ?>
            /* Background Navbar */
            .home header .navbar.navbar-default {
                <?php if ($navselectcolor): ?>
                    background: none;
                    background-color: <?= $navdata; ?>;
                <?php endif; ?>

                <?php if ( $navselect == 'textured' ): ?>
                    background: url(/assets/img/bg.png);
                <?php endif; ?>

                <?php if ( $navselect == 'transparent' ): ?>
                    background-color: transparent;
                <?php endif; ?>

            }
        <?php endif; ?>
        
        <?php if ( $navrightselect != 'default'): ?>
            /* Background Rightn Navbar */
            .home header .navbar-right.access, .home header .navbar-right .navbar-nav {
                <?php if ($navrightselectcolor): ?>
                    background: none;
                    background-color: <?= $navrightdata; ?>;
                <?php endif; ?>

                <?php if ( $navrightselect == 'textured' ): ?>
                    background: url(/assets/img/bg.png);
                <?php endif; ?>

                <?php if ( $navrightselect == 'transparent' ): ?>
                    background-color: transparent;
                <?php endif; ?>
            }
        <?php endif; ?>



        <?php if (!empty($textcolor)): ?>
            /* Text nav color */
            .navbar-left.menus li a.menu, .navbar-nav > li > a, .navbar-default .navbar-nav > li > a {
                color: <?= $textcolor; ?>;
            }
        <?php endif; ?>

        <?php if (!empty($texthovercolor)): ?>
            /* Text nav hover color */
            .navbar-left.menus li a.menu:hover, .navbar-default .navbar-nav > li > a:hover {
                color: <?= $texthovercolor; ?>;
            }
        <?php endif; ?>

        <?php if (!empty($blockhovercolor)): ?>
            /* Block nav hover color */
            .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
                background-color: <?= $blockhovercolor; ?>;
            }
        <?php endif; ?>

        <?php if (!empty($textactivecolor)): ?>
            /* Text nav active color */
            .navbar-left.menus li a.menu.active {
                color: <?= $textactivecolor; ?>;
            }
        <?php endif; ?>
        
        


        <?php if (!empty($textsidercolor)): ?>
            /* Text sider nav color */
            .filters a {
                color: <?= $textsidercolor; ?>;
            }
        <?php endif; ?>
        
        <?php if (!empty($textsideractivecolor)): ?>
            /* Text sider nav active color */
            .filters a.active {
                color: <?= $textsideractivecolor; ?>;
            }
        <?php endif; ?>

        <?php if (!empty($textsiderhovercolor)): ?>
            /* Text sider nav hover color */
            .filters a:hover {
                color: <?= $textsiderhovercolor; ?>;
            }
        <?php endif; ?>

            
    </style>