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

	$vb_print_buttons = (intval($vn_subject_id) > 0 ? $vb_can_edit : $vb_can_create);
	
	$vs_control_box = caFormControlBox(
		(caFormSubmitButton($this->request, __CA_NAV_BUTTON_SAVE__, _t("Save"), 'ContributeForm', array('graphicsPath' => $this->getVar('graphicsPath')))).' '.
		(caNavButton($this->request, __CA_NAV_BUTTON_CANCEL__, _t("Cancel"), $this->request->getModulePath(), $this->request->getController(), $this->request->getAction().'/'.$this->request->getActionExtra(), array($t_subject->primaryKey() => $vn_subject_id), '', array('graphicsPath' => $this->getVar('graphicsPath')))),
		'', 
		''
	);
?>
	<H2>Contribute Your Story</H2>
	<p>
		Become a participant in documenting this rich legacy of artists on the East End. The Parrish is currently soliciting contributions of oral histories, photographs, audio, home movies, and print ephemera related to artists who have lived or worked in the region. Content contributed will be added to a redesigned East End Stories website, launching in 2012.  Please use this form to upload a description of content you would like to contribute.
	</p>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			// initialize CA Utils
			caUI.initUtils({unsavedChangesWarningMessage: '<?php _p('You have made changes in this form that you have not yet saved. If you navigate away from this form you will lose your unsaved changes.'); ?>'});
		});
	</script>
	<div class="sectionBox">
<?php
			print caFormTag($this->request, 'Save/'.$this->request->getActionExtra().'/'.$t_subject->primaryKey().'/0', 'ContributeForm', null, 'POST', 'multipart/form-data');
		
			$va_form_elements = $t_subject->getBundleFormHTMLForScreen($this->request->getActionExtra(), array(
									'request' => $this->request, 
									'formName' => 'ContributeForm',
									'ui_instance' => $t_ui,
									'viewPath' => $this->getVar('viewPath'),
									'graphicsPath' => $this->getVar('graphicsPath'),
									'config' => $this->getVar('plugin_config')
								));
			
			print join("\n", $va_form_elements);
			
			#print $vs_control_box;
?>
			<button type="submit" name="submit" class="submitForm">Submit </button>
			<input type='hidden' name='<?php print $t_subject->primaryKey(); ?>' value='0'/>
		</form>
	</div>

	<div class="editorBottomPadding"><!-- empty --></div>
