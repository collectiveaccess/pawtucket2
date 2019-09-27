<?php
	function collectionIcon($po_request, $t_object, $vs_version = "collection_placeholders") {
			$o_icons_conf = caGetIconsConfig();
			$va_collection_specific_icons = $o_icons_conf->getAssoc($vs_version);
			$va_item_collection_idnos = explode(";", $t_object->get('ca_collections.hierarchy.idno', array("delimeter" => ';')));
			$vs_collection_idno = "";
			if(sizeof($va_item_collection_idnos)){
				foreach($va_item_collection_idnos as $vs_item_collection_idno){
					if(in_array($vs_item_collection_idno, array_keys($va_collection_specific_icons))){
						$vs_collection_idno = $vs_item_collection_idno;
					}
				}
		
				if($vs_collection_idno){
					if($vs_graphic = caGetOption($vs_collection_idno, $va_collection_specific_icons, null)){
						return caGetThemeGraphic($po_request, $vs_graphic);
					}
				}
			}else{
				return null;
			}

	}
?>
