<?php
	# --- meta tags
	MetaTagManager::addMeta("twitter:title", str_replace('"', '', $t_object->get("ca_objects.preferred_labels.name")));
	MetaTagManager::addMetaProperty("og:title", str_replace('"', '', $t_object->get("ca_objects.preferred_labels.name")));
	MetaTagManager::addMetaProperty("og:url", $this->request->config->get("site_host").caNavUrl("*", "*", "*"));
	if($t_representation){
		MetaTagManager::addMetaProperty("og:image", $t_representation->get("ca_object_representations.media.large.url"));
		MetaTagManager::addMetaProperty("og:image:secure_url", $t_representation->get("ca_object_representations.media.large.url"));
		MetaTagManager::addMeta("twitter:image", $t_representation->get("ca_object_representations.media.large.url"));
		$va_media_info = $t_representation->getMediaInfo('media', 'large');
		MetaTagManager::addMetaProperty("og:image:width", $va_media_info["WIDTH"]);
		MetaTagManager::addMetaProperty("og:image:height", $va_media_info["HEIGHT"]);
	}	
?>