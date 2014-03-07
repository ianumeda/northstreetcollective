</div> <!-- #page -->	

<footer id="footer-homegrid">
  <div class="row">
    <div class="col-sm-2">
  	  <a href="<?php echo home_url(); ?>"><div id="logo" class="inline"><img src="http://northstreetcollective.org/wp-content/uploads/2013/11/logo-orange-whitemargin-137x240.jpg" alt="North Street Collective"></div></a>
    </div>
    <div class="col-sm-6">
      <div class="address">
        <p><span class="name">North Street Collective</span></p>
        <p>350 North Street</p>
	      <p>Willits, CA 95490</p>
        <p>Phone: </p>
        <p>Fax: </p>
      </div>
      	<?php  //wp_nav_menu( array('menu'=>'footer','menu_class'=>'nav','walker'=>new wp_bootstrap_navwalker())); ?>
    </div>
    <div class="col-sm-4">
		  <div id="sb-search-bottom" class="sb-search row">
				<form action="<?php echo home_url('/'); ?>" method="get">
					<input class="sb-search-input" placeholder="Search the North Street Collective..." type="text" value="" name="s" id="s">
					<input class="sb-search-submit" type="submit" value="">
					<span class="sb-icon-search glyphicon glyphicon-search"></span>
				</form>
			</div>
    </div>
  </div>

  <div class="row">
	  <div id="copyright" class="col-xs-12">&copy; <?php echo date("Y"); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.</div>
	</div>
</footer>
