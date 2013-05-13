jQuery(document).ready(function() { 
	// auto blur text input
	var tempIT = jQuery(".AutoBlurText");
	if(tempIT.length) inputText(".AutoBlurText","NotInput");
	
	if(jQuery(".MbInputSt").length) {
		jQuery(".MbInputSt").bind("focus", function () {
			jQuery(this).closest(".MbInputWrap").addClass("MbFocusBg");
		});
		jQuery(".MbInputSt").bind("blur", function () {
			jQuery(this).closest(".MbInputWrap").removeClass("MbFocusBg");
		});
	}
	
	if(jQuery(".MbFrm").length > 0) {
		jQuery(".MbFrm").validate({
			rules: {
				first_name: "required",
				last_name: "required",
				email_address: {
					required: true,
					email: true
				},
				mailing_address: "required",
				zip_code: {
					required: true,
					maxlength: "5",
					digits: true
				}
			}
		});
	}
	
	if(jQuery(".OpepPopup").length > 0) {
		jQuery(".OpepPopup").colorbox(
		{
			onComplete:function(){
				jQuery('#cboxClose').fadeIn();
			},
			html: jQuery(".DASPopupContent").html()
		});
	}
});

function inputText(cssSel,NewInputClass){
	jQuery(cssSel).each(function(){
		var tagName = this.tagName.toLowerCase();
		var tempString = "";
		if(tagName=="textarea")
			tempString = this.title;
		else if(tagName=="input")
			tempString = this.alt;
		
		var maskObj = jQuery(this).prev();
		
		if(tempString!=""){
			if(jQuery(this).val()!="") {
				maskObj.text("");
			}
			jQuery(this).bind("blur",function(){
				if(jQuery(this).val()=="") {
					maskObj.text(tempString);
					jQuery(this).addClass(NewInputClass);
				}
			}).bind("focus",function(){
				if(maskObj.text()==tempString) {
					maskObj.text("");
					jQuery(this).removeClass(NewInputClass);
				}
			});
		}
	});
}
