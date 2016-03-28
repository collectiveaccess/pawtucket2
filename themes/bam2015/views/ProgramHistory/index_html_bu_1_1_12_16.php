<?php
	$va_access_values = $this->getVar("access_values");
	$q_years = $this->getVar("years");
?>
<div class="row">
	<div class='col-xs-12'>
		<div class="detailHead"><H2>Programming History</H2></div>
	</div>
	<hr class='divide' style='margin-bottom:0px;'/>
</div>
<div class="row">
	<div class='col-xs-3'><br/><H1>Season</H1>
		<div class="phSeasonsList">
<?php	
	if($q_years && $q_years->numHits()){
		while($q_years->nextHit()){
			print "<p><H3 style='margin-bottom:5px; padding-bottom:0px;'>".$q_years->get("ca_occurrences.preferred_labels")."</H3>";
			$va_children = $q_years->get("ca_occurrences.children.preferred_labels", array("returnWithStructure" => true));
			foreach($va_children as $vn_child_id => $va_child){
				$va_child = array_pop($va_child);
				print '<a href="#" onClick="$(\'.children\').load(\''.caNavUrl($this->request, "", "ProgramHistory", "child", array("id" => $vn_child_id)).'\')">'.$va_child["name"].'</a>&nbsp;&nbsp;&nbsp;';
			}
			print "<br/><br/></p>";
		}
	}
?>
		</div>
	</div>
	<div class='col-xs-9 children'>
		<i class='fa fa-arrow-left'></i> Choose a season to start navigating BAM Programing History
	</div>
</div><!-- end row -->