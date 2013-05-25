<?php
/*Template Name: Archive News
 *
 * You can customize this view by putting a replacement file of the same name (single.php) in the events/ directory of your theme.
 *
 */
 
get_header(); 
?>

<div id="primary" class="site-content">
  <div id="content" role="main" class="news-cpt widecolumn">
  
    <div class="archive-header">
				<h1 class="archive-title"><?php
					if ( is_day() ) :
						printf( __( 'Daily News Archives: %s' ), '<span>' . get_the_date() . '</span>' );
					elseif ( is_month() ) :
						printf( __( 'Monthly News Archives: %s' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'twentytwelve' ) ) . '</span>' );
					elseif ( is_year() ) :
						printf( __( 'Yearly News Archives: %s' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'twentytwelve' ) ) . '</span>' );
					else :
						_e( 'News' );
					endif;
				?></h1>
    </div> <!-- .archive-header -->
  
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    
      <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
          <div class="post-info">
              <span class="date published time" title="<?php the_time('c') ?>"><?php the_time('F j, Y') ?></span>
          </div>
          <div class="entry-content">
                  <?php
                  if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) {
                    the_post_thumbnail();
                  }
                  ?>
                  <div class="summary"><?php the_excerpt(); ?> <a class="moretag" href="<?php the_permalink() ?>"> Read the full news article</a></div>
          </div>
          <?php edit_post_link(__('Edit'), '<span class="edit-link">', '</span>'); ?>
      </div><!-- post -->
      
    <?php endwhile; ?>
    
      <div class="navigation">
        <div class="alignleft"><?php next_posts_link('Previous entries') ?></div>
        <div class="alignright"><?php previous_posts_link('Next entries') ?></div>
      </div>
    
    <?php else: ?>
    
      <p>There are no news items to display.</p>

    <?php endif; ?>
    
    </div><!-- #content -->
    
</div><!--#primary-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>