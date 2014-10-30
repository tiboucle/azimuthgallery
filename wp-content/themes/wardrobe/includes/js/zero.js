/**
 * jQuery Mobile Menu 
 * Turn unordered list menu into dropdown select menu
 * version 1.0(31-OCT-2011)
 * 
 * Built on top of the jQuery library
 *   http://jquery.com
 * 
 * Documentation
 * 	 http://github.com/mambows/mobilemenu
 */
(function(a){a.fn.mobileMenu=function(b){var e={defaultText:"Navigate to...",className:"select-menu",subMenuClass:"sub-menu",subMenuDash:"&ndash;"},d=a.extend(e,b),c=a(this);this.each(function(){c.find("ul").addClass(d.subMenuClass);a("<select />",{"class":d.className}).insertAfter(c);a("<option />",{value:"#",text:d.defaultText}).appendTo("."+d.className);c.find("a").each(function(){var i=a(this),g="&nbsp;"+i.text(),h=i.parents("."+d.subMenuClass),f=h.length,j;if(i.parents("ul").hasClass(d.subMenuClass)){j=Array(f+1).join(d.subMenuDash);g=j+g}a("<option />",{value:this.href,html:g,selected:(this.href==window.location.href)}).appendTo("."+d.className)});a("."+d.className).change(function(){var f=a(this).val();if(f!=="#"){window.location.href=a(this).val()}})});return this}})(jQuery);

/**
 * Equal Height plugin
 */
(function(a){a.fn.equalHeight=function(){var c=0,b=a(window).width();this.addClass("equal-height").each(function(){var d=a(this).height();if(d>c){c=d}});a(this).height(c);return this}})(jQuery);

/**
 * jQuery Custom select box
 */
(function($){
 $.fn.extend({
 
 	customStyle : function(options) {
	  if(!$.browser.msie || ($.browser.msie&&$.browser.version>6)){
	  return this.each(function() {
	  
			var currentSelected = $(this).find(':selected');
			$(this).after('<span class="customStyleSelectBox"><span class="customStyleSelectBoxInner">'+currentSelected.text()+'</span></span>').css({position:'absolute', opacity:0,fontSize:$(this).next().css('font-size')});
			var selectBoxSpan = $(this).next();
			var selectBoxWidth = parseInt($(this).width()) - parseInt(selectBoxSpan.css('padding-left')) -parseInt(selectBoxSpan.css('padding-right'));			
			var selectBoxSpanInner = selectBoxSpan.find(':first-child');
			selectBoxSpan.css({display:'inline-block'});
			selectBoxSpanInner.css({width:selectBoxWidth, display:'inline-block'});
			var selectBoxHeight = parseInt(selectBoxSpan.height()) + parseInt(selectBoxSpan.css('padding-top')) + parseInt(selectBoxSpan.css('padding-bottom'));
			$(this).height(selectBoxHeight).change(function(){
				selectBoxSpanInner.text($(this).find(':selected').text()).parent().addClass('changed');
			});
			
	  });
	  }
	}
 });
})(jQuery);


(function($){

/** On Load **/
$(window).load(function(){
	/** Equal height **/
	$('.latest.section .news').height('auto').equalHeight();
});

/** On Resize **/
$(window).resize(function(){
	$('.latest.section .news').height('auto').equalHeight();
});

/** On Document Ready **/
$(document).ready(function(){

	/**
	 * Jquery Sooperfish Menu
	 */
	$('.navigation .menu, .second-nav .menu')
		.addClass('sf-menu')
		.sooperfish({
			hoverClass : 'sf-hover',
			animationShow : {height:'show'},
			speedShow : 200,
			delay:500,
			animationHide : {height:'hide'},
			speedHide : 200,
			autoArrows : true,
			dualColumn: 1000,
			tripleColumn: 1000
		});

	// Wrap featured img, to create inset box shadow effect
	$('.items-grid img, .entry-meta img, .flexslider img').wrap(function(){
		$(this).css('opacity','0');
		return '<div class="image-wrap" style="background:url('+ $(this).attr('src') +') no-repeat"></div>';
	});

	/**
	 * Jquery Flex slider
	 */
	$('.flexslider').flexslider({
		animation: 'slide',
		directionNav: false,
		controlsContainer: '.flex-container',
		start: function(slider) {
			//$('<div class="shadow">').insertBefore( slider.container );
			slider.controlNav.html('')
		}
	});

	// Custom select
	$('select').customStyle();

	// Video thumbnail
	$('.playicon').parent().addClass('video-thumb');

	// Infinite scroll
	$('#blog-content').infinitescroll({
		navSelector:	".blog-nav",
		nextSelector:	".nav-previous a",
		itemSelector:	"#blog-content .post",
		loadingImg:		"/ajax-loader.gif"
	}, function(){
		$('.playicon', this).parent().addClass('video-thumb');
	});


	/* Mobile nav collapse
	------------------------------------------------------------------- */
	$('.btn-navbar').click(function(e){
	  e.preventDefault();
	  var $el = $(this),
	      $navCollapse = $el.next('.nav-collapse');

	  // If collapsed
	  if( $el.hasClass('collapsed') ) {
	    $navCollapse.height( $navCollapse.children().outerHeight(true) );
	    $el.removeClass('collapsed');
	  } else {
	    $navCollapse.height(0);
	    $el.addClass('collapsed');
	  }
	});

});
})(jQuery);