<?php
/**
 * The Template for displaying all people posts
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
<div class="row">
  <div id="pagenav_mobile" class="col-md-12 hidden-md hidden-lg">
    <?php $menu='people'; ?>
  	<?php if(!empty($menu)) wp_nav_menu( array('menu'=>$menu,'menu_class'=>'nav nav-pills','walker'=>new wp_bootstrap_navwalker())); ?>
  </div>
  <div id="pagenav" class="col-md-3 hidden-sm hidden-xs">
  	<?php if(!empty($menu)) wp_nav_menu( array('menu'=>$menu,'menu_class'=>'nav nav-pills nav-stacked','walker'=>new wp_bootstrap_navwalker())); ?>
  </div>
    <div class="col-md-9 content person_page">
      <div class="row">
        <div class="col-xs-8">
          <article>
          <h2 class="section_heading">
            <?php 
              echo display_name_format(get_the_title()); 
          		if($titles=wp_get_post_terms($post->ID, 'title', array("fields" => "names"))) { 
          		  echo '<span class="titles">';
          		  foreach($titles as $title){
          		    echo ', ';
          		    echo $title;
          		  }
          		  echo '</span>';
          		}
            ?>
          </h2>
            <?php the_content(); ?>
          </article>
        </div>
        <div class="col-xs-4">
          <?php
            if (has_post_thumbnail( $post->ID ) ){
              $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
              $imgurl=$image[0];
              echo '<div class="image headshot"><img src="'. $imgurl .'"></div>';
            } else {
        		  echo '<div class="image headshot"><span class="glyphicon glyphicon-user"></span></div>';
            }
          ?>
        </div>
      </div>
    </div>
  </div>


<?php endwhile; ?>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>