<?php
/**
 * @package News Custom Post Type
 * @author Van Wilson
 * @version 1.1.1
*/
/*
Plugin Name: News Custom Post Type
Plugin URI: http://vanwilson.info/wordpress/plugins/news-cpt-plugin-for-wordpress/
Description: This plugin registers a custom post type for News items and helps to manage those custom posts. It allows news items to be input from the admin area. Next, the plugin provides default templates to output the News items as single or archive pages. Finally, it adds a Recent News Items widget, which can be placed on any sidebar, to show a user-configurable number of news items in reverse chronological order.
Author: Van Wilson
Version: 1.1.1
Author URI: http://vanwilson.info/
License: GPL2
*/
/*  Copyright 2012  Van Wilson      (email : van at vanwilson.info)
	
	    This program is free software; you can redistribute it and/or modify
	    it under the terms of the GNU General Public License, version 2, as
	    published by the Free Software Foundation.
	
	    This program is distributed in the hope that it will be useful,
	    but WITHOUT ANY WARRANTY; without even the implied warranty of
	    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	    GNU General Public License for more details.
	
	    You should have received a copy of the GNU General Public License
	    along with this program; if not, write to the Free Software
	    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

  Icons from the Fugue icon set created by Yusuke Kamiyamane (http://http://p.yusukekamiyamane.com/), licensed under the Creative Commons Attribution 3.0 license (http://creativecommons.org/licenses/by/3.0/).

*/

// Initialization function
add_action('init', 'news_cpt_init');
function news_cpt_init() {
  // Create new News custom post type
    $labels = array(
    'name' => _x('News', 'post type general name'),
    'singular_name' => _x('News', 'post type singular name'),
    'add_new' => _x('Add News Item', 'news'),
    'add_new_item' => __('Add New News Item'),
    'edit_item' => __('Edit News Item'),
    'new_item' => __('New News Item'),
    'view_item' => __('View News Item'),
    'search_items' => __('Search  News Items'),
    'not_found' =>  __('No News Items found'),
    'not_found_in_trash' => __('No  News Items found in Trash'), 
    '_builtin' =>  false, 
    'parent_item_colon' => '',
    'menu_name' => 'News'
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'show_ui' => true,
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array( 
                'slug' => 'news',
                'with_front' => false
                ),
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => 8,
    'menu_icon' => plugins_url( 'images/newspaper.png', __FILE__ ),
    'supports' => array('title','editor','thumbnail','excerpt'),
    'taxonomies' => array('category', 'post_tag')
  );
  register_post_type('news',$args);
}

/* 
The following method of getting permalinks to work with the News CTP is taken directly from the Wordpress Codex: http://codex.wordpress.org/Function_Reference/register_post_type
*/
function my_rewrite_flush() {
    // First, we "add" the custom post type via the above written function.
    // Note: "add" is written with quotes, as CPTs don't get added to the DB,
    // They are only referenced in the post_type column with a post entry, 
    // when you add a post of this CPT.
    news_cpt_init();

    // ATTENTION: This is *only* done during plugin activation hook in this example!
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'my_rewrite_flush' );

// Sidebar widget to display recent news items
/* Begin Widget Class */
class News_CTP_Widget extends WP_Widget {

    /* Widget setup  */
    function News_CTP_Widget() {

        /* Widget settings. */
        $widget_ops = array('classname' => 'News_CTP_Widget', 'description' => __('Displayed News Items from the News custom post type in a block in a sidebar', 'news_cpt') );

        /* Widget control settings. */
        $control_ops = array( 'width' => 350, 'height' => 450, 'id_base' => 'news_cpt_widget' );

        $this->WP_Widget( 'news_cpt_widget', __('News CTP Widget', 'news_cpt'), $widget_ops, $control_ops );
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array( 'title' => '' ));
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $num_items = isset($instance['num_items']) ? absint($instance['num_items']) : 5;
    ?>
      <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
      <p><label for="<?php echo $this->get_field_id('num_items'); ?>">Number of Items: <input class="widefat" id="<?php echo $this->get_field_id('num_items'); ?>" name="<?php echo $this->get_field_name('num_items'); ?>" type="text" value="<?php echo attribute_escape($num_items); ?>" /></label></p>
    <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['num_items'] = $new_instance['num_items'];
        return $instance;
    }
    function widget($args, $instance) {
        extract($args, EXTR_SKIP);

        $current_post_name = get_query_var('name');

        $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
        $num_items = empty($instance['num_items']) ? '5' : apply_filters('widget_title', $instance['num_items']);

        $postcount = 0;

        echo $before_widget;

?>
            <h4 class="title-news-cpt"><?php echo $title ?></h4>
            <!--visual-columns-->
            <div class="recent-news-items">
                <ul>
            <?php // setup the query
            $args = array( 'suppress_filters' => true,
                           'posts_per_page' => $num_items,
                           'post_type' => 'news',
                           'order' => 'DESC'
                         );

            $cust_loop = new WP_Query($args);
            if ($cust_loop->have_posts()) : while ($cust_loop->have_posts()) : $cust_loop->the_post(); $postcount++;
                    ?>
                    <li>
                        <a class="post-title" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                    </li>
            <?php endwhile;
            endif;
             wp_reset_query(); ?>

                </ul>
            </div>
<?php
        echo $after_widget;
    }
}

/* Register the widget */
function news_cpt_widget_load_widgets() {
    register_widget( 'News_CTP_Widget' );
}

/* Load the widget */
add_action( 'widgets_init', 'news_cpt_widget_load_widgets' );

