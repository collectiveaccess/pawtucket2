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
<div class="hpText">
	<div class="hpTextImage"><?php print caGetThemeGraphic($this->request, 'hp_eggshell.jpg'); ?></div>
	<div class="hpIntroText">The University of Colorado Museum of Natural History is home to the <b>Karl Hirsh Eggshell Collection</b>, one of the world’s finest collections of fossil eggshells.</div>
	<br/><div class="text-center">
		<?php print caNavLink($this->request, _t("Explore the Fossil Eggshell Collection"), "btn btn-default", "", "Front", "FossilEggshellCollection"); ?>
	</div>
	<div style="clear:left;"><!-- empty --></div>
</div>

<div class="hpText">
	<div class="hpTextImage"><?php print caGetThemeGraphic($this->request, 'hp_tracks.jpg'); ?></div>
	<div class="hpIntroText"><b>The University of Colorado Fossil Tracks Collection</b> is comprised of a remarkable range of fossil footprints that show exceptional temporal, taxonomic, and geographic breadth.</div> 
	<br/><div class="text-center">
		<?php print caNavLink($this->request, _t("Explore the Fossil Tracks Collection"), "btn btn-default", "", "Front", "FossilTracksCollection"); ?>
	</div>
	<div style="clear:left;"><!-- empty --></div>
</div>
<div class="hpText">
	<div class="hpTextImage"><?php print caGetThemeGraphic($this->request, 'hp_vertebrate.jpg'); ?></div>
	<div class="hpIntroText"><b>The Fossil Vertebrate Collection at the University of Colorado Museum of Natural History</b> is among the largest in the Western Interior.</div>
	<br/><div class="text-center">
		<?php print caNavLink($this->request, _t("Explore the Fossil Vertebrate Collection"), "btn btn-default", "", "Front", "FossilVertebrateCollection"); ?>
	</div>
	<div style="clear:left;"><!-- empty --></div>
</div>