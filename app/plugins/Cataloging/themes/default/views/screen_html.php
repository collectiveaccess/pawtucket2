<?php
/* ----------------------------------------------------------------------
 * views/editor/objects/screen_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2008-2011 Whirl-i-Gig
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
 	$t_subject 			= $this->getVar('t_subject');
	$vn_subject_id 		= $this->getVar('subject_id');
	$t_ui 				= $this->getVar('t_ui');
	$vs_theme			= $this->getVar('theme');
	$vs_message			= $this->getVar('notification_message');

	$vb_print_buttons = (intval($vn_subject_id) > 0 ? $vb_can_edit : $vb_can_create);
	
	$vs_control_box = caFormControlBox(
		(caFormSubmitButton($this->request, __CA_NAV_BUTTON_SAVE__, _t("Save"), 'CatalogingForm', array('graphicsPath' => $this->getVar('graphicsPath')))).' '.
		(caNavButton($this->request, __CA_NAV_BUTTON_CANCEL__, _t("Cancel"), 'Detail', 'Object', 'Show', array($t_subject->primaryKey() => $vn_subject_id), '', array('graphicsPath' => $this->getVar('graphicsPath')))),
		'', 
		''
	);
?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			// initialize CA Utils
			caUI.initUtils({unsavedChangesWarningMessage: '<?php _p('You have made changes in this form that you have not yet saved. If you navigate away from this form you will lose your unsaved changes.'); ?>'});
		});
	</script>
	<div class="sectionBox">
	<div class='textContent'>
		<p><?php print _t("Use the following form to make cataloging adjustments to this record."); ?></p>
	</div>
<?php
	if($vs_message){
		print "<div class='formNotification'>".$vs_message."</div>";
	}
?>
		<form action="#" id="CatalogingForm" method="POST" enctype="multipart/form-data">
<?php
			#print caFormTag($this->request, 'Save/'.$this->request->getActionExtra(), 'CatalogingForm', null, 'POST', 'multipart/form-data');
		
			$va_form_elements = $t_subject->getBundleFormHTMLForScreen($this->request->getActionExtra(), array(
									'request' => $this->request, 
									'formName' => 'CatalogingForm',
									'ui_instance' => $t_ui,
									'viewPath' => $this->getVar('viewPath'),
									'graphicsPath' => $this->getVar('graphicsPath'),
									'config' => $this->getVar('plugin_config'),
									'omit' => array('hierarchy_location', 'hierarchy_navigation')
								));
			
			print join("\n", $va_form_elements);
			
			
			print "<div style='height:15px; width: 100%;'></div>";
			print "<div><input type='submit' value='Save'></div>";
?>
			<input type='hidden' name='_formName' value='CatalogingForm'/>
			<input type='hidden' name='id' value='<?php print $t_subject->get($t_subject->primaryKey()); ?>'/>
			<input type='hidden' name='<?php print $t_subject->primaryKey(); ?>' value='<?php print $t_subject->get($t_subject->primaryKey()); ?>'/>
			<input type='hidden' name='ui' value='<?php print CatalogingPlugin::$s_ui_code; ?>'/>
		</form>
	</div>

	<div class="editorBottomPadding"><!-- empty --></div>
	
	<script type="text/javascript">
		$('#CatalogingForm').submit(function() {
		  jQuery("#adminForm").load("<?php print caNavUrl($this->request, 'Cataloging', 'Form', 'Save/'.$this->request->getActionExtra()); ?>?" + $('#CatalogingForm').serialize());
		  return false;
		});
	</script>