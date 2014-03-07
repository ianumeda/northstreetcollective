<?php
/**
 * The Template for displaying all single posts
 *
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<?php
  // get art piece's show post to create link back
  $showtags=wp_get_post_terms( $post->ID ,'show', array('fields'=>'names'));
  $myshow=$showtags[0];
  $args=array( 'name' => strtolower($myshow), 'post_type' => 'show', 'posts_per_page' => 1 );
  $posts = get_posts( $args );
  foreach ( $posts as $post ) : setup_postdata( $post ); 
    $show_backlink='<a href="'. get_permalink($post->ID) .'" alt="Go back to &ldquo;'. get_the_title($post->ID) .'&rdquo;">'. get_the_title($post->ID) .'</a>';
  endforeach; 
  wp_reset_postdata();
?>
  <div class="row">
    <div class="col-md-8 col-md-push-2 content">
          <article>
          <h2 class="section_heading"><?php if($show_backlink) echo $show_backlink . " : " ?><?php the_title(); ?></h2>
        	<time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_date(); ?></time> <?php if(comments_open()) comments_popup_link('<span class="glyphicon glyphicon-comment">', '1 Comment', '% Comments'); ?></span>
            <?php the_content(); ?>
            <?php if(comments_open()) comments_template( '', true ); ?>
          </article>
    </div>
  </div>


<?php endwhile; ?>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>