<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/representation_viewer_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015-2023 Whirl-i-Gig
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
$representation_count 			= $this->getVar('representation_count');
$representation_ids				= $this->getVar('representation_ids');
$show_annotations_mode			= $this->getVar('display_annotations');
$default_annotation_id				= $this->getVar('default_annotation_id');
$start_timecode						= $this->getVar('start_timecode');
$context							= $this->getVar('context');

$t_subject							= $this->getVar('t_subject');
$subject_id						= $t_subject->getPrimaryKey();

$params = ['context' => $context, 'id' => $subject_id, 'representation_id' => ''];

$slide_list = $this->getVar('slide_list');

if ($representation_count > 0) {
?>
<div id="carouselIndicators" class="carousel slide collection-carousel" data-bs-interval="false">
  <div class="carousel-inner">
<?php
	$active = true;
	foreach($slide_list as $index => $slide) {
?>
	<div class="carousel-item <?= ($active ? 'active' : ''); ?>" <?= ($active ? 'aria-current="true"' : ''); ?> aria-label="Media <?= $index+ 1; ?> style="width: auto; height: 525px;">	
		<?= $slide; ?>
	</div>	
<?php
		$active = false;
	}
?>
  </div>	
<?php
	if($representation_count > 1) { 
?>
  <div class="carousel-indicators collection-indicators">
<?php
	$active = true;
	foreach($slide_list as $index => $slide) {
?>
        <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="<?= $index; ?>" class="<?= ($active ? 'active' : ''); ?>" <?= ($active ? 'aria-current="true"' : ''); ?> aria-label="Media <?= $index+ 1; ?>"></button>
<?php
		$active = false;
	}
?>
              </div>
<?php
	}
?>
</div>
<?php
} else {
		// Use placeholder graphic when no representations are available
?>
		{{{placeholder}}}
<?php
}
