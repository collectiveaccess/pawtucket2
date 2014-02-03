<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>

	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print $this->request->config->get('html_page_title'); ?></title>
	
	<!--NS design-->
	<script type="text/javascript" src="//use.typekit.net/cvi0qyc.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<!--end NS design-->

	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('.dropdown-browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
</script>

</head>
<body>
	<nav class="navbar navbar-default" role="navigation"><div class="container">
	  <!-- Brand and toggle get grouped for better mobile display -->
	  <div class="navbar-header">
	  	<!-- NS design -->
		<div class="nslogotype"><span class="newschool">The New School</span></div>
		<div class="nslogotype2"><span class="kellen">Kellen Design Archives</span></div>
		
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-main-navbar-collapse-1">
		  <span class="sr-only">Toggle navigation</span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		</button>
	
		
			  </div>

		
<!--<?php
		print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/assets/pawtucket/graphics/ca_nav_logo300.png' border='0'>", "navbar-brand", "", "","");
?>-->
<!--end NS design-->
	
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
		  <li class="dropdown">
			<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><span class="glyphicon glyphicon-unchecked"></span><!--<img src='<?php print $this->request->getThemeUrlPath(); ?>/assets/pawtucket/graphics/buttons/bookmark_mainnav.png' border='0'>--></a>
			<ul class="dropdown-menu">
			  <li><a href="#">Action</a></li>
			  <li><a href="#">Another action</a></li>
			  <li><a href="#">Something else here</a></li>
			  <li class="divider"></li>
			  <li><a href="#">Separated link</a></li>
			  <li class="divider"></li>
			  <li><a href="#">One more separated link</a></li>
			</ul>
		  </li>
		</ul>
		<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
		  <div class="formOutline">
			  <div class="form-group">
				<input type="text" class="form-control" placeholder="Search" name="search">
			  </div>
			  <button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
		  </div>
		</form>
		<ul class="nav navbar-nav navbar-right">
		  <li class="active"><a href="#">About</a></li>
		  <li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Browse</a>
			<ul class="dropdown-menu dropdown-browse-menu">
				<li class="browseNavFacet">
<?php
	$vs_facet_list = caGetFacetForMenuBar($this->request);
	
	if($vs_facet_list) {
?>
	<table class="table browseNavTable">
		<tbody>
			<tr><?php print $vs_facet_list; ?></tr>
		</tbody>
	</table>
	<div id='browseNavFacetContent'> </div>
<?php
	} else {
?>
		No facets available
<?php
	}
?>
				</li>
			</ul>
		  </li>
		</ul>
	  </div><!-- /.navbar-collapse --></div><!-- end container -->
	</nav>
	
	<div class="container"><div id="pageArea">
