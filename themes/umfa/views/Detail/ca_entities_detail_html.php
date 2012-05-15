<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_entities_detail_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010 Whirl-i-Gig
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
 * ----------------------------------------------------------------------
 */
	$t_entity 			= $this->getVar('t_item');
	$vn_entity_id 		= $t_entity->getPrimaryKey();
	
	$vs_title 			= $this->getVar('label');
	
	$t_rel_types 		= $this->getVar('t_relationship_types');

if (!$this->request->isAjax()) {		
?>
	<div id="detailBody">
		<div id="pageNav">
<?php
		if (($this->getVar('is_in_result_list')) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_entities', "<img src='".$this->request->getThemeUrlPath()."/graphics/arrow_up_grey.gif' width='11' height='10' border='0'> "._t("BACK"), ''))) {
			print $vs_back_link;
			if (($this->getVar('next_id')) || ($this->getVar('previous_id'))) {	
				print "&nbsp;&nbsp;&nbsp;";
			}
			if ($this->getVar('previous_id')) {
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/arrow_grey_left.gif' width='10' height='10' border='0'> "._t("PREVIOUS"), '', 'Detail', 'Entity', 'Show', array('entity_id' => $this->getVar('previous_id')), array('id' => 'previous'));
			}
			if (($this->getVar('next_id')) && ($this->getVar('previous_id'))) {	
				print "&nbsp;&nbsp;|&nbsp;&nbsp;";
			}
			if ($this->getVar('next_id') > 0) {
				print caNavLink($this->request, _t("NEXT")." <img src='".$this->request->getThemeUrlPath()."/graphics/arrow_grey_right.gif' width='10' height='10' border='0'>", '', 'Detail', 'Entity', 'Show', array('entity_id' => $this->getVar('next_id')), array('id' => 'next'));
			}
		}
?>
		</div><!-- end nav -->
		<h1><?php print $vs_title; ?></h1>

		<div id="resultBox">
<?php
}
	// set parameters for paging controls view
	$this->setVar('other_paging_parameters', array(
		'entity_id' => $vn_entity_id
	));
	print $this->render('related_objects_grid.php');
	
if (!$this->request->isAjax()) {
?>
		</div><!-- end resultBox -->
</div><!-- end detailBody -->
<?php
}
?>