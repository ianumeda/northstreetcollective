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
  <?php $menu=get_post_meta($post->ID, 'menu', true) ? $menu : $menu='about'; ?>

<div class="row">
  <div id="pagenav_mobile" class="col-md-12 hidden-md hidden-lg">
  	<?php wp_nav_menu( array('menu'=>'about','menu_class'=>'nav nav-pills','walker'=>new wp_bootstrap_navwalker())); ?>
  </div>
  <div id="pagenav" class="col-md-3 hidden-sm hidden-xs">
  	<?php wp_nav_menu( array('menu'=>'about','menu_class'=>'nav nav-pills nav-stacked','walker'=>new wp_bootstrap_navwalker())); ?>
  </div>
  <div class="col-md-8 content">
    <div class="row">
      <div class="col-sm-12">
        <h5 class="section_heading"><?php the_title(); ?></h5>
        <?php the_content(); ?>
        <?php
          $query = new WP_Query( array( 'category__and' => array( 5, 6 ), 'posts_per_page' => '1', 'offset' => '0' ));
          if ( $query->have_posts() ) {
          	while ( $query->have_posts() ) {
          		$query->the_post();
          		echo '<div class="top_news_item lead">';
          		echo '<h2>' . get_the_title() . '</h2>';
              if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail or "featured image" assigned to it.
                echo '<div class="top_post_image">';
                the_post_thumbnail('large');
                echo '</div>';
              } 
          		the_content();
          		echo '<button type="button" class="btn btn-link btn-block btn-xs"><a class="post_preview_link" href=' . get_permalink($post->ID) . '>Go to Article <span class="glyphicon glyphicon-chevron-right"></span></a></button>';
          		echo '</div>';
          	}
          } else { ?>
          	<div class="alert alert-danger">Error: Content not found.</div>
          <?php }
          wp_reset_postdata();
          ?>
      </div>
      <div id="news_feed" class="col-sm-6">
        <h5 class="section_heading">News</h5>
        <?php
          $query = new WP_Query( array( 'category_name' => 'news', 'posts_per_page' => '5', 'offset' => '1' ));
          if ( $query->have_posts() ) {
          	while ( $query->have_posts() ) {
          		$query->the_post(); ?>
              <div class="news_item">
                <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
            		<?php the_excerpt(); ?>
            		<button type="button" class="btn btn-link btn-block btn-xs"><a class="post_preview_link" href="<?php the_permalink(); ?>">Read more <span class="glyphicon glyphicon-chevron-right"></span></a></button>
          		</div>
          	<?php }
          } else { ?>
          	<div class="alert alert-danger">Error: Content not found.</div>
          <?php }
          wp_reset_postdata();
        ?>
      </div>
      <div id="events_feed" class="col-sm-6">
        <h5 class="section_heading">Events</h5>
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
          <?php
						if( tribe_get_start_date($post->ID, true, 'U')-strtotime('now') < 86400) {
							if( tribe_get_end_date($post->ID, true, 'U') < strtotime('now') ) $eventstatus="passed"; // event is over
							elseif( tribe_get_start_date($post->ID, true, 'U') < strtotime('now')) $eventstatus="now"; // event is happening now
							else /*if( tribe_get_start_date($post->ID, true, 'Ymdhi') <= date('Ymdhi', time('now')) )*/ $eventstatus="soon"; // event is upcoming within the next 24 hours
						}
						else $eventstatus="future";
          ?>
          <div class="event_item event_<?php echo $eventstatus; ?>"><div class="event_status event_<?php echo $eventstatus; ?>"><?php if($eventstatus!="future") echo $eventstatus; ?></div><h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
            <div class="event_date"><?php echo tribe_events_event_schedule_details(); ?></div>
          <?php the_excerpt(); ?>
      		<button type="button" class="btn btn-link btn-block btn-xs"><a class="post_preview_link" href="<?php get_permalink($post->ID); ?>">Read more <span class="glyphicon glyphicon-chevron-right"></span></a></button>
          </div>
        <?php
          endwhile;
          endif;
          wp_reset_query();
        ?>        
      </div>
    </div>
  </div>
</div>

<?php endwhile; ?>

<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>
