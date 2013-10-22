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
	<div id="hpLogo">
<?php	
	print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/assets/pawtucket/graphics/MF_logo.jpg' border='0'>", '', '', '','');
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
                <li><a href="#">Visit</a></li>
                <li><a href="#">Calendar</a></li>
                <li><a href="#">History</a></li>
                <li><a href="#">Get Involved</a></li>
                <li><a href="#">Rentals</a></li>
                <li><a href="#">Press Room</a></li>
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
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Learn</a>
              <ul class="dropdown-menu">
                <li><a href="#">Schools + Teachers</a></li>
                <li><a href="#">Kids + Families</a></li>
                <li><a href="#">Community</a></li>
                <li><a href="#">Public Programs</a></li>
                <li><a href="#">The Space I'm In</a></li>
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
                <li><a href="<?php print caNavUrl($this->request, '', 'Browse', 'Artists', array()); ?>">Browse Artists</a></li>
                <li><a href="<?php print caNavUrl($this->request, '', 'Browse', 'Exhibitions', array()); ?>">Browse Exhibitions & Events</a></li>                
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
