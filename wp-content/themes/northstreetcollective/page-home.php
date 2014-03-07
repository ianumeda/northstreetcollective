<?php
/**
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<div id="page" class="row">
  <div class="col-md-8">
    <div id="welcome" class="col-md-7 col-md-push-5 content lead">
      <!-- <h4 class="section_heading">Welcome</h4> -->
      <?php
      $query = new WP_Query( 'pagename=welcome' );
      if ( $query->have_posts() ) {
      	while ( $query->have_posts() ) {
      		$query->the_post();
      		the_content();
      	}
      } else { ?>
      	<div class="alert alert-danger">Content not found.</div>
      <?php }
      wp_reset_postdata();
      ?>
    </div>
    <div id="news" class="content col-md-5 col-md-pull-7">
      <ul class="nav nav-tabs " id="news_events_tabs">
        <li class="active"><a href="#news_tab" data-toggle="pill">News <span class="glyphicon glyphicon-bullhorn"></span></a></li>
        <li><a href="#events_tab" data-toggle="pill">Events <span class="glyphicon glyphicon-calendar"></span></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="news_tab">
          <?php
            $query = new WP_Query( array( 'category_name' => 'news', 'category__not_in' => array( 6 ), 'posts_per_page' => '5' ));
            if ( $query->have_posts() ) {
            	while ( $query->have_posts() ) {
            		$query->the_post(); 
          ?>
            		<div <?php post_class(); ?>><h5><a href="<?php the_permalink(); ?>"> <?php echo get_the_title(); ?></a></h5>
            		<?php the_excerpt(); ?>
            		<button type="button" class="btn btn-link btn-block btn-xs"><a class="post_preview_link" href="<?php echo get_permalink($post->ID); ?>">Read more <span class="glyphicon glyphicon-chevron-right"></span></a></button>
            		</div>
          <?php }
            } else { ?>
            	<div class="alert alert-danger">Content not found.</div>
            <?php }
            wp_reset_postdata();
          ?>
        </div><!-- #news -->
        <div class="tab-pane " id="events_tab">
          <?php 
          $args = array(
            'post_status'=>'publish',
            'post_type'=>array(TribeEvents::POSTTYPE),
            'posts_per_page'=>5,
            //order by startdate from newest to oldest
            'meta_key'=>'_EventStartDate',
            'orderby'=>'_EventStartDate',
            'order'=>'DESC',
            //required in 3.x
            'eventDisplay'=>'custom'
            //query events by category
            // 'tax_query' => array(
            //     array(
            //         'taxonomy' => 'tribe_events_cat',
            //         'field' => 'slug',
            //         'terms' => 'featured',
            //         'operator' => 'IN'
            //     ),
            // )
          );
          $get_posts = null;
          $get_posts = new WP_Query();

          $get_posts->query($args);
          if($get_posts->have_posts()) : while($get_posts->have_posts()) : $get_posts->the_post(); ?>

            <div <?php post_class(); ?>><h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
              <div class="event_date"><?php echo tribe_events_event_schedule_details(); ?></div>
            <?php the_excerpt(); ?>
        		<button type="button" class="btn btn-link btn-block btn-xs"><a class="post_preview_link" href="<?php get_permalink($post->ID); ?>">Read more <span class="glyphicon glyphicon-chevron-right"></span></a></button>
            </div>
          <?php
            endwhile;
            endif;
            wp_reset_query();
          ?>        
        </div><!-- #events -->
      </div><!-- .tab-content -->
      <button id="link_to_news_page" type="button" class="btn btn-link btn-block">
        <a href="./news-events/">Go to the News &amp; Events Page <span class="glyphicon glyphicon-chevron-right"></span></a>
      </button>
    </div><!-- #news -->
  </div>
  <div id="spotlight" class="content col-md-4">
    <div class="section_heading"><h3>On The Horizon</h3></div>
    <?php
      $query = new WP_Query( array( 'category_name' => 'horizon', 'posts_per_page' => '3' ));
      if ( $query->have_posts() ) {
      	while ( $query->have_posts() ) {
      		$query->the_post();
      		echo '<div class="horizon">';
      		echo '<h4>' . get_the_title() . '</h4>';
      		echo get_preview_image();
      		the_excerpt();
      		echo '<button type="button" class="btn btn-link btn-block btn-xs"><a class="post_preview_link" href=' . get_permalink($post->ID) . '>Read more <span class="glyphicon glyphicon-chevron-right"></span></a></button>';
      		echo '</div>';
      	}
      } else { ?>
      	<div class="alert alert-danger">Content not found.</div>
      <?php }
      wp_reset_postdata();
    ?>
  </div>
</div>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>

