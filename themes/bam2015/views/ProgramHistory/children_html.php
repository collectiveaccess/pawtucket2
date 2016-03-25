<?php
	$va_access_values = $this->getVar("access_values");
	$q_children = $this->getVar("children");
	$vs_parent_type = $this->getVar("parent_type");
	$vs_description = $this->getVar("parent_description");
	#$vs_description = "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus porttitor lorem sed sapien vulputate luctus. Mauris sed bibendum tellus, et scelerisque tellus. Proin nec erat quis lacus pulvinar volutpat. Aliquam ut arcu id purus vestibulum facilisis. Suspendisse potenti.</p><p>Donec non aliquam arcu. Curabitur eu metus accumsan, congue metus a, laoreet orci. Vestibulum laoreet ante at ante gravida pellentesque. Nam eget lobortis metus. Curabitur ullamcorper velit nec lorem consectetur, vitae pulvinar eros hendrerit.</p>";
	if($q_children && $q_children->numHits()){
?>
	<div class="row">
<?php
		# --- is there description text for the series
		if(($vs_parent_type == "series") && $vs_description){
?>
			<div class='col-xs-12 col-sm-4 leftPadding'>
				<div class='leader'>
					About the Program
				</div>
				<div class="phSeriesDescription">
					<?php print $vs_description; ?>
				</div>
			</div>
			<div class='col-xs-12 col-sm-8 leftPadding'>
<?php
		}else{
?>
			<div class='col-xs-12 leftPadding'>
<?php
		}
?>		

				<div class='leader lastLeader'>
					Productions and Events (<?php print $q_children->numHits(); ?>)
				</div>
				<div class="phChildrenList">
<?php
				# --- are there productions?
				$q_productions = $this->getVar("children");
				if($q_productions && $q_productions->numHits()){

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

				}
?>				
				</div>
			</div><!-- end col -->
		</div><!-- end row -->
<?php
	}
?>