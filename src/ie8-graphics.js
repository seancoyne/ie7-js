
// =========================================================================
// ie8-graphics.js
// =========================================================================

IE7.CSS.addFix(/opacity\s*:\s*([\d.]+)/, function(match, value) {
  return "zoom:1;filter:Alpha(opacity=" + ((value * 100) || 1) + ")";
});

// fix object[type=image/*]
var IMAGE = /^image/i;
IE7.HTML.addRecalc("object", function(element) {
  if (IMAGE.test(element.type)) {
    element.body.style.margin = "0";
    element.body.style.padding = "0";
    element.body.style.border = "none";
    element.body.style.overflow = "hidden";
    return element;
  }
});
