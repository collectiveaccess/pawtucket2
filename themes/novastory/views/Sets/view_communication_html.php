<?php
/* ----------------------------------------------------------------------
 * themes/default/views/client/view_communication_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2011 Whirl-i-Gig
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
 
 	$va_messages = $this->getVar('messages');
 	$t_message = $this->getVar('message');
 	$va_snapshot = $t_message->get('set_snapshot');
 	
 	$va_communication_ids = array();
 	foreach($va_messages[$t_message->get('transaction_id')] as $vn_i => $va_communication) {
 		$va_communication_ids[] = (int)$va_communication['communication_id'];
 	}
 	
 	if (($vn_index = array_search($t_message->getPrimaryKey(), $va_communication_ids)) >= 0) {
		print "<div id='messageNav'>";
		if ($vn_index > 0) {
			print "<a href='#' onclick='jQuery(\"#caClientCommunicationsViewerPanelContentArea\").load(\"".caNavUrl($this->request, '', 'Sets', 'ViewMessage', array('communication_id' => $va_communication_ids[$vn_index - 1]))."\"); return false;'>&lsaquo; "._t('Previous')."</a>";
		}else{
			print "&lsaquo; "._t('Previous');
		}
		print "&nbsp;|&nbsp;";
		if ($vn_index < (sizeof($va_communication_ids) - 1)) {
			print "<a href='#' onclick='jQuery(\"#caClientCommunicationsViewerPanelContentArea\").load(\"".caNavUrl($this->request, '', 'Sets', 'ViewMessage', array('communication_id' => $va_communication_ids[$vn_index + 1]))."\"); return false;'>"._t('Next')." &rsaquo;</a>";
		}else{
			print _t('Next')." &rsaquo;";
		}
		print "</div><!-- end messageNav -->";
	}
 ?>
 	<div id="caClientCommunicationsMessage">
 <?php
	print caClientServicesFormatMessagePawtucket($this->request, $t_message->getFieldValuesArray(), array('replyButton' => "<a href='#' onclick='caClientCommunicationsViewerPanelRef.hidePanel(); jQuery(\"#newFormContainer\").slideUp(0); jQuery(\".reply\").hide(); jQuery(\"#caClientCommunications\").slideDown(250); return false;'>"._t('Reply')."</a>"));
	
	
	if (is_array($va_snapshot) && is_array($va_snapshot['items']) && sizeof($va_snapshot['items'])) {
		$va_ids = array();
		foreach($va_snapshot['items'] as $vn_id => $vn_dummy) { $va_ids[] = (int)$vn_id; }
		$t_object = new ca_objects();

		$qr_res = $t_object->makeSearchResult('ca_objects', $va_ids);
?>
	<div>
		<a href="#" onclick="showHideCommunicationAttachedMedia(); return false;" id="caClientCommunicationsAttachedMediaControl" class="caClientCommunicationsAttachedMediaControl"><?php print _t('Show attached media'); ?> &rsaquo;</a>
	</div>
	<div class="caClientCommunicationsAttachedMediaContainer">
		<div id="caClientCommunicationsAttachedMedia" class="caClientCommunicationsAttachedMediaItems caClientCommunicationsAttachedMedia">
			<ul class="caClientCommunicationsAttachedMediaList">
<?php		
				while($qr_res->nextHit()) {
					$vs_representation_tag = $qr_res->getMediaTag('ca_object_representations.media', 'thumbnail');
					$vs_title = $qr_res->get('ca_objects.preferred_labels.name')."<br/>";
					$vs_idno = $qr_res->get('ca_objects.idno')."<br/>";
					$vn_object_id = $qr_res->get('ca_objects.object_id');
					$vn_representation_id = $qr_res->get('ca_object_representations.representation_id');
					
					$va_title = array();
?>
					<li class='caClientCommunicationsAttachedMediaItem'>
						<div class='imagecontainer'>
							<div class='caClientCommunicationsAttachedMediaItemThumbnail'>
<?php
							if ($vs_representation_tag) {
								print caNavLink($this->request, $vs_representation_tag, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
							}
							
							if ($vs_title) {
								if (mb_strlen($vs_title) > 70) {
									$va_title[] = '<em>'.mb_substr($vs_title, 0, 67).'...</em>';
								} else {
									$va_title[] = '<em>'.$vs_title.'</em>';
								}
							}
							
							if ($vs_idno) {
								$va_title[] = '<strong>'._t('Id:').'</strong> '.$vs_idno;
							}
							$vs_title = join('<br/>', $va_title);
?>
							</div>
							<div class='caClientCommunicationsAttachedMediaItemCaption'><?php print caNavLink($this->request, $vs_title, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id)); ?></div>
						</div>
					</li>
<?php
				}
?>
			</ul>
		</div>
	</div>
<?php
	}
?> 	
 	</div>
