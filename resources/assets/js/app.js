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

		var validateForm = function(form){

			$(form).find('.alert.alert-danger').remove();

			//validate principal
			var $el = $('#principal');
			var patt = /^((\d+)|(\d{1,3})(\,\d{3}|)*)(\.\d{2}|)$/;
			var hasError = false;
			var message = "";
			if(!patt.test($el.val())){
				$el.closest('.form-group').addClass('has-error');
				message += "The value you entered for the principal is invalid. Please use only a valid monetary value with no more than 2 decimal places.<br>";
				hasError = true;
			}else{
				$el.closest('.form-group').removeClass('has-error');
			}

			//validate term-length
			$el = $('#term-length');
			patt = /^\d+$/;
			if(!patt.test($el.val())){
				$el.closest('.form-group').addClass('has-error');
				message += "The value you entered for the term length is invalid. Please enter only numerical digits.<br>";
				hasError = true;
			}else{
				$el.closest('.form-group').removeClass('has-error');
			}

			//validate interest rate
			patt = /^(\d{1,3})(\.\d{1,4}|)$|^(\d{0,3})(\.\d{1,4})$/;
			$el = $('#rate');
			if(!patt.test($el.val()) || $el.val() > 100 || $el.val() < .0001){
				$el.closest('.form-group').addClass('has-error');
				message += "The value you entered for the loan rate is invalid. Please enter only values between .0001 and 100.<br>";
				hasError = true;
			}else{
				$el.closest('.form-group').removeClass('has-error');
			}

			if(hasError){
				$(form).find('.has-error:first').find('.form-control:first').focus().select();
				$(form).append("<div class='alert alert-danger alert-dismissible fade in' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>You have an errors in your input. They have been hilighted in the form.<br>"+message+"</div>");
			}

			return !hasError;
		}

		var submitted = false;
		//set up a validator for the form...
		$('#calcForm').on('submit',function(e){

			submitted = true;

			var isValid = validateForm(this);

			return isValid;
		});

		//set up the form to submit any time a value changes once the form has been submitted once.
		$('.form-control').on('change', function(){
			if(submitted){
				validateForm($(this).closest('form'));
			}
		});


	});
});

