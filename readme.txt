=== JM Simple QR code Widget ===
Contributors: jmlapam
Tags: widget, QR code, mobile
Requires at least: 3.8
Tested up to: 3.9
License: GPLv2 or later
Stable tag: trunk
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easy integration of QR Codes in WordPress !

== Description ==

QR codes are very useful. It's a good way to set quickly and easily linking to content on smartphones. This plugin adds a simple widget you can grab on the widget page.
Just set it with your own settings and display it on whatever sidebar you want.

<a href="http://twitter.com/intent/user?screen_name=tweetpressfr">Follow me on Twitter</a>


== Installation ==

1. Upload plugin files to the /wp-content/plugins/ directory
2. Activate the plugin through the Plugins menu in WordPress
3. A new widget will appear, just grab it and set your settings

== Frequently asked questions ==

Not yet.

== Changelog ==

= 1.4.5 =
* 2O Aug 2014
* Change provider (now Google Charts) because of multiple bugs with former API
* Some options such as color and background color might have disappear but in fact it's not very useful

= 1.4.4 =
* 09 June 2014

= 1.4.3 =
* 15 May 2014
* compatibility with multisite

= 1.4.2 =
* 25 Apr 2014
* Fix bug in page where global $post is null
* Reduce loads by removing time from transient
* In fact QR codes do no need to be timed, if you want to modify it just update widget
* Fix stupid use of transient, one transient per post is more appropriate, in fact 1.3 was saving on QR code for all posts !
* To do : implement QRcode library to avoid calling an API and handle QR code locally

= 1.3 =
* 23 Apr 2014
* Add transient for qr code and fix little bugs

= 1.2 =
* 21 Apr 2014
* Add a checking system in case QR Code API is down 

= 1.1 =
* 04 Apr 2014
* better way to chek current URL and to avoid URL of first post to be taken instead of page URL (home, categories, etc)

= 1.0 =
* 24 Mar 2014
* Initial release