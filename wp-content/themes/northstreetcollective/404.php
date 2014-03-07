<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * Please see /external/starkers-utilities.php for info on Starkers_Utilities::get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>
<div class="row">
  <div class="col-md-8 col-md-push-2 col-sm-10 col-sm-push-1 content article">
    <div class="section_heading"><h2>Page not found. Perhaps searching will help:</h2></div>
    <p>
      <?php get_search_form(); ?>
    </p>
  </div>
</div>


<?php Starkers_Utilities::get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>