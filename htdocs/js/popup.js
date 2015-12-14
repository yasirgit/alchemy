/***************************/
//@Author: Adrian "yEnS" Mato Gondelle
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
/***************************/
//jQuery.noConflict();
//SETTING UP OUR POPUP
//0 means disabled; 1 means enabled;
var popupStatus = 0;
var popupWkStatus = 0;
var popupBnStatus = 0;
var popupPlanStatus = 0;
var popupAddBucketStatus = 0;
var popupMeasureState = 0;
var popupGalleryView = 0;
var popupUploadView =0 ;
var popupTrackerView =0 ;
var popupReadView =0 ;
var popupTrackList =0 

//loading popup with jQuery magic!
function loadPopup(){
	//loads popup only if it is disabled
	if(popupStatus==0){
		$("#backgroundPopup").css({
			"opacity": "0.7"
		});
		$("#backgroundPopup").fadeIn("slow");
		$("#popupContact").fadeIn("slow");
		popupStatus = 1;
	}
}

//disabling popup with jQuery magic!
function disablePopup(){
	//disables popup only if it is enabled
	if(popupStatus==1){
		$("#backgroundPopup").fadeOut("slow");
		$("#popupContact").fadeOut("slow");
		popupStatus = 0;
	}
}

//centering popup
function centerPopup(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#popupContact").height();
	var popupWidth = $("#popupContact").width();
	//centering
	$("#popupContact").css({
		"position": "absolute",
		//"top": windowHeight/2-popupHeight/2,
		//"left": windowWidth/2-popupWidth/2
		"top":30,
		"left":100
	});
	//only need force for IE6
	
	$("#backgroundPopup").css({
		"height": windowHeight
	});
	
}
/*  ********************************************    */

//for 8 weeks goals
function loadWeekPopup(){
	//loads popup only if it is disabled
	if(popupWkStatus==0){
		$("#bgWeekPopup").css({
			"opacity": "0.7"
		});
		$("#bgWeekPopup").fadeIn("slow");
		$("#popupWeek").fadeIn("slow");
		popupWkStatus = 1;
	}
}


//disable week Popup
function disableWeekPopup(){
	//disables popup only if it is enabled
	if(popupWkStatus==1){
		$("#bgWeekPopup").fadeOut("slow");
		$("#popupWeek").fadeOut("slow");
		popupWkStatus = 0;
	}
}



//8 week center popup
function centerWeekPopup(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#popupWeek").height();
	var popupWidth = $("#popupWeek").width();
	//centering
	$("#popupWeek").css({
		"position": "absolute",
		//"top": windowHeight/2-popupHeight/2,
		//"left": windowWidth/2-popupWidth/2
		"top":30,
		"left":100
	});
	//only need force for IE6
	
	$("#bgWeekPopup").css({
		"height": windowHeight
	});
	
}

/*  ********************************************    */
//for Bonus goals
function loadBonusPopup(){
	//loads popup only if it is disabled
	if(popupBnStatus==0){
		$("#bgBonusPopup").css({
			"opacity": "0.7"
		});
		$("#bgBonusPopup").fadeIn("slow");
		$("#popup-bonus-goal").fadeIn("slow");
		popupBnStatus = 1;
	}
}


//disable week Popup
function disableBonusPopup(){
	//disables popup only if it is enabled
	if(popupBnStatus==1){
		$("#bgBonusPopup").fadeOut("slow");
		$("#popup-bonus-goal").fadeOut("slow");
		popupBnStatus = 0;
	}
}



//8 week center popup
function centerBonusPopup(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#popup-bonus-goal").height();
	var popupWidth = $("#popup-bonus-goal").width();
	//centering
	$("#popup-bonus-goal").css({
		"position": "absolute",
		//"top": windowHeight/2-popupHeight/2,
		//"left": windowWidth/2-popupWidth/2
		"top":30,
		"left":100
	});
	//only need force for IE6
	
	$("#bgBonusPopup").css({
		"height": windowHeight
	});
	
	
}

/*  ********************************************    */
//for Plans goals
function loadPlansPopup(){
	//loads popup only if it is disabled
	if(popupPlanStatus==0){
		$("#bgGoalPlanPopup").css({
			"opacity": "0.7"
		});
		$("#bgGoalPlanPopup").fadeIn("slow");
		$("#popup-plan-goal").fadeIn("slow");
		popupPlanStatus = 1;
	}
}


