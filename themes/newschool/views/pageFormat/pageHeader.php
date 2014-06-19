<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>

	<script type="text/javascript">window.caBasePath = '<?php print $this->request->getBaseUrlPath(); ?>';</script>
		
	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print ($vs_page_title = MetaTagManager::getWindowTitle()) ? $vs_page_title : "New School Archives : Digital Collections"; ?></title>
	
	<!--NS design-->
	<script type="text/javascript" src="//use.typekit.net/cvi0qyc.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
	<!--end NS design-->

	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter hide.bs.dropdown',function(e) { e.stopPropagation(); });
    	});
	</script>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-7966352-9', 'newschool.edu');
  ga('send', 'pageview');

	</script>

<meta name="google-site-verification" content="j2ZduLZYPPtHe6G-r_BPBVE7XG97dTZMFfqrDKoUrns" />
<meta name="description" content="Historical images, text, audio and video from The New School including Parsons, Mannes, The New School for Social Research, and Eugene Lang College."/>

</head>
<body>
<?php 
	# --- display larger header on home page
	if($this->request->getController() == "Front"){
?>
		<div class="container nslogotype">
			<span class="newschool">The New School</span>
			<div class="container breadcrumb"><a href="http://www.newschool.edu/">Home</a> &gt; <a href="http://library.newschool.edu/">Libraries & Archives</a> &gt; <a href="http://library.newschool.edu/speccoll/index.php">Archives & Special Collections</a> &gt; <a href="http://digitalarchives.library.newschool.edu/">Digital Collections</a></div>
	
			<span class="kellen"><a href="/">The New School Archives: Digital Collections</a></span>
		</div>
<?php
	}else{
		# --- condensed header
?>
		<div class="container nslogotypesub"><span class="newschool">The New School </span><span class="kellen"><a href="/"> The New School Archives: Digital Collections</a></span></div>		
<?php
	}
?>
	<nav class="navbar navbar-default yamm" role="navigation"><div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-main-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
	
	  <!-- Collect the nav links, forms, and other content for toggling -->
	  <div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">
		<ul class="nav navbar-nav navbar-right">
		  <li class="dropdown" style="position:relative;">
			<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span></a>
			<ul class="dropdown-menu">
<?php
			if($this->request->isLoggedIn()){
				print '<li role="presentation" class="dropdown-header">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email").'</li>';
				print '<li class="divider"></li>';
				print "<li>".caNavLink($this->request, _t('Lightbox'), '', '', 'Sets', 'Index', array())."</li>";
				print "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
			}else{	
				print "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>";
				print "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>";
			}
?>
			</ul>
		  </li>
		</ul>
	<!--form cut from here-->
		<ul class="nav navbar-nav navbar-right">
		  <li <?php print ($this->request->getController() == "About") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("About"), "", "", "About", "Index"); ?></li>
				

<?php
	print $this->render("pageFormat/browseMenu.php");
?>			  
		  <li <?php print ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Topics"), "", "", "Gallery", "Index"); ?></li>
		  <li <?php print ($this->request->getController() == "Contact") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Contact"), "", "", "Contact", "Form"); ?></li>

		  <!--NS design-->
		  <li>
		  	<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
		  <div class="formOutline">
			  <div class="form-group">
				<input type="text" class="form-control" placeholder="Search" name="search">
			  </div>
			  <button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
		  </div>
		</form>
		 </li> 
		  <!--end NS design-->
		</ul><!--end navbar right-->
	  </div><!-- /.navbar-collapse --></div><!-- end container -->
	</nav>
<?php
	# --- display breadcrumb trail on interior pages
	if($this->request->getController() != "Front"){
?>
		<div class="container breadcrumb subcrumb"><a href="http://www.newschool.edu/">Home</a> > <a href="http://library.newschool.edu/">Libraries & Archives</a> > <a href="http://library.newschool.edu/speccoll/index.php">Archives & Special Collections</a> > <a href="http://digitalarchives.library.newschool.edu/">Digital Collections</a></div>		
<?php
	}
?>
	<div class="container"><div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
