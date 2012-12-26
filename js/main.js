// Document ready
//----------------

var myScroll;
var aMenuClicked = false;

documentReady(function() {
	
	
	// myScroll = new iScroll('menu', {vScrollbar: false}); // place iScroll on menu section
	
	// Toggle script
	
	$(".container").hide();

	$(".toggle").click(function(){
		$(this).toggleClass("active").next().slideToggle(350);
			return false;
	});
	
	// toggle script end
	
	$("body").swipe({
	  swipeLeft:function(event, direction, distance, duration, fingerCount) {
		// $('#menu').removeClass('activeState');
		$('#content-wrapper').removeClass('moved');
		aMenuClicked = false;
	  },
	  swipeRight:function(event, direction, distance, duration, fingerCount) {
		// $('#menu').addClass('activeState');
		$('#content-wrapper').addClass('moved');
		aMenuClicked = true;
	  },
	  excludedElements:$.fn.swipe.defaults.excludedElements+", .slides, .toggle"
	});
	
	
	
	
	if("ontouchstart" in document.documentElement)
	{	
		
			$('#a-menu').bind('touchstart touchon', function(event){
					if(aMenuClicked)
					{
						$('#menu').removeClass('activeState');
						$('#content-wrapper').removeClass('moved');
						aMenuClicked = false;
					}
					else
					{
						$('#menu').addClass('activeState');
						$('#content-wrapper').addClass('moved');
						aMenuClicked = true;
					}
			});
		}
		else
		{
			
			$('#a-menu').bind('click', function(event){
					if(aMenuClicked)
					{
						$('#menu').removeClass('activeState');
						$('#content-wrapper').removeClass('moved');
						aMenuClicked = false;
					}
					else
					{
						$('#menu').addClass('activeState');
						$('#content-wrapper').addClass('moved');
						aMenuClicked = true;
					}
			});
			
	}
	

	$("#header_menu li.item").mouseenter(function(){
			$(this).find('.subnav').fadeIn({ duration: 300, easing: 'easeInOutQuad'}) 	
		}).mouseleave(function(){
			$(this).animate({delay:1},50, function() {
				$(this).find('.subnav').fadeOut({ delay:500, duration: 300, easing: 'easeOutQuad'}) 	
			});
	});
	

});

// Run specified function when document is ready (HTML5)
//------------------------------------------------------
function documentReady(readyFunction) {
	document.addEventListener('DOMContentLoaded', function() {
		document.removeEventListener('DOMContentLoaded', arguments.callee, false);
		readyFunction();

	}, false);

}