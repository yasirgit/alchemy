$(function() {

		$( "#slider-range-first" ).slider({
			range: false,
			//value: 1,
			min: 0,
			max: 10,
			slide: function( event, ui ) {
				$( "#hungerlevel" ).val(ui.value );
			}
		});
		 $( "#hungerlevel" ).val( "$" + $( "#slider-range-first" ).slider( "value" ) );
		//$( "#amount" ).val( "rima");
		
		///////////////////////////////////////////
		//slider 2:
		$( "#slider-range-two" ).slider({
			range: false,
			//value: 1,
			min: 0,
			max: 10,
			slide: function( event, ui ) {
				$( "#energylevel" ).val(ui.value );
			}
		});
		 $( "#energylevel" ).val( "$" + $( "#slider-range-two" ).slider( "value" ) );
		 
		////////////////////////////////////////////
		//slider 3: 
		$( "#slider-range-three" ).slider({
			range: false,
			//value: 1,
			min: 0,
			max: 10,
			slide: function( event, ui ) {
				$( "#esteemlevel" ).val(ui.value );
			}
		});
		 $( "#esteemlevel" ).val( "$" + $( "#slider-range-three" ).slider( "value" ) );
		 
		 ////////////////////////////////////////////
		 //slider 4:
		$( "#slider-range-four" ).slider({
			range: false,
			//value: 1,
			min: 0,
			max: 10,
			slide: function( event, ui ) {
				$( "#sleepquality" ).val(ui.value );
			}
		});
		 $( "#sleepquality" ).val( "$" + $( "#slider-range-four" ).slider( "value" ) );		 
		 

});
