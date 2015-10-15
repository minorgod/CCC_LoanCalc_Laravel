/**
 * Created by Brett Brewer on 9/22/2015.
 * You may need to make sure this file loads after JQuery
 */
function checkJQueryLoaded(){
	if(typeof jQuery === "undefined"){
		setTimeout(checkJQueryLoaded,50);
		return;
	}

	if(jQuery.isReady === true){
		if(typeof window.fireEvent !== "undefined"){
			//stupid IE 8 and lower
			window.fireEvent("onJQueryLoaded", window.JQueryLoaded);
		}else{
			window.dispatchEvent(window.JQueryLoaded);
		}
		return;
	}
	setTimeout(checkJQueryLoaded,50);
}
checkJQueryLoaded();


/**
* Stupid Windows Phone 8 fixes
*/

// Copyright 2014-2015 Twitter, Inc.
// Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
	var msViewportStyle = document.createElement('style')
	msViewportStyle.appendChild(
			document.createTextNode(
					'@-ms-viewport{width:auto!important}'
			)
	)
	document.querySelector('head').appendChild(msViewportStyle)
}


window.addEventListener('JQueryLoaded', function (e) {
	$(function () {

		//enable any tooltips
		$('[data-toggle="tooltip"]').tooltip();

		/**
		 * Stupid Android Stock Browser fix for select form control
		 */
		var nua = navigator.userAgent
		var isAndroid = (nua.indexOf('Mozilla/5.0') > -1 && nua.indexOf('Android ') > -1 && nua.indexOf('AppleWebKit') > -1 && nua.indexOf('Chrome') === -1)
		if (isAndroid) {
			$('select.form-control').removeClass('form-control').css('width', '100%')
		}
	});
});

