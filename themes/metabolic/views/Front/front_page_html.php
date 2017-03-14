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
	<div id="hpFeatured1">
<?php
	$t_object = new ca_objects();
		$t_featured = new ca_sets();
	$featured_set = $t_featured->load(array('set_code' => 'splash'));
	$carousel_ids = $t_featured->getItemRowIDs(array('shuffle' => true));
	$qr_set = ca_objects::createResultSet(array_keys($carousel_ids));

$v_i = 0;
$m_i = 0;
	while($qr_set->nextHit()) {

		$object_media = $qr_set->get('ca_object_representations.media.splashthumb', array('primaryOnly' => 1));
		$vn_object_id = $qr_set->get('ca_objects.object_id');
		print "<div class='figureDiv'><div class='figure'";
			if ($v_i== 4){
				print "style='margin-right:0px'";
			}
			print ">".caNavLink($this->request, $object_media, '', '', 'Detail', 'objects/'.$vn_object_id)."</div></div>";
			$v_i ++;
			$m_i ++;
			if ($v_i > 3) {$v_i = 0;}
			if ($m_i == 16) {break;}
	}


?>
	</div>