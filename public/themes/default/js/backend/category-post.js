$(function () {


	 $('[data-toggle="tooltip"]').tooltip({placement: 'auto bottom', html: true, container: 'body' });

	 $('a.lang-switcher').click(function (e) {
	     e.preventDefault();
	     if ( !$(this).hasClass('active') ) {
		     lang = $(this).attr('href');
		     el = $(this).parent().parent();
		     el.find('.localisation').not( ".hidden" ).addClass('hidden');
		     el.find('.localisation.'+lang).removeClass('hidden');
		     el.find('a.lang-switcher').removeClass('active');
		     $(this).addClass('active');
		 }
	 });

});