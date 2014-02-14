<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>

		<?php print MetaTagManager::getHTML(); ?>
		<?php print AssetLoadManager::getLoadHTML($this->request); ?>
 
		<title><?php print $this->request->config->get('html_page_title'); ?></title>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('.dropdown-browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
			});
		</script>
	</head>
<body>

<?php 
	if(($this->request->getController() == "Front") && ($this->request->getAction() == "Index")){
?>
		<div class="container shadowed homebody roundedbottom">
<?php
	}else{
?>
		<div class="container shadowed mainbody roundedbottom">
<?php
	}	
?>
<div class="row">
	<div class="container" id="headbanner">
		<div class="row">
			<div class="col-sm-1 emblem">
<?php
				print caNavLink($this->request, caGetThemeGraphic($this->request, 'omb_logo.png'), "navbar-brand", "", "","");
?>
			</div><!--end col-sm-1-->
			<div class="col-sm-11">	
				<div id="tagline">Cincinnati Judaica Fund and<br />the Center for Holocaust & Humanity Education </div>
				<div id="titlehead">Collections Database</div>
				<div class="mynav collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
					<nav class="navbar navbar-default yamm" role="navigation">
						<div class="container">
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
							} else {	
								print "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>";
								print "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>";
							}
				?>
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
									<li class="active dropdown"><a href="#" class="dropdown-toggle top" data-toggle="dropdown">Home<b class="caret"></b></a>
										<ul class="dropdown-menu">
											<li><?php print caNavLink($this->request, 'Cincinnati Judaica Fund', '', '', 'Front', 'CJF'); ?></li>
											<li class="divider"></li>
											<li><?php print caNavLink($this->request, 'Center for Holocaust &amp; Humanity Education', '', '', 'Front', 'CHHE'); ?></li>
										</ul>
									</li>
									<li class="dropdown"><a href="#" class="dropdown-toggle top" data-toggle="dropdown">About<b class="caret"></b></a>
										<ul class="dropdown-menu">
											<li><a href="<?php caStaticPageUrl('/About/cjf'); ?>">About Cincinnati Judaica Fund</a></li>
											<li class="divider"></li>
											<li><a href="<?php caStaticPageUrl('/About/chhe'); ?>">About Center for Holocaust &amp; Humanity Education</a></li>
										</ul>	
									</li>								
<?php
										print $this->render("pageFormat/browseMenu.php");
?>
								</ul>
							</div><!-- /.navbar-collapse -->
						</div><!-- end container -->
					</nav>
	
				</div> <!--end collapse navbar--> 
			</div><!--end col sm 11-->
		</div> <!--end row-->	
	</div><!--end container end headbanner-->
</div><!-- end row -->


<!--<div class="container">-->
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
