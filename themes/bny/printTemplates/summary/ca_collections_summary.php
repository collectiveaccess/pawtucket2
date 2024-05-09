<?php
/* ----------------------------------------------------------------------
 * app/templates/summary/ca_collections_summary.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * -=-=-=-=-=- CUT HERE -=-=-=-=-=-
 * Template configuration:
 *
 * @name Collection Finding Aid
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_collections
 * @marginTop 0.75in
 * @marginLeft 0.5in
 * @marginRight 0.5in
 * @marginBottom 0.75in
 *
 * ----------------------------------------------------------------------
 */
 
 	$t_item = $this->getVar('t_subject');
	$t_display = $this->getVar('t_display');
	$va_placements = $this->getVar("placements");

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");	

?>
	<!---Title page -->
	
	<div style="text-align:center; margin-bottom:20px;"><img src='<?php print $this->request->getThemeDirectoryPath(); ?>/printTemplates/summary/BNY-logo.png' width='200px'></div>
	<h1>Brooklyn Navy Yard Development Corporation Archives<br/>
	Guide to the <?php print $t_item->getLabelForDisplay();?>
	{{{<ifdef code="^ca_collections.unitdate.dacs_date_value"><br/>^ca_collections.unitdate.dacs_date_value%delimiter=,_</ifdef>}}}
	{{{<ifdef code="^ca_collections.idno"><br/>^ca_collections.idno</ifdef>}}}
	</h1>
	<div class="border"></div>
	{{{<ifdef code="ca_collections.repository.repositoryName|ca_collections.repository.repositoryLocation">
		<div class="unit">^ca_collections.repository.repositoryName<ifdef code="ca_collections.repository.repositoryLocation"><br/>^ca_collections.repository.repositoryLocation</ifdef></div>
	</ifdef>}}}
	<div class="unit">
		Finding aid produced on: <?php print date("F j, Y"); ?>
		<br/>Description is in English.
	</div>
	<div class="border"></div>
	{{{
		<dl>
			
			<ifdef code="ca_collections.preferred_labels">
				<dt><?= _t('Title'); ?></dt>
				<dd>
					^ca_collections.preferred_labels
				</dd>
			</ifdef>
		</dl>
			<ifdef code="ca_collections.parent_id">
				<div class="unit"><H6>Part of</H6>
					<unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; ">^ca_collections.preferred_labels.name</unit>
					<ifdef code="ca_collections.label">^ca_collections.label</ifdev>
				</div>
			</ifdef>
		<dl>
			<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="creator">
				<dt>Creator</dt>
				<dd><unit relativeTo="ca_entities" restrictToRelationshipTypes="creator" delimiter=", ">
					^ca_entities.preferred_labels.displayname
				</unit></dd>
			</ifcount>
				<ifdef code="ca_collections.unitdate">
					<unit relativeto="ca_collections.unitdate" delimiter="">
						<dt>^ca_collections.unitdate.dacs_dates_types</dt>
						<dd>
							^ca_collections.unitdate.dacs_date_value
						</dd>
					</unit>
				</ifdef>
				<ifdef code="ca_collections.extentDACS">
					<dt><?= _t('Quantity'); ?></dt>
					<dd>
						^ca_collections.extentDACS
					</dd>
				</ifdef>
				<ifdef code="ca_collections.langmaterial">
					<dt><?= _t('Language of Materials'); ?></dt>
					<dd>
						^ca_collections.langmaterial
					</dd>
				</ifdef>
				<ifdef code="ca_collections.idno">
					<dt><?= _t('Call Number'); ?></dt>
					<dd>
						^ca_collections.idno
					</dd>
				</ifdef>
				<ifdef code="ca_collections.adminbiohist">
					<dt><?= _t('Administrative/Biographical History'); ?></dt>
					<dd>
						^ca_collections.adminbiohist
					</dd>
				</ifdef>
				<ifdef code="ca_collections.scopecontent">
					<dt><?= _t('Scope and Content'); ?></dt>
					<dd>
						^ca_collections.scopecontent
					</dd>
				</ifdef>
				
				<ifdef code="ca_collections.originalsloc|ca_collections.altformavail|ca_collections.relation|ca_collections.publication_note">
					<dt><?= _t('Related Materials'); ?></dt>
					<ifdef code="ca_collections.originalsloc"><dd><b>Existence and Location of Originals: </b>
						^ca_collections.originalsloc
					</dd></ifdef>
					<ifdef code="ca_collections.altformavail"><dd><b>Existence and Location of Copies: </b>
						^ca_collections.altformavail
					</dd></ifdef>
					<ifdef code="ca_collections.relation"><dd><b>Related Archival Materials: </b>
						^ca_collections.relation
					</dd></ifdef>
					<ifdef code="ca_collections.publication_note"><dd><b>Publication Note: </b>
						^ca_collections.publication_note
					</dd></ifdef>
				</ifdef>				
				<ifdef code="ca_collections.arrangement">
					<dt><?= _t('System of Arrangement'); ?></dt>
					<dd>
						^ca_collections.arrangement
					</dd>
				</ifdef>

				<ifcount code="ca_list_items" min="1">
					<dl class="mb-0">
						<dt>Access Points</dt>
						<dd><unit relativeTo="ca_list_items" delimiter=", ">
							^ca_list_items.preferred_labels
						</unit></dd>
					</dl>
				</ifcount>
				<ifdef code="ca_collections.processInfo|ca_collections.acqinfo|ca_object_lots.idno_stub">
					<dt><?= _t('Administrative Information'); ?></dt>
					<ifdef code="ca_object_lots.idno_stub"><dd><b>Related Lots: </b>
						^ca_object_lots.idno_stub%delimiter=,_
					</dd></ifdef>
					<ifdef code="ca_collections.acqinfo"><dd><b>Acquisition Notes: </b>
						^ca_collections.acqinfo
					</dd></ifdef>
					<ifdef code="ca_collections.processInfo"><dd><b>Processing Notes: </b>
						^ca_collections.processInfo
					</dd></ifdef>
				</ifdef>
				
				
				
				
				<ifdef code="ca_collections.processInfo|ca_collections.acqinfo|ca_object_lots.idno_stub">
					<dt><?= _t('Access and Use'); ?></dt>	
				
					<ifdef code="ca_collections.accessrestrict">
						<dd><b><?= _t('Conditions Governing Access'); ?></b>
							^ca_collections.accessrestrict
						</dd>
					</ifdef>
					<ifdef code="ca_collections.physaccessrestrict">
						<dd><b><?= _t('Physical Access'); ?></b>
							^ca_collections.physaccessrestrict
						</dd>
					</ifdef>
					<ifdef code="ca_collections.techaccessrestrict">
						<dd><b><?= _t('Technical Access'); ?></b>
							^ca_collections.techaccessrestrict
						</dd>
					</ifdef>
					<ifdef code="ca_collections.reproduction">
						<dd><b><?= _t('Conditions Governing Reproduction'); ?></b>
							^ca_collections.reproduction
						</dd>
					</ifdef>
					<ifdef code="ca_collections.otherfindingaid">
						<dd><b><?= _t('Other Finding Aids'); ?></b>
							^ca_collections.otherfindingaid
						</dd>
					</ifdef>
					<ifdef code="ca_collections.preferCite">
						<dd><b><?= _t('Preferred Citation'); ?></b>
							^ca_collections.preferCite
						</dd>
					</ifdef>
				</ifdef>
				<ifcount code="ca_collections.related" min="1">
					<dt><ifcount code="ca_collections.related" min="1" max="1"><?= _t('Related Collections'); ?></ifcount><ifcount code="ca_collections.related" min="2"><?= _t('Related Collections'); ?></ifcount></dt>
					<unit relativeTo="ca_collections.related" delimiter=""><dd><unit relativeTo="ca_collections.hierarchy" delimiter=" ➔ ">^ca_collections.preferred_labels.name</unit></dd></unit>
				</ifcount>
				<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="related">
					<dt>Related People and Organizations:</dt>
					<dd><unit relativeTo="ca_entities" restrictToRelationshipTypes="related" delimiter=", ">
						^ca_entities.preferred_labels.displayname
					</unit></dd>
				</ifcount>
			</dl>
			}}}

	
	
<?php
	if ($t_item->get("ca_collections.children.collection_id") || $t_item->get("ca_objects.object_id")){
		print "<div class='border'></div><br/><b>Collection Contents</b>";
		if ($t_item->get('ca_collections.collection_id')) {
			print caGetCollectionLevelSummary($this->request, array($t_item->get('ca_collections.collection_id')), 1);
		}
	}
	print $this->render("pdfEnd.php");
?>
