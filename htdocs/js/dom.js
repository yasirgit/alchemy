$(document).ready(function(){
	$('.lost-boxes-tab:eq(0)').show();
	$('.lost-tabbing-click li a').click(function(){
		var tracker = $('.lost-tabbing-click li a').index(this);
		$('.lost-tabbing-click li').removeClass('active-in-tab');
		$('.lost-boxes-tab').hide();
		$(this).parent().addClass('active-in-tab');
		$('.lost-boxes-tab').eq(tracker).show();
		return false;
	});
	
	// Function for My Result Tab
	$('.lost-boxes-result:eq(0)').show();
	$('.active-in-tab-result li a').click(function(){
		var tracker = $('.active-in-tab-result li a').index(this);
		$('.active-in-tab-result li').removeClass('active-in-tab');
		$('.lost-boxes-result').hide();
		$(this).parent().addClass('active-in-tab');
		$('.lost-boxes-result').eq(tracker).show();
		return false;
	});
	
    $('.add-journal-zone:eq(0)').show();
	$('.journaltabset li a').click(function(){
		var tracker = $('.journaltabset li a').index(this);
		$('.journaltabset li').removeClass('active');
		$('.add-journal-zone').hide();
		$(this).parent().addClass('active');
		$('.add-journal-zone').eq(tracker).show();
		return false;
	});
	
    $('.graph-replacer:eq(0)').show();
	$('.grid-tabbing li a').click(function(){
		var tracker = $('.grid-tabbing li a').index(this);
		$('.grid-tabbing li').removeClass('active');
		$('.graph-replacer').hide();
		$(this).parent().addClass('active');
		$('.graph-replacer').eq(tracker).show();
		return false;
	});
	

	
	
});