<div class="textContent">
	<div>
		<b>How to Browse the Van Alen Institute Design Archive:</b>
	</div>
	<div>
		With more than 3000 digital objects, The Design Archive web site encourages exploration with a number of browse options:
	</div>
	<div>
		1. To search the Design Archive, simply enter a keyword in the search box on the upper-right-hand corner of the window. The more specific the search, the more relevant your results will be. You may enter text, dates, or a combination of terms.
	</div>
	<div>
		2. Pull-down menus across the top of the window organize search results by pre-defined criteria.
	</div>
	<div>
		At any time in your search, you may navigate to related content by clicking on linked criteria in the "Browsing By" search path below the pull-down menus, or by clicking on linked subject terms within an object page.
	</div>
	
<?php
if($show_competition_list){
	require_once(__CA_LIB_DIR__."/ca/Search/OccurrenceSearch.php");
	# --- get all competitions
	$t_list = new ca_lists();
	$vn_competition_type_id = $t_list->getItemIDFromList('occurrence_types', 'competitions');
	
	$o_search = new OccurrenceSearch();
	$qr_competitions = $o_search->search("ca_occurrences.access:1 AND ca_occurrences.type_id:".$vn_competition_type_id, array("sort" => "ca_occurrences.competition_date", "checkAccess" => array(1)));
	if($qr_competitions->numHits() > 0){
		print "<b>Competitions (organized chronologically):</b><br/>";
		print "<div style='height:250px; overflow:auto;'>";
		while($qr_competitions->nextHit()){
			print join(', ', $qr_competitions->getDisplayLabels($this->request));
			if($qr_competitions->get("ca_occurrences.competition_date")){
				print " (".$qr_competitions->get("ca_occurrences.competition_date").")";
			}
			print "<br/>";
		}
		print "</div>";
	}
}
?>
</div>