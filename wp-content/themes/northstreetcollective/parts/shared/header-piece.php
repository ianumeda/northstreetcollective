<header id="header" class="cbp-af-shrunken">
  <div class="cbp-af-header cbp-af-header-shrink">
    <div class="cbp-af-inner container">
      <div class="row">
        <div class="col-xs-3">
          <div class="branding">
          <a href="<?php bloginfo('url'); ?>" title="North Street Collective Home">
            <img class="logo" src="http://northstreetcollective.org/wp-content/uploads/2013/11/logo-orange-whitemargin-137x240.jpg" alt="North Street Collective">
            <!-- <h6 class="logo">North Street Collective</h6> -->
          </a>
        </div>
      </div>
      <div class="col-xs-9">
        <nav class="hidden-md hidden-lg visible-sm visible-xs">
    	    <?php //wp_nav_menu( array('menu'=>'top','menu_class'=>'nav')); ?>
    	    <?php wp_nav_menu( array('menu'=>'top_top','menu_class'=>'nav navbar-nav','walker'=>new wp_bootstrap_navwalker())); ?>
    	    <?php wp_nav_menu( array('menu'=>'top_bottom','menu_class'=>'nav navbar-nav','walker'=>new wp_bootstrap_navwalker())); ?>
        </nav>
        <nav class="visible-md visible-lg hidden-sm hidden-xs">
          <?php wp_nav_menu( array('menu'=>'top','menu_class'=>'nav navbar-nav','walker'=>new wp_bootstrap_navwalker())); ?>
        </nav>
      </div>
    </div>
  </div>
</header>


<div id="page">