//disable plan Popup
function disablePlansPopup(){
	//disables popup only if it is enabled
	if(popupPlanStatus==1){
		$("#bgGoalPlanPopup").fadeOut("slow");
		$("#popup-plan-goal").fadeOut("slow");
		popupPlanStatus = 0;
	}
}



//Goal plan center popup
function centerPlansPopup(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#popup-plan-goal").height();
	var popupWidth = $("#popup-plan-goal").width();
	//centering
	$("#popup-plan-goal").css({
		"position": "absolute",
		//"top": windowHeight/2-popupHeight/2,
		//"left": windowWidth/2-popupWidth/2
		"top":30,
		"left":13
	});
	//only need force for IE6
	
	$("#bgGoalPlanPopup").css({
		"height": windowHeight
	});
	
}

/*  ********************************************    */
//for Add Buket List goals
function loadAddBucketPopup(){
	//loads popup only if it is disabled
	if(popupAddBucketStatus==0){
		$("#bgAddBuketPopup").css({
			"opacity": "0.7"
		});
		$("#bgAddBuketPopup").fadeIn("slow");
		$("#popup-bucketBox").fadeIn("slow");
		popupAddBucketStatus = 1;
	}
}


//disable add bucjet Popup
function disableAddBucketPopup(){
	//disables popup only if it is enabled
	if(popupAddBucketStatus==1){
		$("#bgAddBuketPopup").fadeOut("slow");
		$("#popup-bucketBox").fadeOut("slow");
		popupAddBucketStatus = 0;
	}
}



//Goal add bucket center popup
function centerAddBucketPopup(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#popup-bucketBox").height();
	var popupWidth = $("#popup-bucketBox").width();
	//centering
	$("#popup-bucketBox").css({
		"position": "absolute",
		//"top": windowHeight/2-popupHeight/2,
		//"left": windowWidth/2-popupWidth/2
		"top":100,
		"left":100
	});
	//only need force for IE6
	
	$("#bgAddBuketPopup").css({
		"height": windowHeight
	});
	
}

/*  ********************************************    */
function loadMeasurePopup(){
	//loads popup only if it is disabled
	if(popupMeasureState==0){
		$("#bgMeasurePopup").css({
			"opacity": "0.7"
		});
		$("#bgMeasurePopup").fadeIn("slow");
		$("#popup-measurement").fadeIn("slow");
		popupMeasureState = 1;
	}
}

//disabling popup with jQuery magic!
function disableMeasurePopup(){
	//disables popup only if it is enabled
	if(popupMeasureState==1){
		$("#bgMeasurePopup").fadeOut("slow");
		$("#popup-measurement").fadeOut("slow");
		popupMeasureState = 0;
	}
}

//centering popup
function centerMeasurePopup(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#popup-measurement").height();
	var popupWidth = $("#popup-measurement").width();
	//centering
	$("#popup-measurement").css({
		"position": "absolute",
		//"top": windowHeight/2-popupHeight/2,
		"top":100,
		"left": windowWidth/2-popupWidth/2
		
	});
	//only need force for IE6
	
	$("#bgMeasurePopup").css({
		"height": windowHeight
	});
	
}
/*  ********************************************    */

//for gallery view goals
function loadGalleryPopup(){
	//loads popup only if it is disabled
	if(popupGalleryView==0){
		$("#bgGalViewPopup").css({
			"opacity": "0.7"
		});
		$("#bgGalViewPopup").fadeIn("slow");
		$("#popup_gview").fadeIn("slow");
		popupGalleryView = 1;
	}
}


//disable week Popup
function disableGalleryPopup(){
	//disables popup only if it is enabled
	if(popupGalleryView==1){
		$("#bgGalViewPopup").fadeOut("slow");
		$("#popup_gview").fadeOut("slow");
		popupGalleryView = 0;
	}
}



