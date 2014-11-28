<?php
/**
 * The template for displaying Category Archive pages
 *
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php if ( have_posts() ): ?>
<div class="container">
    <div class="content article">
      <div class="section_heading"><h2>Archive: <?php echo single_cat_title( '', false ); ?></h2></div>

      	<div class="row">

        <?php while ( have_posts() ) : the_post(); ?>

              <div class="col-xs-12 col-md-6 col-lg-4">
                <div class="row post_preview">
                  <div class="post_preview_thumbnail col-xs-3">
<?php
                if(has_post_thumbnail( $post->ID ) ){
                  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' ); 
                  $imgurl=$image[0];
?>
                <div class="background_thumbnail" style="background-image: url('<?php echo $imgurl; ?>')"></div>
            <?php 
              } else { 
            ?>
                <div class="background_thumbnail"></div>
            <?php 
              }
              ?>
              </div>
              <div class="post_preview_content col-xs-9">
          			<time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_date(); ?> </time> 
        		    <h4><?php echo $post->post_title; ?> </h4>
          			<?php the_excerpt(); ?>
                </div>
              <a href="<?php echo get_permalink($post->ID); ?>" alt="<?php echo $post->post_title; ?>" class="post_preview_link link_overlay btn btn-link btn-xs"><span class="glyphicon glyphicon-chevron-right"></span></a>
            </div>
          </div>

        <?php endwhile; ?>
        	</div>
        <?php else: ?>
        <h2>No posts to display in <?php echo single_cat_title( '', false ); ?></h2>
        <?php endif; ?>
      </div>
  </div>
</div>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>