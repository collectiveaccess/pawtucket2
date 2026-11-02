<?php

require_once(__CA_APP_DIR__."/helpers/browseHelpers.php");
$va_public_access = array(1);
$va_restricted_access = array(2);

global $g_ui_locale;

$o_browse = caGetBrowseInstance("ca_objects");
$va_types = caMakeTypeIDList("ca_objects", array("book"), array('dontIncludeSubtypesInTypeRestriction' => true));
$o_browse->setTypeRestrictions($va_types, array('dontExpandHierarchically' => true));
$o_browse->execute(array('checkAccess' => $va_public_access));

$o_db = new Db();
$q_institutions_public = $o_db->query("SELECT distinct c.collection_id FROM ca_collections c where c.deleted = 0 AND c.access IN (".join(", ", $va_public_access).") AND c.parent_id IS NULL");
$institutions_count = $q_institutions_public->numRows();
$institution_ids = array();
while($q_institutions_public->nextRow()){
	$institution_ids[] = $q_institutions_public->get("ca_collections.collection_id");
}
$institions = caMakeSearchResult("ca_collections", $institution_ids, array("sort" => "ca_collections.preferred_labels"));
$sueltas_dist = array("1–10 sueltas" => array(), "11–100 sueltas" => array(), "101–999 sueltas" => array(), "1,000 or more sueltas" => array());
$c = $inst_link = "";
while($institions->nextHit()){
	$tmp = $institions->get("ca_objects.related.object_id", array("returnAsArray" => true, "checkAccess" => $va_public_access, "restrictToTypes" => array("book")));
	if(is_array($tmp)){
		$c = sizeof($tmp);
		$inst_link = $institions->getWithTemplate("<l>^ca_collections.preferred_labels</l>"." (".$c.")", array("checkAccess" => $va_public_access));
		switch($c){
			case ($c <= 10):
				$sueltas_dist["1–10 sueltas"][] = $inst_link;
			break;
			# ---------------------------------
			case (($c > 10) && ($c <= 100)):
				$sueltas_dist["11–100 sueltas"][] = $inst_link;
			break;
			# ---------------------------------
			case (($c > 100) && ($c <= 999)):
				$sueltas_dist["101–999 sueltas"][] = $inst_link;
			break;
			# ---------------------------------
			case ($c > 1000):
				$sueltas_dist["1,000 or more sueltas"][] = $inst_link;
			break;
			# ---------------------------------
		}
	}
}
?>
<div class="row">
	<div class="col-sm-12 col-md-offset-1 col-md-10">
		<div id="distribution">
			<H2><?php print ($g_ui_locale == "en_US") ? "Distribution of Sueltas Across ".$institutions_count." Institutions" : "Distribution of Sueltas Across ".$institutions_count." Institutions"; ?></H2>
<?php
			if($g_ui_locale == "en_US"){
?>
			<div class="distributionIntro">{{{distributionIntroEnglish}}}</div>
<?php
			}else{
?>
			<div class="distributionIntro">{{{distributionIntroSpanish}}}</div>
<?php
			}
?>
			<hr/>
			<div class="row">
				<div class="col-sm-8">
<?php
			print caGetThemeGraphic($this->request, 'InstitutionsPieChart.png');
?>
				<br/>
<?php
			print caGetThemeGraphic($this->request, 'InstitutionsBarChart.png');
?>
				</div>
				<div class="col-sm-4">
					<H2>Institutions holding:</H2>
<?php
				$i = 1;
				foreach($sueltas_dist as $cat => $inst_by_sueltas){
					print "<h3><a href='#' onClick='$(\"#cat".$i."\").toggle(); return false;'>".$cat." <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chevron-expand' viewBox='0 0 16 16'><path fill-rule='evenodd' d='M3.646 9.146a.5.5 0 0 1 .708 0L8 12.793l3.646-3.647a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 0-.708m0-2.292a.5.5 0 0 0 .708 0L8 3.207l3.646 3.647a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 0 0 0 .708'/></svg></a></h3>";
					print "<div id='cat".$i."' style='display:none;'>";
					foreach($inst_by_sueltas as $inst_link){
						print "<div style='margin-left:15px; margin-bottom:5px;'>".$inst_link."</div>";
					}
					#print "<a href='#' onClick='$(\"#cat".$i."\").toggle(); return false;'>Close</a>";
					print "</div>";
					$i++;
				}
?>				
				</div>
			</div>
				

		</div>
	</div>
</div>