//8 week center popup
function centerGalleryPopup(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#popup_gview").height();
	var popupWidth = $("#popup_gview").width();
	//centering
	$("#popup_gview").css({
		"position": "absolute",
		//"top": windowHeight/2-popupHeight/2,
		//"left": windowWidth/2-popupWidth/2
		"top":420,
		"left":20
	});
	//only need force for IE6
	
	$("#bgGalViewPopup").css({
		"height": windowHeight
	});
	
}

/*  ********************************************    */

//for Upload-gallery popup
function loadUploadPopup(){
	//loads popup only if it is disabled
	if(popupUploadView==0){
		$("#bgUploadPopup").css({
			"opacity": "0.7"
		});
		$("#bgUploadPopup").fadeIn("slow");
		$("#popup_upload").fadeIn("slow");
		popupUploadView = 1;
	}
}


//disable week Popup
function disableUploadPopup(){
	//disables popup only if it is enabled
	if(popupUploadView==1){
		$("#bgUploadPopup").fadeOut("slow");
		$("#popup_upload").fadeOut("slow");
		popupUploadView = 0;
	}
}



//8 week center popup
function centerUploadPopup(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#popup_upload").height();
	var popupWidth = $("#popup_upload").width();
	//centering
	$("#popup_upload").css({
		"position": "absolute",
		//"top": windowHeight/2-popupHeight/2,
		//"left": windowWidth/2-popupWidth/2
		"top":650,
		"left":20
	});
	//only need force for IE6
	
	$("#bgUploadPopup").css({
		"height": windowHeight
	});
	
}

/* *******************Compliment Tracker*************************   */

//for gallery view goals
function loadTrackerPopup(){
	//loads popup only if it is disabled
	if(popupTrackerView==0){
		$("#bgTrackerPopup").css({
			"opacity": "0.7"
		});
		$("#bgTrackerPopup").fadeIn("slow");
		$("#compli_track_popup").fadeIn("slow");
		popupTrackerView = 1;
	}
}


//disable week Popup
function disableTrackerPopup(){
	//disables popup only if it is enabled
	if(popupTrackerView==1){
		$("#bgTrackerPopup").fadeOut("slow");
		$("#compli_track_popup").fadeOut("slow");
		popupTrackerView = 0;
	}
}



//8 week center popup
function centerTrackerPopup(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#compli_track_popup").height();
	var popupWidth = $("#compli_track_popup").width();
	//centering
	$("#compli_track_popup").css({
		"position": "absolute",
		//"top": windowHeight/2-popupHeight/2,
		//"left": windowWidth/2-popupWidth/2
		"top":260,
		"left":50

	});
	//only need force for IE6
	
	$("#bgTrackerPopup").css({
		"height": windowHeight
	});
	
}

/*   ********************************************       */


/* *******************List  Tracker*************************   */

//for gallery view goals
function loadListTracker(){
	//loads popup only if it is disabled
	if(popupTrackList==0){
		$("#bgTrackerList").css({
			"opacity": "0.7"
		});
		$("#bgTrackerList").fadeIn("slow");
		$("#popup_tracker_list").fadeIn("slow");
		popupTrackList = 1;
	}
}


//disable week Popup
function disableListTracker(){
	//disables popup only if it is enabled
	if(popupTrackList==1){
		$("#bgTrackerList").fadeOut("slow");
		$("#popup_tracker_list").fadeOut("slow");
		popupTrackList = 0;
	}
}



//8 week center popup
function centerListTracker(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#popup_tracker_list").height();
	var popupWidth = $("#popup_tracker_list").width();
	//centering
	$("#popup_tracker_list").css({
		"position": "absolute",
		//"top": windowHeight/2-popupHeight/2,
		//"left": windowWidth/2-popupWidth/2
		"top":260,
		"left":50

	});
	//only need force for IE6
	
	$("#bgTrackerList").css({
		"height": windowHeight
	});
	
}

/*   ********************************************       */

/*  ********************************************    */
/*         ********************************************      */

