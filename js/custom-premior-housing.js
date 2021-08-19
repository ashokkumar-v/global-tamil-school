// JavaScript Document
// JavaScript Document

$(document).ready(function(){
  $('.slider1').bxSlider({
	auto:false,pager:false,
	 mode: 'fade',auto:true	
  });
});


               (function($){
	$(document).ready(function(){
		$('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
			event.preventDefault(); 
			event.stopPropagation(); 
			$(this).parent().siblings().removeClass('open');
			$(this).parent().toggleClass('open');
		});
	});
})(jQuery);
//mobile-menu


//mobile-menu

