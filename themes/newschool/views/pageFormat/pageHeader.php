<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>

	<script type="text/javascript">window.caBasePath = '<?php print $this->request->getBaseUrlPath(); ?>';</script>
		
	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print $this->request->config->get('html_page_title'); ?></title>
	
	<!--NS design-->
	<script type="text/javascript" src="//use.typekit.net/cvi0qyc.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
	<!--end NS design-->

	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('.dropdown-browse-menu').on('click mouseover mouseout mousemove mouseenter hide.bs.dropdown',function(e) { e.stopPropagation(); });
    	});
	</script>
</head>
<body>
<?php 
	# --- check if we're on the home page
	if($this->request->getController() == "Front"){
?>
	<!-- NS design -->
	<div class="container nslogotype">
		<span class="newschool">The New School</span>
		<div class="container breadcrumb">Home &gt; Libraries & Archives &gt; Special Collections</div>

		<span class="kellen"><a href="/">The New School Digital Archives</a></span>
	</div>
	<!-- end NS design -->
	
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
		  <li class="dropdown">
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
		  <li <?php print ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Features"), "", "", "Gallery", "Index"); ?></a></li>
		  <li <?php print ($this->request->getController() == "Contact") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Contact"), "", "", "Contact", "Form"); ?></a></li>

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
	} else {
		# --- not on home page so display condensed header
?>
		<!--start condensed header -->

		<!-- NS design -->
		<div class="container nslogotypesub"><span class="newschool">The New School </span><span class="kellen"><a href="/"> The New School Digital Archives</a></span></div>
		<!-- end NS design -->
	
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
		  <li class="dropdown">
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
		<ul class="nav navbar-nav navbar-right" id="browse-menu">
		  <li <?php print ($this->request->getController() == "About") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("About"), "", "", "About", "Index"); ?></li>
<?php
	print $this->render("pageFormat/browseMenu.php");
?>		  <li <?php print ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Features"), "", "", "Gallery", "Index"); ?></a></li>
		  <li <?php print ($this->request->getController() == "Contact") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Contact"), "", "", "Contact", "Form"); ?></a></li>

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
		
<div class="container breadcrumb subcrumb">Home > Libraries & Archives > Special Collections</div>		
<!--end condensed header -->		
		
<?php
	}
?>
	<div class="container"><div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