// Function to return single or archive template for news custom post types
function get_news_cpt_template( $template_path ) {

    if ( get_post_type() == 'news' ) {
        if ( is_single() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-news.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/views/single-news.php';
            }
        } elseif ( is_archive() ) {
            if ( $theme_file = locate_template( array ( 'archive-news.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/views/archive-news.php';
            }
        }

    }

    return $template_path;
}

add_filter( 'template_include', 'get_news_cpt_template' ) ;


// functions to add date-based rewrite rules for the news custom post type

function news_cpt_datearchives_rewrite_rules( $wp_rewrite ) {
  $rules = news_cpt_generate_date_archives( 'news', $wp_rewrite );
  $wp_rewrite->rules = $rules + $wp_rewrite->rules;
  return $wp_rewrite;
}

function news_cpt_generate_date_archives( $cpt, $wp_rewrite ) {
  $rules = array();

  $post_type = get_post_type_object( $cpt );
  $slug_archive = $post_type->has_archive;
  if ($slug_archive === false) return $rules;
  if ($slug_archive === true) {
    $slug_archive = $post_type->rewrite['slug'];
  }

  $dates = array(
            array(
              'rule' => "([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})",
              'vars' => array('year', 'monthnum', 'day')),
            array(
              'rule' => "([0-9]{4})/([0-9]{1,2})",
              'vars' => array('year', 'monthnum')),
            array(
              'rule' => "([0-9]{4})",
              'vars' => array('year'))
        );

  foreach ($dates as $data) {
    $query = 'index.php?post_type='.$cpt;
    $rule = $slug_archive.'/'.$data['rule'];

    $i = 1;
    foreach ($data['vars'] as $var) {
      $query.= '&'.$var.'='.$wp_rewrite->preg_index($i);
      $i++;
    }

    $rules[$rule."/?$"] = $query;
    $rules[$rule."/feed/(feed|rdf|rss|rss2|atom)/?$"] = $query."&feed=".$wp_rewrite->preg_index($i);
    $rules[$rule."/(feed|rdf|rss|rss2|atom)/?$"] = $query."&feed=".$wp_rewrite->preg_index($i);
    $rules[$rule."/page/([0-9]{1,})/?$"] = $query."&paged=".$wp_rewrite->preg_index($i);
  }
  return $rules;
}

add_action('generate_rewrite_rules', 'news_cpt_datearchives_rewrite_rules');

/**
 * list_news_items_shortcode
 *
 * @atts   list of attributes specified by user in shortcode
 *
 * @since 1.1.1 Added the show_date and date_format shortcode arguments.
 * @since 1.1.0
 */
function list_news_items_shortcode( $atts ) {
    global $post;

    $default = array(
      'count'          => 5,
      'show_thumbnail' => true,
      'category'       => '',
      'show_date'      => false,
      'date_format'    => '',
      'show_excerpt'   => true,
    );

    // extract the attributes into variables
    extract( shortcode_atts( $default, $atts ) );

    /* if a category slug was passed in,
     * try to retrieve the category ID for that slug
     * in order to limit the query
     *
     */
    $div_class = '';
    if ( '' !== $category ) { 
        $cat_obj = get_category_by_slug( $category );
        if ( $cat_obj ) {
            $catID = $cat_obj->term_id;
            $div_class = "category-$category";
        } else {
            $catID = 0;
        }
    } else {
        $catID = 0;
    }
    
    $args = array(
      'post_type'   => 'news',
      'numberposts' => $count,
      'category'    => $catID,
      'post_status' => 'publish',
      'orderby'     => 'post_date',
      'order'       => 'DESC',
    );

    $posts = get_posts( $args );


    $output = '';
    if( count($posts) ):
        $output .= "<div class=\"news-items $div_class\">";
        foreach( $posts as $post ): setup_postdata( $post );
          $meta = get_post_custom( $post->ID );
          $thumb = get_the_post_thumbnail( $post->ID, 'thumbnail' );
          $link = get_permalink( $post->ID );
          if ( $show_date ) {
            switch ( $show_date ) {
              case 'custom':
                if ( $date_format ) {
                  $custom_date_format = sanitize_text_field( $date_format );
                  $date = get_the_date( $custom_date_format );
                } else {
                  $date = get_the_date( 'F j, Y' );
                }
                break;
              case 'datetime':
                $date = get_the_date( 'F j, Y g:i a' );
                break;
              case 'date':
              case 'dateonly':
              default:
                $date = get_the_date( 'F j, Y ' );
                break;
            }
          }
          $excerpt = get_the_excerpt();
          $classes = get_post_class( array( 'media', 'news-item' ) );
          $class_string = implode( ' ', $classes );
          $output .= "<div class=\"$class_string\">";
          if ( $show_thumbnail ) :
              $output .=  <<<EOD
              <div class="img news-item-thumbnail">
                  <a href="{$link}">{$thumb}</a>
              </div>  <!-- end of .img.news-item-thumbnail -->
EOD;
          endif;
          $output .=  <<<EOD
              <div class="bd news-item">
                  <h3><a href="{$link}">{$post->post_title}</a></h3>
EOD;
          if ( $show_date ) :
              $output .=  <<<EOD
                  <p class="date">{$date}</p>
EOD;
          endif;
          if ( $show_excerpt ) :
              $output .=  <<<EOD
                  <p class="description">{$excerpt}</p>
EOD;
          endif;
          $output .=  <<<EOD
              </div>  <!-- end of .bd.news-item -->

            </div>  <!-- end of .media.news-item -->
EOD;
        endforeach; wp_reset_postdata();
        $output .= '</div>  <!-- end of .news-items -->';
    endif;

    return $output;
}

add_shortcode('list-news-items', 'list_news_items_shortcode');
