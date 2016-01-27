/*
 *
 * Copyright (c) 2006 Sam Collett (http://www.texotela.co.uk)
 * Licensed under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 * 
 */
 
/*
 * Allows only valid characters to be entered into input boxes.
 * Note: does not validate that the final text is a valid number
 * (that could be done by another script, or server-side)
 *
 * @name     numeric
 * @param    decimal      Decimal separator (e.g. '.' or ',' - default is '.')
 * @param    callback     A function that runs if the number is not valid (fires onblur)
 * @author   Sam Collett (http://www.texotela.co.uk)
 * @example  $(".numeric").numeric();
 * @example  $(".numeric").numeric(",");
 * @example  $(".numeric").numeric(null, callback);
 *
 */
 function char_numeric(str) {
 $(str).keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
			((e.ctrlKey && e.keyCode == 99 /* firefox */) || (e.ctrlKey && e.keyCode == 67) /* opera */) ||
			 // Allow: Ctrl+C
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
	});
}

function char_alpha(str) {
 $(str).keydown(function (e) {    
        // Ensure that it is a number and stop the keypress
		 if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110,32]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
			((e.ctrlKey && e.keyCode == 99 /* firefox */) || (e.ctrlKey && e.keyCode == 67) /* opera */) ||
			 // Allow: Ctrl+C
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        if (((e.keyCode < 65 || e.keyCode > 90) && e.keyCode != 190 ))        {
            e.preventDefault();
        }
	});
}

 function char_num(str) {
 $(str).keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
			((e.ctrlKey && e.keyCode == 99 /* firefox */) || (e.ctrlKey && e.keyCode == 67) /* opera */) ||
			 // Allow: Ctrl+C
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
	});
}

function char_alphanumber(str) {
 $(str).keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 32,110]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
			((e.ctrlKey && e.keyCode == 99 /* firefox */) || (e.ctrlKey && e.keyCode == 67) /* opera */) ||
			 // Allow: Ctrl+C
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105) && (e.keyCode < 65 || e.keyCode > 90)) {
            e.preventDefault();
        }
	});
}

function char_alphanumber1(str) {
 $(str).keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 32,110]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
			((e.ctrlKey && e.keyCode == 99 /* firefox */) || (e.ctrlKey && e.keyCode == 67) /* opera */) ||
			 // Allow: Ctrl+C
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
		
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if (e.keyCode != 191  && (e.keyCode < 65 || e.keyCode > 90) && (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
	});
}
function char_num2(str) {
 $(str).keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
			((e.ctrlKey && e.keyCode == 99 /* firefox */) || (e.ctrlKey && e.keyCode == 67) /* opera */) ||
			 // Allow: Ctrl+C
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
		
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if (e.keyCode != 191 && (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
	});
}
function char_num1(str) {
 $(str).keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
       
        // Ensure that it is a number and stop the keypress
       // if (e.keyCode != 191  && (e.keyCode < 65 || e.keyCode > 90) && (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
      //  }
	});
}