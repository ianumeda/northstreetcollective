<?php
/**
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header-homegrid' ) ); ?>


<div class="row">
  <div id="home_grid" class="col-md-12">
  
    <div id="branding">
      <div id="logo"><img src="http://northstreetcollective.org/wp-content/uploads/2013/11/logo-orange-whitemargin-137x240.jpg" alt="North Street Collective"></div>
      <div id="title"></div>
      <div id="subtitle"></div>
      <div id="menu_button">MENU</div>
    </div>
  
    <div id="carousel1" class="carousel left slide col-xs-12 col-sm-6" data-interval="10000" data-ride="carousel">
      <?php
      $carousel_items='';
      $i=0;
      // current show is set by "home" (id==5) page's "show" setting
      $showtags=wp_get_post_terms( $post->ID ,'show', array('fields'=>'slugs'));
      // get show's slide first...
      $args=array( 'name' => strtolower($showtags[0]), 'post_type' => 'show', 'posts_per_page' => 1 );
      $posts = get_posts( $args );
      if( !empty($posts) ) 
      {
        $i++;
        foreach ( $posts as $post ) 
        {
          setup_postdata( $post ); 
          $current_show_link=get_permalink($post->ID);
          $current_show_title=get_the_title($post->ID);
      		if (has_post_thumbnail( $post->ID ) )
          {
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
            $imgurl=$image[0];
          } 
          else $imgurl="";
          $carousel_items.='        
          <div class="carousel_background item active" style="background-image:url('. $imgurl .');">
            <div class="caption_overlay"></div>
            <div class="the_content">
              <h1><a href="'. $current_show_link .'">'. $current_show_title .'</a></h1>
              <div class="excerpt">
                <p>'. get_the_excerpt($post->ID) .'</p>
                <h6><a href="'. $current_show_link .'">Go to the current show <span class="glyphicon glyphicon-arrow-right"></span></a></h6>
              </div>
            </div>
            
            <div class="carousel-bottom">&nbsp;</div> 
          </div> ';
        }
        wp_reset_postdata();
        // then get artwork in the show...
        $query = new WP_Query( array( 'post_type' => 'piece', 'tax_query' => array ( array ( 'taxonomy' => 'show', 'field' => 'slug', 'terms' => $showtags[0], 'operator' => 'IN' ) ), 'posts_per_page' => '0', 'offset' => '0', 'order' => 'ASC'));
        if ( $query->have_posts() ) 
        {
        	while ( $query->have_posts() ) 
          {
        	  $i++;
        		$query->the_post();
        		if (has_post_thumbnail( $post->ID ) )
            {
              $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
              $imgurl=$image[0];
            } 
            else $imgurl="";
            $carousel_items.='
              <div class="carousel_background item" style="background-image:url('. $imgurl .'); ">
                <div class="caption_overlay"></div>
                <div class="the_content">
                  <h5><a href="'. $current_show_link .'">'. $current_show_title .'</a> :</h5>
                  <h1><a href="'. get_permalink($post->ID) .'">'. get_the_title($post->ID) .'</a></h1>
                  <div class="excerpt">
                    <p>'. get_the_excerpt($post->ID) .'</p>
                    <h6 class="hidden-xs"><a href="'. $current_show_link .'">Go to the current show <span class="glyphicon glyphicon-arrow-right"></span></a></h6>
                    <h6 class="hidden-xs"><a href="'. get_permalink($post->ID) .'">View this artwork <span class="glyphicon glyphicon-arrow-right"></span></a></h6>
                  </div>
                </div>
                <div class="carousel-bottom">&nbsp;</div>
              </div>';
        	}
        } 
        if(!empty($carousel_items)) echo '<div class="carousel-inner">'. $carousel_items .'</div>';
        else echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Content not found.</div>';
        if($i > 0) 
        { 
          $carousel_indicators='<div class="carousel_nav"><div class="nav nav_left"><a href="#carousel1" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"></span> </a></div> <ol class="nav carousel-indicators">'; //initiate the indicator variable so we can build this dynamically 
          for($k=0; $k<=$i-1; $k++){
            $carousel_indicators.='<li data-target="#carousel1" data-slide-to="'.$k.'" class="carousel-indicator';
            if($k==0) $carousel_indicators.=' active';
            $carousel_indicators.='"></li>';
          }
          $carousel_indicators.='</ol> <div class="nav nav_right"><a class="" href="#carousel1" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a></div></div>';
          echo $carousel_indicators;
        }
      }
      wp_reset_postdata(); 
      ?>
      <!-- Controls -->
      <!-- <a class="left carousel-control" href="#carousel1" data-slide="prev">
        <span class="icon-prev"></span>
      </a>
      <a class="right carousel-control" href="#carousel1" data-slide="next">
        <span class="icon-next"></span>
      </a> -->
    </div>
    

  
    <div id="home_stack" class="right col-xs-12 col-sm-6">
      <?php
      $carousel_items='';
      $i=0;
      // get show's slide first...
      $args=array( 'post_type' => 'post', 'category_name'=>'news', 'posts_per_page' => 5 );
      $posts = get_posts( $args );
      if( $posts ) {
        foreach ( $posts as $post ) {
          $i++;
          setup_postdata( $post ); 
          $post_link=get_permalink($post->ID);
          $post_title=get_the_title($post->ID);
      		if (has_post_thumbnail( $post->ID ) )
          {
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
            $imgurl=$image[0];
          } 
          else $imgurl="";
        
          $carousel_items.='<div class="row homegrid_stack_item '. ($i==1 ? "active" : "") .'" style="background-image:url('. $imgurl .');">
                              <div class="caption_overlay"></div>
                              <div class="the_content">
                                <h1><a href="'. $post_link .'">'. $post_title .'</a></h1>
                                <div class="excerpt">
                                  <p>'. get_the_excerpt($post->ID) .'</p>
                                  <h6 class=""><a href="'. $post_link .'">Go to post <span class="glyphicon glyphicon-arrow-right"></span></a></h6>
                                </div>
                              </div>
                            </div> ';
        }
      }
      if(!empty($carousel_items)) echo $carousel_items;
      else echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign"></span> Content not found.</div>';
      wp_reset_postdata(); 
      ?>
    </div>
</div>
<div id="welcome_modal" class="modal fade">
  <div class="modal-dialog" style="left:0;">
    <div class="modal-content">
      <?php
      $query = new WP_Query( 'pagename=welcome' );
      if ( $query->have_posts() ) {
      	while ( $query->have_posts() ) {
      		$query->the_post();
      ?>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <img style="display:block; margin:0 auto;" src="http://northstreetcollective.org/wp-content/uploads/2013/11/logo-orange-whitemargin-137x240.jpg" alt="North Street Collective">
          <!-- <h4 class="modal-title"><?php the_title(); ?></h4> -->
        </div>
        <div class="modal-body">
          <?php the_content(); ?>
        </div> 
  
      <?php           
      	}
      } 
      wp_reset_postdata();
      ?>
      <div class="modal-footer menu">
      	<?php wp_nav_menu( array('menu'=>'home-modal-menu','menu_class'=>'nav navbar-nav','walker'=>new wp_bootstrap_navwalker())); ?>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<script>
$(document).ready(function(){
  $('#carousel1').carousel({
        interval: (8000+Math.random(5000)),
         cycle: true
  });
  $('#carousel2').carousel({
        interval: (8000+Math.random(5000)),
         cycle: true
  });
  $('#branding').click(function(){
    $('#welcome_modal').modal('show');
  });
});
</script>

<?php Starkers_Utilities::get_template_parts( array('partst/shared/footer-homegrid', 'parts/shared/html-footer' ) ); ?>

