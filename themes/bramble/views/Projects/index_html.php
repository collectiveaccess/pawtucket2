<?php
	$o_projects_config = $this->getVar("projects_config");
	$qr_projects = $this->getVar("project_results");
?>
	<div class="projectList">
	<div class="row">
		<div class='col-sm-6'>
			<h1>My Projects</h1>
		</div>
		<div class='col-sm-6 text-right'>
<?php
			print "<a href='#' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Projects', 'projectForm', array())."\"); return false;' >"._t("New Project")."</a>";
?>
		</div>
	</div>
<?php	
	$vn_i = 0;
	if($qr_projects && $qr_projects->numHits()) {
		while($qr_projects->nextHit()) {
			print "<div class='row'>";
			print "<div class='col-sm-12'><div class='title'>".caDetailLink($this->request, $qr_projects->get("ca_occurrences.preferred_labels"), "", "ca_occurrences",  $qr_projects->get("ca_occurrences.occurrence_id"))."</div>";	
			if ($vs_tmp = $qr_projects->get("ca_occurrences.description")) {
				print "<div>".$vs_tmp."</div>";
			}
			print "<div class='pull-right'><a href='#' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Projects', 'projectForm', array('project_id' => $qr_projects->get("ca_occurrences.occurrence_id")))."\"); return false;' >"._t("Edit")."</a></div>";

			print "</div></div><!-- end row -->\n";
			print "<div class='row'><div class='col-sm-12'><hr/></div></div><!-- end row -->\n";
			
		}
	} else {
		print "<div class='row'><div class='col-sm-12'>"._t('No Projects available')."</div></div>";
	}
?>
