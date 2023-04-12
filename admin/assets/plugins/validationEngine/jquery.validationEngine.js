!function(e){"use strict";var t={init:function(a){return this.data("jqv")&&null!=this.data("jqv")||(a=t._saveOptions(this,a),e(document).on("click",".formError",function(){e(this).fadeOut(150,function(){e(this).closest(".formError").remove()})})),this},attach:function(a){var r;return(r=a?t._saveOptions(this,a):this.data("jqv")).validateAttribute=this.find("[data-validation-engine*=validate]").length?"data-validation-engine":"class",r.binded&&(this.on(r.validationEventTrigger,"["+r.validateAttribute+"*=validate]:not([type=checkbox]):not([type=radio]):not(.datepicker)",t._onFieldEvent),this.on("click","["+r.validateAttribute+"*=validate][type=checkbox],["+r.validateAttribute+"*=validate][type=radio]",t._onFieldEvent),this.on(r.validationEventTrigger,"["+r.validateAttribute+"*=validate][class*=datepicker]",{delay:300},t._onFieldEvent)),r.autoPositionUpdate&&e(window).bind("resize",{noAnimation:!0,formElem:this},t.updatePromptsPosition),this.on("click","a[data-validation-engine-skip], a[class*='validate-skip'], button[data-validation-engine-skip], button[class*='validate-skip'], input[data-validation-engine-skip], input[class*='validate-skip']",t._submitButtonClick),this.removeData("jqv_submitButton"),this.on("submit",t._onSubmitEvent),this},detach:function(){var a=this.data("jqv");return this.off(a.validationEventTrigger,"["+a.validateAttribute+"*=validate]:not([type=checkbox]):not([type=radio]):not(.datepicker)",t._onFieldEvent),this.off("click","["+a.validateAttribute+"*=validate][type=checkbox],["+a.validateAttribute+"*=validate][type=radio]",t._onFieldEvent),this.off(a.validationEventTrigger,"["+a.validateAttribute+"*=validate][class*=datepicker]",t._onFieldEvent),this.off("submit",t._onSubmitEvent),this.removeData("jqv"),this.off("click","a[data-validation-engine-skip], a[class*='validate-skip'], button[data-validation-engine-skip], button[class*='validate-skip'], input[data-validation-engine-skip], input[class*='validate-skip']",t._submitButtonClick),this.removeData("jqv_submitButton"),a.autoPositionUpdate&&e(window).off("resize",t.updatePromptsPosition),this},validate:function(a){var r,i=e(this),o=null;if(i.is("form")||i.hasClass("validationEngineContainer")){if(i.hasClass("validating"))return!1;i.addClass("validating"),r=a?t._saveOptions(i,a):i.data("jqv");o=t._validateFields(this);setTimeout(function(){i.removeClass("validating")},100),o&&r.onSuccess?r.onSuccess():!o&&r.onFailure&&r.onFailure()}else{if(!i.is("form")&&!i.hasClass("validationEngineContainer")){var s=i.closest("form, .validationEngineContainer");return r=s.data("jqv")?s.data("jqv"):e.validationEngine.defaults,(o=t._validateField(i,r))&&r.onFieldSuccess?r.onFieldSuccess():r.onFieldFailure&&r.InvalidFields.length>0&&r.onFieldFailure(),!o}i.removeClass("validating")}return r.onValidationComplete?!!r.onValidationComplete(s,o):o},updatePromptsPosition:function(a){if(a&&this==window)var r=a.data.formElem,i=a.data.noAnimation;else r=e(this.closest("form, .validationEngineContainer"));var o=r.data("jqv");return o||(o=t._saveOptions(r,o)),r.find("["+o.validateAttribute+"*=validate]").not(":disabled").each(function(){var a=e(this);o.prettySelect&&a.is(":hidden")&&(a=r.find("#"+o.usePrefix+a.attr("id")+o.useSuffix));var s=t._getPrompt(a),n=e(s).find(".formErrorContent").html();s&&t._updatePrompt(a,e(s),n,void 0,!1,o,i)}),this},showPrompt:function(e,a,r,i){var o=this.closest("form, .validationEngineContainer").data("jqv");return o||(o=t._saveOptions(this,o)),r&&(o.promptPosition=r),o.showArrow=1==i,t._showPrompt(this,e,a,!1,o),this},hide:function(){var a=e(this).closest("form, .validationEngineContainer"),r=a.data("jqv");r||(r=t._saveOptions(a,r));var i,o=r&&r.fadeDuration?r.fadeDuration:.3;return i=a.is("form")||a.hasClass("validationEngineContainer")?"parentForm"+t._getClassName(e(a).attr("id")):t._getClassName(e(a).attr("id"))+"formError",e("."+i).fadeTo(o,0,function(){e(this).closest(".formError").remove()}),this},hideAll:function(){var t=this.data("jqv"),a=t?t.fadeDuration:300;return e(".formError").fadeTo(a,0,function(){e(this).closest(".formError").remove()}),this},_onFieldEvent:function(a){var r=e(this),i=r.closest("form, .validationEngineContainer"),o=i.data("jqv");o||(o=t._saveOptions(i,o)),o.eventTrigger="field",1==o.notEmpty?r.val().length>0&&window.setTimeout(function(){t._validateField(r,o)},a.data?a.data.delay:0):window.setTimeout(function(){t._validateField(r,o)},a.data?a.data.delay:0)},_onSubmitEvent:function(){var a=e(this),r=a.data("jqv");if(a.data("jqv_submitButton")){var i=e("#"+a.data("jqv_submitButton"));if(i&&i.length>0&&(i.hasClass("validate-skip")||"true"==i.attr("data-validation-engine-skip")))return!0}r.eventTrigger="submit";var o=t._validateFields(a);return o&&r.ajaxFormValidation?(t._validateFormWithAjax(a,r),!1):r.onValidationComplete?!!r.onValidationComplete(a,o):o},_checkAjaxStatus:function(t){var a=!0;return e.each(t.ajaxValidCache,function(e,t){if(!t)return a=!1,!1}),a},_checkAjaxFieldStatus:function(e,t){return 1==t.ajaxValidCache[e]},_validateFields:function(a){var r=a.data("jqv"),i=!1;a.trigger("jqv.form.validating");var o=null;if(a.find("["+r.validateAttribute+"*=validate]").not(":disabled").each(function(){var s=e(this),n=[];if(e.inArray(s.attr("name"),n)<0){if((i|=t._validateField(s,r))&&null==o&&(s.is(":hidden")&&r.prettySelect?o=s=a.find("#"+r.usePrefix+t._jqSelector(s.attr("id"))+r.useSuffix):(s.data("jqv-prompt-at")instanceof jQuery?s=s.data("jqv-prompt-at"):s.data("jqv-prompt-at")&&(s=e(s.data("jqv-prompt-at"))),o=s)),r.doNotShowAllErrosOnSubmit)return!1;if(n.push(s.attr("name")),1==r.showOneMessage&&i)return!1}}),a.trigger("jqv.form.result",[i]),i){if(r.scroll){var s=o.offset().top,n=o.offset().left,l=r.promptPosition;if("string"==typeof l&&-1!=l.indexOf(":")&&(l=l.substring(0,l.indexOf(":"))),"bottomRight"!=l&&"bottomLeft"!=l){var d=t._getPrompt(o);d&&(s=d.offset().top)}if(r.scrollOffset&&(s-=r.scrollOffset),r.isOverflown){var u=e(r.overflownDIV);if(!u.length)return!1;s+=u.scrollTop()+-parseInt(u.offset().top)-5,e(r.overflownDIV).filter(":not(:animated)").animate({scrollTop:s},1100,function(){r.focusFirstField&&o.focus()})}else e("html, body").animate({scrollTop:s},1100,function(){r.focusFirstField&&o.focus()}),e("html, body").animate({scrollLeft:n},1100)}else r.focusFirstField&&o.focus();return!1}return!0},_validateFormWithAjax:function(a,r){var i=a.serialize(),o=r.ajaxFormValidationMethod?r.ajaxFormValidationMethod:"GET",s=r.ajaxFormValidationURL?r.ajaxFormValidationURL:a.attr("action"),n=r.dataType?r.dataType:"json";e.ajax({type:o,url:s,cache:!1,dataType:n,data:i,form:a,methods:t,options:r,beforeSend:function(){return r.onBeforeAjaxFormValidation(a,r)},error:function(e,a){r.onFailure?r.onFailure(e,a):t._ajaxError(e,a)},success:function(i){if("json"==n&&!0!==i){for(var o=!1,s=0;s<i.length;s++){var l=i[s],d=l[0],u=e(e("#"+d)[0]);if(1==u.length){var c=l[2];if(1==l[1])if(""!=c&&c){if(r.allrules[c])(f=r.allrules[c].alertTextOk)&&(c=f);r.showPrompts&&t._showPrompt(u,c,"pass",!1,r,!0)}else t._closePrompt(u);else{var f;if(o|=!0,r.allrules[c])(f=r.allrules[c].alertText)&&(c=f);r.showPrompts&&t._showPrompt(u,c,"",!1,r,!0)}}}r.onAjaxFormComplete(!o,a,i,r)}else r.onAjaxFormComplete(!0,a,i,r)}})},_validateField:function(a,r,i){if(a.attr("id")||(a.attr("id","form-validation-field-"+e.validationEngine.fieldIdCounter),++e.validationEngine.fieldIdCounter),a.hasClass(r.ignoreFieldsWithClass))return!1;if(!r.validateNonVisibleFields&&(a.is(":hidden")&&!r.prettySelect||a.parent().is(":hidden")))return!1;var o=a.attr(r.validateAttribute),s=/validate\[(.*)\]/.exec(o);if(!s)return!1;var n=s[1],l=n.split(/\[|,|\]/),d=a.attr("name"),u="",c="",f=!1,v=!1;r.isError=!1,r.showArrow=1==r.showArrow,r.maxErrorsPerField>0&&(v=!0);for(var p=e(a.closest("form, .validationEngineContainer")),m=0;m<l.length;m++)l[m]=l[m].toString().replace(" ",""),""===l[m]&&delete l[m];m=0;for(var g=0;m<l.length;m++){if(v&&g>=r.maxErrorsPerField){if(!f){var h=e.inArray("required",l);f=-1!=h&&h>=m}break}var x=void 0;switch(l[m]){case"required":f=!0,x=t._getErrorMessage(p,a,l[m],l,m,r,t._required);break;case"custom":x=t._getErrorMessage(p,a,l[m],l,m,r,t._custom);break;case"groupRequired":var _="["+r.validateAttribute+"*="+l[m+1]+"]",C=p.find(_).eq(0);C[0]!=a[0]&&(t._validateField(C,r,i),r.showArrow=!0),(x=t._getErrorMessage(p,a,l[m],l,m,r,t._groupRequired))&&(f=!0),r.showArrow=!1;break;case"ajax":(x=t._ajax(a,l,m,r))&&(c="load");break;case"minSize":x=t._getErrorMessage(p,a,l[m],l,m,r,t._minSize);break;case"maxSize":x=t._getErrorMessage(p,a,l[m],l,m,r,t._maxSize);break;case"min":x=t._getErrorMessage(p,a,l[m],l,m,r,t._min);break;case"max":x=t._getErrorMessage(p,a,l[m],l,m,r,t._max);break;case"past":x=t._getErrorMessage(p,a,l[m],l,m,r,t._past);break;case"future":x=t._getErrorMessage(p,a,l[m],l,m,r,t._future);break;case"dateRange":_="["+r.validateAttribute+"*="+l[m+1]+"]";r.firstOfGroup=p.find(_).eq(0),r.secondOfGroup=p.find(_).eq(1),(r.firstOfGroup[0].value||r.secondOfGroup[0].value)&&(x=t._getErrorMessage(p,a,l[m],l,m,r,t._dateRange)),x&&(f=!0),r.showArrow=!1;break;case"dateTimeRange":_="["+r.validateAttribute+"*="+l[m+1]+"]";r.firstOfGroup=p.find(_).eq(0),r.secondOfGroup=p.find(_).eq(1),(r.firstOfGroup[0].value||r.secondOfGroup[0].value)&&(x=t._getErrorMessage(p,a,l[m],l,m,r,t._dateTimeRange)),x&&(f=!0),r.showArrow=!1;break;case"maxCheckbox":a=e(p.find("input[name='"+d+"']")),x=t._getErrorMessage(p,a,l[m],l,m,r,t._maxCheckbox);break;case"minCheckbox":a=e(p.find("input[name='"+d+"']")),x=t._getErrorMessage(p,a,l[m],l,m,r,t._minCheckbox);break;case"equals":x=t._getErrorMessage(p,a,l[m],l,m,r,t._equals);break;case"funcCall":x=t._getErrorMessage(p,a,l[m],l,m,r,t._funcCall);break;case"creditCard":x=t._getErrorMessage(p,a,l[m],l,m,r,t._creditCard);break;case"condRequired":void 0!==(x=t._getErrorMessage(p,a,l[m],l,m,r,t._condRequired))&&(f=!0);break;case"funcCallRequired":void 0!==(x=t._getErrorMessage(p,a,l[m],l,m,r,t._funcCallRequired))&&(f=!0)}var b=!1;if("object"==typeof x)switch(x.status){case"_break":b=!0;break;case"_error":x=x.message;break;case"_error_no_prompt":return!0}if(0==m&&0==n.indexOf("funcCallRequired")&&void 0!==x&&(""!=u&&(u+="<br/>"),u+=x,r.isError=!0,g++,b=!0),b)break;"string"==typeof x&&(""!=u&&(u+="<br/>"),u+=x,r.isError=!0,g++)}!f&&!a.val()&&a.val().length<1&&e.inArray("equals",l)<0&&(r.isError=!1);var E=a.prop("type"),T=a.data("promptPosition")||r.promptPosition;("radio"==E||"checkbox"==E)&&p.find("input[name='"+d+"']").length>1&&(a=e("inline"===T?p.find("input[name='"+d+"'][type!=hidden]:last"):p.find("input[name='"+d+"'][type!=hidden]:first")),r.showArrow=r.showArrowOnRadioAndCheckbox),a.is(":hidden")&&r.prettySelect&&(a=p.find("#"+r.usePrefix+t._jqSelector(a.attr("id"))+r.useSuffix)),r.isError&&r.showPrompts?t._showPrompt(a,u,c,!1,r):t._closePrompt(a),a.trigger("jqv.field.result",[a,r.isError,u]);var F=e.inArray(a[0],r.InvalidFields);return-1==F?r.isError&&r.InvalidFields.push(a[0]):r.isError||r.InvalidFields.splice(F,1),t._handleStatusCssClasses(a,r),r.isError&&r.onFieldFailure&&r.onFieldFailure(a),!r.isError&&r.onFieldSuccess&&r.onFieldSuccess(a),r.isError},_handleStatusCssClasses:function(e,t){t.addSuccessCssClassToField&&e.removeClass(t.addSuccessCssClassToField),t.addFailureCssClassToField&&e.removeClass(t.addFailureCssClassToField),t.addSuccessCssClassToField&&!t.isError&&e.addClass(t.addSuccessCssClassToField),t.addFailureCssClassToField&&t.isError&&e.addClass(t.addFailureCssClassToField)},_getErrorMessage:function(a,r,i,o,s,n,l){var d=jQuery.inArray(i,o);"custom"!==i&&"funcCall"!==i&&"funcCallRequired"!==i||(i=i+"["+o[d+1]+"]",delete o[d]);var u,c=i,f=(r.attr("data-validation-engine")?r.attr("data-validation-engine"):r.attr("class")).split(" ");if(null!=(u="future"==i||"past"==i||"maxCheckbox"==i||"minCheckbox"==i?l(a,r,o,s,n):l(r,o,s,n))){var v=t._getCustomErrorMessage(e(r),f,c,n);v&&(u=v)}return u},_getCustomErrorMessage:function(e,a,r,i){var o=!1,s=/^custom\[.*\]$/.test(r)?t._validityProp.custom:t._validityProp[r];if(null!=s&&null!=(o=e.attr("data-errormessage-"+s)))return o;if(null!=(o=e.attr("data-errormessage")))return o;var n="#"+e.attr("id");if(void 0!==i.custom_error_messages[n]&&void 0!==i.custom_error_messages[n][r])o=i.custom_error_messages[n][r].message;else if(a.length>0)for(var l=0;l<a.length&&a.length>0;l++){var d="."+a[l];if(void 0!==i.custom_error_messages[d]&&void 0!==i.custom_error_messages[d][r]){o=i.custom_error_messages[d][r].message;break}}return o||void 0===i.custom_error_messages[r]||void 0===i.custom_error_messages[r].message||(o=i.custom_error_messages[r].message),o},_validityProp:{required:"value-missing",custom:"custom-error",groupRequired:"value-missing",ajax:"custom-error",minSize:"range-underflow",maxSize:"range-overflow",min:"range-underflow",max:"range-overflow",past:"type-mismatch",future:"type-mismatch",dateRange:"type-mismatch",dateTimeRange:"type-mismatch",maxCheckbox:"range-overflow",minCheckbox:"range-underflow",equals:"pattern-mismatch",funcCall:"custom-error",funcCallRequired:"custom-error",creditCard:"pattern-mismatch",condRequired:"value-missing"},_required:function(t,a,r,i,o){switch(t.prop("type")){case"radio":case"checkbox":if(o){if(!t.prop("checked"))return i.allrules[a[r]].alertTextCheckboxMultiple;break}var s=t.closest("form, .validationEngineContainer"),n=t.attr("name");if(0==s.find("input[name='"+n+"']:checked").length)return 1==s.find("input[name='"+n+"']:visible").length?i.allrules[a[r]].alertTextCheckboxe:i.allrules[a[r]].alertTextCheckboxMultiple;break;case"text":case"password":case"textarea":case"file":case"select-one":case"select-multiple":default:var l=e.trim(t.val()),d=e.trim(t.attr("data-validation-placeholder")),u=e.trim(t.attr("placeholder"));if(!l||d&&l==d||u&&l==u)return i.allrules[a[r]].alertText}},_groupRequired:function(a,r,i,o){var s="["+o.validateAttribute+"*="+r[i+1]+"]",n=!1;if(a.closest("form, .validationEngineContainer").find(s).each(function(){if(!t._required(e(this),r,i,o))return n=!0,!1}),!n)return o.allrules[r[i]].alertText},_custom:function(e,t,a,r){var i,o=t[a+1],s=r.allrules[o];if(s)if(s.regex){var n=s.regex;if(!n)return void alert("jqv:custom regex not found - "+o);if(!new RegExp(n).test(e.val()))return r.allrules[o].alertText}else{if(!s.func)return void alert("jqv:custom type not allowed "+o);if("function"!=typeof(i=s.func))return void alert("jqv:custom parameter 'function' is no function - "+o);if(!i(e,t,a,r))return r.allrules[o].alertText}else alert("jqv:custom rule not found - "+o)},_funcCall:function(e,t,a,r){var i,o=t[a+1];if(o.indexOf(".")>-1){for(var s=o.split("."),n=window;s.length;)n=n[s.shift()];i=n}else i=window[o]||r.customFunctions[o];if("function"==typeof i)return i(e,t,a,r)},_funcCallRequired:function(e,a,r,i){return t._funcCall(e,a,r,i)},_equals:function(t,a,r,i){var o=a[r+1];if(t.val()!=e("#"+o).val())return i.allrules.equals.alertText},_maxSize:function(e,t,a,r){var i=t[a+1];if(e.val().length>i){var o=r.allrules.maxSize;return o.alertText+i+o.alertText2}},_minSize:function(e,t,a,r){var i=t[a+1];if(e.val().length<i){var o=r.allrules.minSize;return o.alertText+i+o.alertText2}},_min:function(e,t,a,r){var i=parseFloat(t[a+1]);if(parseFloat(e.val())<i){var o=r.allrules.min;return o.alertText2?o.alertText+i+o.alertText2:o.alertText+i}},_max:function(e,t,a,r){var i=parseFloat(t[a+1]);if(parseFloat(e.val())>i){var o=r.allrules.max;return o.alertText2?o.alertText+i+o.alertText2:o.alertText+i}},_past:function(a,r,i,o,s){var n,l=i[o+1],d=e(a.find("*[name='"+l.replace(/^#+/,"")+"']"));if("now"==l.toLowerCase())n=new Date;else if(null!=d.val()){if(d.is(":disabled"))return;n=t._parseDate(d.val())}else n=t._parseDate(l);if(t._parseDate(r.val())>n){var u=s.allrules.past;return u.alertText2?u.alertText+t._dateToString(n)+u.alertText2:u.alertText+t._dateToString(n)}},_future:function(a,r,i,o,s){var n,l=i[o+1],d=e(a.find("*[name='"+l.replace(/^#+/,"")+"']"));if("now"==l.toLowerCase())n=new Date;else if(null!=d.val()){if(d.is(":disabled"))return;n=t._parseDate(d.val())}else n=t._parseDate(l);if(t._parseDate(r.val())<n){var u=s.allrules.future;return u.alertText2?u.alertText+t._dateToString(n)+u.alertText2:u.alertText+t._dateToString(n)}},_isDate:function(e){return new RegExp(/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(?:(?:0?[1-9]|1[0-2])(\/|-)(?:0?[1-9]|1\d|2[0-8]))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(0?2(\/|-)29)(\/|-)(?:(?:0[48]00|[13579][26]00|[2468][048]00)|(?:\d\d)?(?:0[48]|[2468][048]|[13579][26]))$/).test(e)},_isDateTime:function(e){return new RegExp(/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1}$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^((1[012]|0?[1-9]){1}\/(0?[1-9]|[12][0-9]|3[01]){1}\/\d{2,4}\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1})$/).test(e)},_dateCompare:function(e,t){return new Date(e.toString())<new Date(t.toString())},_dateRange:function(e,a,r,i){return!i.firstOfGroup[0].value&&i.secondOfGroup[0].value||i.firstOfGroup[0].value&&!i.secondOfGroup[0].value?i.allrules[a[r]].alertText+i.allrules[a[r]].alertText2:t._isDate(i.firstOfGroup[0].value)&&t._isDate(i.secondOfGroup[0].value)&&t._dateCompare(i.firstOfGroup[0].value,i.secondOfGroup[0].value)?void 0:i.allrules[a[r]].alertText+i.allrules[a[r]].alertText2},_dateTimeRange:function(e,a,r,i){return!i.firstOfGroup[0].value&&i.secondOfGroup[0].value||i.firstOfGroup[0].value&&!i.secondOfGroup[0].value?i.allrules[a[r]].alertText+i.allrules[a[r]].alertText2:t._isDateTime(i.firstOfGroup[0].value)&&t._isDateTime(i.secondOfGroup[0].value)&&t._dateCompare(i.firstOfGroup[0].value,i.secondOfGroup[0].value)?void 0:i.allrules[a[r]].alertText+i.allrules[a[r]].alertText2},_maxCheckbox:function(e,t,a,r,i){var o=a[r+1],s=t.attr("name");if(e.find("input[name='"+s+"']:checked").length>o)return i.showArrow=!1,i.allrules.maxCheckbox.alertText2?i.allrules.maxCheckbox.alertText+" "+o+" "+i.allrules.maxCheckbox.alertText2:i.allrules.maxCheckbox.alertText},_minCheckbox:function(e,t,a,r,i){var o=a[r+1],s=t.attr("name");if(e.find("input[name='"+s+"']:checked").length<o)return i.showArrow=!1,i.allrules.minCheckbox.alertText+" "+o+" "+i.allrules.minCheckbox.alertText2},_creditCard:function(e,t,a,r){var i=!1,o=e.val().replace(/ +/g,"").replace(/-+/g,""),s=o.length;if(s>=14&&s<=16&&parseInt(o)>0){var n,l=0,d=(a=s-1,1),u=new String;do{n=parseInt(o.charAt(a)),u+=d++%2==0?2*n:n}while(--a>=0);for(a=0;a<u.length;a++)l+=parseInt(u.charAt(a));i=l%10==0}if(!i)return r.allrules.creditCard.alertText},_ajax:function(a,r,i,o){var s=r[i+1],n=o.allrules[s],l=n.extraData,d=n.extraDataDynamic,u={fieldId:a.attr("id"),fieldValue:a.val()};if("object"==typeof l)e.extend(u,l);else if("string"==typeof l){var c=l.split("&");for(i=0;i<c.length;i++){var f=c[i].split("=");f[0]&&f[0]&&(u[f[0]]=f[1])}}if(d){var v=String(d).split(",");for(i=0;i<v.length;i++){var p=v[i];if(e(p).length){var m=a.closest("form, .validationEngineContainer").find(p).val();p.replace("#",""),escape(m);u[p.replace("#","")]=m}}}if("field"==o.eventTrigger&&delete o.ajaxValidCache[a.attr("id")],!o.isError&&!t._checkAjaxFieldStatus(a.attr("id"),o))return e.ajax({type:o.ajaxFormValidationMethod,url:n.url,cache:!1,dataType:"json",data:u,field:a,rule:n,methods:t,options:o,beforeSend:function(){},error:function(e,a){o.onFailure?o.onFailure(e,a):t._ajaxError(e,a)},success:function(r){var i=r[0],s=e("#"+i).eq(0);if(1==s.length){var l=r[1],d=r[2];if(l){if(o.ajaxValidCache[i]=!0,d){if(o.allrules[d])(u=o.allrules[d].alertTextOk)&&(d=u)}else d=n.alertTextOk;o.showPrompts&&(d?t._showPrompt(s,d,"pass",!0,o):t._closePrompt(s)),"submit"==o.eventTrigger&&a.closest("form").submit()}else{var u;if(o.ajaxValidCache[i]=!1,o.isError=!0,d){if(o.allrules[d])(u=o.allrules[d].alertText)&&(d=u)}else d=n.alertText;o.showPrompts&&t._showPrompt(s,d,"",!0,o)}}s.trigger("jqv.field.result",[s,o.isError,d])}}),n.alertTextLoad},_ajaxError:function(e,t){0==e.status&&null==t?alert("The page is not served from a server! ajax call failed"):"undefined"!=typeof console&&console.log("Ajax error: "+e.status+" "+t)},_dateToString:function(e){return e.getFullYear()+"-"+(e.getMonth()+1)+"-"+e.getDate()},_parseDate:function(e){var t=e.split("-");return t==e&&(t=e.split("/")),t==e?(t=e.split("."),new Date(t[2],t[1]-1,t[0])):new Date(t[0],t[1]-1,t[2])},_showPrompt:function(a,r,i,o,s,n){a.data("jqv-prompt-at")instanceof jQuery?a=a.data("jqv-prompt-at"):a.data("jqv-prompt-at")&&(a=e(a.data("jqv-prompt-at")));var l=t._getPrompt(a);n&&(l=!1),e.trim(r)&&(l?t._updatePrompt(a,l,r,i,o,s):t._buildPrompt(a,r,i,o,s))},_buildPrompt:function(a,r,i,o,s){var n=e("<div>");switch(n.addClass(t._getClassName(a.attr("id"))+"formError"),n.addClass("parentForm"+t._getClassName(a.closest("form, .validationEngineContainer").attr("id"))),n.addClass("formError"),i){case"pass":n.addClass("greenPopup");break;case"load":n.addClass("blackPopup")}o&&n.addClass("ajaxed");e("<div>").addClass("formErrorContent").html(r).appendTo(n);var l=a.data("promptPosition")||s.promptPosition;if(s.showArrow){var d=e("<div>").addClass("formErrorArrow");if("string"==typeof l)-1!=(f=l.indexOf(":"))&&(l=l.substring(0,f));switch(l){case"bottomLeft":case"bottomRight":n.find(".formErrorContent").before(d),d.addClass("formErrorArrowBottom").html('<div class="line1">\x3c!-- --\x3e</div><div class="line2">\x3c!-- --\x3e</div><div class="line3">\x3c!-- --\x3e</div><div class="line4">\x3c!-- --\x3e</div><div class="line5">\x3c!-- --\x3e</div><div class="line6">\x3c!-- --\x3e</div><div class="line7">\x3c!-- --\x3e</div><div class="line8">\x3c!-- --\x3e</div><div class="line9">\x3c!-- --\x3e</div><div class="line10">\x3c!-- --\x3e</div>');break;case"topLeft":case"topRight":d.html('<div class="line10">\x3c!-- --\x3e</div><div class="line9">\x3c!-- --\x3e</div><div class="line8">\x3c!-- --\x3e</div><div class="line7">\x3c!-- --\x3e</div><div class="line6">\x3c!-- --\x3e</div><div class="line5">\x3c!-- --\x3e</div><div class="line4">\x3c!-- --\x3e</div><div class="line3">\x3c!-- --\x3e</div><div class="line2">\x3c!-- --\x3e</div><div class="line1">\x3c!-- --\x3e</div>'),n.append(d)}}s.addPromptClass&&n.addClass(s.addPromptClass);var u=a.attr("data-required-class");if(void 0!==u)n.addClass(u);else if(s.prettySelect&&e("#"+a.attr("id")).next().is("select")){var c=e("#"+a.attr("id").substr(s.usePrefix.length).substring(s.useSuffix.length)).attr("data-required-class");void 0!==c&&n.addClass(c)}n.css({opacity:0}),"inline"===l?(n.addClass("inline"),void 0!==a.attr("data-prompt-target")&&e("#"+a.attr("data-prompt-target")).length>0?n.appendTo(e("#"+a.attr("data-prompt-target"))):a.after(n)):a.before(n);var f=t._calculatePosition(a,n,s);return e("body").hasClass("rtl")?n.css({position:"inline"===l?"relative":"absolute",top:f.callerTopPosition,left:"initial",right:f.callerleftPosition,marginTop:f.marginTopSize,opacity:0}).data("callerField",a):n.css({position:"inline"===l?"relative":"absolute",top:f.callerTopPosition,left:f.callerleftPosition,right:"initial",marginTop:f.marginTopSize,opacity:0}).data("callerField",a),s.autoHidePrompt&&setTimeout(function(){n.animate({opacity:0},function(){n.closest(".formError").remove()})},s.autoHideDelay),n.animate({opacity:1})},_updatePrompt:function(a,r,i,o,s,n,l){if(r){void 0!==o&&("pass"==o?r.addClass("greenPopup"):r.removeClass("greenPopup"),"load"==o?r.addClass("blackPopup"):r.removeClass("blackPopup")),s?r.addClass("ajaxed"):r.removeClass("ajaxed"),r.find(".formErrorContent").html(i);var d=t._calculatePosition(a,r,n);if(e("body").hasClass("rtl"))var u={top:d.callerTopPosition,left:"initial",right:d.callerleftPosition,marginTop:d.marginTopSize,opacity:1};else u={top:d.callerTopPosition,left:d.callerleftPosition,right:"initial",marginTop:d.marginTopSize,opacity:1};r.css({opacity:0,display:"block"}),l?r.css(u):r.animate(u)}},_closePrompt:function(e){var a=t._getPrompt(e);a&&a.fadeTo("fast",0,function(){a.closest(".formError").remove()})},closePrompt:function(e){return t._closePrompt(e)},_getPrompt:function(a){var r=e(a).closest("form, .validationEngineContainer").attr("id"),i=t._getClassName(a.attr("id"))+"formError",o=e("."+t._escapeExpression(i)+".parentForm"+t._getClassName(r))[0];if(o)return e(o)},_escapeExpression:function(e){return e.replace(/([#;&,\.\+\*\~':"\!\^$\[\]\(\)=>\|])/g,"\\$1")},isRTL:function(t){var a=e(document),r=e("body"),i=t&&t.hasClass("rtl")||t&&"rtl"===(t.attr("dir")||"").toLowerCase()||a.hasClass("rtl")||"rtl"===(a.attr("dir")||"").toLowerCase()||r.hasClass("rtl")||"rtl"===(r.attr("dir")||"").toLowerCase();return Boolean(i)},_calculatePosition:function(e,t,a){var r,i,o,s=e.width(),n=e.position().left,l=e.position().top;e.height();r=i=0,o=-t.height();var d=e.data("promptPosition")||a.promptPosition,u="",c="",f=0,v=0;switch("string"==typeof d&&-1!=d.indexOf(":")&&(u=d.substring(d.indexOf(":")+1),d=d.substring(0,d.indexOf(":")),-1!=u.indexOf(",")&&(c=u.substring(u.indexOf(",")+1),u=u.substring(0,u.indexOf(",")),v=parseInt(c),isNaN(v)&&(v=0)),f=parseInt(u),isNaN(u)&&(u=0)),d){default:case"topRight":i+=n+s-27,r+=l;break;case"topLeft":r+=l,i+=n;break;case"centerRight":r=l+4,o=0,i=n+e.outerWidth(!0)+5;break;case"centerLeft":i=n-(t.width()+2),r=l+4,o=0;break;case"bottomLeft":r=l+e.height()+5,o=0,i=n;break;case"bottomRight":i=n+s-27,r=l+e.height()+5,o=0;break;case"inline":i=0,r=0,o=0}return{callerTopPosition:(r+=v)+"px",callerleftPosition:(i+=f)+"px",marginTopSize:o+"px"}},_saveOptions:function(t,a){if(e.validationEngineLanguage)var r=e.validationEngineLanguage.allRules;else e.error("jQuery.validationEngine rules are not loaded, plz add localization files to the page");e.validationEngine.defaults.allrules=r;var i=e.extend(!0,{},e.validationEngine.defaults,a);return t.data("jqv",i),i},_getClassName:function(e){if(e)return e.replace(/:/g,"_").replace(/\./g,"_")},_jqSelector:function(e){return e.replace(/([;&,\.\+\*\~':"\!\^#$%@\[\]\(\)=>\|])/g,"\\$1")},_condRequired:function(e,a,r,i){var o,s;for(o=r+1;o<a.length;o++)if((s=jQuery("#"+a[o]).first()).length&&null==t._required(s,["required"],0,i,!0))return t._required(e,["required"],0,i)},_submitButtonClick:function(t){var a=e(this);a.closest("form, .validationEngineContainer").data("jqv_submitButton",a.attr("id"))}};e.fn.validationEngine=function(a){var r=e(this);return r[0]?"string"==typeof a&&"_"!=a.charAt(0)&&t[a]?("showPrompt"!=a&&"hide"!=a&&"hideAll"!=a&&t.init.apply(r),t[a].apply(r,Array.prototype.slice.call(arguments,1))):"object"!=typeof a&&a?void e.error("Method "+a+" does not exist in jQuery.validationEngine"):(t.init.apply(r,arguments),t.attach.apply(r)):r},e.validationEngine={fieldIdCounter:0,defaults:{validationEventTrigger:"blur",scroll:!0,focusFirstField:!0,showPrompts:!0,validateNonVisibleFields:!1,ignoreFieldsWithClass:"ignoreMe",promptPosition:"topRight",bindMethod:"bind",inlineAjax:!1,ajaxFormValidation:!1,ajaxFormValidationURL:!1,ajaxFormValidationMethod:"get",onAjaxFormComplete:e.noop,onBeforeAjaxFormValidation:e.noop,onValidationComplete:!1,doNotShowAllErrosOnSubmit:!1,custom_error_messages:{},binded:!0,notEmpty:!1,showArrow:!0,showArrowOnRadioAndCheckbox:!1,isError:!1,maxErrorsPerField:!1,ajaxValidCache:{},autoPositionUpdate:!1,InvalidFields:[],onFieldSuccess:!1,onFieldFailure:!1,onSuccess:!1,onFailure:!1,validateAttribute:"class",addSuccessCssClassToField:"",addFailureCssClassToField:"",autoHidePrompt:!1,autoHideDelay:1e4,fadeDuration:300,prettySelect:!1,addPromptClass:"",usePrefix:"",useSuffix:"",showOneMessage:!1}},e(function(){e.validationEngine.defaults.promptPosition=t.isRTL()?"topLeft":"topRight"})}(jQuery);