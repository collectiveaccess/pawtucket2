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
	$pn_set_id 							= $this->getVar("set_id");
	$va_lightboxDisplayName 		= caGetLightboxDisplayNameParent();
	$vs_lightbox_displayname 		= $va_lightboxDisplayName["singular"];
	$vs_lightbox_displayname_plural = $va_lightboxDisplayName["plural"];
	
?>
<div id="caFormOverlay"><div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<H1><?php print _t("Unpublish %1", ucfirst($vs_lightbox_displayname)); ?></H1>

	<form id='unPublishFormOverlay' action='#' class='form-horizontal' role='form'>
<?php
		print "<div class='form-group'><label for='message' class='col-sm-4 control-label'>"._t("Message")."</label><div class='col-sm-7'><textarea class='form-control' name='message' placeholder='Why are you unpublishing?'></textarea></div><!-- end col-sm-7 --></div><!-- end form-group -->\n";
?>
		<div class="form-group">
			<div class="col-sm-offset-4 col-sm-7">
				<button type="submit" class="btn btn-default"><?php print _t('Unpublish'); ?></button>
			</div><!-- end col-sm-7 -->
		</div><!-- end form-group -->
		<input type="hidden" name="set_id" value="<?php print $pn_set_id; ?>">
				
	</form>
</div>
<?php
		# --- reload the parent list
?>
			<script type='text/javascript'>
				jQuery(document).ready(function() {
					jQuery('#unPublishFormOverlay').on('submit', function(e){		
						jQuery('#caMediaPanelContentArea').load(
							'<?php print caNavUrl($this->request, '', 'Lightbox', 'ajaxUserUnpublish', null); ?>',
							jQuery('#unPublishFormOverlay').serialize()
						);
						e.preventDefault();
						return false;
					});
				});
			</script>
