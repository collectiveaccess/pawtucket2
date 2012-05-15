<?php
/* ----------------------------------------------------------------------
 * app/views/system/preferences_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2008 Whirl-i-Gig
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
 
 	
	$t_user = $this->getVar('t_user');
	$va_errors = $this->getVar('reg_errors');
 
 ?>
<div id="pageHeading"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/t_account_information.gif' width='244' height='23' border='0'></div><!-- end pageHeading -->
<div id="accountInfoForm">
<p><i>* indicates required fields.</i></p>
<form action="<?php print caNavUrl($this->request, 'system', 'Preferences', 'Save', array()); ?>" method="post" id="ProfileForm">
<?php

	#print caFormTag($this->request, 'Save', 'ProfileForm');
	
	//$va_prefs = $t_user->getValidPreferences($vs_group);
	
	//foreach($va_prefs as $vs_pref) {
	//	print $t_user->preferenceHtmlFormElement($vs_pref, null, array());
	//}
	
	foreach(array('fname', 'lname', 'email', 'password') as $vs_field) {
		switch($vs_field) {
			case 'password':
				print $t_user->htmlFormElement($vs_field, "<div class='formLabel'>Change password<br/>^ELEMENT</div>", array('value' => ''));
				print $t_user->htmlFormElement($vs_field, "<div class='formLabel'>Change password (confirm)<br/>^ELEMENT</div>", array('name' => 'password_confirm', 'value' => ''));
				break;
			default:
				print $t_user->htmlFormElement($vs_field, "<div class='formLabel'>^LABEL *<br/>^ELEMENT</div>");
				break;
		}
	}
	
?>
		<a href="#" name="save" class="button" onclick="jQuery('#ProfileForm').submit(); return false;"><?php print _t("Save"); ?></a>
	</form>
</div>