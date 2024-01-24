<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Contribute/terms_and_conditions_check_html.php : simple terms and conditions click-through sub-view
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
 
	//
	// Force user to agree to click-through agreement (as if that makes a difference :-)
	// http://www.npr.org/2014/09/01/345044359/why-do-we-blindly-sign-terms-of-service-agreements
	//
	if ($this->getVar('terms_and_conditions')) {
?>
		<div>
			<div class="bundleLabel">	
				<span class="formLabelText">
						<?php print _t('Terms and conditions'); ?>
						<br/>
						<div style="margin-left: 40px;">
							<input name="iAgreeToTerms" value="1" id="iAgreeToTerms" type="checkbox"/>
							<?php print _t('I agree to the Terms and Conditions set out herein'); ?>
						</div>
				</span>
			</div>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('#ContributeForm').on('submit', function() {
					if (jQuery('#iAgreeToTerms').length > 0) {
						if (!jQuery('#iAgreeToTerms').attr('checked')) {
							alert("<?php print _t("You must agree to the terms and conditions before proceeding."); ?>");
							return false;
						}
					}
				});
			});
		</script>
<?php
	}