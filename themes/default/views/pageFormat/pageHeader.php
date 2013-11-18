<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>

	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print $this->request->config->get('html_page_title'); ?></title>
</head>
<body>
	<nav class="navbar navbar-default" role="navigation"><div class="container">
	  <!-- Brand and toggle get grouped for better mobile display -->
	  <div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-main-navbar-collapse-1">
		  <span class="sr-only">Toggle navigation</span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		  <span class="icon-bar"></span>
		</button>
<?php
		print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/assets/pawtucket/graphics/ca_nav_logo300.png' border='0'>", "navbar-brand", "", "","");
?>
	  </div>
	
	  <!-- Collect the nav links, forms, and other content for toggling -->
	  <div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">
		<ul class="nav navbar-nav navbar-right">
		  <li class="dropdown">
			<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span></a>
			<ul class="dropdown-menu">
<?php
			if($this->request->isLoggedIn()){
				print '<li role="presentation" class="dropdown-header">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).'</li>';
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
			<ul class="dropdown-menu">
			  <li><a href="#">Action</a></li>
			  <li><a href="#">Another action</a></li>
			  <li><a href="#">Something else here</a></li>
			  <li class="divider"></li>
			  <li><a href="#">Separated link</a></li>
			</ul>
		  </li>
		</ul>
	  </div><!-- /.navbar-collapse --></div><!-- end container -->
	</nav>
	
	<div class="container"><div id="pageArea">




















<!-- 
	<div class="navbar navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">About</a>
              <ul class="dropdown-menu">
                <li><a href="#">History</a></li>
                <li><a href="#">Staff</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Art</a>
              <ul class="dropdown-menu">
                <li><a href="#">Exhibitions</a></li>
                <li><a href="#">Permanent Installations</a></li>
                <li><a href="#">Artist Limited Editions</a></li>
                <li><a href="#">Search All Art</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Support</a>
              <ul class="dropdown-menu">
                <li><a href="#">Donate</a></li>
                <li><a href="#">Membership</a></li>
                <li><a href="#">Sponsorship</a></li>
                <li><a href="#">Annual Fund</a></li>
                <li><a href="#">Our Partners</a></li>
                <li><a href="#">Urban Garden Party</a></li>                
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Archives</a>
              <ul class="dropdown-menu">
                <li><a href="#">About</a></li>
                <li><a href="<?php print caNavUrl($this->request, '', 'List', 'Collections', array()); ?>">Collections</a></li>
                <li><a href="<?php print caNavUrl($this->request, '', 'Browse', 'Artists', array()); ?>">Browse Productions</a></li>
              </ul>
            </li>            
          </ul>
          <form class="navbar-form pull-right" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
			<div class="input-group">
				<input type="search" class="form-control" placeholder="" name="search"/>
				<span class="input-group-btn">
					<button type="submit" class="btn btn-default"></button>
				</span> 
			</div>
		</form>
        </div>
      </div>
    </div>
 -->
