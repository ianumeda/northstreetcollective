<header>
	<h1><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
	<?php bloginfo( 'description' ); ?>
  <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
     <a class="navbar-brand" href="#">North Street Collective</a>
    </div>

    <div id="mainnav" class="collapse navbar-collapse navbar-ex1-collapse">
    	<?php wp_nav_menu( array('menu'=>'main','menu_class'=>'nav navbar-nav','walker'=>new wp_bootstrap_navwalker())); ?>
      <form class="navbar-form" role="search">
        <div class="form-group col-sm-3 navbar-right">
        	<?php get_search_form(); ?>
        </div>
      </form>
    </div><!-- /.navbar-collapse -->
  </nav>
</header>
