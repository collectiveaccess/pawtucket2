<?php
	# ---------------------------------------
	/*
	 * Returns the info for each set
	 *
	 * options: "write_access" = false
	 *
	 */

function caLightboxSetListItemBAM($po_request, $t_set, $va_check_access = array(), $pa_options = array()) {
		if(!($vn_set_id = $t_set->get("set_id"))) {
			return false;
		}
		$vb_write_access = false;
		if($pa_options["write_access"]){
			$vb_write_access = true;
		}
		$va_set_items = caExtractValuesByUserLocale($t_set->getItems(array("user_id" => $po_request->user->get("user_id"), "thumbnailVersions" => array("iconlarge", "icon"), "checkAccess" => $va_check_access, "limit" => 5)));
		
		$vs_set_display = "<div class='lbSetContainer' id='lbSetContainer{$vn_set_id}'><div class='lbSet ".(($vb_write_access) ? "" : "readSet" )."'><div class='lbSetContent'>\n";
		if(!$vb_write_access){
			$vs_set_display .= "<div class='pull-right caption'>Read Only</div>";
		}
		$vs_set_display .= "<H5>".caNavLink($po_request, $t_set->getLabelForDisplay(), "", "", "Lightbox", "setDetail", array("set_id" => $vn_set_id), array('id' => "lbSetName{$vn_set_id}"))."</H5>";

        $va_lightboxDisplayName = caGetLightboxDisplayName();
		$vs_lightbox_displayname = $va_lightboxDisplayName["singular"];
		$vs_lightbox_displayname_plural = $va_lightboxDisplayName["plural"];

        if(sizeof($va_set_items)){
			$vs_primary_image_block = $vs_secondary_image_block = "";
			$vn_i = 1;
			$t_list_items = new ca_list_items();
			foreach($va_set_items as $va_set_item){
				$t_list_items->load($va_set_item["type_id"]);
				$vs_placeholder = caGetPlaceholder($t_list_items->get("idno"), "placeholder_media_icon");
				if($vn_i == 1){
					# --- is the iconlarge version available?
					$vs_large_icon = "icon";
					if($va_set_item["representation_url_iconlarge"]){
						$vs_large_icon = "iconlarge";
					}
					if($va_set_item["representation_tag_".$vs_large_icon]){
						$vs_primary_image_block .= "<div class='col-sm-6'><div class='lbSetImg'>".caNavLink($po_request, $va_set_item["representation_tag_".$vs_large_icon], "", "", "Lightbox", "setDetail", array("set_id" => $vn_set_id))."</div><!-- end lbSetImg --></div>\n";
					}else{
						$vs_primary_image_block .= "<div class='col-sm-6'><div class='lbSetImg'>".caNavLink($po_request, "<div class='lbSetImgPlaceholder'>".$vs_placeholder."</div><!-- end lbSetImgPlaceholder -->", "", "", "Lightbox", "setDetail", array("set_id" => $vn_set_id))."</div><!-- end lbSetImg --></div>\n";
					}
				}else{
					if($va_set_item["representation_tag_icon"]){
						$vs_secondary_image_block .= "<div class='col-xs-3 col-sm-6 lbSetThumbCols'><div class='lbSetThumb'>".caNavLink($po_request, $va_set_item["representation_tag_icon"], "", "", "Lightbox", "setDetail", array("set_id" => $vn_set_id))."</div><!-- end lbSetThumb --></div>\n";
					}else{
						$vs_secondary_image_block .= "<div class='col-xs-3 col-sm-6 lbSetThumbCols'>".caNavLink($po_request, "<div class='lbSetThumbPlaceholder'>".caGetThemeGraphic($po_request,'spacer.png').$vs_placeholder."</div><!-- end lbSetThumbPlaceholder -->", "", "", "Lightbox", "setDetail", array("set_id" => $vn_set_id))."</div>\n";
					}
				}
				$vn_i++;
			}
			while($vn_i < 6){
				$vs_secondary_image_block .= "<div class='col-xs-3 col-sm-6 lbSetThumbCols'>".caNavLink($po_request, "<div class='lbSetThumbPlaceholder'>".caGetThemeGraphic($po_request,'spacer.png')."</div><!-- end lbSetThumbPlaceholder -->", "", "", "Lightbox", "setDetail", array("set_id" => $vn_set_id))."</div>";
				$vn_i++;
			}
		}else{
			$vs_primary_image_block .= "<div class='col-sm-6'><div class='lbSetImg'><div class='lbSetImgPlaceholder'>"._t("this %1 contains no items", $vs_lightbox_displayname)."</div><!-- end lbSetImgPlaceholder --></div><!-- end lbSetImg --></div>\n";
			$i = 1;
			while($vn_i < 4){
				$vs_secondary_image_block .= "<div class='col-xs-3 col-sm-6 lbSetThumbCols'><div class='lbSetThumbPlaceholder'>".caGetThemeGraphic($po_request,'spacer.png')."</div><!-- end lbSetThumbPlaceholder --></div>";
				$vn_i++;
			}
		}
		$vs_set_display .= "<div class='row'>".$vs_primary_image_block."<div class='col-sm-6'><div id='comment{$vn_set_id}' class='lbSetComment'><!-- load comments here --></div>\n<div class='lbSetThumbRowContainer'><div class='row lbSetThumbRow' id='lbSetThumbRow{$vn_set_id}'>".$vs_secondary_image_block."</div><!-- end row --></div><!-- end lbSetThumbRowContainer --></div><!-- end col --></div><!-- end row -->";
		$vs_set_display .= "</div><!-- end lbSetContent -->\n";
		$vs_set_display .= "<div class='lbSetExpandedInfo' id='lbExpandedInfo{$vn_set_id}'>\n<hr><div>created by: ".trim($t_set->get("ca_users.fname")." ".$t_set->get("ca_users.lname"))."</div>\n";
		$vs_set_display .= "<div>"._t("Items: %1", $t_set->getItemCount(array("user_id" => $po_request->user->get("user_id"), "checkAccess" => $va_check_access)))."</div>\n";
		if($vb_write_access){
			$vs_set_display .= "<div class='pull-right'><a href='#' data-set_id=\"".(int)$t_set->get('set_id')."\" data-set_name=\"".addslashes($t_set->get('ca_sets.preferred_labels.name'))."\" data-toggle='modal' data-target='#confirm-delete'><span class='icon-trash2'></span></a></div>\n";
		}
		$vs_set_display .= "<div><a href='#' onclick='jQuery(\"#comment{$vn_set_id}\").load(\"".caNavUrl($po_request, '', 'Lightbox', 'AjaxListComments', array('type' => 'ca_sets', 'set_id' => $vn_set_id))."\", function(){jQuery(\"#lbSetThumbRow{$vn_set_id}\").hide(); jQuery(\"#comment{$vn_set_id}\").show();}); return false;' title='"._t("Comments")."'><span class='icon-bubble'></span> <small>".$t_set->getNumComments()."</small></a>";
		if($vb_write_access){
			$vs_set_display .= "&nbsp;&nbsp;&nbsp;<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($po_request, '', 'Lightbox', 'setForm', array("set_id" => $vn_set_id))."\"); return false;' title='"._t("Edit Name/Description")."'><span class='icon-pencil5'></span></a>";
		}
		$vs_set_display .= "</div>\n";
		$vs_set_display .= "</div><!-- end lbSetExpandedInfo --></div><!-- end lbSet --></div><!-- end lbSetContainer -->\n";

        return $vs_set_display;
	}
	
	?>