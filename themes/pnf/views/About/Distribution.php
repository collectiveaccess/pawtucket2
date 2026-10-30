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
?>
<div class="row">
	<div class="col-sm-12 col-md-offset-1 col-md-10">
		<div id="statistics">
			<H2><?php print ($g_ui_locale == "en_US") ? "Distribution of Sueltas Across ".$institutions_count." Institutions" : "Distribution of Sueltas Across ".$institutions_count." Institutions"; ?></H2>
			<div class="statisticsIntro">{{{statistics_intro}}}</div>
			<hr/>
			<div class="row">
				<div class="col-sm-3"><p><b>INSTITUTIONS</b></p></div>
				<div class="col-sm-2"><p>Running Tally<br/><?php print $q_institutions_public->numRows(); ?></p></div>
				<div class="col-sm-7"><p>{{{statistics_inst_public}}}</p></div>
			</div>
			<hr/>
			<div class="row">
				<div class="col-sm-3"><p><b>NUMBER OF SUELTAS</b></p></div>
				<div class="col-sm-2">
					<p>Running Tally<br/><?php print $q_sueltas_public->numRows(); ?> </p>
				</div>
				<div class="col-sm-7"><p>{{{statistics_number_sueltas}}}</p></div>
			</div>
			<hr/>
			<div class="row">
				<div class="col-sm-3"><p><b>AUTHORS</b><br/>including translators<br/>and adaptors</p></div>
				<div class="col-sm-2"><p>Running Tally<br/><?php print $qr_authors->numHits(); ?></p></div>
				<div class="col-sm-7"><p>{{{statistics_authors}}}</p></div>
			</div>
			<hr/>
			<div class="row">
				<div class="col-sm-3"><p><b>PRINTERS</b><br/>including publishers<br/>and booksellers</p></div>
				<div class="col-sm-2"><p>Running Tally<br/><?php print $qr_printers->numHits(); ?></p></div>
				<div class="col-sm-7"><p>{{{statistics_printers}}}</p></div>
			</div>
			<hr/>
			<div class="row">
				<div class="col-sm-3"><p><b>TITLES</b></p></div>
				<div class="col-sm-2"><p>Running Tally<br/><?php print sizeof($va_titles); ?></p></div>
				<div class="col-sm-7"><p>{{{statistics_titles}}}</p></div>
			</div>
			<hr/>
		</div>
	</div>
</div>