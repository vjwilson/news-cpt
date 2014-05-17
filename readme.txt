=== News CPT ===
Contributors: vanjwilson
Tags: news, custom post type, cpt, widget, shortcode
Requires at least: 3.1
Tested up to: 3.9.1
Stable tag: 1.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A quick, easy way to add an extensible News custom post type to Wordpress.

== Description ==

This plugin add a News custom post type to your Wordpress site. Now you can keep your press releases or time-sensitive announcements in a separate list, without having to juggle categories or tags.

The plugin adds a News tab to your admin menu, which allows you to enter news items just as you would regular posts. The archive list of your news items will appear at `/news`, and individual news items will appear at `/news/<permalink>`.

Default single item and archive page templates for news items are also provided. These templates have abundant IDs and classes, so that you can style them with your own CSS.
You may also customize them by putting copies in your theme folder, and changing the markup. When you update the plugin, you will get new features and bug fixes, while keeping any customizations you made in your copies of these templates.

A list of news items may be included in other post content with the list-news-items] shortcode. (See the FAQ for more information on using the shortcode.)

Finally, the plugin adds a Recent News Items widget, which can be placed on any sidebar available in your theme, to show a list of news items in reverse chronological order. You can set the title of this list and the number of news items to show.
 
== Installation ==

1. Upload the `news-cpt` folder to the `/wp-content/plugins/` directory.
1. Activate the News CPT plugin through the 'Plugins' menu in WordPress.
1. Add and manage news items on your site by clicking on the  `News` tab that appears in your admin menu.
1. (Optional) Add and configure the News CPT Widget for one or more your sidebars.

== Frequently Asked Questions ==

= What news templates are available? =

There is one templates named `single-news.php` which controls the display of each individual news item on a page of its own. There is also a template named `archive-news.php` which controls the display of the list of all news items.

= Can I filter the list of news items by date? =

Yes. Just as you can display a list of your regular posts by year, month, or day, you can display news items for a particular year (/news/2013/), month (/news/2013/04/), or day (/news/2013/04/20/).

= What's the easiest way to create my own custom version of the news templates? =

Copy (don't move) the template you wish to customize from `/wp-content/plugins/views/` to `/wp-content/themes/<your-theme-name>/`. Modify the PHP and HTML of the copy in your theme folder, but leave the plugin version alone. You may want to refer back to it if something goes wrong, or you may want to copy new features from it to your custom templates after a plugin update.  

= Do I need to update my permalinks after I activate this plugin? =

No, not usually. While many plugins instruct you to update your permalinks after activation, this plugin tries to update your permalink structure for you. That being said, if the links that begin with `/news` aren't working, please try updating your permalinks first, before reporting a bug or submitting a question to the support forums.

= Are there shortcodes for news items? =

Yes, since Version 1.1.0, the [list-news-items] shortcode is available. It fetches the last X news items in reverse chronological order and outputs them wherever you place the shortcode in any post content.

= Can I customize the list returned by the [list-news-items] shortcode? =

Yes. The [list-news-items] shortcode can take four (4) parameters, which control the number of posts retrieved, whether the thumbnail of the Featured Image of the news item is shown, whether the excerpt is also shown, and whether to filter the news items by a particular category slug.

Here is a list of the parameter names and their defaults:

* count (defaults to 5)
* show_thumbnails (default, 1, which is true)
* show_excerpt (default, 1, which is true)
* category (defaults to '', which will retrieve news items from all categories)
* show_date (default, 0, which will NOT show the date of each item)
* date_format (defaults to '', which will use the default date format, e.g., 'May 13, 2014')

Note: Setting the *show_date* parameter to 'date', 'dateonly' or 1 will cause the date to be printed with each item. Setting it to 'datetime' will cause the date AND time to be printed. Setting it to 'custom' will make it use a date format string that you can supply in the *date_format* parameter. If you specify the 'custom' *show_date* option, the *date_format* string should use the PHP date formatting options: see [http://www.php.net/manual/en/function.date.php](http://www.php.net/manual/en/function.date.php).

Here is an example of the shortcode using all the available parameters:

`[list-news-items count=8 show_thumbnail=0 show_excerpt=0 category='holidays' show_date='custom' date_format='l jS F Y h:i:s A']`

= How can I style the output of the [list-news-items] shortcode? =

You can use your own CSS rules to style the output of the shortcode. The shortcode wraps its output in a div with classes of "news-items" and, if you limit it to a category slug, also a class of "category-<slug>" (where <slug> is the slug you specified in the shortcode).

Each news item listed is structured like an OOCSS media object. See Nicole Sullivan's explanation of styling media objects here: [http://www.stubbornella.org/content/2010/06/25/the-media-object-saves-hundreds-of-lines-of-code/](http://www.stubbornella.org/content/2010/06/25/the-media-object-saves-hundreds-of-lines-of-code/).

Here is an example of the output of the shortcode with only one item, from the category "publishing":

    <div class="news-items category-publishing">
        <div class="post-65 news type-news status-publish hentry category-publishing media news-item">
            <div class="img news-item-thumbnail">
                <a href="/news/a-story-in-the-news/"><img width="48" height="48" src="http://localhost:8888/wp-content/uploads/2013/04/Dandelion.gif" class="attachment-thumbnail wp-post-image" alt="Dandelion"></a>
            </div>  <!-- end of .img.news-item-thumbnail -->
            <div class="bd news-item">
                <h3><a href="/news/a-white-christmas-story-in-the-news/">A White Christmas Story in the News</a></h3>
                <p class="date">Tuesday 13th May 2014 08:49:06 PM</p>
                <p class="description">The excerpt goes here.</p>
            </div>  <!-- end of .bd.news-item -->
        </div>  <!-- end of .media.news-item -->
    </div>  <!-- end of .news-items -->

=  Are there template tags for news items? =

No. Individual news items and the news item list have their own templates. There are no specific tags to add news items to other templates, although if you're comfortable with the Wordpress functions for retrieving posts, you are welcome to use something like `get_posts()` or `query_posts()` with a post_type of "news" and any other parameters you'd like.

= Where did you find the cool newspaper icon for the News tab? =

The icons are from the Fugue icon set created by Yusuke Kamiyamane (http://http://p.yusukekamiyamane.com/), licensed under the Creative Commons Attribution 3.0 license (http://creativecommons.org/licenses/by/3.0/).

== Screenshots ==

1. The News tab in the admin menu
2. The News tab open to the admin list of News items
3. Editing an individual News item
4. The Recent News CPT Widget

== Changelog ==

= 1.1.1 =
* Adds the show_date and date_format parameters to the [list-news-items] shortcode

= 1.1 =
* Adds [list-news-items] shortcode

= 1.0 =
* Initial release
* Adds custom post type for News item
* Adds overridable single and archive templates for News items
* Adds recent News item widget

== Upgrade Notice ==

= 1.1.1 =
Add show_date and date_format options to the [list-news-items] shortcode

= 1.1 =
Get a shortcode to include a list of news items in other posts' content

= 1.0 =
Initial release
