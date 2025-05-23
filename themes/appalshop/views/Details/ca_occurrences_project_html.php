<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_occurrences_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
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
 * ----------------------------------------------------------------------
 */
 
$t_item = 			$this->getVar("item");
$access_values = 	$this->getVar("access_values");
$options = 			$this->getVar("config_options");
$comments = 		$this->getVar("comments");
$tags = 			$this->getVar("tags_array");
$comments_enabled = $this->getVar("commentsEnabled");
$pdf_enabled = 		$this->getVar("pdfEnabled");
$inquire_enabled = 	$this->getVar("inquireEnabled");
$copy_link_enabled = 	$this->getVar("copyLinkEnabled");
$id =				$t_item->get('ca_occurrences.occurrence_id');
$show_nav = 		($this->getVar("previousLink") || $this->getVar("resultsLink") || $this->getVar("nextLink")) ? true : false;
$map_options = $this->getVar('mapOptions') ?? [];
?>
<script>
	pawtucketUIApps['geoMapper'] = <?= json_encode($map_options); ?>;
</script>

<?php
	if($show_nav){
?>
	<div class="row mt-n3">
		<div class="col text-center text-md-end">
			<nav aria-label="result">{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</nav>
		</div>
	</div>
<?php
	}
?>
	<div class="row">
		<div class="col-md-12 mb-3">
<?php
	$proj_themes = $t_item->get("ca_occurrences.proj_theme", array("checkAccess" => $access_values, "returnAsArray" => true, "convertCodesToDisplayText" => true));
	$proj_theme_ids = $t_item->get("ca_occurrences.proj_theme", array("checkAccess" => $access_values, "returnAsArray" => true));
	$theme_links = array();
	if(is_array($proj_themes) && sizeof($proj_themes)){
		foreach($proj_themes as $i => $proj_theme){
			$theme_links[] = caNavLink($this->request, $proj_theme, "", "", "Themes", "theme", array("item_id" => $proj_theme_ids[$i]));
		}
	}
	print join(", ", $theme_links);
?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<H1 class="fs-3">{{{^ca_occurrences.preferred_labels.name}}}</H1>
			<hr class="mb-0">
		</div>
	</div>
<?php
	if($inquire_enabled || $pdf_enabled || $copy_link_enabled){
?>
	<div class="row">
		<div class="col text-center text-md-end">
			<div class="btn-group" role="group" aria-label="Detail Controls">
<?php
				if($inquire_enabled) {
					print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Inquire"), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_occurrences", "id" => $id));
				}
				if($pdf_enabled) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download as PDF'), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "ca_occurrences", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_occurrences_summary'));
				}
				if($copy_link_enabled){
					print $this->render('Details/snippets/copy_link_html.php');
				}
?>
			</div>
		</div>
	</div>
<?php
	}
