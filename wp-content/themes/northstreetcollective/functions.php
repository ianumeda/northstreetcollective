<?php
	/**
	 * Starkers functions and definitions
	 *
	 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
	 *
 	 * @package 	WordPress
 	 * @subpackage 	Starkers
 	 * @since 		Starkers 4.0
	 */

	/* ========================================================================================================================
	
	Required external files
	
	======================================================================================================================== */

	require_once( 'external/starkers-utilities.php' );
	require_once( 'wp_bootstrap_navwalker.php' );

	/* ========================================================================================================================
	
	Theme specific settings

	Uncomment register_nav_menus to enable a single menu with the title of "Primary Navigation" in your theme
	
	======================================================================================================================== */

	add_theme_support('post-thumbnails');
	
	// register_nav_menus(array('primary' => 'Primary Navigation'));

	/* ========================================================================================================================
	
	Actions and Filters
	
	======================================================================================================================== */

	add_action( 'wp_enqueue_scripts', 'starkers_script_enqueuer' );

	add_filter( 'body_class', array( 'Starkers_Utilities', 'add_slug_to_body_class' ) );

	/* ========================================================================================================================
	
	Custom Post Types - include custom post types and taxonimies here e.g.

	e.g. require_once( 'custom-post-types/your-custom-post-type.php' );
	
	======================================================================================================================== */



	/* ========================================================================================================================
	
	Scripts
	
	======================================================================================================================== */

	/**
	 * Add scripts via wp_head()
	 *
	 * @return void
	 * @author Keir Whitaker
	 */

	function starkers_script_enqueuer() {
		wp_register_script( 'site', get_template_directory_uri().'/js/site.js', array( 'jquery' ) );
		wp_enqueue_script( 'site' );

		wp_register_style( 'screen', get_stylesheet_directory_uri().'/style.css', '', '', 'screen' );
        wp_enqueue_style( 'screen' );
	}	

	/* ========================================================================================================================
	
	Comments
	
	======================================================================================================================== */

	/**
	 * Custom callback for outputting comments 
	 *
	 * @return void
	 * @author Keir Whitaker
	 */
	function starkers_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment; 
		?>
		<?php if ( $comment->comment_approved == '1' ): ?>	
		<li>
			<article id="comment-<?php comment_ID() ?>">
				<?php echo get_avatar( $comment ); ?>
				<h4><?php comment_author_link() ?></h4>
				<time><a href="#comment-<?php comment_ID() ?>" pubdate><?php comment_date() ?> at <?php comment_time() ?></a></time>
				<?php comment_text() ?>
			</article>
		<?php endif;
	}
	
	function your_function_name() {
  add_theme_support( 'menus' );
  }

  add_action( 'after_setup_theme', 'your_function_name' );
  

add_theme_support('html5');
$header_defaults = array(
	'default-image'          => '',
	'random-default'         => false,
	'width'                  => 1200,
	'height'                 => 180,
	'flex-height'            => false,
	'flex-width'             => true,
	'default-text-color'     => '',
	'header-text'            => true,
	'uploads'                => true,
	'wp-head-callback'       => '',
	'admin-head-callback'    => '',
	'admin-preview-callback' => '',
);
add_theme_support( 'custom-header', $header_defaults );


