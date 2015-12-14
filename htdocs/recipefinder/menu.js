function initPage() {
	initNavIndexes();
}
function initNavIndexes()
{
	var nav = document.getElementById("tabset");
	if(nav) {
		var lis = nav.getElementsByTagName("li");
		for (var i=0; i<lis.length; i++) {
			//lis[i].style.zIndex = i+1;
			lis[i].style.zIndex = lis.length-i;
		}
	}
}
if (window.addEventListener)
	window.addEventListener("load", initPage, false);
else if (window.attachEvent)
	window.attachEvent("onload", initPage)