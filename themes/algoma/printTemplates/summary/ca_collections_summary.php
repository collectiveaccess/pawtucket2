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
	$va_access_values = caGetUserAccessValues($this->request);

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");	

?>
	<h1 class="title"><?php print $t_item->getLabelForDisplay();?></h1>
		
	<div class="unit"><H6>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef>}}}</H6></div>
	<div class="unit">
	{{{<ifdef code="ca_collections.parent_id"><div class="unit"><H6>Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; ">^ca_collections.preferred_labels.name</unit></H6></ifdef>}}}
	{{{<ifdef code="ca_collections.label">^ca_collections.label<br/></ifdev>}}}
	</div>
<?php
	$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => 1, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("contributor", "creator")));
	# --- note this needs to be placed within <dl></dl> tags
	if(is_array($va_entities) && sizeof($va_entities)){
		$va_entities_by_type = array();
		foreach($va_entities as $va_entity_info){
			$va_entities_by_type[$va_entity_info["relationship_typename"]][] = $va_entity_info["displayname"];
		}
		foreach($va_entities_by_type as $vs_type => $va_entity_links){
			print "<div class='unit'><H6>".$vs_type."</H6><div>".join(", ", $va_entity_links)."</div></div>";
		}
	}
?>
{{{
				<ifdef code="ca_collections.date.date_value">
					<div class="unit">
						<H6><?= _t('Date'); ?></H6>
						<unit relativeTo="ca_collections.date" delimiter=" ">
							<div>
								<ifdef code="ca_collections.date.date_value">^ca_collections.date.date_value</ifdef><ifdef code="ca_collections.date.date_value,ca_collections.date.date_note">, </ifdef><ifdef code="ca_collections.date.date_note">^ca_collections.date.date_note</ifdef>
							</div>
						</unit>
					</div>
				</ifdef>
				<ifdef code="ca_collections.phys_desc">
					<div class="unit">
						<H6><?= _t('Physical Description'); ?></H6>
						<div>
							^ca_collections.phys_desc
						</div>
					</div>
				</ifdef>
				<ifdef code="ca_collections.gmd">
					<div class="unit">
						<H6><?= _t('General Material Designation'); ?></H6>
						<div>
							^ca_collections.gmd%delimiter=,_
						</div>
					</div>
				</ifdef>
				<ifdef code="ca_collections.arrangement">
					<div class="unit">
						<H6><?= _t('Arrangement'); ?></H6>
						<unit relativeTo="ca_collections.arrangement" delimiter=" ">
							<div>
								^ca_collections.arrangement
							</div>
						</unit>
					</div>
				</ifdef>
				<ifdef code="ca_collections.language">
					<div class="unit">
						<H6><?= _t('Language(s)'); ?></H6>
						<div>
							^ca_collections.language%delimiter=,_
						</div>
					</div>
				</ifdef>
				<ifdef code="ca_collections.biblio">
					<div class="unit">
						<H6><?= _t('Bibliographic Information'); ?></H6>
						<div>
							<ifdef code="ca_collections.biblio.pub">^ca_collections.biblio.pub<ifdef code="ca_collections.biblio.volume|ca_collections.biblio.issue|ca_collections.biblio.standard">, </ifdef></ifdef>
							<ifdef code="ca_collections.biblio.volume">^ca_collections.biblio.volume<ifdef code="ca_collections.biblio.issue|ca_collections.biblio.standard">, </ifdef></ifdef>
							<ifdef code="ca_collections.biblio.issue">^ca_collections.biblio.issue<ifdef code="ca_collections.biblio.standard">, </ifdef></ifdef>
							<ifdef code="ca_collections.biblio.standard">^ca_collections.biblio.standard</ifdef>
						</div>
					</div>
				</ifdef>
				<ifdef code="ca_collections.rights.statement">
					<div class="unit">
						<H6><?= _t('Rights Statement'); ?></H6>
						<div>
							^ca_collections.rights.statement
						</div>
					</div>
				</ifdef>
				<ifdef code="ca_collections.rights.access_cond">
					<div class="unit">
						<H6><?= _t('Access Conditions'); ?></H6>
						<div>
							^ca_collections.rights.access_cond
						</div>
					</div>
				</ifdef>
				<ifdef code="ca_collections.rights.use_repro">
					<div class="unit">
						<H6><?= _t('Use and Reproduction Conditions'); ?></H6>
						<div>
							^ca_collections.rights.use_repro
						</div>
					</div>
				</ifdef>
				<ifdef code="ca_collections.rights.rights_note">
					<div class="unit">
						<H6><?= _t('Additional Rights Notes'); ?></H6>
						<div>
							^ca_collections.rights.rights_note
						</div>
					</div>
				</ifdef>	
}}}
<?php
			if($t_item->get("ca_collections.tk_permissions.tk_permissions_label")){
				$t_list_item = new ca_list_items($t_item->get("ca_collections.tk_permissions.tk_permissions_label"));
				$vs_permission_name = $t_list_item->get("ca_list_items.preferred_labels.name_singular");
				$vs_permission_desc = $t_item->get("ca_collections.tk_permissions.tk_permissions_description");
				if(!$vs_permission_desc){
					$vs_permission_desc = $t_list_item->get("ca_list_items.preferred_labels.description");
				}
				$vs_icon = $t_list_item->get("ca_list_items.icon.original", array("alt" => $vs_permission_name, "class" => "tkIcon me-2"));
				
				print "<div class='unit tkLabel'>
						  {$vs_icon} <b>{$vs_permission_name}</b>
						<div id='tkDescription'>{$vs_permission_desc}</div>
					</div>";
			}
?>
{{{				<ifdef code="ca_collections.scope_content">
					<div class="unit">
						<H6><?= _t('Scope and Content'); ?></H6>
						<div>
							^ca_collections.scope_content
						</div>
					</div>
				</ifdef>
				<ifdef code="ca_collections.credit">
					<div class="unit">
						<H6><?= _t('Credit'); ?></H6>
						<div>
							^ca_collections.credit
						</div>
					</div>
				</ifdef>
				<ifdef code="ca_collections.desc_note">
					<div class="unit">
						<H6><?= _t('Descriptive Notes'); ?></H6>
						<unit relativeTo="ca_collections.desc_note" delimiter=" ">
							<div>
							^ca_collections.desc_note
							</div>
						</unit>
					</div>
				</ifdef>
				<ifdef code="ca_collections.associated">
					<div class="unit">
						<H6><?= _t('Associated Material'); ?></H6>
						<unit relativeTo="ca_collections.associated" delimiter=" ">
							<div>
							^ca_collections.associated
							</div>
						</unit>
					</div>
				</ifdef>
				<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="subject">
					<div class="unit">
						<H6><ifcount code="ca_entities" min="1" max="1" restrictToRelationshipTypes="subject"><?= _t('Subject'); ?></ifcount><ifcount code="ca_entities" min="2" restrictToRelationshipTypes="subject"><?= _t('Subjects'); ?></ifcount></H6>
						<unit relativeTo="ca_entities" delimiter="" restrictToRelationshipTypes="subject"><div>^ca_entities.preferred_labels</div></unit>
					</div>
				</ifcount>
				<ifcount code="ca_collections.related" min="1" restrictToRelationshipTypes="related">
					<div class="unit">
						<H6><ifcount code="ca_collections.related" min="1" max="1" restrictToRelationshipTypes="related"><?= _t('Related Collections'); ?></ifcount><ifcount code="ca_collections.related" min="2" restrictToRelationshipTypes="related"><?= _t('Related Collections'); ?></ifcount></H6>
						<unit relativeTo="ca_collections.related" restrictToRelationshipTypes="related" delimiter=""><div><unit relativeTo="ca_collections.hierarchy" delimiter=" ➔ ">^ca_collections.preferred_labels.name</unit></div></unit>
					</div>
				</ifcount>

				<ifdef code="ca_collections.geographic_access">
					<div class="unit">
						<H6><?= _t('Geographic Access'); ?></H6>
						<div>
							^ca_collections.geographic_access%delimiter=,_
						</div>
					</div>
				</ifdef>
				<ifcount code="ca_places" min="1">
					<div class="unit">
						<H6><ifcount code="ca_places" min="1" max="1"><?= _t('Related Place'); ?></ifcount><ifcount code="ca_places" min="2"><?= _t('Related Places'); ?></ifcount></H6>
						<unit relativeTo="ca_places" delimiter=""><div>^ca_places.preferred_labels</div></unit>
					</div>
				</ifcount>
}}}
<?php
	if ($t_item->get("ca_collections.children.collection_id") || $t_item->get("ca_objects.object_id")){
		print "<div class='collectionContents'><div class='contentsTitle'>".$t_item->getWithTemplate("^ca_collections.type_id")." Contents</div>";
		if ($t_item->get('ca_collections.collection_id')) {
			print caGetCollectionLevelSummary($this->request, array($t_item->get('ca_collections.collection_id')), 1);
		}
		print "</div>";
	}
	print $this->render("pdfEnd.php");
?>
