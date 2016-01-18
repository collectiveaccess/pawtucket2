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
<?php
	//
	// Pull in JS and CSS for debug bar
	// 
	if(Debug::isEnabled()) {
		$o_debugbar_renderer = Debug::$bar->getJavascriptRenderer();
		$o_debugbar_renderer->setBaseUrl(__CA_URL_ROOT__.$o_debugbar_renderer->getBaseUrl());
		print $o_debugbar_renderer->renderHead();
	}
?>
<meta name="google-site-verification" content="j2ZduLZYPPtHe6G-r_BPBVE7XG97dTZMFfqrDKoUrns" />
<meta name="description" content="Historical images, text, audio and video from The New School including Parsons, Mannes, The New School for Social Research, and Eugene Lang College."/>

</head>
<body>


<div class="container">




	<div class="row">
		<div class="nslogotypesub col-sm-10"><span class="newschool">The New School Archives</span><span class="kellen"><a href="/"> Digital Collections</a></span></div>
		<div class="col-sm-2 infonav">
			<ul class="nav navbar-nav navbar-right">
				<li <?php print ($this->request->getController() == "About") ? "class='active'" : ""; ?>><?php print caNavLink($this->request, "<span class='glyphicon glyphicon-info-sign'></span>", "", "", "About", "Index", null, array("title" => "For more information")); ?></li>
				<li <?php print ($this->request->getController() == "Contact") ? "class='active'" : ""; ?>><?php print caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span>", "", "", "Contact", "Form"); ?></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span></a>
					<ul class="dropdown-menu">
<?php
					if($this->request->isLoggedIn()){
						print '<li role="presentation" class="dropdown-header">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email").'</li>';
						print '<li class="divider"></li>';
						print "<li>".caNavLink($this->request, _t('Lightbox'), '', '', 'Lightbox', 'Index', array())."</li>";
						print "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
					}else{	
						print "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>";
						print "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>";
					}
?>
			
					</ul>	
				</li>
			</ul>
		</div><!-- end col infonav -->
	</div><!--end row-->	
	<div class="row">		
		<nav class="navbar navbar-default" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<?php print caNavLink($this->request, "<span class='glyphicon glyphicon-info-sign'></span>", "navbar-toggle btn".(($this->request->getController() == "About") ? " active" : ""), "", "About", "Index"); ?>
				<?php print caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span>", "navbar-toggle btn".(($this->request->getController() == "Contact") ? " active" : ""), "", "Contact", "Form"); ?>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-main-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="glyphicon glyphicon-search"></span>
				</button>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-user-navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="glyphicon glyphicon-user"></span>
				</button>
			
				
				
			</div>
	
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">			
				<ul class="nav navbar-nav">
					<li>Browse by:</li>
					<li <?php print (($this->request->getController() == "Browse") && ($this->request->getAction() == "collections")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Collections"), "", "", "Browse", "collections"); ?></li>
					<li <?php print (($this->request->getController() == "Browse") && ($this->request->getAction() == "objects")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Items"), "", "", "Browse", "objects"); ?></li>
					<li <?php print (($this->request->getController() == "Browse") && ($this->request->getAction() == "people")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("People"), "", "", "Browse", "people"); ?></li>
					<li <?php print (($this->request->getController() == "Browse") && ($this->request->getAction() == "organizations")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Organizations"), "", "", "Browse", "organizations"); ?></li>			  
					<li <?php print ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Topics"), "", "", "Gallery", "Index"); ?></li>
					<li>
						<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
							<div class="formOutline">
								<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Search" name="search">
								</div>
							</div>
						</form>
					</li> 
				</ul><!--end navbar right-->
			</div><!-- /.navbar-collapse -->
	  
	  
	  
			<div class="collapse navbar-collapse" id="bs-user-navbar-collapse">
				<ul class="nav navbar-nav">
<?php
					if($this->request->isLoggedIn()){
						print '<li role="presentation" class="dropdown-header">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email").'</li>';
						print '<li class="divider"></li>';
						print "<li>".caNavLink($this->request, _t('Lightbox'), '', '', 'Lightbox', 'Index', array())."</li>";
						print "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
					}else{	
						print "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>";
						print "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>";
					}
?>
				</ul><!--end navbar right-->
			</div><!-- /.navbar-collapse -->
			
			
	  	</nav>
	</div><!--end row-->	
</div><!--end container-->
<?php
	# --- display breadcrumb trail on interior pages
	if($this->request->getController() != "Front"){
?>		
		<div class="container breadcrumb subcrumb"><a href="http://www.newschool.edu/">Home</a> > <a href="http://library.newschool.edu/">Libraries & Archives</a> > <a href="http://library.newschool.edu/speccoll/index.php">Archives & Special Collections</a> > <?php print caNavLink($this->request, _t("Digital Collections"), "", "", "", ""); ?></a></div>		
<?php
	}
?>
<div class="container mainarea"><div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
