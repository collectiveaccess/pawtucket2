<?php

require_once(__CA_APP_DIR__."/helpers/browseHelpers.php");
$va_public_access = array(1);
$va_restricted_access = array(2);

$o_browse = caGetBrowseInstance("ca_objects");
$va_types = caMakeTypeIDList("ca_objects", array("book"), array('dontIncludeSubtypesInTypeRestriction' => true));
$o_browse->setTypeRestrictions($va_types, array('dontExpandHierarchically' => true));
$o_browse->execute(array('checkAccess' => $va_public_access));

$va_titles = $o_browse->getFacet("label_facet", array('checkAccess' => $va_public_access, 'request' => $this->request));

$o_db = new Db();
$q_institutions_public = $o_db->query("SELECT distinct c.collection_id FROM ca_collections c where c.deleted = 0 AND c.access IN (".join(", ", $va_public_access).") AND c.parent_id IS NULL");
$q_institutions_protected = $o_db->query("SELECT distinct c.collection_id FROM ca_collections c where c.deleted = 0 AND  c.access IN (".join(", ", $va_restricted_access).") AND c.parent_id IS NULL");
$q_sueltas_public = $o_db->query("SELECT distinct o.object_id FROM ca_objects o where o.type_id IN (".join(",", $va_types).") AND o.deleted = 0 AND o.access IN (".join(", ", $va_public_access).")");

$va_playwrights = $o_browse->getFacet("playwrights_facet", array('checkAccess' => $va_public_access, 'request' => $this->request));
$va_printer_seller = $o_browse->getFacet("printer_seller_facet", array('checkAccess' => $va_public_access, 'request' => $this->request));

$o_browse_printers = caGetBrowseInstance("ca_entities");
$va_relationship_types = array("ca_objects" =>  array("bookseller", "printer", "printers", "publisher"));
foreach($va_relationship_types as $vs_x => $va_rel_types) {
	if (!is_array($va_rel_types)) { continue; }
	$o_browse_printers->addCriteria("_reltypes", "{$vs_x}:".join(",", $va_rel_types));
}
$o_browse_printers->execute(array('checkAccess' => $va_public_access));
$qr_printers = $o_browse_printers->getResults();

$o_browse_authors = caGetBrowseInstance("ca_entities");
$va_relationship_types = array("ca_objects" =>  array("attributedname", "author", "added_author", "contributor", "dubiousauthor", "translator"));
foreach($va_relationship_types as $vs_x => $va_rel_types) {
	if (!is_array($va_rel_types)) { continue; }
	$o_browse_authors->addCriteria("_reltypes", "{$vs_x}:".join(",", $va_rel_types));
}
$va_types = caMakeTypeIDList("ca_entities", array("ind"), array('dontIncludeSubtypesInTypeRestriction' => true));
$o_browse_authors->setTypeRestrictions($va_types, array('dontExpandHierarchically' => true));

$o_browse_authors->execute(array('checkAccess' => $va_public_access));
$qr_authors = $o_browse_authors->getResults();


?>
<div class="row">
	<div class="col-sm-12 col-md-offset-1 col-md-10">
		<div id="statistics">
			<H2><?php print ($g_ui_locale == "en_US") ? "Statistical Table" : "Tabla de Estadísticas"; ?></H2>
			<div class="statisticsIntro">{{{statistics_intro}}}</div>
			<hr/>
			<div class="row">
				<div class="col-sm-3"><p><b>INSTITUTIONS</b><br/>in public view</p></div>
				<div class="col-sm-2"><p>Running Tally<br/><?php print $q_institutions_public->numRows(); ?></p></div>
				<div class="col-sm-7"><p>{{{statistics_inst_public}}}</p></div>
			</div>
			<hr/>
			<div class="row">
				<div class="col-sm-3"><p><b>INSTITUTIONS</b><br/>in protected view</p></div>
				<div class="col-sm-2"><p>Running Tally<br/><?php print $q_institutions_protected->numRows(); ?></p></p></div>
				<div class="col-sm-7"><p>{{{statistics_inst_protected}}}</p></div>
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