?>
	<div class="row row-cols-1 {{{<ifdef code="ca_occurrences.embed_code|ca_occurrences.externalLink.url_entry">row-cols-md-2</ifdef>}}}">
		<div class="col">				
			{{{<dl class="mb-0">
				<ifdef code="ca_occurrences.description_w_type.description">
					<dt><?= _t('Description'); ?></dt>
					<dd>
						^ca_occurrences.description_w_type.description
					</dd>
				</ifdef>
			</dl>}}}
		</div>
		{{{<ifdef code="ca_occurrences.embed_code|ca_occurrences.externalLink.url_entry">
		<div class="col">
			<ifdef code="embed_code">
				^ca_occurrences.embed_code
			</ifdef>
			
			<dl class="mb-0">
				<ifdef code="ca_occurrences.externalLink.url_entry">
					<dt><?= _t('Links'); ?></ifcount></dt>
					<unit relativeTo="ca_occurrences.externalLink" delimiter=""><dd><a href="^ca_occurrences.externalLink.url_entry"><ifdef code="ca_occurrences.externalLink.url_source">^ca_occurrences.externalLink.url_source</ifdef><ifnotdef code="ca_occurrences.externalLink.url_source">^ca_occurrences.externalLink.url_entry</ifnotdef></a></dd></unit>
				</ifdef>
			</dl>					
		</div>}}}
	</div>
{{{<ifcount code="ca_collections" min="1">
	<dl class="row">
		<dt class="col-12 mt-3 mb-2"><ifcount code="ca_collections" min="1" max="1"><?= _t('Related Collection'); ?></ifcount><ifcount code="ca_collections" min="2"><?= _t('Related Collections'); ?></ifcount></dt>
		<unit relativeTo="ca_collections" delimiter=""><dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><l class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">^ca_collections.preferred_labels</l></dd></unit>
	</dl>
</ifcount>}}}
{{{<ifcount code="ca_occurrences.related" restrictToType="work" min="1">
	<dl class="row">
		<dt class="col-12 mt-3 mb-2"><ifcount code="ca_occurrences.related" restrictToType="work" min="1" max="1"><?= _t('Related Work'); ?></ifcount><ifcount code="ca_occurrences.related" restrictToType="work" min="2"><?= _t('Related Works'); ?></ifcount></dt>
		<unit relativeTo="ca_occurrences.related" restrictToType="work" delimiter=""><dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><l class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">^ca_occurrences.preferred_labels</l></dd></unit>
	</dl>
</ifcount>}}}
{{{<ifcount code="ca_occurrences.children" min="1">
	<div class="row">
		<div class="col"><h2>Projects</h2><hr></div>
	</div>
	<div class="row subProjects" id="browseResultsContainer">	
		<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'projects', array('search' => 'ca_occurrences.parent_id:'.$t_item->get("ca_occurrences.occurrence_id"), 'view' => 'images')); ?>">
			<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
		</div>
	</div>
</ifcount>}}}
<?php
	$t_list = new ca_lists();
	$object_types = $t_list->getItemsForList("object_types", array("checkAccess" => $access_values));
	if(is_array($object_types) && sizeof($object_types)){
		foreach($object_types as $object_type){
			$object_type = array_pop($object_type);
			$type_name = $object_type["name_plural"];
			$type_idno = $object_type["idno"];
			$type_id = $object_type["item_id"];
			print $t_item->getWithTemplate("<ifcount code='ca_objects' restrictToTypes='".$type_idno."' min='1'>
												<div class=' mb-5'>
													<div class='row'>
														<div class='col'><h2>".$type_name."</h2><hr></div>
													</div>
													<div class='row'>
													<unit relativeTo='ca_objects' restrictToTypes='".$type_idno."' limit='6' delimiter=''>
														<div class='col-md-6 col-lg-4 d-flex'>
															<div class='card flex-grow-1 width-100 rounded-0 shadow border-0 mb-4'>
															  <l><ifdef code='ca_object_representations.media'>^ca_object_representations.media.medium%class=card-img-top,test-style</ifdef><ifnotdef code='ca_object_representations.media'><div class='display-1 text-center d-flex bg-light ca-placeholder' aria-label='media placeholder' role='img'><i class='bi bi-card-image align-self-center w-100'></i></div></ifnotdef></l>
																<div class='card-body'>
																	<div class='card-title'><div class='fw-medium lh-sm fs-5'><l>^ca_objects.preferred_labels</l></div></div>
																</div>
															 </div>	
														</div>
													</unit>
													</div>
													<ifcount code='ca_objects' restrictToTypes='".$type_idno."' min='7'>
														<div class='row'>
															<div class='col text-center'>".caNavLink($this->request, _t("View All %1", $type_name), "btn btn-primary", "", "Browse", "objects", array("facets" => "type_facet:".$type_id.";project_facet:".$t_item->get("ca_occurrences.occurrence_id")))."</div>
														</div>
													</ifcount>
												</div>
											</ifcount>");
		}
		
	}
?>