// ==UserScript==
// @name        Send Bulk SMS
// @namespace   Send-Bulk-SMS
// @include     http://localhost/ppds/send-sms.php
// @version     1
// @grant       none
// ==/UserScript==
/**
 * How can I use jQuery in Greasemonkey scripts in Google Chrome?
 * All Credits to Original Author for this wonderful function.
 *
 * @author  Erik Vergobbi Vold & Tyler G. Hicks-Wright
 * @link    http://stackoverflow.com/questions/2246901
 * @param   callback
 * @returns {undefined}
 */
function jQueryInclude(callback) {
  var jQueryScript = document.createElement('script');
  var jQueryCDN = '//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js';
  jQueryScript.setAttribute('src', jQueryCDN);
  jQueryScript.addEventListener('load', function () {
    var UserScript = document.createElement('script');
    UserScript.textContent = 'window.jQ=jQuery.noConflict(true);'
      + 'var BaseURL = "http://localhost/";'
      + '(' + callback.toString() + ')();';
    document.head.appendChild(UserScript);
  }, false);
  document.head.appendChild(jQueryScript);
}

/**
 * Main Body of Helper Script For Sending SMS
 */

jQueryInclude(function () {
  jQ('#form1').hide();
  jQ('option').html(function () {
    return jQ(this).val() + ' - ' + jQ(this).html();
  });
  var HackUI = '<div style="text-align:center;clear:both;magrin:20px;padding:10px;">'
    + '<div id="HackUI">'
    + '<div style="text-align:right;width:320px;" id="Msg"></div>'
    + '<label style="font-size:20px;">From: </label><input type="text" id="MsgFrom" size="5"/><br/>'
    + '<label style="font-size:20px;">Total Messages to be sent: </label><input type="text" id="MsgCount" size="5"/><br/>'
    + '<input type="button" id="CmdClear" value="Clear"/>'
    + '<input type="button" id="CmdStatus" value="Show"/>'
    + '<input type="button" id="CmdGo" value="Send Bulk SMS"/>'
    + '</div><div style="float:left;"><ol id="listItems" style="text-align:left;margin:10px;font-size:12px;"></ol></div>';
  jQ('#form1').after(HackUI);
  jQ('[id^=Cmd]').css({
    'margin': '5px',
    'padding': '5px'
  });
  jQ('#Msg').css({
    'text-align': 'right',
    'display': 'inline-block',
    'border': '2px dashed greenyellow',
    'padding': '10px',
    'margin': '10px',
    'float': 'left',
    'font-size': '16px'
  });


  /**
   * Perform the Selected Action
   */
  jQ("#CmdGo").click(function () {
    localStorage.setItem('KeyPrefix', 'SendSMS_');
    localStorage.setItem('MsgFrom', jQ('#MsgFrom').val());
    localStorage.setItem('OrderNo', jQ('#MsgCount').val());
    var MsgFrom = jQ('#MsgFrom').val();
    for (i = 1; i <= jQ('#MsgCount').val(); i++) {
      setTimeout(AjaxFunnel(SendSMS, i + parseInt(MsgFrom), i + parseInt(MsgFrom)), 2000 * i);
    }
  });

  /**
   * Get a List of All Institutions
   *
   * @returns {undefined}
   */
  var SendSMS = function (From, To) {
    localStorage.setItem('Status', 'Sending SMS');
    var KeyPrefix = localStorage.getItem('KeyPrefix');

    jQ.ajax({
      type: 'POST',
      url: BaseURL + 'ppds/sms/SendSMS.php',
      dataType: 'html',
      xhrFields: {
        withCredentials: true
      },
      data: {
        'from': From,
        'to': To
      }
    }).done(function (data) {
      try {
        jQ('#listItems').append(data);
      }
      catch (e) {
        jQ('#listItems').append('<li>Error: ' + e + '<li>');
        localStorage.setItem(KeyPrefix + ' Error:', e);
      }
    }).fail(function (FailMsg) {
      jQ('#listItems').append('<li>Failed<li>');
      localStorage.setItem(KeyPrefix + ' Fail:', FailMsg.statusText);
    }).always(function () {
      AjaxPending("Stop");
    });
  };

  /**
   * Limits No of AjaxCalls at a time
   *
   * @param {type} Fn
   * @param {type} Arg1
   * @param {type} Arg2
   * @param {type} Arg3
   * @param {type} Arg4
   * @returns {Boolean}
   */
  var AjaxFunnel = function (Fn, Arg1, Arg2, Arg3, Arg4) {
    var NextCallTimeOut = 2500;
    var PendingAjax = parseInt(localStorage.getItem('AjaxPending'));
    var AjaxLimit = parseInt(localStorage.getItem('AjaxLimit'));
    if (AjaxLimit === null) {
      AjaxLimit = 5;
    }
    if (PendingAjax > AjaxLimit) {
      if (typeof Arg1 === 'undefined') {
        setTimeout(AjaxFunnel(Fn), NextCallTimeOut);
      } else if (typeof Arg2 === 'undefined') {
        setTimeout(AjaxFunnel(Fn, Arg1), NextCallTimeOut);
      } else if (typeof Arg3 === 'undefined') {
        setTimeout(AjaxFunnel(Fn, Arg1, Arg2), NextCallTimeOut);
      } else if (typeof Arg4 === 'undefined') {
        setTimeout(AjaxFunnel(Fn, Arg1, Arg2, Arg3), NextCallTimeOut);
      } else {
        setTimeout(AjaxFunnel(Fn, Arg1, Arg2, Arg3, Arg4), NextCallTimeOut);
      }
      return false;
    } else {
      if (typeof Arg1 === 'undefined') {
        AjaxPending('Start');
        return Fn();
      } else if (typeof Arg2 === 'undefined') {
        AjaxPending('Start');
        return Fn(Arg1);
      } else if (typeof Arg3 === 'undefined') {
        AjaxPending('Start');
        return Fn(Arg1, Arg2);
      } else if (typeof Arg4 === 'undefined') {
        AjaxPending('Start');
        return Fn(Arg1, Arg2, Arg3);
      } else {
        AjaxPending('Start');
        return Fn(Arg1, Arg2, Arg3, Arg4);
      }
    }
  };

  /**
   * Records the No of Ajax Calls
   *
   * @param {type} AjaxState
   * @returns {undefined}
   */
  var AjaxPending = function (AjaxState) {
    var StartAjax = parseInt(localStorage.getItem('AjaxPending'));
    if (AjaxState === 'Start') {
      localStorage.setItem('AjaxPending', StartAjax + 1);
    } else {
      localStorage.setItem('AjaxPending', StartAjax - 1);
    }
  };

  /**
   * Continious Polling for Server Response to avoid Session TimeOut
   *
   * @returns {Boolean}
   */
  var RefreshOnWait = function () {
    var CurrDate = new Date(),
      TimeOut;
    var LastRespTime = new Date(localStorage.getItem('LastRespTime'));
    var ElapsedTime = CurrDate.getTime() - LastRespTime.getTime();
    TimeOut = localStorage.getItem('RefreshTimeOut');
    if (TimeOut === null) {
      TimeOut = 300000;
    } else {
      TimeOut = 5000 + 60000 * TimeOut; // 5sec is minimum
    }
    if (ElapsedTime > TimeOut) {
      localStorage.setItem('LastRespTime', Date());
      var URL = BaseURL + 'ppds/home.php';
      jQ.get(URL);
    } else {

      jQ('#Msg').html('AjaxPending :<span>'
        + localStorage.getItem('AjaxPending')
        + '</span><br/>Count :<span>'
        + localStorage.getItem('Count')
        + '</span><br/><br/>Total Messages : <b>'
        + localStorage.getItem('OrderNo')
        + '</b><br/><br/><b>Last API('
        + localStorage.getItem('KeyPrefix')
        + ') : </b>'
        + localStorage.getItem('Status')
        + '<br/><br/>' + localStorage.getItem('LastRespTime'));
      if (localStorage.getItem('AjaxPending') === '0') {
        jQ('#CmdGo').removeProp('disabled');
      }
      jQ('#Msg span').css({
        'width': '80px',
        'display': 'inline-block'
      });
    }
    setTimeout(RefreshOnWait, 2000);
    return true;
  };
  RefreshOnWait();

  /**
   * Loads the contents of localStorage into the interface
   */
  jQ("#CmdStatus").click(function () {
    if (jQ("#CmdStatus").val() === "Show") {
      jQ("#CmdStatus").val("Load");
      var vals = LoadData(localStorage.getItem('KeyPrefix'));
      var StatusDiv = document.createElement("div");
      StatusDiv.setAttribute("id", "AppStatus");

      jQ("#AppStatus")
        .html("<ol><li>" + vals.join("</li><li>") + "</li></ol>")
        .css({"text-align": "left", "clear": "both"});

      jQ("#AppStatus li").css("list-style-type", "decimal-leading-zero");
    } else {
      jQ("#AppStatus").remove();
      jQ("#CmdStatus").val("Show");
    }
  });


  /**
   * Clears all the contents of localStorage
   */
  jQ("#CmdClear").click(function () {
    localStorage.clear();
    localStorage.setItem('AjaxPending', 0);
    localStorage.setItem('Count', 0);
    localStorage.setItem('OrderNo', 0);
  });


});