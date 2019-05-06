<?php
	# -----
	# --- get name of project sets
	# ---
	function caGetLightboxDisplayNameProject($o_lightbox_config = null){
		if(!$o_lightbox_config){ $o_lightbox_config = caGetLightboxConfig(); }
		$vs_lightbox_displayname = $o_lightbox_config->get("lightboxDisplayNameProject");
		if(!$vs_lightbox_displayname){
			$vs_lightbox_displayname = _t("project");
		}
		$vs_lightbox_displayname_plural = $o_lightbox_config->get("lightboxDisplayNamePluralProject");
		if(!$vs_lightbox_displayname_plural){
			$vs_lightbox_displayname_plural = _t("projects");
		}
		$vs_lightbox_section_heading = $o_lightbox_config->get("lightboxSectionHeadingProject");
		if(!$vs_lightbox_section_heading){
			$vs_lightbox_section_heading = _t("Projects");
		}
		return array("singular" => $vs_lightbox_displayname, "plural" => $vs_lightbox_displayname_plural, "section_heading" => $vs_lightbox_section_heading);
	}
	# ------
?>