<?php
header('Content-Type: application/x-javascript');
header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

print("// timestamp: ".gmdate('D, d M Y H:i:s')."\r\n");
?>
/*
  IE7/IE8.js - copyright 2004-2008, Dean Edwards
  http://dean.edwards.name/IE7/
  http://www.opensource.org/licenses/mit-license.php
*/

/* W3C compliance for Microsoft Internet Explorer */

/* credits/thanks:
  Shaggy, Martijn Wargers, Jimmy Cerra, Mark D Anderson,
  Lars Dieckow, Erik Arvidsson, Gellért Gyuris, James Denny,
  Unknown W Brackets, Benjamin Westfarer, Rob Eberhardt,
  Bill Edney, Kevin Newman, James Crompton, Matthew Mastracci,
  Doug Wright, Richard York, Kenneth Kolano, MegaZone,
  Thomas Verelst
*/

// =======================================================================
// TO DO
// =======================================================================

// PNG - unclickable content

// =======================================================================
// TEST/BUGGY
// =======================================================================

// hr{margin:1em auto} (doesn't look right in IE5)

(function() {
IE7 = {
  toString: function(){return "IE7 version 2.0 (alpha)"}
};

// -----------------------------------------------------------------------
// globals
// -----------------------------------------------------------------------
var Undefined = K();
// IE7 version info
// error reporting
var ie7_debug = /ie7_debug/.test(top.location.search);
//-var alert = ie7_debug ? function(message){window.alert(IE7+"\n\n"+message)} : Undefined;
// IE version info
var appVersion = IE7.appVersion = navigator.appVersion.match(/MSIE (\d\.\d)/)[1];
var quirksMode = document.compatMode != "CSS1Compat";
// handy
var documentElement, body, viewport;
var ANON = "!";

// -----------------------------------------------------------------------
// external
// -----------------------------------------------------------------------

var RELATIVE = /^[\w\.]+[^:]*$/;
function makePath(href, path) {
  if (RELATIVE.test(href)) href = (path || "") + href;
  return href;
};

function getPath(href, path) {
  href = makePath(href, path);
  return href.slice(0, href.lastIndexOf("/") + 1);
};

// get the path to this script
var script = document.scripts[document.scripts.length - 1];
// create global variables from the inner text of the IE7 script
try {
  eval(script.innerHTML);
} catch (e) {
  // ignore errors
}
var path = getPath(script.src);

// we'll use microsoft's http request object to load external files
try {
  var httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
} catch (e) {
  // ActiveX disabled
}

var fileCache = {};
function loadFile(href, path) {
try {
  href = makePath(href, path);
  if (!fileCache[href]) {
    // easy to load a file huh?
    httpRequest.open("GET", href, false);
    httpRequest.send();
    if (httpRequest.status == 0 || httpRequest.status == 200) {
      fileCache[href] = httpRequest.responseText;
    }
  }
} catch (e) {
  // ignore errors
} finally {
  return fileCache[href] || "";
}};

// -----------------------------------------------------------------------
// IE5.0 compatibility
// -----------------------------------------------------------------------

<?php 
include("ie7-ie5.js");
?>

// -----------------------------------------------------------------------
// OO support
// -----------------------------------------------------------------------

<?php include("base2.js") ?>

// clone the fixWidth function to create a fixHeight function
var rotater = new RegGrp({
  Width: "Height",
  width: "height",
  Left:  "Top",
  left:  "top",
  Right: "Bottom",
  right: "bottom",
  X:     "Y"
});

function rotate(fn) {
  return rotater.exec(fn);
};

var Fix = Base.extend({
  constructor: function() {
    this.fixes = [];
    this.recalcs = [];
  },
  init: Undefined
});

// -----------------------------------------------------------------------
// initialisation
// -----------------------------------------------------------------------

function init() {
  // IE7 can be turned "off"
  if (/ie7_off/.test(top.location.search) || appVersion < 5) return;

  // frequently used references
  documentElement = document.documentElement;
  body = document.body;
  IE7._viewport = viewport = quirksMode ? body : documentElement;
  
  if (quirksMode) ie7Quirks();
  
  IE7.CSS.init();  
  IE7.HTML.init();
  
  IE7.HTML.apply();  
  IE7.CSS.apply();
  
  recalc();
};

// a store for functions that will be called when refreshing IE7
var recalcs = [];
function addRecalc(recalc) {
  recalcs.push(recalc);
};

function recalc() {
  IE7.HTML.recalc();
  // re-apply style sheet rules (re-calculate ie7 classes)
  IE7.CSS.recalc();
  // apply global fixes to the document
  for (var i = 0; i < recalcs.length; i++) recalcs[i]();
};

var Parser = RegGrp.extend({ignoreCase: true});

// -----------------------------------------------------------------------
//  cssQuery
// -----------------------------------------------------------------------

<?php
include("ie7-cssQuery.js");
?>

// -----------------------------------------------------------------------
// encoding
// -----------------------------------------------------------------------

var QUOTE = /'/g, STRING = /^\x01/;
var _strings = [];

var encoder = new Parser({
  // comments
  "<!\\-\\-|\\-\\->": "",
  "\\/\\*[^*]*\\*+([^\\/][^*]*\\*+)*\\/": "",
  // get rid
  "@(namespace|import)[^;\\n]+[;\\n]": "",
  // strings
  "'(\\\\.|[^'\\\\])*'": encodeString,
  '"(\\\\.|[^"\\\\])*"': encodeString,
  // white space
  "\\s+": " "
});

function encode(cssText) {
  return encoder.exec(cssText);
};

function encodeString(string) {
  return "\x01" + _strings.push(string.replace(/\\([\da-fA-F]{1,4})/g, function(match, chr) {
    return "\\u" + "0000".slice(chr.length) + match;
  }).slice(1, -1).replace(QUOTE, "\\'"));
};

function getString(value) {
  return STRING.test(value) ? _strings[value.slice(1) - 1] : value;
};

// -----------------------------------------------------------------------
// decoding
// -----------------------------------------------------------------------

var decoder = new Parser({
  "\\x01(\\d+)": function(match, index) {
    return _strings[index - 1];
  }
});

function decode(cssText) {
  return decoder.exec(cssText);
};


// -----------------------------------------------------------------------
// event handling
// -----------------------------------------------------------------------

var eventHandlers = [];

function addResize(handler) {
  addRecalc(handler);
  addEventHandler(window, "onresize", handler);
};

// add an event handler (function) to an element
function addEventHandler(element, type, handler) {
  element.attachEvent(type, handler);
  // store the handler so it can be detached later
  eventHandlers.push(arguments);
};

// remove an event handler assigned to an element by IE7
function removeEventHandler(element, type, handler) {
try {
  element.detachEvent(type, handler);
} catch (ignore) {
  // write a letter of complaint to microsoft..
}};

// remove event handlers (they eat memory)
addEventHandler(window, "onunload", function() {
  var handler;
  while (handler = eventHandlers.pop()) {
    removeEventHandler(handler[0], handler[1], handler[2]);
  }
});

function register(handler, element, condition) { // -@DRE
  //var set = handler[element.uniqueID];
  if (!handler.elements) handler.elements = {};
  if (condition) handler.elements[element.uniqueID] = element;
  else delete handler.elements[element.uniqueID];
  //return !set && condition;
  return condition;
};

addEventHandler(window, "onbeforeprint", function() {
  if (!IE7.CSS.print) new StyleSheet("print");
  IE7.CSS.print.recalc();
});

// -----------------------------------------------------------------------
// pixel conversion
// -----------------------------------------------------------------------

// this is handy because it means that web developers can mix and match
//  measurement units in their style sheets. it is not uncommon to
//  express something like padding in "em" units whilst border thickness
//  is most often expressed in pixels.

var PIXEL = /^\d+(px)?$/i;
var PERCENT = /^\d+%$/;
var getPixelValue = function(element, value) {
  if (PIXEL.test(value)) return parseInt(value);
  var style = element.style.left;
  var runtimeStyle = element.runtimeStyle.left;
  element.runtimeStyle.left = element.currentStyle.left;
  element.style.left = value || 0;
  value = element.style.pixelLeft;
  element.style.left = style;
  element.runtimeStyle.left = runtimeStyle;
  return value;
};

// create a temporary element which is used to inherit styles
//  from the target element. the temporary element can be resized
//  to determine pixel widths/heights
function createTempElement(tagName) {
  var element = document.createElement(tagName || "object");
  element.style.cssText = "position:absolute;padding:0;display:block;border:none;clip:rect(0 0 0 0);left:-9999";
  element.ie7_anon = true;
  return element;
};

// -----------------------------------------------------------------------
// generic
// -----------------------------------------------------------------------

var $IE7 = "ie7-";

function isFixed(element) {
  return element.currentStyle["ie7-position"] == "fixed";
};

// original style
function getDefinedStyle(element, propertyName) {
  return element.currentStyle[$IE7 + propertyName] || element.currentStyle[propertyName];
};

function setOverrideStyle(element, propertyName, value) {
  if (element.currentStyle[$IE7 + propertyName] == null) {
    element.runtimeStyle[$IE7 + propertyName] = element.currentStyle[propertyName];
  }
  element.runtimeStyle[propertyName] = value;
};

// -----------------------------------------------------------------------
//  modules
// -----------------------------------------------------------------------

<?php
include('ie7-css.js');
include('ie7-html.js');
include('ie7-layout.js');
include('ie7-graphics.js');
include('ie7-fixed.js');
include('ie7-overflow.js');
include('ie7-quirks.js');
if (preg_match('/ie8/', $_SERVER['QUERY_STRING'])) {
  include('ie8-cssQuery.js');
  include('ie8-css.js');
  include('ie8-html.js');
  include('ie8-layout.js');
  include('ie8-graphics.js');
}
?>

// -----------------------------------------------------------------------
//  initialise
// -----------------------------------------------------------------------

document.write("<script id=__ready defer src=//:><\/script>");
document.all.__ready.onreadystatechange = function() {
  if (this.readyState == "complete") {
    this.removeNode(); // tidy
    init();
  }
};

})();
