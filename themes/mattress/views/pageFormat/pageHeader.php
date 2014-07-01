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
	<div id="headerWrapper">
		<div id="hpLogo">
	<?php	
		print caNavLink($this->request, caGetThemeGraphic($this->request, 'MF_logo.jpg'), '', '', '','');
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
					<li><a href="../?q=content/hours-admission">Visit</a></li>
					<li><a href="../?q=calendar/month">Calendar</a></li>
					<li><a href="../?q=content/history">History</a></li>
					<li><a href="../?q=content/get-involved">Get Involved</a></li>
					<li><a href="../?q=content/rentals">Rentals</a></li>
					<li><a href="../?q=content/press-room">Press Room</a></li>
					<li><a href="../?q=content/staff-board-directors">Staff + Board of Directors</a></li>
				  </ul>
				</li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Art</a>
				  <ul class="dropdown-menu">
				  	<li><a href="../?q=exhibitions">Exhibitions</a></li>
				  	<li><?php print caNavLink($this->request, _t('Artists'), '', 'Browse', 'Artists', ''); ?></li>
					<li><a href="#">Artist Limited Editions</a></li>
					<li><?php print caNavLink($this->request, _t('Search All Art'), '', '', '', ''); ?></li>
				  </ul>
				</li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Learn</a>
				  <ul class="dropdown-menu">
				  	<li><a href="../?q=content/kids-families">Kids + Families</a></li>
					<li><a href="../?q=content/schools-teachers">Schools + Teachers</a></li>
					<li><a href="../?q=content/community">Community</a></li>
					<li><a href="../?q=content/public-programs">Public Programs</a></li>
					<li><a href="../?q=content/space-im">The Space I'm In</a></li>
				  </ul>
				</li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Support</a>
				  <ul class="dropdown-menu">
					<li><a href="../?q=content/donate">Donate</a></li>
					<li><a href="../?q=node/13">Membership</a></li>
					<li><a href="../?q=content/sponsorship">Sponsorship</a></li>
					<li><a href="../?q=content/annual-fund">Annual Fund</a></li>
					<li><a href="../?q=content/our-partners">Our Partners</a></li>
					<li><a href="../?q=content/urban-garden-party">Urban Garden Party</a></li>                
				  </ul>
				</li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Archives</a>
				  <ul class="dropdown-menu">
					<li><?php print caNavLink($this->request, _t('About'), '', '', '', ''); ?></li>
					<li><a href="<?php print caNavUrl($this->request, '', 'Listing', 'collections', array()); ?>">Collections</a></li>
					<li><a href="<?php print caNavUrl($this->request, '', 'Browse', 'Artists', array()); ?>">Browse Artists</a></li>
					<li><a href="<?php print caNavUrl($this->request, '', 'Browse', 'Exhibitions', array()); ?>">Browse Exhibitions & Events</a></li>                
					<li><a href="<?php print caNavUrl($this->request, '', 'Browse', 'Collections', array()); ?>">Browse Artworks</a></li>                
					<li><a href="#">p{ART}icipate</a></li>  
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
			</div><!--/.nav-collapse -->
		  </div>
		</div>
	 
		<div class="artYou">art you can get into</div>
		<div class="clearfix"></div>
	</div><!--/headerWrapper -->
