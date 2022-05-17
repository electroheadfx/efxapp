
<div class="bcg" id="intro">

    <div class="hero">
     
        <!-- Top part -->
        <div class="top">
          
          <span></span>
          
          <!-- Master Slide Top -->
          <div class="homeSlide top-hero slide01 active">
            <div class="slide-img"></div>
            <div class="hero-container">

              <h1 class="hero-title" data-size="<?= \Config::get('slider.master.top.size') ?>"><?= html_entity_decode(\Config::get('slider.master.top.text')) ?></h1>
              <p class="hero-txt">
                  <?= html_entity_decode(\Config::get('slider.master.bottom.text')) ?>
              </p>

            </div> <!-- hero-container -->

            <div class="divider"></div>
            
          </div>

          <!-- Slides top -->
          <?php for ($key=0; $key < $nth; $key++): ?>

            <div class="homeSlide top-hero slide<?= sprintf("%02d", $key+2) ?>">
            <div class="slide-img"></div>
            <div class="hero-container">

              <h1 class="hero-title" data-size="<?= \Config::get('slider.sliders.'.$slides[$key].'.top.size') ?>"><?= html_entity_decode(\Config::get('slider.sliders.'.$slides[$key].'.top.text')) ?></h1>
              
              <p class="hero-txt">
                <?= html_entity_decode(\Config::get('slider.sliders.'.$slides[$key].'.bottom.text')) ?>
              </p>

            </div>
              
              <div class="divider"></div>

            </div>

          <?php endfor; ?>

        </div><!-- /Top part -->
     
        <!-- Bottom part -->
        <div class="bottom">

                 <a href="http://cru2vie.org" class="logo-homeslide"><img src="/assets/img/cru2vie-flag.jpg" /></a>

        </div><!-- /Bottom part -->
                  
    </div> <!-- hero -->
     
     <!-- Prev/Next Navigation -->
    <div id="slideNav">
       <ul>
         <li class="slideNavPrev">
           <a href="#" title="<?= __('module.blog.default.go_to_previous_slide') ?>">
             <i class="fa fa-chevron-up"></i>
           </a>
         </li>
         <!--
         <li class="slideNPlay">
           <a href="#" title="<?= __('module.blog.default.go_to_previous_slide') ?>">
             <i class="fa fa-pause"></i>
           </a>
         </li>
         -->
         <li class="slideNavNext">
           <a href="#" title="<?= __('module.blog.default.go_to_next_slide') ?>">
             <i class="fa fa-chevron-down"></i>
           </a>
         </li>
       </ul>
    </div>

    <nav id="short-slideNav" >

       <ul>
           
           <?php for ($key=0; $key < $nth+1; $key++): ?>
           
               <li>
                 <a href="#shortSlideNav<?= sprintf("%02d", $key+1) ?>" data-slide="<?= $key+1 ?>" >
                    <span class="nav-label"></span>
                    <span id="short-slideNav<?= $key+1 ?>" class="nav-dot<?php if ($key == 0) echo ' active' ?>"> </span>
                 </a>
               </li>

           <?php endfor; ?>

       </ul>

    </nav>

    <div id="first-content-nav">
            <a href="#<?= $nav[0]->slug; ?>" ><i class="fa fa-angle-down"></i></a>
    </div>


</div>