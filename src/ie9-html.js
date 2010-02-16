
var HTML5 = "article,aside,audio,canvas,details,figcaption,figure,footer,header,hgroup,mark,menu,meter,nav,output,progress,section,summary,time,video".split(",");
for (var i = 0, tagName; tagName = HTML5[i]; i++) {
  document.createElement(tagName);
}
