<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
?>

<div class="container homebackground mainhome">
	<div class="row">	
		<div class="col-sm-1"></div>
		<div class="col-sm-5 text-center">
			<a href="<?php print caNavUrl($this->request, '*', '*', 'CJF'); ?>"><?php print caGetThemeGraphic($this->request, 'homecjflogo@2x.png', array('class' => 'innershadow', 'alt' => 'Cincinnati Judaica Fund', 'width' => '394', 'height' => '394')); ?></a>
		</div>
		<div class="col-sm-5 text-center">
			<a href="<?php print caNavUrl($this->request, '*', '*', 'CHHE'); ?>"><?php print caGetThemeGraphic($this->request, 'homecfhh_logo@2x.png', array('class' => 'innershadow', 'alt' => 'Center for Holocaust and Humanity', 'width' => '394', 'height' => '394')); ?></a>
		</div>
		<div class="col-sm-1"></div>
	</div><!--end row-->
</div><!--end homebackground-->