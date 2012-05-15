<?php
	$pn_object_id 			= $this->getVar('object_id');
	$t_rep 					= $this->getVar('t_object_representation');	
	$vn_representation_id 	= $t_rep->getPrimaryKey();
	
	$pn_previous_id 		= $this->getVar('previous_rep_id');
	$pn_next_id 			= $this->getVar('next_rep_id');
	
	$va_reps 				= $this->getVar('reps');
	$vs_display_version 	= $this->getVar('rep_display_version');
	$va_display_options		= $this->getVar('rep_display_options');
?>
	<div id="objDetailImage">
<?php
	if ($vs_media_tag = $t_rep->getMediaTag('media', $vs_display_version, $va_display_options)) {
		if (isset($va_display_options['no_overlay']) && $va_display_options['no_overlay']) {
			print $vs_media_tag;
		} else {
			print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetObjectMediaOverlay', array('object_id' => $pn_object_id, 'representation_id' => $vn_representation_id))."\"); return false;' >".$vs_media_tag."</a>";
		}
	}
?>
	</div><!-- end objDetailImage -->
	<div id="objDetailImageNav">
<?php
	if(sizeof($va_reps) > 1){
		if($pn_previous_id){
			print "<a href='#' onclick='jQuery(\"#objDetailImageContainer\").load(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetObjectDetailMedia', array('object_id' => $pn_object_id, 'representation_id' => $pn_previous_id))."\"); return false;' >&lsaquo; "._t("Previous")."</a>";
		}else{
			print "&lsaquo; "._t("Previous");
		}
		print "&nbsp;|&nbsp;";
		if($pn_next_id){
			print "<a href='#' onclick='jQuery(\"#objDetailImageContainer\").load(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetObjectDetailMedia', array('object_id' => $pn_object_id, 'representation_id' => $pn_next_id))."\"); return false;' >"._t("Next")." &rsaquo;</a>";
		}else{
			print _t("Next")." &rsaquo;";
		}
		print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	}
	if (!$this->request->config->get('dont_allow_registration_and_login')) {
		if($this->request->isLoggedIn()){
			print caNavLink($this->request, _t("Add to Collection +"), '', '', 'Sets', 'addItem', array('object_id' => $pn_object_id));
		}else{
			print caNavLink($this->request, _t("Add to Collection +"), '', '', 'LoginReg', 'form', array('site_last_page' => 'Sets'));
		}
	}
?>			
	</div><!-- end objDetailImageNav -->