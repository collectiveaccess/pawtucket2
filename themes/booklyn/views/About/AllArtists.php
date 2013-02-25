<?php
	include_once(__CA_LIB_DIR__."/core/Db.php");
	include_once(__CA_LIB_DIR__."/ca/Search/EntitySearch.php");
	include_once(__CA_MODELS_DIR__."/ca_lists.php");
	include_once(__CA_MODELS_DIR__."/ca_entities.php");

	$t_list = new ca_lists();
	$vn_entity_type_id = $t_list->getItemIDFromList("entity_types", "ind");
	$vn_org_type_id = $t_list->getItemIDFromList("entity_types", "org");

	$o_artist_search = new EntitySearch();
	$qr_artists = $o_artist_search->search("ca_entities.artist_status:Top OR ca_entities.artist_status:Current Associated OR ca_entities.artist_status:Associated", array('sort' => 'ca_entities.preferred_labels.surname', 'sort_direction' => 'asc'));
	
	$o_org_search = new EntitySearch();
	$qr_orgs = $o_org_search->search("ca_entities.artist_status:Top OR ca_entities.artist_status:Current Associated OR ca_entities.artist_status:Associated", array('sort' => 'ca_entities.preferred_labels.surname', 'sort_direction' => 'asc'));
?>
<div class="artistDiv">
	<h1 class="results">Artists</h1>
<?php	
	if ($qr_artists->numHits()) {
		while($qr_artists->nextHit()) {
			if (($qr_artists->get('ca_entities.type_id') == 78)&&($qr_artists->get('ca_entities.artist_status'))&&($qr_artists->get('ca_entities.artist_status') != 247)) {
				$vn_entity_id = $qr_artists->get('ca_entities.entity_id');
				print "<div class='artistList'>".caNavLink($this->request, $qr_artists->get('ca_entities.preferred_labels'), '', 'Detail','Entity', 'Show', array('entity_id' => $vn_entity_id))."</div>";
			}
		}
	}
?>
</div>
<div class="artistDiv">
	<h1 class="results">Organizations</h1>
<?php	
	if ($qr_orgs->numHits()) {
		while($qr_orgs->nextHit()) {
			if (($qr_orgs->get('ca_entities.type_id') == 79)&&($qr_orgs->get('ca_entities.artist_status') != 247)) {
				$vn_org_id = $qr_orgs->get('ca_entities.entity_id');
				print "<div class='artistList'>".caNavLink($this->request, $qr_orgs->get('ca_entities.preferred_labels'), '', 'Detail','Entity', 'Show', array('entity_id' => $vn_org_id))."</div>";
			}
		}
	}
?>	
</div>
<div class='seeMore'>
<?php
	print caNavLink($this->request, '+ RETURN TO CURRENT ARTISTS AND ORGANIZATIONS', '','','About','Artists');
?>
</div>
<div style="height:35px; width:100%; clear:both"></div>