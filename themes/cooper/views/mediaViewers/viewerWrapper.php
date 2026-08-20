<?php
/** ---------------------------------------------------------------------
 * themes/default/views/mediaViewers/viewerWrapper.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2016-2017 Whirl-i-Gig
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
 * @subpackage Media
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
?>
<div id="caMediaOverlayContent" ><?php print $this->render($this->getVar('viewer').".php"); ?></div>	
<?php if ($this->getVar('hideOverlayControls')) { ?>
<div class="caMediaOverlayControlsMinimal">
	<div class='close'><a href="#" onclick="caMediaPanel.hidePanel(); return false;" title="close"><?php print caNavIcon(__CA_NAV_ICON_CLOSE__, "18px", [], ['color' => 'white']); ?></a></div>
</div>
<?php } else { ?>
<div class="caMediaOverlayControls">
	<div class='close'><a href="#" onclick="caMediaPanel.hidePanel(); return false;" title="close"><?php print caNavIcon(__CA_NAV_ICON_CLOSE__, "18px", [], ['color' => 'white']); ?></a></div>
	<?php print $this->getVar('controls'); ?>
<?php 
	$vn_object_id = $this->request->getParameter('id', pInteger);
	if(!$vn_object_id){
		$vn_object_id =  $this->request->getParameter('object_id', pInteger);
	}
	$vs_context = $this->request->getParameter('context', pString);
	$t_object = new ca_objects($vn_object_id);
	$va_siblings = $t_object->get("ca_objects.siblings.object_id", array("returnAsArray" => true));
	$vn_previous_id = $vn_next_id = $vn_current_id = null;
	if(is_array($va_siblings) && sizeof($va_siblings)){
		foreach($va_siblings as $vn_sib_obj_id){
			if($vn_current){
				$vn_next_id = $vn_sib_obj_id;
				break;
			}
			if($vn_sib_obj_id == $vn_object_id){
				$vn_current = $vn_sib_obj_id;
			}else{
				$vn_previous_id = $vn_sib_obj_id;
			}
		}
	}
	print "<div class='pull-right'>";
	if($vn_previous_id){
		$t_object = new ca_objects($vn_previous_id);
		if($vn_rep_id = $t_object->get("ca_object_representations.representation_id")){
			print "<a href='#' onClick='jQuery(\"#caMediaPanelContentArea\").load(\"".caNavUrl($this->request, '*', '*', $this->request->getAction(), array('representation_id' => $vn_rep_id, "object_id" => $vn_previous_id, 'context' => $vs_context))."\");'><i class='fa fa-angle-left'></i> Previous</a>";
			print "&nbsp;&nbsp;&nbsp;&nbsp;";
		}			
	}
	
	if($vn_next_id){
		$t_object = new ca_objects($vn_next_id);
		if($vn_rep_id = $t_object->get("ca_object_representations.representation_id")){
			print "<a href='#' onClick='jQuery(\"#caMediaPanelContentArea\").load(\"".caNavUrl($this->request, '*', '*', $this->request->getAction(), array('representation_id' => $vn_rep_id, "object_id" => $vn_next_id, 'context' => $vs_context))."\");'>Next <i class='fa fa-angle-right'></i></a>";
			print "&nbsp;&nbsp;&nbsp;&nbsp;";
		}			
	}
	print "</div>";
?>
</div>
<?php } ?>