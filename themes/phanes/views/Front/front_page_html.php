<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * @package CollectiveAccess
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
?>
<div class="parallax" style="background-image: url('<?php print caGetThemeGraphicUrl($this->request, 'hero.jpg'); ?>');">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-6 col-md-offset-1">
				<div class="hpIntro">
					{{{frontWelcomeMessage}}}
					<p class="text-center">
						<?php print caNavLink($this->request, _t("Browse the Collection"), "btn btn-default", "", "Browse", "coins"); ?>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2 text-center">
<?php
			if($this->getVar("frontTagLine")){
				print "<br/><br/><br/><H1>".$this->getVar("frontTagLine")."</H1><br/><br/><br/>";
			}else{
				print "<br/><br/><br/>";
			}
?>			
		</div>
	</div>
</div>
<div class="container">
	<div class="row hpBrowseLinks">
		<div class="col-sm-3">
			<?php print caGetThemeGraphic($this->request, '1.jpg'); ?>
		</div>
		<div class="col-sm-3">
			<?php print caGetThemeGraphic($this->request, '2.jpg'); ?>
		</div>
		<div class="col-sm-3">
			<?php print caGetThemeGraphic($this->request, '3.jpg'); ?>
		</div>
		<div class="col-sm-3">
			<?php print caGetThemeGraphic($this->request, '4.jpg'); ?>
		</div>
	</div>
</div>