//CONTROLLING EVENTS IN jQuery
$(document).ready(function(){
	
	//LOADING POPUP
	//Click the button event!
	$("#return-to").click(function(){
		//centering with css
		centerPopup();
		//load popup
		loadPopup();
	});
	
	$("#return-uedit").click(function(){
		//centering with css
		centerPopup();
		//load popup
		loadPopup();
	});
	
	$("#return-week").click(function(){
		//centering with css
		centerWeekPopup();
		//load popup
		loadWeekPopup();
	});
	
	$("#return-weekedit").click(function(){
		//centering with css
		centerWeekPopup();
		//load popup
		loadWeekPopup();
	});
	
	$("#return-bonus").click(function(){
		//centering with css
		centerBonusPopup();
		//load popup
		loadBonusPopup();
	});
	$("#return-bonus-edit").click(function(){
		//centering with css
		centerBonusPopup();
		//load popup
		loadBonusPopup();
	});
			
    $("#return-addBucketList").click(function(){
		//centering with css
		centerAddBucketPopup();
		//load popup
		loadAddBucketPopup();
	});
	$("#edit_bucket").click(function(){
		//centering with css
		centerAddBucketPopup();
		//load popup
		loadAddBucketPopup();
	});
	
	$("#return_gview").click(function(){
		//centering with css
		centerGalleryPopup();
		//load popup
		loadGalleryPopup();
	});
	
	$("#return-measure1").click(function(){
		//centering with css
		centerMeasurePopup();
		//load popup
		loadMeasurePopup();
	});
	$("#return-measure2").click(function(){
		//centering with css
		centerMeasurePopup();
		//load popup
		loadMeasurePopup();
	});
	$("#return-measure3").click(function(){
		//centering with css
		centerMeasurePopup();
		//load popup
		loadMeasurePopup();
	});
	
	$("#return_upload").click(function(){
		//centering with css
		centerUploadPopup();
		//load popup
		loadUploadPopup();
	});
	
	$("#return_tracker").click(function(){
		//centering with css
		centerTrackerPopup();
		//load popup
		loadTrackerPopup();
	});
	
	$("#return_list").click(function(){
		//centering with css
		centerListTracker();
		//load popup
		loadListTracker();
	});

				
	//CLOSING POPUP
	//Click the x event!
	//$(".close, .btn input:first").click(function(){
	$(".close").click(function(){											 
		disablePopup();
		disableWeekPopup();
		disableBonusPopup();
		disablePlansPopup();
		disableAddBucketPopup();
		disableMeasurePopup();
		disableGalleryPopup();
		disableUploadPopup();
		disableTrackerPopup();
		disableReadMorePopup();
		disableListTracker();
		return false;
	});
	$('.close2').live('click',
					  function(){	
								
		disablePopup();
		disableWeekPopup();
		disableBonusPopup();
		disablePlansPopup();
		disableAddBucketPopup();
		disableMeasurePopup();
		disableUploadPopup();
		disableTrackerPopup();
		disableReadMorePopup();
		disableListTracker();
		return false;
	});
	
	//Click out event!
	$("#backgroundPopup").click(function(){
		disablePopup();
	});
		//Click out event!
	$("#bgWeekPopup").click(function(){
		disableWeekPopup();
	});
	$("#bgBonusPopup").click(function(){
		disableBonusPopup();
	});
	
	$("#bgGoalPlanPopup").click(function(){
		disablePlansPopup();
	});
	
	$("#bgAddBuketPopup").click(function(){
		disableAddBucketPopup();
	});
	$("#bgMeasurePopup").click(function(){
		disableMeasurePopup();
	});
	$("#bgGalViewPopup").click(function(){
		disableMeasurePopup();
	});
	
    $("#bgUploadPopup").click(function(){	
	   disableUploadPopup();
	
	});
	
	 $("#bgTrackerPopup").click(function(){	
	   disableTrackerPopup();
	
	});
	 
	 $("#bgReadMorePopup").click(function(){	 
	   disableReadMorePopup();
	 });
	 
	 $("#bgTrackerList").click(function(){	
	    disableListTracker();
	});	
	//Press Escape event!
	$(document).keypress(function(e){
		if(e.keyCode==27 && popupStatus==1){
			disablePopup();
			disableWeekPopup();
			disableBonusPopup();
			disablePlansPopup();
			disableAddBucketPopup();
			disableMeasurePopup();
			disableGalleryPopup();
			disableListTracker();
		}
	});
	
	$("#usave").click(function(){
		$('#ulti').submit();
										 
	});
	
	$("#weekGl").click(function(){
		$('#wGoal').submit();
										 
	});


});