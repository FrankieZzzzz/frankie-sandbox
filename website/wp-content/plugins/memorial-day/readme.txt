=== Memorial Day ===
Contributors: BennyThinks
Tags: comments, spam
Requires at least: 3.0
Stable tag: trunk
Tested up to: 4.7
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A plugin to convert your blog to black white in order to honor the heroes.

== Description ==

How could we forget those hereos who had delicated their life for democracy?

The massacre on June 4th, the passing of Noble Prize winner Liu Xiaobo?

But soon people will forget...we try to honor their deeds even as their name has faded from our memories.

This plugin was designed to change your blog to black and white on specific day you want.

Also it could set an `meta theme-color` for Android Chrome.


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/MemorialDay` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->MemorialDay screen to configure the plugin


== Frequently Asked Questions ==

### Default Day ###
June 4th and July 13rd

### What is theme-color? ###
This value is designed to control Android Chrome's notification bar via a meta:
`<meta name="theme-color" content="#299981">`
On memorial day, this value WILL NOT come to effect;it will set `theme-color` to `757575` to make it more comfortable.
On non memorial day, if you leave it blank, it will not affect your own meta;however, if you set a new value, it'll be your new mata color.

So in a word, if your theme has a meta, leave it blank;
if your theme has no meta and you want to set an meta, then set it.

### Firefox shows and white bar on Memorial Day ###
I don't know why but Chrome seems fine.

== Changelog ==

= 0.2.3 =
* Release version