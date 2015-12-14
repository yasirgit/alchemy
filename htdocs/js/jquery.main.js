$(document).ready(function(){
	
	if (typeof $().galleryScroll == 'function')
		$('div.G1').galleryScroll({
			holderList:'.g-holder'
		});
	
	if (typeof VSA_initScrollbars == 'function') VSA_initScrollbars();
	
	$('.gallery:has(a.tab)').each(function(i, tabset){
		var _tabLinks = $('a.tab',tabset), _active;
		_tabLinks.each(function(j, link){
			var _id = $(link.href.substr(link.href.indexOf('#')));
			if ($(link).parent().hasClass('active')){_id.show();_active = _id;}
			else _id.hide();
			
			$(link).click(function(){
				_tabLinks.parent().removeClass('active');
				_active.hide();
				$(link).parent().addClass('active');
				_id.show();
				_active = _id;
				return false;
			})
		});
	});
	
	if (typeof initTabs == 'function') initTabs();
});
