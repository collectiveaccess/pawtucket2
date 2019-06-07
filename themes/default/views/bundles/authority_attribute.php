<?php
/* ----------------------------------------------------------------------
 * bundles/authority_attribute.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2019 Whirl-i-Gig
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


$vs_field_name_prefix 		= $this->getVar('field_name_prefix');
$vs_quickadd_url 			= $this->getVar('quickadd_url');
$vs_url 					= $this->getVar('lookup_url');
$pa_options 				= $this->getVar('options');
$va_settings 				= $this->getVar('settings');
$pa_element_info 			= $this->getVar('element_info');
$vs_class					= $this->getVar('class');

print caHTMLTextInput(
	"{$vs_field_name_prefix}_{n}",
	array(
		'size' => (isset($pa_options['width']) && $pa_options['width'] > 0) ? $pa_options['width'] : $va_settings['fieldWidth'],
		'height' => (isset($pa_options['height']) && $pa_options['height'] > 0) ? $pa_options['height'] : 1,
		'value' => '{{'.$pa_element_info['element_id'].'}}',
		'maxlength' => 512,
		'id' => "{$vs_field_name_prefix}_autocomplete{n}",
		'class' => $vs_class
	)
);

