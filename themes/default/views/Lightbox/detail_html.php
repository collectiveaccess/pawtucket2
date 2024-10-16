<?php
/** ---------------------------------------------------------------------
 * themes/default/Lightbox/detail_html.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2024 Whirl-i-Gig
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
 
$t_set = $this->getVar('t_set');
$qr_items = $this->getVar('items');
$table = $this->getVar('table');
$t_list_item = new ca_list_items();

$va_access_values 	= $this->getVar('access_values');
$vs_result_caption_template = "^ca_objects.preferred_labels (^ca_objects.idno)";

if($vs_image_format == "contain"){
	$vs_image_class = "object-fit-contain py-3 ps-3 rounded-0";
}else{
	$vs_image_class = "card-img-top object-fit-cover rounded-0";
}
?>
<h1><?= $t_set->get('ca_sets.preferred_labels.name'); ?></h1>

<?php
while($qr_items->nexthit()) {
	$vs_detail_button_link = caDetailLink($this->request, "<i class='bi bi-arrow-right-square'></i>", 'link-dark mx-1', $table, $id, null, array("title" => _t("View Record"), "aria-label" => _t("View Record")));
	$id = $qr_items->get('object_id');
	$vs_caption 	= $qr_items->getWithTemplate($vs_result_caption_template, array("checkAccess" => $va_access_values));
	$image = ($table === 'ca_objects') ? $qr_items->get('ca_object_representations.media.medium', array("checkAccess" => $va_access_values, "class" => $vs_image_class)) : $va_images[$vn_id];
		
	if(!$image){
		if ($table == 'ca_objects') {
			$t_list_item->load($qr_items->get("type_id"));
			$vs_typecode = $t_list_item->get("idno");
			if($vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon")){
				$image = "<div class='bResultItemImgPlaceholder'>".$vs_type_placeholder."</div>";
			}else{
				$image = $vs_default_placeholder_tag;
			}
		}else{
			$image = $vs_default_placeholder_tag;
		}
	}
	$vs_rep_detail_link 	= caDetailLink($this->request, $image, '', $table, $id);	
		
?>
		<div class='col-md-12'>
			<div id='row{$id}' class='card width-100 rounded-0 shadow border-0 mb-4'>
				<div class='row g-0'>
					<div class='col-sm-3'>
						<?= $vs_rep_detail_link; ?>
					</div>
					<div class='col-sm-9'>
						<div class='card-body'>
							<?= $vs_caption; ?>
						</div>
					</div>
				</div>
				<div class='row g-0'>
					<div class='col-sm-12'>
						<div class='card-footer text-end bg-transparent'>
							<?= $vs_detail_button_link; ?><?=$vs_add_to_set_link; ?>
						</div>
					</div>
				</div>
			 </div>	
		</div><!-- end col -->
<?php
}
