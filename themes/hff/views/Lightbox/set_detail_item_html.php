<?php
/** ---------------------------------------------------------------------
 * themes/default/Lightbox/set_detail_item_html.php :
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
 
    $vb_write_access = $this->getVar('write_access');
    $vs_view = $this->getVar('view');
    $vn_item_id = $this->getVar('item_id');
    $vn_set_id = $this->getVar('set_id');
    $vn_object_id = $this->getVar('object_id');

    $vs_caption = $this->getVar('caption');
    $vn_representation_id = $this->getVar('representation_id');
    $vs_representation = $this->getVar('representation');
    $vs_placeholder = $this->getVar('placeholder');
    
    $t_object = new ca_objects($vn_object_id);
    $vs_table = "ca_objects";
   	$vn_id = $t_object->get("ca_objects.object_id");
    $va_access_values = caGetUserAccessValues($this->request);
    
					$vs_typecode = "";
					$t_list_item = new ca_list_items($t_object->get("type_id"));
					$vs_typecode = $t_list_item->get("idno");
					
					$vs_idno_detail_link = "";
					$vs_label_detail_link = "";
					switch($vs_typecode){
						case "literature":
							$vs_tmp = $t_object->get("{$vs_table}.lit_citation");
							$vs_label_detail_link 	= caDetailLink($this->request, ($vs_tmp) ? $vs_tmp : "No citation available.  Title:".$t_object->get("{$vs_table}.preferred_labels"), '', $vs_table, $vn_id);
							
						break;
						# ------------------------
						case "archival":
							# --- no idno link
							$vs_label_detail_link 	= caDetailLink($this->request, $t_object->get("{$vs_table}.preferred_labels"), '', $vs_table, $vn_id).(($t_object->get("{$vs_table}.unitdate.dacs_date_text")) ? ", ".$t_object->get("{$vs_table}.unitdate.dacs_date_text") : "");
							$vs_tmp = $t_object->getWithTemplate("<unit relativeTo='ca_collections' delimiter=', '><l>^ca_collections.preferred_labels</l></unit>", array("checkAccess" => $va_access_values));				
							if($vs_tmp){
								$vs_label_detail_link .= "<br/>Part of: ".$vs_tmp;
							}
						break;
						# ------------------------
						case "artwork":
						case "art_HFF":
						case "art_nonHFF":
						case "edition":
						case "edition_HFF":
						case "edition_nonHFF":
							$vs_idno_detail_link 	= "<small>".caDetailLink($this->request, $t_object->get("{$vs_table}.idno"), '', $vs_table, $vn_id)."</small><br/>";
							$vs_label_detail_link 	= caDetailLink($this->request, italicizeTitle($t_object->get("{$vs_table}.preferred_labels")), '', $vs_table, $vn_id).(($t_object->get("{$vs_table}.common_date")) ? ", ".$t_object->get("{$vs_table}.common_date") : "");
						break;
						# ------------------------
						case "library":
							# --- no idno link
							# --- title, author, publisher, year, library, LC classification, Tags, Public Note
							$va_tmp = array();
							if($vs_tmp = $t_object->get("ca_objects.preferred_labels")){
								$va_tmp[] = $vs_tmp;
							}
							if($vs_tmp = $t_object->get("ca_objects.author.author_name", array("delimiter" => ", "))){
								$va_tmp[] = $vs_tmp;
							}
							if($vs_tmp = $t_object->getWithTemplate("<unit relativeTo='ca_entities' restrictToRelationshipTypes='publisher' delimiter=', '>^ca_entities.preferred_labels</unit>", array("checkAccess" => $va_access_values))){
								$va_tmp[] = $vs_tmp;
							}elseif($vs_tmp = $t_object->get("ca_objects.publisher", array("delimiter" => ", "))){
								$va_tmp[] = $vs_tmp;
							}
							if($vs_tmp = $t_object->get("ca_objects.common_date", array("delimiter" => ", "))){
								$va_tmp[] = $vs_tmp;
							}
							if($vs_tmp = $t_object->get("ca_objects.library", array("delimiter" => ", ", "convertCodesToDisplayText" => true))){
								$va_tmp[] = $vs_tmp;
							}
							if($vs_tmp = $t_object->get("ca_objects.call_number", array("delimiter" => ", "))){
								$va_tmp[] = $vs_tmp;
							}
							if($vs_tmp = $t_object->get("ca_objects.artwork_status", array("delimiter" => ", ", "convertCodesToDisplayText" => true))){
								$va_tmp[] = $vs_tmp;
							}
							if($vs_tmp = $t_object->get("ca_objects.remarks", array("delimiter" => ", "))){
								$va_tmp[] = $vs_tmp;
							}
							$vs_label_detail_link 	.= caDetailLink($this->request, join("<br/>", $va_tmp), '', $vs_table, $vn_id);
						
						break;
						# ------------------------
						default:
							$vs_idno_detail_link 	= "<small>".caDetailLink($this->request, $t_object->get("{$vs_table}.idno"), '', $vs_table, $vn_id)."</small><br/>";
							$vs_label_detail_link 	= caDetailLink($this->request, $t_object->get("{$vs_table}.preferred_labels"), '', $vs_table, $vn_id);
					
						break;
						# ------------------------
					}
					    
?>
<div class='lbItem'>
	<div class='lbItemContent'>
<?php
		if(!in_array($vs_typecode, array("library", "literature"))){
			print $this->getVar("representation");
		}
?>
		<div id='comment{{{item_id}}}' class='lbSetItemComment'><!-- load comments here --></div>
		<div class='caption'><?php print $vs_idno_detail_link.$vs_label_detail_link; ?></div>
	</div><!-- end lbItemContent -->
	<div class='lbExpandedInfo' id='lbExpandedInfo{{{item_id}}}'><hr/>
<?php
		if($vb_write_access) {
?>
		   <div class='pull-right'><a href='#' class='lbItemDeleteButton' id='lbItemDelete{{{item_id}}}' data-item_id='{{{item_id}}}' title='Remove'><span class='glyphicon glyphicon-trash'></span></a></div>
<?php
		}
?>
		<div>
			<?php print caDetailLink($this->request, "<span class='glyphicon glyphicon-file'></span>", '', 'ca_objects', $vn_object_id, "", array("title" => _t("View Item Detail"))); ?>
<?php
			if($vn_representation_id){
				print "&nbsp;&nbsp;<a href='#' title='"._t("Enlarge Image")."' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'objects', 'id' => $vn_object_id, 'representation_id' => $vn_representation_id, 'item_id' => $vn_item_id, 'overlay' => 1))."\"); return false;' ><span class='glyphicon glyphicon-zoom-in'></span></a>\n";
			}
?>
			&nbsp;&nbsp;<a href='#' title='Comments' onclick='jQuery(".lbSetItemComment").hide(); jQuery("#comment{{{item_id}}}").load("<?php print caNavUrl($this->request, '', '*', 'AjaxListComments', array()); ?>", {item_id: <?php print (int)$vn_item_id; ?>, type: "ca_set_items", set_id: <?php print (int)$vn_set_id; ?>}, function(){jQuery("#comment{{{item_id}}}").show();}); return false;'><span class='glyphicon glyphicon-comment'></span> <small id="lbSetCommentCount{{{item_id}}}">{{{commentCount}}}</small></a>
			</div>
	</div><!-- end lbExpandedInfo -->
</div><!-- end lbItem -->
