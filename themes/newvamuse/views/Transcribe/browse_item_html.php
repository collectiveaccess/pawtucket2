<?php
/** ---------------------------------------------------------------------
 * themes/default/Transcribe/set_detail_item_html.php :
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
 
    $vs_view = $this->getVar('view');
    $vn_object_id = $this->getVar('object_id');

    $vs_caption = $this->getVar('caption');
    $vn_representation_id = $this->getVar('representation_id');
    $vs_representation = $this->getVar('representation');
?>
<div class='lbItem'>
	<div class='lbItemContent'>
		{{{representation}}}
		<div id='comment{{{item_id}}}' class='lbSetItemComment'><!-- load comments here --></div>
		<div class='caption'>{{{caption}}}</div>
	</div><!-- end lbItemContent -->
	<div class='lbExpandedInfo' id='lbExpandedInfo{{{item_id}}}'><hr/>
		<div>
			<?php print caNavLink($this->request, "<span class='glyphicon glyphicon-file'></span>", '', '*', 'Transcribe', 'Item', ['id' => $vn_object_id], ["title" => _t("Transcribe")]); ?>
			</div>
	</div><!-- end lbExpandedInfo -->
</div><!-- end lbItem -->
