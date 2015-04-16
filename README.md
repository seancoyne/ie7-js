## About
IE7.js is a JavaScript library to make Microsoft Internet Explorer behave like a standards-compliant browser. It fixes many HTML and CSS issues and makes transparent PNG work correctly under IE5 and IE6.

## Status
Current version: 2.1 beta4.

## Usage

### IE7.js
Upgrade MSIE5.5-6 to be compatible with MSIE7.

```html
<!--[if lt IE 7]>
<script src="https://seancoyne.github.io/ie7-js/lib/IE7.js"></script>
<![endif]-->
```

### IE8.js
Upgrade MSIE5.5-7 to be compatible with MSIE8.

```html
<!--[if lt IE 8]>
<script src="https://seancoyne.github.io/ie7-js/lib/IE8.js"></script>
<![endif]-->
```

You do not need to include IE7.js if you are using IE8.js

### IE9.js
Upgrade MSIE5.5-8 to be compatible with modern browsers.

```html
<!--[if lt IE 9]>
<script src="https://seancoyne.github.io/ie7-js/lib/IE9.js"></script>
<![endif]-->
```

You do not need to include IE7/IE8.js if you are using IE9.js

### PNG
The script only fixes images named: *-trans.png

If you want the fix to apply to all PNG images then set a global variable as follows:

```javascript
var IE7_PNG_SUFFIX = ".png";
```

You must set this variable before including the IE7.js script. Alternatively, you can set the variable inside the IE7.js script element:

```html
<script src="IE8.js">IE7_PNG_SUFFIX=".png";</script>
```

The suffix will ignore query string parameters. For more fine-grained control you can also set `IE7_PNG_SUFFIX` to a RegExp object. If you want to use an alternative PNG solution then set the suffix to something that cannot possibly match:

```javascript
var IE7_PNG_SUFFIX = ":";
```

By default, the PNG will be stretched (this simulates tiling). If you want to turn this off then set the no-repeat property as follows:

```css
div.example {
  background: url(my-trans.png) no-repeat;
}
```

Unfortunately, the transparent background image cannot be tiled (repeated) using background-repeat. Nor can it be positioned using background-position.

## Download

Go to the [releases](https://github.com/seancoyne/ie7-js/releases) section to download the current version.

## Getting Started
Here is a nice introduction:

http://www.charlescooke.me.uk/web/lab_notes/ie7_script.html

## Demo

https://seancoyne.github.io/ie7-js/

## Links

### Blogs

* [All Blog Posts](http://dean.edwards.name/weblog/category/IE7/)
* [Eric Meyer on IE7.js](http://meyerweb.com/eric/thoughts/2005/10/17/ie7-and-ie7/)
* [The IE6 Equation](http://24ways.org/2008/the-ie6-equation)

### External Links

* [Getting Started](http://www.charlescooke.me.uk/web/lab_notes/ie7_script.html)
* [Examples](https://seancoyne.github.io/ie7-js/)
* [Hotlink](https://github.com/seancoyne/ie7-js/releases)

### Groups
* [Google Group](http://groups.google.com/group/ie7-js)
