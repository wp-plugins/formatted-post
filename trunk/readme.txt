=== Plugin Name ===
Contributors: Kiro G.
Donate link: http://example.com/
Tags: post,format,formatted,template
Requires at least: 2.5
Tested up to: 2.8
Stable tag: 0.1

This plugin is for the users who need to post with fixed format regularly,and it's first plugin I develope solo.
== Description ==

This plugin is  to help people who need to post with fixed,complicated format regularly,
Insteading of using post_meta,it just replcace text with words wrapped in #,and save it as a new post to preserve more room to modify.
If there is bug,or problem ,suggestion,mail me:guankiro@gmail.com or leave comment `http://kiro.twbbs.org/wp/?p=504`

== Installation ==


1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to options to find 'post formmat',and estabilish your new template
4. Go to Edit>"Post with Format" to create new acticle

== Frequently Asked Questions ==
= How to localization? =
I recommend "CodeStyling Localization".

== Screenshots ==

1. Enter the html template ,the word to be changable should be wrapped with "#",and the word in '#' should be number and alphabet combination,not including blank
2. Select a Template and fill out the form, and click "publish" or "draft" to complete a post.

== Changelog ==

= 1.0 =
* Start A new plugin

== Usage ==
 This plugin supply a function to let user post,
use: <?php formatted_post_form(0,'publish');?>
This function is for customization,but so far I still pondor better way .

First augument:0 can be replace with template number.
Second augument: can be 'publish','draft','both' 

but you should notice that user should have enough authority.