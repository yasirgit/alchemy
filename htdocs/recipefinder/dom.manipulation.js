$(document).ready(function(){
	$('.min-max').click(function(){
		if($(this).hasClass('expandable')){
			$('.expand-wrapper').hide();
			$(this).removeClass('expandable').text('VIEW ALL OPTIONS');
			$('.expand-middle').find('input').attr('checked', false);
			$('.options-short-view').show();
			$('#tracker').val(0);
		}
		else {
			$('.expand-wrapper').show();
			$(this).addClass('expandable').text('MINIMIZE OPTIONS');
			$('.options-short-view').hide();
			$('#tracker').val(1);
		}
		return false;
	});
});