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
  <div class="row">
    <div class="col-md-8 col-md-push-2 col-sm-10 col-sm-push-1 content article">
      <div class="section_heading"><h2>Category Archive: <?php echo single_cat_title( '', false ); ?></h2></div>

        <ol>
        <?php while ( have_posts() ) : the_post(); ?>
        	<li>
        		<article>
        			<h2><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
        			<time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_date(); ?> </time> 
        			<?php the_content(); ?>
        		</article>
        	</li>
        <?php endwhile; ?>
        </ol>
        <?php else: ?>
        <h2>No posts to display in <?php echo single_cat_title( '', false ); ?></h2>
        <?php endif; ?>
      </div>
    </div>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>