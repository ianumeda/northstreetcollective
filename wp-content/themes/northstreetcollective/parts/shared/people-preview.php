<?php

echo '<div class="person_item col-sm-4">';
echo '<a class="post_preview_link" href=' . get_permalink($post->ID) . '>';
if (has_post_thumbnail( $post->ID ) ){
  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); 
  $imgurl=$image[0];
  echo '<div class="image headshot" style="background-image: url('. $imgurl .');"></div>';
} else {
  echo '<div class="image headshot"><span class="glyphicon glyphicon-user"></span></div>';
}
echo '<h5 class="name">' . display_name_format(get_the_title());
if($titles=wp_get_post_terms($post->ID, 'title', array("fields" => "names"))) { 
  echo '<span class="titles">';
  foreach($titles as $title){
    echo ', ';
    echo $title;
  }
  echo '</span>';
}
echo '</h5>';
echo '</a>';
the_excerpt();
echo '<button type="button" class="btn btn-link btn-block btn-xs"><a class="post_preview_link" href=' . get_permalink($post->ID) . '>Go to '. display_name_format(get_the_title()) .'\'s Page <span class="glyphicon glyphicon-chevron-right"></span></a></button>';
echo '</div>';

?>