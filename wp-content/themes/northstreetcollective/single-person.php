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
<div class="container">
    <div class="content person_page <?php echo $roles[0]; ?>">
      <div class="row">
          <div class="section_heading">
            <h2><?php echo display_name_format(get_the_title()); ?></h2>
            <span class="subheading">
              <div class="roles">
              <?php 
              foreach($roles as $role){
                echo $role;
                echo ($role==$roles[count($roles)-1]) ? "" : ", ";
              }
              ?>
              </div>
              <?php
              // the following collects the class names that this person is associated with
              $my_classes=array();
              $all_classes = get_posts( array( 'post_type' => 'class', 'posts_per_page' => '0', 'offset' => '0', 'order' => 'DESC', 'orderby' => 'date'));
              foreach($all_classes as $class){
                $class_people=get_the_terms($class, 'person');
                foreach($class_people as $this_person){
                  if($post->ID == $this_person->term_id){
                    $my_classes[]=get_the_title($class);
                  }
                }
              }
              if(!empty($my_classes)){ ?>
                
                <div class="classes">

                <?php
                  foreach($my_classes as $class){
                  echo $class;
                  echo ($class==$my_classes[count($my_classes)-1] ? "" : ", ");
                }
                ?>
                </div>
              <?php } ?>
              </span>
          </div>
        <div class="col-sm-4 col-sm-push-8 col-xs-12">
          <?php
            if (has_post_thumbnail( $post->ID ) ){
              $artist_mugshot = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
            }
            if ($artist_mugshot){
              $imgurl=$artist_mugshot[0];
              echo '<div class="image headshot"><img src="'. $imgurl .'"></div>';
            } else {
        		  echo '<div class="image headshot"><span class="glyphicon glyphicon-user"></span></div>';
            }
          ?>
        </div>
        <div class="col-sm-8 col-sm-pull-4 col-xs-12">
          <article>
          <?php the_content(); ?>
          </article>
        </div>
      </div>
      <div class="row">
        
        <?php if( in_array( 'artist' , $roles ) || in_array('apprentice', $roles) ) { ?>
        <div class="section_heading"><h3>Artwork:</h3></div>
        <div class="artists_art_list">
        <?php 
        $artists_artwork=get_artists_art($post->ID);
        foreach($artists_artwork as $artwork_id){ 
          $piece=get_post($artwork_id);
          ?>
          <div class="post_preview">
            <h5><?php echo $piece->post_title; ?></h5>
            <a class="post_preview_link link_overlay" href="<?php echo get_permalink($piece->ID); ?>" alt="<?php echo $piece->post_title; ?>"><span class="glyphicon glyphicon-chevron-right"></span></a>
          </div>
        <?php } ?>
        <?php } // end if (is artist) ?>
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
  </div>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>