<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>

	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>
	<link rel="icon" href="<?php print caGetThemeGraphicURL($this->request, 'favicon.jpg'); ?>">
	<title><?php print $this->request->config->get('html_page_title'); ?></title>
</head>
<body>
	<div id="headerWrapper">
		<div id="hpLogo">
	<?php	
		print '<a href="/">'.caGetThemeGraphic($this->request, 'MF_logo.jpg', array('width' => '150px', 'height' => '112px'))."</a>";
		
	?>	
		</div>
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
					<li><a href="/content/hours-admission">Visit</a></li>
					<li><a href="/content/calendar">Calendar</a></li>					
					<li><a href="/content/history">History</a></li>
					<li><a href="/content/get-involved">Get Involved</a></li>
					<li><a href="/content/rentals">Rentals</a></li>
					<li><a href="/content/press-room">Press Room</a></li>
					<li><a href="/content/staff-board-directors">Staff + Board of Directors</a></li>
				  </ul>
				</li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Art</a>
				  <ul class="dropdown-menu">
				  	<li><a href="/exhibitions">Exhibitions</a></li>
				  	<li><?php print caNavLink($this->request, _t('Artists'), '', 'Browse', 'Artists', ''); ?></li>
				  	<li><a href="/content/residency-program">Residency Program</a></li>					
					<li><?php print caNavLink($this->request, _t('Artist Limited Editions'), '', 'Listing', 'editions', array()); ?></li>
					<li><a href="<?php print caNavUrl($this->request, '', 'Browse', 'Collections', array()); ?>">Search All Art</a></li>
				  </ul>
				</li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Learn</a>
				  <ul class="dropdown-menu">
				  	<li><a href="/content/kids-families">Kids + Families</a></li>
					<li><a href="/content/schools-teachers">Schools + Teachers</a></li>
					<li><a href="/content/community">Community</a></li>
					<li><a href="/content/public-programs">Public Programs</a></li>
					<li><a href="<?php print caNavUrl($this->request, '', 'Listing', 'objects', array()); ?>">Toolkit</a></li>
				  </ul>
				</li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Support</a>
				  <ul class="dropdown-menu">
					<li><a href="/content/donate">Donate</a></li>
					<li><a href="/node/13">Membership</a></li>
					<li><a href="/node/annual-fund">Annual Fund</a></li>
					<li><a href="/content/institutional-giving">Institutional Giving</a></li>
					<li><a href="/content/urban-garden-party">Urban Garden Party</a></li>                
				  </ul>
				</li>
				<li class="dropdown">
				  <a href="/calendar/month" class="dropdown-toggle" >Calendar</a>
				</li>  				
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Archives</a>
				  <ul class="dropdown-menu">
					<li><?php print caNavLink($this->request, _t('About'), '', '', '', ''); ?></li>
					<li><a href="<?php print caNavUrl($this->request, '', 'Browse', 'Artists', array()); ?>">Browse Artists</a></li>
					<li><a href="<?php print caNavUrl($this->request, '', 'Browse', 'Collections', array()); ?>">Browse Artworks</a></li>                
					<li><a href="<?php print caNavUrl($this->request, '', 'Browse', 'Exhibitions', array()); ?>">Browse Exhibitions & Events</a></li>                
					<li><a href="<?php print caNavUrl($this->request, '', 'Listing', 'collections', array()); ?>">Research</a></li>					
					<li><?php print caNavLink($this->request, _t('Contribute'), '', '', 'Contribute', 'artworks'); ?></li>  
				  </ul>
				</li> 
				<li class="dropdown">
				  <a href="http://mfshop.org" class="dropdown-toggle" >Shop</a>
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
			</div><!--/.nav-collapse -->
		  </div>
		</div>
	 
		<div class="clearfix"></div>
	</div><!--/headerWrapper -->
