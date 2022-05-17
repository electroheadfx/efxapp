
$(window).load(function(){

  var $container = $('#articles');

  // grid_full = "col-xs-12 col-sm-12 col-md-12 col-lg-12";
  // grid_thumb = "col-xs-6 col-sm-6 col-md-4 col-lg-4";
  var active = "active";
  var pending = "pending";

  $container.isotope({
    layoutMode: 'packery',
    itemSelector: '.grid-item',
    animationOptions: {
        duration: 500,
        easing: 'swing'
    }
  });

  /* filters button */

  // add sorts_control actived by menu
  if ( $( '#frontend-control' ).length ) {

      $('#sorteddesc').on("click touchstart", function(event) {
      // $('#sorteddesc').click(function(event){
        
          $('#frontend-control .btn.active').removeClass('active');
          $(this).addClass('active');
          $container.isotope({ filter: '*', sortBy: 'original-order', sortAscending: true });
      });

      $('#sortedasc').on("click touchstart", function(event) {
      // $('#sortedasc').click(function(event){
          $('#frontend-control .btn.active').removeClass('active');
          $(this).addClass('active');
          $container.isotope({ filter: '*', sortBy: 'original-order', sortAscending: false });
      });

      $('#favorites').on("click touchstart", function(event) {
      // $('#favorites').click(function(event){
          $('#frontend-control .btn.active').removeClass('active');
          $(this).addClass('active');
          $container.isotope({ filter: '.favorite', sortAscending: true });
      });

      $('#random').on("click touchstart", function(event) {
      // $('#random').click(function(event){
          $('#frontend-control .btn.active').removeClass('active');
          $(this).addClass('active');
          $container.isotope('updateSortData').isotope({
            filter: '*',
            sortBy: 'random'
          });
      });
  }

});