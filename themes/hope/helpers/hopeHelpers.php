<?php
	# -----
	# --- get name of parent sets
	# ---
	function caGetLightboxDisplayNameParent($o_lightbox_config = null){
		if(!$o_lightbox_config){ $o_lightbox_config = caGetLightboxConfig(); }
		$vs_lightbox_displayname = $o_lightbox_config->get("lightboxDisplayNameParent");
		if(!$vs_lightbox_displayname){
			$vs_lightbox_displayname = _t("Parent set");
		}
		$vs_lightbox_displayname_plural = $o_lightbox_config->get("lightboxDisplayNamePluralParent");
		if(!$vs_lightbox_displayname_plural){
			$vs_lightbox_displayname_plural = _t("parent sets");
		}
		$vs_lightbox_section_heading = $o_lightbox_config->get("lightboxSectionHeadingParent");
		if(!$vs_lightbox_section_heading){
			$vs_lightbox_section_heading = _t("Parent Setss");
		}
		return array("singular" => $vs_lightbox_displayname, "plural" => $vs_lightbox_displayname_plural, "section_heading" => $vs_lightbox_section_heading);
	}
?>
