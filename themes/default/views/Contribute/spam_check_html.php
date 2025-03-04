<?php	
/* ----------------------------------------------------------------------
 * themes/default/views/Contribute/spam_check_html.php : simple spam protection sub-view
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
	// Provide simple math problem to deter spambots
	// 
	if ($this->getVar('spam_protection')) {
		$vn_1 = rand(0, 9);
		$vn_2 = rand(0, 9);
		$vn_sum = (int)$vn_1 + (int)$vn_2;
?>
		<div>
			<div class="bundleLabel">	
				<span class="formLabelText">
						<?php print _t('Simple Math Quiz (to prevent SPAMbots)'); ?>
						<br/>
						<div style="margin-left: 40px;">
							<span id="securityText"><?php print $vn_1; ?> + <?php print $vn_2; ?> = </span>
							<input name="security" value="" id="security" type="text" size="3" style="width:40px;" />
						</div>
				</span>
			</div>
		</div>
		<input type="hidden" name="sum" value="<?php print $vn_sum; ?>" id="securitySum"/>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('#ContributeForm').on('submit', function() {
					if (jQuery('#security').length > 0) {
						if (jQuery('#security').val() != jQuery('#securitySum').val()) {
							alert("<?php print _t("Please correctly answer the security question."); ?>");
							return false;
						}
					}
				});
			});
		</script>
<?php
	}