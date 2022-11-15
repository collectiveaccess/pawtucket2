<?php
function caGetExhibitionBrowsePreviews($pm_table, $pa_ids, $pa_options=null) {
	$t = Datamodel::getInstance($pm_table);
	$rel_items = $t->getRelatedItems('ca_objects', ['row_ids' => $pa_ids]);
	
	$config = Configuration::load();
	$base_url = $config->get('ca_url_root');
	
	$return = caGetOption('return', $pa_options, 'tags');
	$version = caGetOption('version', $pa_options, 'icon');
	$versions = caGetOption("versions", $pa_options, null);
	$versions_set = (is_array($versions) && sizeof($versions));
	
	if(!is_array($versions) && $version) { $versions = [$version]; }
	if(!is_array($versions) || !sizeof($versions)) { $versions = [$version]; }
	$version = $versions[0];
	
	
	$objects_for_id = [];
	foreach($rel_items as $k => $info) {
		$objects_for_id[$info['row_id']][] = $info['object_id'];
	}
	
	$selected_media = [];
	foreach($objects_for_id as $id => $object_ids) {
		$o = caMakeSearchResult('ca_objects', $object_ids);
		
		$poster = $announcement = $first = null;
		while($o->nextHit()) {
			if(!$o->get('ca_object_representations.representation_id')) { continue; }
			if($o->get('ca_objects.access') != 1) { continue; }
			$series = array_map('strtolower', $o->get('ca_objects.series', ['returnAsArray' => true, 'convertCodesToIdno' => true]) ?? []);
			if(!$first) { $first = $o->getPrimaryKey(); }
			if(in_array('posters', $series)) {
				$poster = $o->getPrimaryKey();
				break;
			}
			if(in_array('announcements', $series)) {
				$announcement = $o->getPrimaryKey();
			}
		}
		
		if ($poster) {
			$selected_media[$id] = $poster;
		} elseif($announcement) {
			$selected_media[$id] = $announcement;
		} else {
			$selected_media[$id] = $first;
		}
		
	}
	
	$o = caMakeSearchResult('ca_objects', array_values($selected_media));
	while($o->nextHit()) {
		switch($return) {
			case 'data':
				$t->load($o->get($t->primaryKey(true)));
				$alt_text = $alt_text_template ? $t->getWithTemplate($alt_text_template) : $t->get("{$vs_table}.preferred_labels");
			
				$id = $t->getPrimaryKey();
				if($versions_set) {
					foreach($versions as $v) {
						$version_info = $o->getMediaInfo("ca_object_representations.media", $v);
						$va_res[$id][$v]['tag'] = $o->getMediaTag("ca_object_representations.media", $v);
						$va_res[$id][$v]['url'] = $o->getMediaUrl("ca_object_representations.media", $v);
						$va_res[$id][$v]['path'] = $o->getMediaPath("ca_object_representations.media", $v);
						$va_res[$id][$v]['width'] = $version_info['WIDTH'];
						$va_res[$id][$v]['height'] = $version_info['HEIGHT'];
						$va_res[$id][$v]['mimetype'] = $version_info['MIMETYPE'];
					}
				
					$va_res[$id]['iiif']['url'] = "{$base_url}/service.php/IIIF/".$o->get('ca_object_representations.representation_id')."/info.json";
				} else {
					$va_res[$id] = $o->getMediaTag("media", $version, ['alt' => $alt_text]);
				}
				break;
			case 'urls':
				if($versions_set) {
					foreach($versions as $v) {
						$va_res[$id][$v] = $o->getMediaUrl("ca_object_representations.media", $v);
					}
				} else {
					$va_res[$id] = $o->getMediaUrl("ca_object_representations.media", $version);
				}
				break;
			case 'paths':
				if($versions_set) {
					foreach($versions as $v) {
						$va_res[$id][$v] = $o->getMgetMediaPathediaUrl("ca_object_representations.media", $v);
					}
				} else {
					$va_res[$id] = $o->getMediaPath("ca_object_representations.media", $version);
				}
				break;
			case 'tags':
			default:
				$t->load($o->get($t->primaryKey(true)));
				$alt_text = $alt_text_template ? $t->getWithTemplate($alt_text_template) : $t->get("{$vs_table}.preferred_labels");
			
				if($versions_set) {
					foreach($versions as $v) {
						$va_res[$id][$v] = $o->getMediaTag("ca_object_representations.media", $v);
					}
				} else {
					$va_res[$id] = $o->getMediaTag("ca_object_representations.media", $version, ['alt' => $alt_text]);
				}
				break;
		}
	}
	return $va_res;
}