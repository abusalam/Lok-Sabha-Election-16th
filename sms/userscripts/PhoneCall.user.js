// ==UserScript==
// @name        Pollday Monitoring - Phone Call
// @namespace   Poll-Day-Phone-Call
// @include     http://wbelect.in/*
// @version     1.1
// @grant       none
// ==/UserScript==

function jQueryInclude(callback) {
  var jQueryScript = document.createElement('script');
  var jQueryCDN = '//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js';
  jQueryScript.setAttribute('src', jQueryCDN);
  jQueryScript.addEventListener('load', function () {
    var UserScript = document.createElement('script');
    UserScript.textContent = 'window.jQ=jQuery.noConflict(true);'
      + '(' + callback.toString() + ')();';
    document.head.appendChild(UserScript);
  }, false);
  document.head.appendChild(jQueryScript);
}


jQueryInclude(function () {
  jQ('option').html(function () {
    return jQ(this).val() + ' - ' + jQ(this).html();
  });

  jQ('body').html(jQ('body').html().replace(/(\d\d\d\d\d\d\d\d\d\d)/g, '<a href="tel:$1" class="PhoneNo">$1</a>'));

  var HackUI = '<div id="HackUI">'
    + '<div><label>Mobile IP: <span id="MobileIP" contenteditable="true">192.168.1.101</span></label>'
    + '<div id="Msg"></div>'
    + '</div></div>';

  jQ('form').before(HackUI);
  jQ('#HackUI').css({
    'text-align': 'left',
    'display': 'inline-block',
    'border':'0px dashed greenyellow',
    'padding': '10px',
    'margin': '10px',
    'height': '100px',
    'width':'300px',
    'position':'absolute',
    'top':'5px',
    'left':'10px'
  });

  jQ('#MobileIP').blur(function(){
    sessionStorage.setItem("MobileIP",jQ(this).text());
    //alert('MobileIP:'+jQ(this).text());
  }).text(function(){
    var MobileIP=sessionStorage.getItem("MobileIP");
    if(MobileIP!==null){
      return MobileIP;
    }
  });

  jQ(function () {
    jQ('.PhoneNo').click(function (event) {
      event.preventDefault();
      jQ('#Msg').html('Calling... Mobile No: ' + jQ(this).text() + ' using ' + jQ('#MobileIP').text());
      jQ.ajax({
        type: 'GET',
        url: 'http://' + jQ('#MobileIP').text() + ':8080',
        dataType: 'html',
        data: {
          'cellNo': jQ(this).text()
        }
      });
    });
  });
});
