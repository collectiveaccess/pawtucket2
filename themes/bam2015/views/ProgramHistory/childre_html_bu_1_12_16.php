<?php
	$va_access_values = $this->getVar("access_values");
	$q_children = $this->getVar("series_children");
	if($q_children && $q_children->numHits()){
?>
	<div class="row">
		<div class='col-xs-4'><H1><?php print $this->getVar("parent_name"); ?> Series</H1>
			<div class="phChildrenList">
<?php
		$va_grandchildren = array();
		$va_children_titles = array();
		while($q_children->nextHit()){
			$va_children = $q_children->get("ca_occurrences.children.preferred_labels", array("returnWithStructure" => true, "sort" => "ca_occurrences.productionDate", "checkAccess" => $va_access_values));
			if(is_array($va_children) && sizeof($va_children)){
				print '<p><H3><a href="#" onClick="$(\'.grandchildren\').hide(); $(\'.grandchild'.$q_children->get("ca_occurrences.occurrence_id").'\').show();">'.$q_children->get("ca_occurrences.preferred_labels").'</a></H3>';
				print "<br/>";
			}
			$va_children_dates = $q_children->get("ca_occurrences.children.productionDate", array("returnWithStructure" => true, "sort" => "ca_occurrences.productionDate"));
			$va_children_dates_raw = $q_children->get("ca_occurrences.children.productionDate", array("returnWithStructure" => true, "rawDate" => true));
			foreach($va_children as $vn_child_id => $va_child){
				$va_child = array_pop($va_child);
				if(is_array($va_children_dates[$vn_child_id])){
					$va_date = array_pop($va_children_dates[$vn_child_id]);
				}
				if(is_array($va_children_dates_raw[$vn_child_id])){
					$va_date_raw = array_pop($va_children_dates_raw[$vn_child_id]);
				}
				$vs_link = caDetailLink($this->request, $va_child["name"].", ".$va_date["productionDate"], '', 'ca_occurrences', $vn_child_id);
				if($va_grandchildren[$q_children->get("ca_occurrences.occurrence_id")][$va_date_raw['productionDate'][0]]){
					$va_grandchildren[$q_children->get("ca_occurrences.occurrence_id")][$va_date_raw['productionDate'][0].$vn_child_id] = $vs_link;
				}else{
					$va_grandchildren[$q_children->get("ca_occurrences.occurrence_id")][$va_date_raw['productionDate'][0]] = $vs_link;
				}
			}
			$va_children_titles[$q_children->get("ca_occurrences.occurrence_id")] = $q_children->get("ca_occurrences.preferred_labels");
			print "</p>";
		}
?>
			</div>
		</div>
		<div class='col-xs-8'>
<?php

		foreach($va_grandchildren as $vn_parent_id => $va_links){
			ksort($va_links);
			print "\n<div class='grandchildren grandchild".$vn_parent_id."' style='display:none;'>";
			print '<H1>'.$va_children_titles["$vn_parent_id"].'</H1><div class="phGrandchildrenList">';
			foreach($va_links as $vs_link){
				print "<div class='bBAMResultListItem'><span class='pull-right icon-arrow-up-right'></span>".$vs_link."</div>";
			}
			print "</div></div>";
		}
?>		
		</div>
	</div><!-- end row -->
<?php
	}
	# --- are there productions?
	$q_productions = $this->getVar("production_children");
	if($q_productions && $q_productions->numHits()){
?>
	<div class="row">
		<div class='col-xs-12'><H1><?php print $this->getVar("parent_name"); ?></H1><div class="phGrandchildrenList">
<?php
			$va_productions = array();
			while($q_productions->nextHit()){
				$va_dates_raw = $q_productions->get("ca_occurrences.productionDate", array("returnWithStructure" => true, "rawDate" => true));
				if(is_array($va_dates_raw[$q_productions->get("ca_occurrences.occurrence_id")])){
					$va_date_raw = array_pop($va_dates_raw[$q_productions->get("ca_occurrences.occurrence_id")]);
				}
				if($va_productions[$va_date_raw['productionDate'][0]]){
					$va_productions[$va_date_raw['productionDate'][0].$q_productions->get("ca_occurrences.occurrence_id")] = "<div class='bBAMResultListItem'><span class='pull-right icon-arrow-up-right'></span>".caDetailLink($this->request, $q_productions->get("ca_occurrences.preferred_labels").", ".$q_productions->get("ca_occurrences.productionDate"), '', 'ca_occurrences', $q_productions->get("ca_occurrences.occurrence_id"))."</div>";
				}else{
					$va_productions[$va_date_raw['productionDate'][0]] = "<div class='bBAMResultListItem'><span class='pull-right icon-arrow-up-right'></span>".caDetailLink($this->request, $q_productions->get("ca_occurrences.preferred_labels").", ".$q_productions->get("ca_occurrences.productionDate"), '', 'ca_occurrences', $q_productions->get("ca_occurrences.occurrence_id"))."</div>";
				}
			}
			ksort($va_productions);
			print join("\n", $va_productions);
?>
		</div></div>
	</div>
<?php
	}
?>

