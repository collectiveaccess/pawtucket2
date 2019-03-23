<?php
/** ---------------------------------------------------------------------
 * themes/default/Lightbox/form_set_info_html.php :
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
	$t_set 							= $this->getVar("set");
	$va_errors 						= $this->getVar("errors");
	$va_lightboxDisplayName 		= caGetLightboxDisplayName();
	$vs_lightbox_displayname 		= $va_lightboxDisplayName["singular"];
	$vs_lightbox_displayname_plural = $va_lightboxDisplayName["plural"];
	$vs_description_attribute 		= $this->getVar("description_attribute");

?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<H1><?php print _t("%1 Information", ucfirst($vs_lightbox_displayname)); ?></H1>
<?php
	if($va_errors["general"]){
		print "<div class='alert alert-danger'>".$va_errors["general"]."</div>";
	}
?>
	<form id="SetForm" action="#" class="form-horizontal" role="form">
<?php
		if($va_errors["name"]){
			print "<div class='alert alert-danger'>".$va_errors["name"]."</div>";
		}
		print "<div class='form-group".(($va_errors["name"]) ? " has-error" : "")."'><label for='name' class='col-sm-4 control-label'>"._t("Name")."</label><div class='col-sm-7'><input type='text' name='name' value='".htmlentities($this->getVar("name"), ENT_QUOTES, 'UTF-8', false)."' class='form-control'></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
		if($va_errors["description"]){
			print "<div class='alert alert-danger'>".$va_errors["description"]."</div>";
		}
		print "<div class='form-group".(($va_errors["description"]) ? " has-error" : "")."'><label for='".$vs_description_attribute."' class='col-sm-4 control-label'>"._t("Description")."</label><div class='col-sm-7'><textarea name='".$vs_description_attribute."' class='form-control' rows='3'>".htmlentities($this->getVar("description"), ENT_QUOTES, 'UTF-8', false)."</textarea></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
?>
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-7">
				<button type="submit" class="btn btn-default"><?php print _t('Save'); ?></button>
			</div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
		<input type="hidden" name="set_id" value="<?php print $t_set->get("set_id"); ?>">
	</form>
</div>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#SetForm').on('submit', function(e){		
			jQuery.getJSON(
				'<?php print caNavUrl($this->request, '', 'Lightbox', 'ajaxSaveSetInfo', null); ?>',
				jQuery('#SetForm').serializeObject(), function(data) {
					jQuery("#lbSetName" + data.set_id).html(data.name);
					jQuery("#lbSetDescription" + data.set_id).html(data.description);
					jQuery("#caMediaPanel").data('panel').hidePanel();
					
					if(data.is_insert) { 
						// add new set to list
						var h = "<div class='col-xs-6 col-sm-6 col-md-6 lbSetListItemCol'>" + data.block + "</div>";
						var l = jQuery('.lbSetListItemRow').last().find('.lbSetListItemCol').length;
				
						if (l >= 2) {	// add row
							jQuery('.lbSetListItemRow').last().parent().append('<div class="row lbSetListItemRow">' + h + "</div>");
						} else {
							jQuery('.lbSetListItemRow').last().append(h);
						}
					}
				}
			);
			e.preventDefault();
			return false;
		});
	});
</script>