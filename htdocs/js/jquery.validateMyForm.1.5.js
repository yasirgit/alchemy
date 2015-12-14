/* 	============================================================================
	sales++ jQuery Plugins, http://www.salesplusplus.com
	----------------------------------------------------------------------------	
	Plugin: validateMyForm
	Version: 1.5
	Description: validateMyForm - Easy form validation
	File: jquery.validateMyForm.1.5.js
	License: MIT, see http://jquery.org/license
	Author: Andy Shora, andyshora@gmail.com, Created 13/09/2010, Copyright 2010 Andy Shora
	Plugin Homepage: http://www.salesplusplus.com/validatemyform-jquery-plugin-easy-form-validation/
	============================================================================
*/
(function($) {
  $.fn.validateMyForm = function(options) {
	/* set default options */
    var options = $.extend({
			form: '#recipeform',
			requiredClass: 'required',
			message: "Please complete all required fields",
			showMessage: false,
			showNotifications: true,
			notificationText: 'required',
			notificationClass: 'required-display',
			emailValidationClass: 'email',
			emailNotificationText: 'invalid email',
			numericValidationClass: 'numeric',
			numericNotificationText: 'not numeric',
			dateValidationClass: 'date',
			dateNotificationText: 'invalid date',
			daysFirst: false,
			ifClass: 'if', /* if inputs with this class (appended by an integer, e.g. if2) are not null */
			thenClass: 'then', /* then validate inputs with this class (appended by the same integer, e.g. then2) */
			shake: true,
			scrollUp: true,
			textareaLimit: 0, /* limit the number of characters/words */
			textareaCounter: '#remaining strong', /* selector of the area to insert the number of characters/words remaining */
			textareaCounterWrap: '#remaining', /* the whole selector to hide, which the counter will sit inside. e.g. <div id="remaining"><strong>100</strong> characters remaining</div> */
			hideTextareaCounter: false, /* visibility of counter when there is no input */
			showAsterisk: true,
			asterisk: '*',
			asteriskClass: 'required-asterisk',
			clearForm: '.clearForm' /* when this element is clicked the form will reset */
    }, options);
	/* iterate over the matched elements passed to the plugin */
  $(this).each(function() {
		/* ========== INIT CODE ========== */
		
		
		
		
		//append notifications in HTML
		if (options.showNotifications){
			/* insert required fields span after each input */
			$(options.form + " input").each(function(){
					if ( $(this).hasClass(options.requiredClass) ){
						appendNotification( $(this), options.notificationClass, options.notificationText );
					} else if ( $(this).hasClass(options.emailValidationClass) ){
						appendNotification( $(this), options.notificationClass, options.notificationText );
					} else if ( $(this).hasClass(options.numericValidationClass) ){
						appendNotification( $(this), options.notificationClass, options.notificationText );
					} else if ( $(this).hasClass(options.dateValidationClass) ){
						appendNotification( $(this), options.notificationClass, options.notificationText );
					}
			});
			/* insert required fields span after selects */
			$(options.form + " select").each(function(){
				if ( $(this).hasClass(options.requiredClass) ){
					appendNotification( $(this), options.notificationClass, options.notificationText );
				}
			});
			
			//append * in HTML
	
			if (options.showAsterisk){
				/* insert required fields span after each input */
				$("label").each(function(){
						if ( $(this).hasClass(options.requiredClass) ){
							appendAsterisk( $(this), options.asteriskClass, options.asterisk );
						}
				});
			}
		
			//append conditional notifications in HTML
			var conditionalLoop = 1;
				//loop through conditional elements
				while ( $("." + options.ifClass + conditionalLoop).length > 0 ){
					//loop
					$("." + options.thenClass + conditionalLoop).each(function(){
						appendNotification( $(this), options.notificationClass, options.notificationText );
					});
					conditionalLoop++;
				}
    	}
		
		/*  insert required fields span after each textarea */
			$(options.form + " textarea").each(function(){
					//initially hide counter
					if (options.hideTextareaCounter) $(options.textareaCounterWrap).css('visibility','hidden');
					
					//if required field append notification
					if ($(this).hasClass(options.requiredClass)){
						appendNotification( $(this), options.notificationClass, options.notificationText );
					}
					//0 means there is no limit, for anything else display the characters remaining in the target
					
					if (options.textareaLimit > 0) {
						//display characters remaining count
						$(this).bind('keyup', function(){ 
							countCharacters(options.textareaCounter, $(this), options.textareaLimit, true, options.hideTextareaCounter, options.textareaCounterWrap);
						});
					}
			});
		/* ========== END INIT CODE ========== */
		
		
		//attach this validator to the form's submit event
		$(options.form).bind('submit', function(){
				
				var invalidFields = 0;
				var firstInvalidField = "";
				//loop through basic validation class, check all these required fields are not empty
				$(options.form + " input").each(function(){
					if (($(this).attr('type')=='checkbox') && ($(this).hasClass(options.requiredClass)) && (!($(this).is(':checked')))){
							//checkbox, required but unchecked
							if (options.showNotifications) showNotification( $(this), options.shake, options.notificationClass );
							//remember first encountered invalid field
							if ((invalidFields==0) && (options.scrollUp)) firstInvalidField = $(this);
							invalidFields++;
					} else if (($(this).attr('type')=='radio') && ($(this).hasClass(options.requiredClass))){
							
							var radioGroupName = $(this).attr('name');
							//check radio button group for selected input
							
							if ( $('input[name=' + radioGroupName + ']:checked').length == 0){
									//radio group, required but no inputs checked
									if (options.showNotifications) showNotification( $(this), options.shake, options.notificationClass );
									//remember first encountered invalid field
									if ((invalidFields==0) && (options.scrollUp)) firstInvalidField = $(this);
									invalidFields++;
							} else {
									//an answer has been selected, hide notification
									hideNotification( $(this), options.notificationClass );
							}
					} else if (( $(this).hasClass(options.requiredClass) ) && ( $(this).val() == "" )){
							//required field missing
							if (options.showNotifications) showNotification( $(this), options.shake, options.notificationClass );
							//remember first encountered invalid field
							if ((invalidFields==0) && (options.scrollUp)) firstInvalidField = $(this);
							invalidFields++;
					} else if (( $(this).hasClass( options.emailValidationClass ) ) && ( $(this).val() != "" ) && 
( !(isValidEmail( $(this).val() ) ))) {
								//invalid email address
								showCustomNotification( $(this), options.emailNotificationText, options.shake, options.notificationClass );
								//remember first encountered invalid field
								if ((invalidFields==0) && (options.scrollUp)) firstInvalidField = $(this);
								invalidFields++;
						} else if (( $(this).hasClass( options.numericValidationClass ) ) && ( $(this).val() != "" ) && ( !(isNumeric( $(this).val() ) ))){
								//numeric check failed
								showCustomNotification( $(this), options.numericNotificationText, options.shake, options.notificationClass );
								//remember first encountered invalid field
								if ((invalidFields==0) && (options.scrollUp)) firstInvalidField = $(this);
								invalidFields++;
						} else if (( $(this).hasClass( options.dateValidationClass ) ) && ( $(this).val() != "" ) && ( !(isValidDate( $(this).val(), options.daysFirst ) ))){
								//invalid date
								showCustomNotification( $(this), options.dateNotificationText, options.shake, options.notificationClass );
								//remember first encountered invalid field
								if ((invalidFields==0) && (options.scrollUp)) firstInvalidField = $(this);
								invalidFields++;
						} else if ((options.showNotifications) && ($(this).hasClass(options.requiredClass) || $(this).hasClass(options.emailValidationClass) || $(this).hasClass(options.numericValidationClass) || $(this).hasClass(options.dateValidationClass))) {
								//field has already been checked as required, so hide notification
								hideNotification( $(this), options.notificationClass );
						}
					

				});
				/* validate selects */
				$(options.form + " select").each(function(){
					if ($(this).hasClass(options.requiredClass) && ($(this).val()== "")){
							
							if (options.showNotifications) showNotification( $(this), options.shake, options.notificationClass );
							//remember first encountered invalid field
							if ((invalidFields==0) && (options.scrollUp)) firstInvalidField = $(this);
							invalidFields++;
					}
				});
				/* validate textareas */
				$(options.form + " textarea").each(function(){
					if ($(this).hasClass(options.requiredClass) && ($(this).val().length == 0)){
							
							if (options.showNotifications) showNotification( $(this), options.shake, options.notificationClass );
							//remember first encountered invalid field
							if ((invalidFields==0) && (options.scrollUp)) firstInvalidField = $(this);
							invalidFields++;
					}
				});

				//loop through conditional validation class, if primary input is not null, then validate secondary input
				var conditionalLoop = 1;
				
				var debug = $("." + options.ifClass + conditionalLoop).length;
				//alert("debug:"+debug);
				
				while ( $("." + options.ifClass + conditionalLoop).length > 0 ){
				
					// if primary imput is not null
					if ( $("." + options.ifClass + conditionalLoop).val() != "" ) {
						//validate secondary inputs

						$("." + options.thenClass + conditionalLoop).each(function(){
								
								//no need for 'required' class, if the input has the thenClass then it's a required field
								if (($(this).attr('type')=='checkbox') && (!($(this).is(':checked')))){
										//checkbox, required but unchecked
										if (options.showNotifications) showNotification( $(this), options.shake, options.notificationClass );
										//remember first encountered invalid field
										if ((invalidFields==0) && (options.scrollUp)) firstInvalidField = $(this);
										invalidFields++;
								} else if ($(this).attr('type')=='radio'){
							
										var radioGroupName = $(this).attr('name');
										//check radio button group for selected input
										
										if ( $('input[name=' + radioGroupName + ']:checked').length == 0){
												//radio group, required but no inputs checked
												if (options.showNotifications) showNotification( $(this), options.shake, options.notificationClass );
												//remember first encountered invalid field
												if ((invalidFields==0) && (options.scrollUp)) firstInvalidField = $(this);
												invalidFields++;
										} else {
												//an answer has been selected, hide notification
												hideNotification( $(this), options.notificationClass );
										}
								} else if ( $(this).val() == "" ){
										//required field missing
										if (options.showNotifications) showNotification( $(this), options.shake, options.notificationClass );
										//remember first encountered invalid field
										if ((invalidFields==0) && (options.scrollUp)) firstInvalidField = $(this);
										invalidFields++;
								} else if (( $(this).hasClass( options.emailValidationClass ) ) && ( $(this).val() != "" ) && 
			( !(isValidEmail( $(this).val() ) ))) {
											//invalid email address
											showCustomNotification( $(this), options.emailNotificationText, options.shake, options.notificationClass );
											//remember first encountered invalid field
											if ((invalidFields==0) && (options.scrollUp)) firstInvalidField = $(this);
											invalidFields++;
									} else if (( $(this).hasClass( options.numericValidationClass ) ) && ( $(this).val() != "" ) && ( !(isNumeric( $(this).val() ) ))){
											//numeric check failed
											showCustomNotification( $(this), options.numericNotificationText, options.shake, options.notificationClass );
											//remember first encountered invalid field
											if ((invalidFields==0) && (options.scrollUp)) firstInvalidField = $(this);
											invalidFields++;
									} else if (( $(this).hasClass( options.dateValidationClass ) ) && ( $(this).val() != "" ) && ( !(isValidDate( $(this).val(), options.daysFirst ) ))){
											//invalid date
											showCustomNotification( $(this), options.dateNotificationText, options.shake, options.notificationClass );
											//remember first encountered invalid field
											if ((invalidFields==0) && (options.scrollUp)) firstInvalidField = $(this);
											invalidFields++;
									} else if (options.showNotifications) {
											//field has already been checked as required, so hide notification
											hideNotification( $(this), options.notificationClass );
									}
								
						});
					} else {
						//remove notification from secondary inputs
						$("." + options.thenClass + conditionalLoop).each(function(){
							if (options.showNotifications) hideNotification( $(this), options.notificationClass );
						});
					}
					
					conditionalLoop++;
				}
			
			
			if  ( invalidFields > 0 ) {
				//scroll up to first invalid field
				if (options.scrollUp) scrollUp(firstInvalidField);
				
				//invalid, don't submit form
				if (options.showMessage) alert(options.message);
				return false;
			}
		});
		//remove notification on keyup or select change
		if (options.showNotifications){
			$("."+options.requiredClass).bind('keyup', function(){
				if ( $(this).val() != "" ) hideNotification( $(this), options.notificationClass );
				else showNotification( $(this), options.shake, options.notificationClass );
			});
			$("select."+options.requiredClass).bind('change', function(){
				if ( $(this).val() != "" ) hideNotification( $(this), options.notificationClass );
				else showNotification( $(this), options.shake, options.notificationClass );
			});
		}
		
		//clear the form
		$(options.form + " " + options.clearForm).bind('click', function(){
			//clear text inputs
			$(options.form + " input[type=text]").val('');
			//clear textareas
			$(options.form + " textarea").text('');
			//trigger keypress to reset character count
			$(options.form + " textarea").trigger('keyup');
			//reset select box
			$(options.form + " select option").removeAttr('selected');
			$(options.form + " select option[value='']").attr('selected','selected');
			//uncheck checkboxes
			$(options.form + " input[type=checkbox]").removeAttr('checked');
			//uncheck radio
			$(options.form + " input[type=radio]").removeAttr('checked');
			
			//hide all notifications
			$("span." + options.notificationClass).hide();
			//set character count invisible, we still want it to occupy space as it's probably not an inline element
			$(options.textareaCounterWrap).css('visibility','hidden');
		});
			
    });
  }
  function appendAsterisk(elm,cssClass,asterisk){
			var oldHTML = elm.html();
			elm.html(oldHTML + '<span class="'+ cssClass +'">'+ asterisk +'</span>');
  }
  function appendNotification(elm,cssClass,text){
		if (elm.attr('type')=='radio'){
			//need to append notification to the label of the radio questions
			//the label's 'for' attribute should be set to this input's id
			var newElm = $('label[for=' + elm.attr('id') + ']');
			newElm.after('<span class="'+ cssClass +'">'+ text +'</span>');
		} else {
			//else append after the input
			//elm.after('<span class="'+ cssClass +'">'+ text +'</span>');
			//$('.msg').append('<span class="'+ cssClass +'">'+ text +'</span>');
			elm.parent().parent().after('<span class="'+ cssClass +'">'+ text +'</span>');
		}
  }
  function showNotification(elm, shakeIt, notificationClass){
		if (elm.attr('type')=='radio'){
			//need to show notification after label of the radio questions
			//the label's 'for' attribute should be set to this input's id
			var newElm = $('label[for=' + elm.attr('id') + ']');
			newElm.next("span." + notificationClass).fadeIn(200, function(){
				if (shakeIt) shake( $(this) );
			});
		} else {
			elm.next("span." + notificationClass).fadeIn(200, function(){
				if (shakeIt) shake( $(this) );
			});
		}
  }
   function showCustomNotification(elm,text,shakeIt, notificationClass){
		elm.next("span." + notificationClass).html(text);
		elm.next("span." + notificationClass).fadeIn(200, function(){
			if (shakeIt) shake( $(this) );
		});
  }
  function hideNotification(elm, notificationClass){
		if (elm.attr('type')=='radio'){
			//need to hide notification after label of the radio questions
			//the label's 'for' attribute should be set to this input's id
			var newElm = $('label[for=' + elm.attr('id') + ']');
			newElm.next("span." + notificationClass).fadeOut(200);
		} 
		elm.next("span.required-display").fadeOut(200);
  }
  function isValidEmail(email) {
		/* use regex to check for a valid email address */
		var filter = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
		if (!filter.test(email)) {
			return false;
		}
		return true;
  }
  function isNumeric(val){
		if (val != parseFloat(val)) return false;
		return true;		
  }
  function isValidDate(str, daysFirst){
		
	  var re = /^(\d{1,2})[\s\.\/-](\d{1,2})[\s\.\/-](\d{4})$/
	  if (!re.test(str)) return false;
	  var result = str.match(re);
	  var m = parseInt(result[1]);
	  var d = parseInt(result[2]);
	  if (daysFirst) {
	  //if dd/mm/yyyy
		d = parseInt(result[1]);
		m = parseInt(result[2]);
	  }
	  var y = parseInt(result[3]);
	  if (m < 1 || m > 12 || y < 1900 || y > 2100) return false;
	  if (m == 2){
			  var days = ((y % 4) == 0) ? 29 : 28;
	  } else if(m == 4 || m == 6 || m == 9 || m == 11){
			  var days = 30;
	  } else{
			  var days = 31;
	  }
	  return (d >= 1 && d <= days);
  }
  function shake(elm){
  // shake an element from side-to-side
		for (var x = 1; x <= 2; x++){
			$(elm).animate({ "marginLeft" : "-=2px" },20)
			.animate({ "marginLeft" : "+=2px" },20)
			.animate({ "marginLeft" : "+=2px" },20)
			.animate({ "marginLeft" : "-=2px" },20);
		}
		
  }
  
  function scrollUp(elm){
	var px = elm.offset().top - 100;
	//scroll the browser window up 100px before the target element
	if ($.browser.opera){
		$('html').animate({scrollTop: px}, 500);
	} else {
		$('html,body').animate({scrollTop: px}, 500);
	}
  }
  function countCharacters(feedbackArea, field, limit, trim, hide, wrap){
  
	var tooLong = false;
	
	//show or hide counter wrap
	if ((hide) && (field.val().length==0)) $(wrap).css('visibility','hidden');
	else $(wrap).css('visibility','');
	
	if (field.val().length > limit) { 
		//too long
		tooLong = true;
		if (trim){
			field.val( field.val().substring(0, limit) );
			}
		// otherwise update characters remaining
	} else {
		$(feedbackArea).html(limit - field.val().length);
	}
	
	
	return tooLong;
  }
  
})(jQuery);