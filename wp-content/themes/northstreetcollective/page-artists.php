<?php
/**
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<div class="row">
  <div class="col-lg-10 col-lg-offset-1 ">
    <div class="row">
      <?php Starkers_Utilities::get_template_parts( array( 'parts/shared/page-menu' ) ); ?>
      <div class="col-md-10 col-md-offset-1 content lead">
        <div class="section_heading"><h2><?php the_title(); ?></h2></div>
        <?php the_content(); ?>

        <div id="artist_list">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#by_show" data-toggle="tab">Artists By Show</a></li>
          <li><a href="#by_name" data-toggle="tab">Artists By Name</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane active in fade" id="by_show">
            
        <?php
          // this page gets artists by show
          // 1. get list of shows in reverse chronological order
          // 2. foreach show get artists and apprentices
          //    a. because artists are not directly associated with shows we have to get the artwork and then the associated artists 

          // get all shows...
          $allshows = get_posts( array( 'post_type' => 'show', 'posts_per_page' => '0', 'offset' => '0', 'order' => 'ASC', 'orderby' => 'post_date'));
          foreach($allshows as $show){
            $this_shows_artists=array(); // start a list of the show's artists by post->ID
            echo '<div class="show_section"><h2 class="show_title"><a href="'. get_permalink($show->ID) .'">'. $show->post_title .'</a></h2>';
            // get show's artwork...
            // get "art" terms from this Show post 
            $this_shows_art=get_the_terms($show->ID, 'piece');
            if ( $this_shows_art && ! is_wp_error( $this_shows_art ) ) { 
              $artist_list=array();
              foreach($this_shows_art as $piece){
        	      $art_post=get_post($piece->term_id);
            	  if($art_post){
              		// get art piece's associated artists, list them with Art and store their IDs for the list of artists below...
            	    $arts_artists=get_the_terms($art_post->ID, 'person');
              		if($arts_artists && !is_wp_error( $arts_artists )){
              	    foreach($arts_artists as $artist){
              	      if( !in_array($artist->term_id, $artist_list) ){
                	      array_push($artist_list, $artist->term_id);
              	      }
              	    }
              		}
            		}
              }
            }
            wp_reset_postdata();
            $this_shows_artists = get_posts( array('post_type'=>'person','include'=>implode(',',$artist_list), 'order'=>'ASC', 'orderby'=>'title') );
            // artist loop...
            echo '<div class="row">';
            echo '<div class="col-sm-6 artists"><h5 class="column_heading">Artists</h5>';
            foreach($this_shows_artists as $person){
              setup_postdata( $person );
              if(has_term( 'artist', 'role', $person )){
                echo '<div class="artist_listing"><h3><a href="'. get_permalink($person->ID) .'">'. display_name_format($person->post_title) .'</a></h3></div>';
              }
            }
            echo '</div>';
            // apprentice loop...
            echo '<div class="col-sm-6 apprentices"><h5 class="column_heading">Apprentices</h5>';
            foreach($this_shows_artists as $person){
              setup_postdata( $person );
              if(has_term( 'apprentice', 'role', $person )){
                echo '<div class="artist_listing"><h3><a href="'. get_permalink($person->ID) .'">'. display_name_format($person->post_title) .'</a></h3></div>';
              }
            }
            echo '</div>';
            echo '</div><!-- .row -->';
            echo '</div><!-- .show_section -->';
          }
        ?>            
          </div>
          <div class="tab-pane fade" id="by_name">
            <div class="show_section">
              <?php   
                wp_reset_postdata();
                $all_artists = get_posts( array( 'post_type'=>'person', 'posts_per_page'=>-1, 'order'=>'ASC', 'orderby'=>'title', 'role'=>'artist' ) );
                // artist loop...
                echo '<div class="row">';
                echo '<div class="col-sm-6 artists"><h5 class="column_heading">Artists</h5>';
                foreach($all_artists as $person){
                  setup_postdata( $person );
                  echo '<div class="artist_listing"><h3><a href="'. get_permalink($person->ID) .'">'. display_name_format($person->post_title) .'</a></h3></div>';
                }
                echo '</div>';
                wp_reset_postdata();
                $all_apprentices = get_posts( array( 'post_type'=>'person', 'posts_per_page'=>-1, 'order'=>'ASC', 'orderby'=>'title', 'role'=>'apprentice' ) );
                // apprentice loop...
                echo '<div class="col-sm-6 apprentices"><h5 class="column_heading">Apprentices</h5>';
                foreach($all_apprentices as $person){
                  setup_postdata( $person );
                  echo '<div class="artist_listing"><h3><a href="'. get_permalink($person->ID) .'">'. display_name_format($person->post_title) .'</a></h3></div>';
                }
                echo '</div>';
                echo '</div><!-- .row -->';
                echo '</div><!-- .show_section -->';
                wp_reset_postdata();
              
              ?>
              <!-- </div> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php endwhile; ?>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
