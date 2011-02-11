$(function(){

	if (navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/iPad/i)) {
		$(document).ready(function () {
			$('label[for]').click(function () {
				var el = $(this).attr('for');
				if ($('#' + el + '[type=radio], #' + el + '[type=checkbox]').attr('selected', !$('#' + el).attr('selected'))) {
					return;
				} else {
					$('#' + el)[0].focus();
				}
			});
		});
	}
	
  
  if(window.orientation != 0){
	  document.body.className+=' landscape';
  }
  
    
  $('.reserve-now').unbind();

  $('input.ting-autocomplete').each(function () {
		$(this).unbind();		
		
		$(".top label").inFieldLabels({
		    fadeOpacity:"0.2",
		    fadeDuration:"100"			
		  });
		
	});
  
});



/* disable modal login */
Drupal.behaviors.dingLibraryUserLoginDialog = function () {
	var loginPath = Drupal.settings.basePath + 'user/login';
	$("a[href^='" + loginPath + "']").unbind('click');
}; 

Drupal.behaviors.addTingAutocomplete = function (context) {
	
	
		
/*		$(this)
	.autocomplete(Drupal.settings.tingSearchAutocomplete.path, {
	// TODO: Consider moving dimensions to CSS for easier customization
	scrollHeight: 200,
	 width: 493,
	 delay: 200,
	 selectFirst: false,
	 matchCase: true,
	 formatResult: function (data) { return data[1]; }
	 })
	 .result(function (event) {
	$(event.target)
	 .addClass('ac_loading')
	 .parents('form:first')
	 .submit();
	 });
	 });*/
};


window.addEventListener("onorientationchange" in window ? "orientationchange" : "resize", function() {
	if(window.orientation != 0){
		document.body.className+=' landscape';
	}
	else{
		document.body.className = document.body.className.replace(' landscape','');
	}
}, false);