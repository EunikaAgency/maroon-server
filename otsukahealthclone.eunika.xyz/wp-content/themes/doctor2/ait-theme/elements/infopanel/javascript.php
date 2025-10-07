<script id="{$htmlId}-script">
jQuery(window).load(function(){
	{if $options->theme->general->progressivePageLoading}
		if(!isResponsive(1024)){
			jQuery("#{!$htmlId}-main").waypoint(function(){
				jQuery("#{!$htmlId}-main").addClass('load-finished');
			}, { triggerOnce: true, offset: "95%" });
		} else {
			jQuery("#{!$htmlId}-main").addClass('load-finished');
		}
	{else}
		jQuery("#{!$htmlId}-main").addClass('load-finished');
	{/if}
});

jQuery(document).ready(function(){
	jQuery("#{!$htmlId}-main .tabs-container a").click(function(e){
		e.preventDefault();
		jQuery("#{!$htmlId}-main .tabs-container li").removeClass('active');
		jQuery("#{!$htmlId}-main .panel-container").removeClass('panel-active');
		jQuery(this).parent().addClass('active');
		jQuery("#"+jQuery(this).data('panel')).addClass('panel-active');

		if(isResponsive(640)){
			var $li = jQuery(this).parent();
			jQuery("#{!$htmlId}-main .tabs-container ul").prepend($li);
			jQuery("#{!$htmlId}-main .tabs-container ul").addClass('elements-unsorted');	
		}
	});
	
	if(isResponsive(640)){
		var tabs = jQuery("#{!$htmlId}-main .tabs-container");

		if(!isMobile()) {
			tabs.mouseenter(function(){
				tabs.addClass('hover');
			})
			.mouseleave(function(){
				tabs.removeClass('hover');
			});
		} else {
			tabs.click(function(){
				jQuery(this).toggleClass("hover");
			});
		}
	}
	
});

jQuery(window).resize(function(){
	// reset the tabs order
	if(isResponsive(640) == false){
		var $container = jQuery("#{!$htmlId}-main ul.elements-unsorted");
		var $tabs = $container.children('li');
		$tabs.sort(function(a, b){
			var ao = parseInt(jQuery(a).data("order"));
			var bo = parseInt(jQuery(b).data("order"));

			if(ao > bo) {
				return 1;
			}
			if(ao < bo) {
				return -1;
			}
			return 0;
		});
		$tabs.detach().appendTo($container);
		$container.removeClass('elements-unsorted');
	} else {
		jQuery("#{!$htmlId}-main .tabs-container ul").prepend(jQuery("#{!$htmlId}-main .tabs-container li.active"));
		jQuery("#{!$htmlId}-main .tabs-container ul").addClass('elements-unsorted');
	}
});
	 

</script>