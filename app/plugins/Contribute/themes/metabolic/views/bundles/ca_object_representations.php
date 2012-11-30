<?php
/* ----------------------------------------------------------------------
 * bundles/ca_object_representations.php : 
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

	JavascriptLoadManager::register('sortableUI');

	$vs_id_prefix 		= $this->getVar('placement_code').$this->getVar('id_prefix');
	$t_item 			= $this->getVar('t_item');			// object representation
	$t_item_rel 		= $this->getVar('t_item_rel');
	$t_subject 			= $this->getVar('t_subject');		// object
	$vs_add_label 		= $this->getVar('add_label');
	
	$vb_allow_fetching_from_urls = $this->request->getAppConfig()->get('allow_fetching_of_media_from_remote_urls');
	
	// generate list of inital form values; the bundle Javascript call will
	// use the template to generate the initial form
	$va_inital_values = array();
	$va_reps = $t_subject->getRepresentations(array('thumbnail', 'original'));
	$va_rep_type_list = $t_item->getTypeList();
	$va_errors = array();
	
	if (sizeof($va_reps)) {
		foreach ($va_reps as $va_rep) {
			$vn_num_multifiles = $va_rep['num_multifiles'];
			$vs_extracted_metadata = caFormatMediaMetadata(caUnserializeForDatabase($va_rep['media_metadata']));
			$vs_md5 = isset($va_rep['info']['original']['MD5']) ? _t('MD5 signature').': '.$va_rep['info']['original']['MD5'] : '';
			
			$va_inital_values[$va_rep['representation_id']] = array(
				'status' => $va_rep['status'], 
				'access' => $va_rep['access'], 
				'is_primary' => ($va_rep['is_primary'] == 1) ? true : false, 
				'locale_id' => $va_rep['locale_id'], 
				'icon' => $va_rep['tags']['thumbnail'], 
				'type' => $va_rep['info']['original']['PROPERTIES']['typename'], 
				'dimensions' => $va_rep['dimensions']['original'], 
				'filename' => $va_rep['info']['original_filename'],
				'num_multifiles' => ($vn_num_multifiles ? (($vn_num_multifiles == 1) ? _t('+ 1 additional preview') : _t('+ %1 additional previews', $vn_num_multifiles)) : ''),
				'metadata' => $vs_extracted_metadata,
				'md5' => $vs_md5,
				'type_id' => $va_rep['type_id'],
				'typename' => $va_rep_type_list[$va_rep['type_id']]['name_singular'],
				'fetched_from' => $va_rep['fetched_from'],
				'fetched_on' => date('c', $va_rep['fetched_on'])
			);
			
			if(is_array($va_action_errors = $this->request->getActionErrors('ca_object_representations', $va_rep['representation_id']))) {
				foreach($va_action_errors as $o_error) {
					$va_errors[$va_rep['representation_id']][] = array('errorDescription' => $o_error->getErrorDescription(), 'errorCode' => $o_error->getErrorNumber());
				}
			}
		}
	}
	
	$va_failed_inserts = array();
	foreach($this->request->getActionErrorSubSources('ca_object_representations') as $vs_error_subsource) {
		if (substr($vs_error_subsource, 0, 4) === 'new_') {
			$va_action_errors = $this->request->getActionErrors('ca_object_representations', $vs_error_subsource);
			foreach($va_action_errors as $o_error) {
				$va_failed_inserts[] = array('icon' => '', '_errors' => array(array('errorDescription' => $o_error->getErrorDescription(), 'errorCode' => $o_error->getErrorNumber())));
			}
		}
	}
?>
<div id="<?php print $vs_id_prefix.$t_item->tableNum().'_rel'; ?>">
<?php
	//
	// The bundle template - used to generate each bundle in the form
	//
?>
	<textarea class='caItemTemplate' style='display: none;'>
		<div id="<?php print $vs_id_prefix; ?>Item_{n}" class="labelInfo">
			<span class="formLabelError">{error}</span>
			<table class="caListItem">
				<tr>
					<td>
<?php 
			if ($vn_type_id = ContributePlugin::getFormSetting("representation_type_id")) {
				print caHTMLHiddenInput('{fieldNamePrefix}type_id_{n}', array('value' => $vn_type_id));
			} else {
				print $t_item->htmlFormElement('type_id', null, array('classname' => '{fieldNamePrefix}type_id_select objectRepresentationType', 'id' => "{fieldNamePrefix}type_id_{n}", 'name' => "{fieldNamePrefix}type_id_{n}", "value" => "", 'no_tooltips' => false, 'tooltip_namespace' => 'bundle_ca_object_representations',  'hide_select_if_only_one_option' => true)); 
			}
			
			if ($vn_status = ContributePlugin::getFormSetting("representation_status")) {
				print caHTMLHiddenInput('{fieldNamePrefix}status_{n}', array('value' => $vn_status));
			}
			if ($vn_access = ContributePlugin::getFormSetting("representation_access")) {
				print caHTMLHiddenInput('{fieldNamePrefix}access_{n}', array('value' => $vn_access));
			}
?>
			<?php print $t_item->htmlFormElement('media', null, array('name' => "{fieldNamePrefix}media_{n}", 'id' => "{fieldNamePrefix}media_{n}", "value" => "", 'no_tooltips' => false, 'tooltip_namespace' => 'bundle_ca_object_representations')); ?>
					</td>
					<td>
						<div style="float:right; margin:5px 0px 0px -10px; position:absolute;">
							<a href="#" class="caDeleteItemButton"><?php print caNavIcon($this->request, __CA_NAV_BUTTON_DEL_BUNDLE__, null, null, array('graphicsPath' => $this->getVar('graphicsPath'))); ?></a>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<script type="text/javascript">
			jQuery("#{fieldNamePrefix}type_id_{n}").attr('disabled', true);
		</script>
<?php
	print TooltipManager::getLoadHTML('bundle_ca_object_representations');
?>
	</textarea>
	
	<div class="bundleContainer">
		<div class="caItemList">
		
		</div>
		<div class='button labelInfo caAddItemButton'><a href='#'><?php print caNavIcon($this->request, __CA_NAV_BUTTON_ADD__, null, null, array('graphicsPath' => $this->getVar('graphicsPath'))); ?> <?php print $vs_add_label ? $vs_add_label : _t("Add representation")." &rsaquo;"; ?></a></div>
	</div>
</div>

<input type="hidden" id="<?php print $vs_id_prefix; ?>_ObjectRepresentationBundleList" name="<?php print $vs_id_prefix; ?>_ObjectRepresentationBundleList" value=""/>
<?php
	// order element
?>
			
<script type="text/javascript">
	caUI.initBundle('#<?php print $vs_id_prefix.$t_item->tableNum().'_rel'; ?>', {
		fieldNamePrefix: '<?php print $vs_id_prefix; ?>_',
		templateValues: ['status', 'access', 'is_primary', 'media', 'locale_id', 'icon', 'type', 'dimensions', 'filename', 'num_multifiles', 'metadata', 'type_id', 'typename', 'fetched_from'],
		initialValues: <?php print json_encode($va_inital_values); ?>,
		errors: <?php print json_encode($va_errors); ?>,
		forceNewValues: <?php print json_encode($va_failed_inserts); ?>,
		itemID: '<?php print $vs_id_prefix; ?>Item_',
		templateClassName: 'caItemTemplate',
		itemListClassName: 'caItemList',
		itemClassName: 'labelInfo',
		addButtonClassName: 'caAddItemButton',
		deleteButtonClassName: 'caDeleteItemButton',
		showOnNewIDList: [],
		hideOnNewIDList: [],
		enableOnNewIDList: ['<?php print $vs_id_prefix; ?>_type_id_'],
		showEmptyFormsOnLoad: 1,
		isSortable: false,
		listSortOrderID: '<?php print $vs_id_prefix; ?>_ObjectRepresentationBundleList',
		defaultLocaleID: <?php print ca_locales::getDefaultCataloguingLocaleID(); ?>
		
	});
</script>
