
	 
jQuery(document).ready(function()
{
	var Slides = 5;
	var CurSlide =1;
	var flag=0;
	
	var autoSlide =function()
	 {
		if(flag==0) 
		{
			 if(CurSlide < Slides)
			 {
			 jQuery('.block-in-content').animate({
			 left: "-=387",
			 }, 1000 );
			 
			 //jQuery('.active').removeClass('active');
			 jQuery('.circle'+CurSlide).removeClass('active');
			 jQuery('.circle'+ ++CurSlide).addClass('active');
			 //fixUi();
			 }
			if(CurSlide==5) 
			flag=1-flag;
		}
		else if(flag==1)
		{
		
			if(CurSlide >=1)
			 {
			 jQuery('.block-in-content').animate({
			 left: "+=387",
			 }, 1000 );
			 
			 //jQuery('.active').removeClass('active');
			 jQuery('.circle'+CurSlide).removeClass('active');
			 jQuery('.circle'+ --CurSlide).addClass('active');
			 //fixUi();
			 }
				
			if(CurSlide==1) 
			flag=1-flag;
		}		
		
	 };
	
	
	var set_timeout_pointer=null;
	var diff;
	
	 
	 set_timeout_pointer = setInterval(autoSlide, 3000);
	 
	 
	 jQuery('.paging a').click(function(e){
		e.preventDefault();
	
		clearInterval(set_timeout_pointer);
		var caur_val = jQuery(this).attr('cur');
		 
		if(CurSlide > caur_val)
		{
			diff = (CurSlide - caur_val)* 387;
		 //var abc = jQuery(this).attr('omar');	 
			 jQuery('.block-in-content').animate({
			 left: "+="+diff,
			 }, 1000 );
			 CurSlide = caur_val;
			 jQuery('.active').removeClass('active');
			 jQuery('.circle'+CurSlide).addClass('active');
			 //fixUi();
		}
		else{
			diff = (caur_val - CurSlide)* 387;
			jQuery('.block-in-content').animate({
			 left: "-="+diff,
			 }, 1000 );
			 CurSlide = caur_val;
			 jQuery('.active').removeClass('active');
			 jQuery('.circle'+CurSlide).addClass('active');
		}
	 });
	 
});
 