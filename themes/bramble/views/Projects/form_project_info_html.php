<?php
/** ---------------------------------------------------------------------
 * themes/bramble/Projects/form_project_info_html.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015 Whirl-i-Gig
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
 * @subpackage theme/default
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
	$t_project 						= $this->getVar("project");
	$va_errors 						= $this->getVar("errors");

?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<H1><?php print _t("Project Information"); ?></H1>
<?php
	if(is_array($va_errors) && sizeof($va_errors)){
		print "<div class='alert alert-danger'>".join("<br/>", $va_errors)."</div>";
	}
?>
	<form id="ProjectForm" action="#" class="form-horizontal" role="form">
<?php
		if($va_errors["name"]){
			print "<div class='alert alert-danger'>".$va_errors["name"]."</div>";
		}
		print "<div class='form-group".(($va_errors["name"]) ? " has-error" : "")."'><label for='name' class='col-sm-4 control-label'>"._t("Name")."</label><div class='col-sm-7'><input type='text' name='name' value='".htmlentities($this->getVar("name"), ENT_QUOTES, 'UTF-8', false)."' class='form-control'></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
		if($va_errors["description"]){
			print "<div class='alert alert-danger'>".$va_errors["description"]."</div>";
		}
		print "<div class='form-group".(($va_errors["description"]) ? " has-error" : "")."'><label for='description' class='col-sm-4 control-label'>"._t("Description")."</label><div class='col-sm-7'><textarea name='description' class='form-control' rows='3'>".htmlentities($this->getVar("description"), ENT_QUOTES, 'UTF-8', false)."</textarea></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
?>
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-7">
				<button type="submit" class="btn btn-default"><?php print _t('Save'); ?></button>
			</div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
		<input type="hidden" name="project_id" value="<?php print $t_project->get("occurrence_id"); ?>">
	</form>
</div>

<?php
	if($this->request->isAjax()){
?>
<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#ProjectForm').on('submit', function(e){		
			jQuery('#caMediaPanelContentArea').load(
				'<?php print caNavUrl($this->request, '', 'Projects', 'ajaxSaveProjectInfo', null); ?>',
				jQuery('#ProjectForm').serialize()
			);
			e.preventDefault();
			return false;
		});
	});
</script>
<?php
	}
?>
