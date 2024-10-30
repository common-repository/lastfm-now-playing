=== LastFM Now Playing ===
Contributors: baabullah
Donate link: http://fridayanabaabullah.wordpress.com/
Tags: lastfm, music
Requires at least: 3.0.0
Tested up to: 3.1.4
Stable tag: 1.0.3

A widget that display recent tracks of an last.fm account.

== Description ==

This is a widget, you can put in the sidebar that display recent played tracks of an last.fm account.

You can set any last.fm username, limit the songs and refresh interval.

This plugin require jQuery on your template. If your template doesn't support jQuery, this plugin will display your currently played song in image format.

== Installation ==

1. Upload the zip to the `/wp-content/plugins/` directory
2. Extract
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Drag LastFM Now Playing Widget to your sidebar
5. Done!

== Frequently Asked Questions ==

= Can I set other last.fm account? =

Yes, you can set any last.fm account.

= Wordpress.org doesn't permit plugins installation :( =

You can display your currently played track using `img` html tag. To do this, drag a Text widget. Set widget title, then set `<img src="http://play.eprofile.web.id/lastfm/lastfm.php?username=baabullah&output=image&width=200"/>` as the content. Change `baabullah` with your desired last.fm account.

== Screenshots ==

1. Displayed in the siderbar
1. Widget configuration
1. Using image html tag

== Changelog ==

= 1.0.3 =
* Fix jquery checking

= 1.0.2 =
* Fallback to image format if the template doesn't support jQuery

= 1.0.1 =
* Fixing typo in readme.txt

= 1.0.0 =
* Initial release