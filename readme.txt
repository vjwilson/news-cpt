=== News CPT ===
Contributors: vanjwilson
Tags: news, custom post type, cpt, widget
Requires at least: 3.1
Tested up to: 3.5.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A quick, easy way to add an extensible News custom post type to Wordpress.

== Description ==

This plugin add a News custom post type to your Wordpress site. Now you can keep your press releases or time-sensitive announcements in a separate list, without having to juggle categories or tags.

The plugin adds a News tab to your admin menu, which allows you to enter news items just as you would regular posts. The archive list of your news items will appear at `/news`, and individual news items will appear at `/news/<permalink>`.

Default single item and archive page templates for news items are also provided. These templates have abundant IDs and classes, so that you can style them with your own CSS.
You may also customize them by putting copies in your theme folder, and changing the markup. When you update the plugin, you will get new features and bug fixes, while keeping any customizations you made in your copies of these templates.

Finally, the plugin adds a Recent News Items widget, which can be placed on any sidebar available in your theme, to show a list of news items in reverse chronological order. You can set the title of this list and the number of news items to show.
 
== Installation ==

1. Upload the `news-cpt` folder to the `/wp-content/plugins/` directory.
1. Activate the News CPT plugin through the 'Plugins' menu in WordPress.
1. Add and manage news items on your site by clicking on the  `News` tab that appears in your admin menu.
1. (Optional) Add and configure the News CPT Widget for one or more your sidebars.

== Frequently Asked Questions ==

= What news templates are available? =

There is one templates named `single-news.php` which controls the display of each individual news item on a page of its own. There is also a template named `archive-news.php` which controls the display of the list of all news items.

= Can I filter the list of news items by date? +

Yes. Just as you can display a list of your regular posts by year, month, or day, you can display news items for a particular year (/news/2013/), month (/news/2013/04/), or day (/news/2013/04/20/).

= What's the easiest way to create my own custom version of the news templates? =

Copy (don't move) the template you wish to customize from `/wp-content/plugins/views/` to `/wp-content/themes/<your-theme-name>/`. Modify the PHP and HTML of the copy in your theme folder, but leave the plugin version alone. You may want to refer back to it if something goes wrong, or you may want to copy new features from it to your custom templates after a plugin update.  

= Do I need to update my permalinks after I activate this plugin? =

No, not usually. While many plugins instruct you to update your permalinks after activation, this plugin tries to update your permalink structure for you. That being said, if the links that begin with `/news` aren't working, please try updating your permalinks first, before reporting a bug or submitting a question to the support forums.

= Are there shortcodes for news items? =

No, not at this time. I decided to concentrate on full templates and the widget at first.

=  Are there template tags for news items? =

No. Individual news items and the news item list have their own templates. There are no specific tags to add news items to other templates, although if you're comfortable with the Wordpress functions for retrieving posts, you are welcome to use something like `get_posts()` or `query_posts()` with a post_type of "news" and any other parameters you'd like.

= Where did you find the cool newspaper icon for the News tab?

The icons are from the Fugue icon set created by Yusuke Kamiyamane (http://http://p.yusukekamiyamane.com/), licensed under the Creative Commons Attribution 3.0 license (http://creativecommons.org/licenses/by/3.0/).

== Screenshots ==

1. The News tab in the admin menu
2. The News tab open to the admin list of News items
3. Editing an individual News item
4. The Recent News CPT Widget

== Changelog ==

= 1.0 =
* Initial release
* Adds custom post type for News item
* Adds overridable single and archive templates for News items
* Adds recent News item widget

== Upgrade Notice ==

= 1.0 =
Initial release
