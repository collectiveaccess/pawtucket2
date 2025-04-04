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
$va_access_values = $this->getVar("access_values");
$o_config = $this->getVar("config");
print $this->render("Front/featured_set_slideshow_html.php");
?>
	<div class="row">
		<div class="col-sm-3"></div>
		<div class="col-sm-6">
			<H1>The story of the city and county of Limerick presented through its objects</H1>
			<h2>Established in 1916, the museum is the oldest local authority museum in the state and with nearly 60,000 objects and its aim is to collect, preserve and display objects that tell the story of Limerick and its people.

</h2>
		</div><!--end col-sm-8-->
		<div class="col-sm-3"></div>
	</div><!-- end row -->
<?php
	if($qr = ca_sets::findAsSearchResult(['type_id' => 'public_presentation'], ['checkAccess' => $va_access_values])) {
		$front_page_set_code = $o_config->get('front_page_set_code');
		while($qr->nextHit()) {
			if($qr->get('ca_sets.set_code') === $front_page_set_code) { continue; }
			if (!$t_set = $qr->getInstance()) { continue; }
			$this->setVar('t_set', $t_set);
			$this->setVar('set_code', $qr->get('ca_sets.set_code'));
			$this->setVar('set_items_as_search_result', $t_set->getItemsAsSearchResult(['checkAccess' => $va_access_values]));
			print $this->render('Front/slideshow_html.php');
		}
	}
?>
