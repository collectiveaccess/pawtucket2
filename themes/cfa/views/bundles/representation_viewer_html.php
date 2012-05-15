<?php
/* ----------------------------------------------------------------------
 * views/editor/objects/ajax_object_representation_info_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2011 Whirl-i-Gig
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
	$t_object 						= $this->getVar('t_object');
	$t_rep 							= $this->getVar('t_object_representation');
	$va_versions 				= $this->getVar('versions');	
	$vn_representation_id 	= $t_rep->getPrimaryKey();
	$va_reps 						= $this->getVar('reps');
	
	$va_display_options	 	= $this->getVar('display_options');
	$vs_show_version 		= $this->getVar('version');
	
	// Get filename of originally uploaded file
	$va_media_info 			= $t_rep->getMediaInfo('media');
	$vs_original_filename 	= $va_media_info['ORIGINAL_FILENAME'];
	
	$vs_container_id 			= $this->getVar('containerID');
	
	$va_pages = array();
	$vb_use_book_reader = false;
	$vn_open_to_page = 1;


		$vb_should_use_book_viewer = isset($va_display_options['use_book_viewer']) && (bool)$va_display_options['use_book_viewer'];

		if (
			$vb_should_use_book_viewer 
			&&
			isset($va_display_options['use_book_viewer_when_number_of_representations_exceeds']) 
			&& 
			((int)$va_display_options['use_book_viewer_when_number_of_representations_exceeds'] > 0) 
			&& 
			((int)$va_display_options['use_book_viewer_when_number_of_representations_exceeds'] < sizeof($va_reps))
		) {
			// Create book viewer from multiple representations
			$va_reps = $t_object->getRepresentations(array('large'));
			foreach($va_reps as $vn_id => $va_file) {
				$va_pages[] = array(
					'pageTitle' => $va_file['label'],
					'pageUrl' => $va_file['urls']['large'], 'pageWidth' => $va_file['info']['large']['WIDTH'], 'pageHeight' => $va_file['info']['large']['HEIGHT'],
					'previewUrl' => $va_file['urls']['large'], 'previewWidth' => $va_file['info']['large']['WIDTH'], 'previewHeight' => $va_file['info']['large']['HEIGHT']
				);
			}
			$vb_use_book_reader = true;
		} else {
			if (
				$vb_should_use_book_viewer
				&&
				(
					((isset($va_display_options['show_hierarchy_in_book_viewer'])
					&& 
					(bool)$va_display_options['show_hierarchy_in_book_viewer']))
					||
					((isset($va_display_options['show_subhierarchy_in_book_viewer'])
					&& 
					(bool)$va_display_options['show_subhierarchy_in_book_viewer']))
				)
				&&
				($va_ancestor_ids = $t_object->getHierarchyAncestors(null, array('idsOnly' => true)))
			) {
				$vn_parent_id = array_pop($va_ancestor_ids);
				
				$vn_page_id = $t_object->getPrimaryKey();
				$t_object->load($vn_parent_id);
				$va_child_ids = $t_object->getHierarchyChildren(null, array('idsOnly' => true));
				
				foreach($va_ancestor_ids as $vn_id) {
					array_unshift($va_child_ids, $vn_id);
				}
				$o_children = $t_object->makeSearchResult('ca_objects', $va_child_ids);
				
				$vn_i = 1;
				while($o_children->nextHit()) {
					$vs_url = $o_children->getMediaUrl('ca_object_representations.media', 'large');
					$va_info = $o_children->getMediaInfo('ca_object_representations.media', 'large');
					
					$va_pages[(int)$o_children->get('ca_objects.object_id')] = array(
						'pageTitle' => $o_children->get('ca_objects.preferred_labels.name'),
						'pageUrl' => $vs_url, 'pageWidth' => $va_info['WIDTH'], 'pageHeight' => $va_info['HEIGHT'],
						'previewUrl' => $vs_url, 'previewWidth' => $va_info['WIDTH'], 'previewHeight' => $va_info['HEIGHT']
					);
					if ($o_children->get('ca_objects.object_id') == $vn_page_id) { $vn_open_to_page = $vn_i; }
					
					$vn_i++;
				}
				ksort($va_pages);
				$va_pages = array_values($va_pages);
				$vb_use_book_reader = true;
			} else {
				if (
					$vb_should_use_book_viewer
					&&
					isset($va_display_options['show_hierarchy_in_book_viewer'])
					&& 
					(bool)$va_display_options['show_hierarchy_in_book_viewer']
					&&
					($va_child_ids = $t_object->getHierarchyChildren(null, array('idsOnly' => true)))
				) {
					array_unshift($va_child_ids, $t_object->getPrimaryKey());
					// Create book viewer from hierarchical objects
					$o_children = $t_object->makeSearchResult('ca_objects', $va_child_ids);
					while($o_children->nextHit()) {
						$vs_url = $o_children->getMediaUrl('ca_object_representations.media', 'large');
						$va_info = $o_children->getMediaInfo('ca_object_representations.media', 'large');
						
						$va_pages[] = array(
							'pageUrl' => $vs_url, 'pageWidth' => $va_info['WIDTH'], 'pageHeight' => $va_info['HEIGHT'],
							'previewUrl' => $vs_url, 'previewWidth' => $va_info['WIDTH'], 'previewHeight' => $va_info['HEIGHT']
						);
					}
					$vb_use_book_reader = true;
				} else {
					if (
						$vb_should_use_book_viewer
						&&
						($this->getVar('num_multifiles') > 0)
					) {
						// Create book viewer from single representation with multifiles
						$vb_use_book_reader = true;
				
						foreach($t_rep->getFileList(null, 0, null, array('original', 'page_preview')) as $vn_id => $va_file) {
							$va_pages[] = array(
									'pageUrl' => $va_file['original_url'], 'pageWidth' => $va_file['original_width'], 'pageHeight' => $va_file['original_height'],
									'previewUrl' => $va_file['page_preview_url'], 'previewWidth' => $va_file['page_preview_width'], 'previewHeight' => $va_file['page_preview_height']
								);
						}
					}
				}
			}
		}
				
	
		
		if ($vb_use_book_reader) {
			$o_view = new View($this->request, $this->request->getViewsDirectoryPath().'/bundles/');
			$o_view->setVar('bookTitle', $t_object->getLabelForDisplay());
			$o_view->setVar('bookUrl', caNavUrl($this->request, 'editor/objects', 'ObjectEditor', 'DownloadRepresentation', array('representation_id' => (int)$t_rep->getPrimaryKey(), 'download' => 1, 'version' => 'original')));
			$o_view->setVar('pages', $va_pages);
			$o_view->setVar('page', $vn_open_to_page);
			
			print $o_view->render('bookviewer_html.php');
		} else {
?>
	<!-- Controls -->
	<div class="caMediaOverlayControls">
			<table width="95%">
				<tr valign="middle">
					<td align="left">
						<form>
<?php
							print _t('Display %1 version', caHTMLSelect('version', $va_versions, array('id' => 'caMediaOverlayVersionControl', 'class' => 'caMediaOverlayControls'), array('value' => $vs_show_version)));
							$va_rep_info = $this->getVar('version_info');

							if (($this->getVar('version_type')) && ($va_rep_info['WIDTH'] > 0) && ($va_rep_info['HEIGHT'] > 0)) {
								print " (".$this->getVar('version_type')."; ". $va_rep_info['WIDTH']." x ". $va_rep_info['HEIGHT']."px)";
							}							
?>
						</form>
						
					</td>
<?php
					if($this->request->user->canDoAction("can_edit_ca_objects")){
?>
						<td align="middle" valign="middle">
							<div><div style="float:left"><a href="<?php print caEditorUrl($this->request, 'ca_object_representations', $vn_representation_id)?>" ><?php print caNavIcon($this->request, __CA_NAV_BUTTON_EDIT__)?></a></div><div style="float:left; margin:2px 0px 0px 3px;"><?php print _t("Edit metadata"); ?></div></div>
						</td>
<?php
					}
?>
					<td align="middle" valign="middle">
						<div>
<?php
	if ($vn_id = $this->getVar('previous_representation_id')) {
		print "<a href='#' onClick='jQuery(\"#{$vs_container_id}\").load(\"".caNavUrl($this->request, 'editor/objects', 'ObjectEditor', 'GetRepresentationInfo', array('representation_id' => (int)$vn_id, 'object_id' => (int)$t_object->getPrimaryKey()))."\");'>←</a>";
	}
	if (sizeof($va_reps) > 1) {
		print ' '._t("%1 of %2", $this->getVar('representation_index'), sizeof($va_reps)).' ';
	}
	if ($vn_id = $this->getVar('next_representation_id')) {
		print "<a href='#' onClick='jQuery(\"#{$vs_container_id}\").load(\"".caNavUrl($this->request, 'editor/objects', 'ObjectEditor', 'GetRepresentationInfo', array('representation_id' => (int)$vn_id, 'object_id' => (int)$t_object->getPrimaryKey()))."\");'>→</a>";
	}
?>
						</div>
					</td>
<?php
					if($this->request->user->canDoAction("can_download_ca_object_representations")){
?>
					<td align="right" text-align="right">
<?php 
						print caFormTag($this->request, 'DownloadRepresentation', 'downloadRepresentationForm', 'editor/objects/ObjectEditor', 'get', 'multipart/form-data', null, array('disableUnsavedChangesWarning' => true));
						print caHTMLSelect('version', $va_versions, array('id' => 'caMediaOverlayVersionControl', 'class' => 'caMediaOverlayControls'), array('value' => 'original'));
						print ' '.caFormSubmitLink($this->request, caNavIcon($this->request, __CA_NAV_BUTTON_DOWNLOAD__, null, array('align' => 'middle')), '', 'downloadRepresentationForm');
						print caHTMLHiddenInput('representation_id', array('value' => $t_rep->getPrimaryKey()));
						print caHTMLHiddenInput('object_id', array('value' => $t_object->getPrimaryKey()));
						print caHTMLHiddenInput('download', array('value' => 1));
?>
						</form>
					</td>
<?php
					}
?>
				</tr>
			</table>
	</div><!-- end caMediaOverlayControls -->

	<div id="caMediaOverlayContent">
<?php
	// return standard tag
	print $t_rep->getMediaTag('media', $vs_show_version, array_merge($va_display_options, array(
		'id' => 'caMediaOverlayContentMedia', 
		'viewer_base_url' => $this->request->getBaseUrlPath()
	)));
?>
	</div><!-- end caMediaOverlayContent -->
<script type="text/javascript">
	jQuery('#caMediaOverlayVersionControl').change(
		function() {
			var containerID = jQuery(this).parents(':eq(6)').attr('id');
			jQuery("#<?php print $vs_container_id; ?>").load("<?php print caNavUrl($this->request, 'editor/objects', 'ObjectEditor', 'GetRepresentationInfo', array('representation_id' => (int)$t_rep->getPrimaryKey(), 'object_id' => (int)$t_object->getPrimaryKey(), 'version' => '')); ?>" + this.value);
		}
	);
</script>
<?php
	}
?>