function get_preview_image ($postID=null){
  if(!is_int($postID)) { global $post; $postID=$post->ID; }
  if($preview_image=get_post_meta($postID,'preview-image', true)){
    if(preg_match('#^http:\/\/(.*)\.(gif|png|jpg)$#i', $preview_image)) return '<img class="post_preview_image" src="'.$preview_image.'"/>';
    else {
      $filtered=apply_filters('the_content', $preview_image);
      if($filtered !== '<p>'.$preview_image.'</p>') return '<div class="post_preview_image">'.$filtered.'</div>';
    }
  } else return null;
}
function get_page_menu($id){
  // (1) returns 'menu' custom field value if found
  if($menu=get_post_meta($id, 'menu', true)) return $menu;
  // (2) returns custom menu name of the same name as page slug if menu exists
  $menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );    
  foreach($menus as $menu){
    if( $menu->name == get_the_slug($id) ) return get_the_slug($id);
  }
  // (3) recurses through parent pages for the above
  $parents = get_post_ancestors( $id );
  foreach($parents as $parent){
    if($menu=get_page_menu($parent)) return $menu; 
  }
} 
function get_the_slug($id,$echo=false){
  $slug = basename(get_permalink($id));
  do_action('before_slug', $slug);
  $slug = apply_filters('slug_filter', $slug);
  do_action('after_slug', $slug);
  return $slug;
}
function display_name_format($name){
  // the current name format as placed in the "title" field is "lastname, firstname"
  // if there is no comma then the name is returned as-is
  if(strstr($name,',')) {
    $aName=explode(',',$name);
    return $aName[1]." ".$aName[0];
  } else return $name;
}

function get_shows_art($showID){
  // returns an array of post id's of artwork associated with showID
  $art_list=get_the_terms($showID, 'piece');
  if ( $art_list && ! is_wp_error( $art_list ) ) { 
    $art_post_id_list=array();
  	foreach ( $art_list as $art ) {
      array_push($art_post_id_list,$art->term_id);
    }
    return $art_post_id_list;
  } else return null;
}

function get_arts_artists($artID){
  // returns array of post id's of artists associated with artID
  $arts_artists=get_the_terms($artID, 'person');
	if($arts_artists && !is_wp_error( $arts_artists )){
    $artist_post_id_list=array();
    foreach($arts_artists as $artist){
      array_push($artist_post_id_list, $artist->term_id);
    }
    return $artist_post_id_list;
	} else return null;
}

function get_artists_art($personID){
  // returns array of post id's of artwork associated with personID
  $person_post=get_post($personID);
  $artists_art_postID_list=array();
  // returns array of art posts associated with artistID
  $all_art=get_posts( array('post_type'=>'piece', 'posts_per_page'=>-1) );
  foreach($all_art as $piece){
    $arts_artists=get_arts_artists($piece->ID);
    foreach($arts_artists as $artist){
      $artist_post=get_post($artist);
      if($artist_post->name == $person_post->name){
        // then we have a match
        $artists_art_postID_list[]=$piece->ID;
      }
  	}
  }
  return $artists_art_postID_list;
}
function get_artists_shows($personID){ }
function get_arts_shows($artID){ 
  $art_post=get_post($artID);
  $arts_show_postID_list=array();
  // $all_art=get_posts( array('post_type'=>'piece', 'posts_per_page'=>-1) );
  $all_shows=get_posts( array('post_type'=>'show', 'posts_per_page'=>-1) );
  foreach($all_shows as $this_show){
    $this_shows_art=get_shows_art($this_show->ID);
    foreach($this_shows_art as $this_shows_artID){
      $this_shows_art_post=get_post($this_shows_artID);
      if($this_shows_art_post->post_name == $art_post->post_name){
        $arts_show_postID_list[]=$this_show->ID;
      }
    }
  }
  return $arts_show_postID_list;
}
function get_shows_artists($showID){ }

add_action( 'init', 'create_people_taxonomies', 0 );

// create two taxonomies, genres and writers for the post type "book"
function create_people_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Roles', 'taxonomy general name' ),
		'singular_name'     => _x( 'Role', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Roles' ),
		'all_items'         => __( 'All Roles' ),
		'edit_item'         => __( 'Edit Role' ),
		'update_item'       => __( 'Update Role' ),
		'add_new_item'      => __( 'Add New Role' ),
		'new_item_name'     => __( 'New Role Type' ),
		'menu_name'         => __( 'Role' ),
	);

	$args = array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => false,
	);

  register_taxonomy( 'role', array( 'people' ), $args );

}

