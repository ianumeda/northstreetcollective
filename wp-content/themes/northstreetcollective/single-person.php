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
  <?php $roles=wp_get_post_terms($post->ID, 'role', array("fields" => "slugs")); ?>
<div class="row">
    <div class="col-md-10 col-md-push-1 content person_page <?php echo $roles[0]; ?>">
      <div class="row">
        <div class="col-xs-8">
          <article>
          <div class="section_heading">
            <?php echo '<span class="preheading">'.$roles[0]." : </span>"; ?>
            <h2><?php echo display_name_format(get_the_title()); ?></h2>
          </div>
          <?php the_content(); ?>
          <?php
          if (has_post_thumbnail( $post->ID ) ){
            $artist_mugshot = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
          }
          // get the artists associated artwork by querying art with this person id
          // $my_artwork=get_posts( array( 'post_type'=>'piece', 'post_per_page'=>-1, 'tax_query' => array( array( 'taxonomy' => 'person', 'field' => 'slug', 'terms' => array($post->post_name) ) ) ) );
          ?>
          <?php if( $roles[0]=='artist' || $roles[0]=='apprentice') { ?>
          <div class="section_heading"><h3>Artwork:</h3></div>
          <ul class="artists_art_list">
          <?php 
          $all_art=get_posts( array('post_type'=>'piece', 'posts_per_page'=>-1) );
          $all_shows=get_posts( array('post_type'=>'show', 'posts_per_page'=>-1) );
          foreach($all_art as $piece){
        	    $arts_artists=get_the_terms($piece->ID, 'person');
          		if($arts_artists && !is_wp_error( $arts_artists )){
                foreach($arts_artists as $artist){
                  if($artist->slug == $post->post_name){
                    echo '<li><a href="'.get_permalink($piece->ID).'">'.$piece->post_title.'</a>';
                    foreach($all_shows as $show){
                      $shows_art=get_the_terms($show->ID,'piece');
                      if($shows_art && !is_wp_error( $shows_art) ){
                        foreach($shows_art as $show_art){
                          if($show_art->slug == $piece->post_name){
                            echo ' : <a href="'.get_permalink($show->ID).'">'.$show->post_title.'</a>';
                          }
                        }
                      }
                    }
                    echo '</li>';          
                  }
                }
          		}
          }
          ?>  
            </ul>
            <? } // end if (is artist) ?>
          </article>
        </div>
        <div class="col-xs-4">
          <?php
            if ($artist_mugshot){
              $imgurl=$artist_mugshot[0];
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
<div class="row">
  <h3 class="section_heading">Browse People:</h3>
<ul class="pager">
  <li><?php previous_post_link('%link', '<span class="glyphicon glyphicon-arrow-left"></span> %title'); ?></li>
  <li><?php next_post_link('%link', '%title <span class="glyphicon glyphicon-arrow-right"></span>'); ?></li>
</ul>
</div>


<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>