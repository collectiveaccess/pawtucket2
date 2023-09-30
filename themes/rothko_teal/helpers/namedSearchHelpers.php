<?php
	/**
	 *
	 *
	 */
	function caRothkoGetDateSearchDisplayText($ps_name, $pa_values, $pa_options=null) {
		if (preg_match("!([\d]{4})[ ]*[-–]{1}[ ]*([\d]{4})!", $pa_values[0], $va_matches)) {
			$vs_dates = $va_matches[1]."/".$va_matches[2];
		} else {
			$vs_dates = $pa_values[0];
		}
		return ucfirst(str_replace("_", " ", $ps_name)).": {$vs_dates}";
	}

	/**
	 *
	 *
	 */
	function caRothkoGetEntitySearchDisplayText($ps_name, $pa_values, $pa_options=null) {
		switch(strtolower($ps_name)) {
		    case 'editor':
				if ($t_entity = ca_entities::find(['entity_id' => (int)$pa_values[0]], ['returnAs' => 'firstModelInstance'])) {
					return "Editor: ".$t_entity->get('ca_entities.preferred_labels.displayname');
				}
				break;
			case 'author':
				if ($t_entity = ca_entities::find(['entity_id' => (int)$pa_values[0]], ['returnAs' => 'firstModelInstance'])) {
					return "Author: ".$t_entity->get('ca_entities.preferred_labels.displayname');
				}
				break;
			case 'publisher':
				if ($t_entity = ca_entities::find(['entity_id' => (int)$pa_values[0]], ['returnAs' => 'firstModelInstance'])) {
					return "Publisher: ".$t_entity->get('ca_entities.preferred_labels.displayname');
				}
				break;
			case 'institution':
				if ($t_entity = ca_entities::find(['entity_id' => (int)$pa_values[0]], ['returnAs' => 'firstModelInstance'])) {
					return "Institution: ".$t_entity->get('ca_entities.preferred_labels.displayname');
				}
				break;
			case 'exhibition':
				if ($t_entity = ca_entities::find(['entity_id' => (int)$pa_values[0]], ['returnAs' => 'firstModelInstance'])) {
					return "Exhibition venue: ".$t_entity->get('ca_entities.preferred_labels.displayname');
				}
				break;
		}
		return "???{$ps_name}";
	}