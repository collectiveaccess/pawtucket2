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
$q_institutions_public = $o_db->query("SELECT distinct c.collection_id FROM ca_collections c where c.access IN (".join(", ", $va_public_access).") AND c.parent_id IS NULL");
$q_institutions_protected = $o_db->query("SELECT distinct c.collection_id FROM ca_collections c where c.access IN (".join(", ", $va_restricted_access).") AND c.parent_id IS NULL");

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
<div id="statistics">
	<H2>Statistical Table</H2>
	<div class="statisticsIntro">The statistical information in this table is generated automatically by the CollectiveAccess database.  At the completion of the survey, we expect to see large data sets that may be analyzed computationally to reveal patterns, trends, and associations, and that we hope will lead to research, especially in Spanish 18th-century printing industry, in ways that were not possible previously.</div>
	<div class="row">
		<div class="col-sm-12 col-md-offset-1 col-md-10">
			<hr/>
			<div class="row">
				<div class="col-sm-3"><p><b>INSTITUTIONS</b><br/>in public view</p></div>
				<div class="col-sm-3"><p>Running Tally<br/><?php print $q_institutions_public->numRows(); ?></p></div>
				<div class="col-sm-6"><p>INSTITUTIONS list those libraries in public view that we have identified as having collections of sueltas. These appear in alphabetical order under INSTITUTION on the Navigation bar, also in Browse.</p></div>
			</div>
			<hr/>
			<div class="row">
				<div class="col-sm-3"><p><b>INSTITUTIONS</b><br/>in protected view</p></div>
				<div class="col-sm-3"><p>Running Tally<br/><?php print $q_institutions_protected->numRows(); ?></p></p></div>
				<div class="col-sm-6"><p>UNDER CONSTRUCTION / EN OBRAS: These are libraries in our pipeline in varying stages of completion. Some lack sufficient information or need images before they are ready to be uploaded.</p></div>
			</div>
			<hr/>
			<div class="row">
				<div class="col-sm-3"><p><b>NUMBER OF SUELTAS</b><br/>in each institution</p></div>
				<div class="col-sm-3">
					<p>Running Tally</p>
<?php
					if($q_institutions_public->numRows()){
						$va_institution_ids = array();
						while($q_institutions_public->nextRow()){
							$va_institution_ids[] = $q_institutions_public->get("ca_collections.collection_id");
						}
						$q_institutions = caMakeSearchResult("ca_collections", $va_institution_ids);
						if($q_institutions->numHits()){
							while($q_institutions->nextHit()){
								$vn_child_count = $vn_num_objects = 0;
								$va_children = $q_institutions->get("ca_collections.children.collection_id", array("returnAsArray" => true, "checkAccess" => $va_public_access));
								if(is_array($va_children) && sizeof($va_children)){
									$q_child_institutions = caMakeSearchResult("ca_collections", $va_children);
									while($q_child_institutions->nextHit()){
										$va_child_objects = $q_child_institutions->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $va_public_access));
										if(is_array($va_child_objects) && sizeof($va_child_objects)){
											$vn_child_count = $vn_child_count + sizeof($va_child_objects);
										}
									}
								}
								$va_objects = $q_institutions->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $va_public_access));
								$vn_num_objects = $vn_child_count;
								if(is_array($va_objects)){
									$vn_num_objects += sizeof($va_objects);
								}
								print $q_institutions->get("ca_collections.preferred_labels").": <b>".$vn_num_objects."</b><br/><br/>";
							}
						}
					}
					if(is_array($va_institutions) && sizeof($va_institutions)){
						foreach($va_institutions as $va_institutions){
							print "<b>".$va_institutions["label"].":</b> ".$va_institutions["content_count"]."<br/><br/>";
						}
					}
?>
				</div>
				<div class="col-sm-6"><p>The number of sueltas held by a library appears as soon as an Institution is selected. Numbers may diminish if we discover a post-1833 imprint or some other reason for eliminating an item.</p></div>
			</div>
			<hr/>
			<div class="row">
				<div class="col-sm-3"><p><b>AUTHORS</b><br/>including translators and adaptors</p></div>
				<div class="col-sm-3"><p>Running Tally<br/><?php print $qr_authors->numHits(); ?></p></div>
				<div class="col-sm-6"><p>Each name in the Author’s Authority File is listed with a single main entry. These main entries are based on the Library of Congress Name Authority File (NACO), Biblioteca Nacional de España Autoridades, and other national standards. They are listed as they appear in the Virtual Internet Authority File (VIAF.) Variant forms of the name will be listed under the main entry, separated by a semi-colon. The distinction between author and translator, or author and adaptor, can be fuzzy. This list also includes a few dozen French, Italian, English, and German writers whose works appear in translation.</p></div>
			</div>
			<hr/>
			<div class="row">
				<div class="col-sm-3"><p><b>PRINTERS</b><br/>including publishers and booksellers</p></div>
				<div class="col-sm-3"><p>Running Tally<br/><?php print $qr_printers->numHits(); ?></p></div>
				<div class="col-sm-6"><p>Each name in the Printers’ Authority File is listed with a single main entry. These main entries are based on the Library of Congress Name Authority File (NACO), Biblioteca Nacional de España Autoridades, and other national standards. They are listed as they appear in the Virtual Internet Authority File (VIAF.) Variant forms of the name will be listed under the main entry, separated by a semi-colon. In the period covered in this database, the role of printers, publishers, and booksellers often overlapped, and was not well defined.</p></div>
			</div>
			<hr/>
			<div class="row">
				<div class="col-sm-3"><p><b>TITLES</b></p></div>
				<div class="col-sm-3"><p>Running Tally<br/><?php print sizeof($va_titles); ?></p></div>
				<div class="col-sm-6"><p>Titles can be tracked in TITLES MODERNIZED under the RESOURCES menu. These are not firm numbers because titles are not unique.  The same title had been used by two or more authors, for example, both Pérez de Montalbán and Calderón wrote plays entitled Los Hijos de la fortuna. The titles La cruz en la sepultura and La devoción de la cruz refer to the same play by Calderón. Or the simple alteration of Calderón’s Nunca lo peor es cierto for a less categorical No siempre lo peor es cierto. Some of these plays rely on comparison of first and last lines to ascertain proper identification. Over the time sueltas were printed, titles were also modified, truncated, misprinted, corrupted, or simply changed in any number of ways. </p></div>
			</div>
			<hr/>
		</div>
	</div>
</div>
