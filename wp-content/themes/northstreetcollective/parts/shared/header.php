<header id="header">

</header>
<nav id="main_navigation" class="navbar navbar-default " role="navigation">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
   <a class="navbar-brand visible-xs visible-sm hidden-md hidden-lg" href="<?php echo home_url(); ?>"><span class="nsc_logo menu-item menu-item-type-post_type menu-item-object-page"><img src="http://northstreetcollective.org/wp-content/uploads/2013/11/northstreetcollective-logo-notext60x88.png" height="50px"></span> North Street Collective</a>
  </div>

  <div id="topnav" class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav navbar-left">
      <li class="hidden-xs hidden-sm nsc_logo menu-item menu-item-type-post_type menu-item-object-page<?php if(is_home() || is_front_page()) echo ' current-menu-item current-menu-parent"'; ?>"><a href="<?php echo home_url(); ?>"><img src="http://northstreetcollective.org/wp-content/uploads/2013/11/northstreetcollective-logo-notext60x88.png" height="50px"></a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <!-- <li id="current_thing_toggle" class="menu-item menu-item-type-post_type menu-item-object-page"><a href="#" class="">The Current Thing <span class="glyphicon glyphicon-chevron-up"></span></a></li> -->
    </ul>
  	<?php wp_nav_menu( array('menu'=>'main','menu_class'=>'nav navbar-nav','walker'=>new wp_bootstrap_navwalker())); ?>
  </div>
</nav>
<div id="page">
