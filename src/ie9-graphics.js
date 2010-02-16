
// =========================================================================
// ie9-graphics.js
// =========================================================================

if (appVersion === 8) {
  IE7.CSS.addFix(/\bopacity\s*:/, "-ms-opacity:");
} else {
  IE7.CSS.addFix(/\bopacity\s*:\s*([\d.]+)/, function(match, value) {
    return "zoom:1;filter:Alpha(opacity=" + ((value * 100) || 1) + ")";
  });
}
