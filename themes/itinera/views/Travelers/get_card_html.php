<?php
	$pn_entity_id = $this->getVar('entity_id');
	$t_entity = $this->getVar('t_entity');
	
	$vs_image_tag = $t_entity->get('ca_entities.agentMedia', array('version' => 'preview'));
	
	print "<div class='travelerCardContent'>";
	print "<div style='margin:10px;' class='clearfix'><div class='travelerCardImage'>";
	print caNavLink($this->request, $vs_image_tag, '', '', 'Travelers', 'Index', array('id' => $pn_entity_id));
		
	if (!empty($vs_image_source = $t_entity->get('ca_entities.sourceUrlSet.sourceURL_URL'))) {
		print "<a href='{$vs_image_source}' class='travelerCardImageSource'>Source</a>";
	} else {
		print "<span>&nbsp;</span>";
	}
	print "</div>";
							
	print "<div class='travelerCardCaption'>";
	
	print "<p class='travelerCardArtistName'>".$t_entity->get('ca_entities.preferred_labels')."</p>";
	$va_entity_roles = $t_entity->get('ca_entities.agentLifeRoleSet.agentLifeRoleType', array('useSingular' => true, 'convertCodesToDisplayText' => true, 'returnAsArray' => 'true'));

	print "<p class='travelerCardArtistRoles'>".join(", " , $va_entity_roles)."</p>";

	if(is_array($va_dates_array = $t_entity->get('ca_entities.agentLifeDateSet', array('returnWithStructure' => true, 'returnAsArray' => true)))) {
		foreach (array_shift($va_dates_array) as $va_dates) {
			$va_date_set[] = $va_dates['agentLifeDisplayDate'];
		}
		print "<p>".join($va_date_set, ' - ')."</p>";
	}
	print "<p>".$t_entity->get('ca_entities.generalNotes')."</p>";
	
	print caGetThemeGraphic($this->request, 'seeicon.png', array('class' => 'frontButton'));
	print caNavLink($this->request, 'See Route', 'frontButton', '', 'Routes', 'Index', array('id' => $pn_entity_id));
	print "</div>";
?>