<?php
/* ----------------------------------------------------------------------
 * themes/cosa/views/Detail/tag_list_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2025 Whirl-i-Gig
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
$table = 			$this->getVar('table');
$id = 				$this->getVar('id');
$detail_type = 		$this->getVar('detail');
$tag_list = 		$this->getVar("tagsAvailable");
$selected_tags = 	$this->getVar("tagsSelected");
$tag_counts = 		$this->getVar("tagCounts");
?>
<div class="col-md-4 mb-4 <?= (!is_array($tag_counts)) ? "d-none" : ""; ?>" id="tagCounts">
	<H2 class="fs-4"><?= _t('What People Are Saying'); ?></H2>
	<ul class="list-group list-group-flush mb-5">
<?php
	if(is_array($tag_counts)) {
		foreach($tag_counts as $tag_id => $tag_info) {
			$l = $tag_info['name_singular'];
			$c = $tag_info['count'];
?><li class="list-group-item"><?= ($c != 1) ? _t('%1 person says <strong>%2</strong>', $c, $l) : _t('%1 people say <strong>%2</strong>', $c, $l); ?></li>
<?php
		}
	}
?>
	</ul>
</div>
<div class="col-md-8 mb-4">
	<H2 class="fs-4"><?= _t('Add Your Review'); ?></H2>
	<div role="group" class="text-center" aria-label=<?= json_encode(_t('Tag reviews')); ?> id="tagList">
<?php
	foreach($tag_list as $tag_id => $tag){
		$url = caNavUrl($this->request, '*', '*', 'ToggleTagListItem', ['detail' => $detail_type, 'id' => $id, 'tag' => $tag_id]);
		$clr = isset($selected_tags[$tag_id]) ? 'dark' : 'light';
		
		print "<button type='button' class='btn btn-{$clr} mx-2 mb-2' hx-trigger='click' hx-target='#tagList' hx-swap='innerHTML' hx-post='{$url}'>{$tag}</button>";				
	}
?>
	</div>
</div>