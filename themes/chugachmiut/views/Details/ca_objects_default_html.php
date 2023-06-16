<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
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
 	$va_access_values = caGetUserAccessValues($this->request);
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
		<div class="row">
			<div class='col-sm-12'>
				<H1>{{{ca_objects.preferred_labels.name}}}</H1>
				<HR>
			</div>
		</div>
		<div class="row">
			<div class='col-sm-6 col-md-6 col-lg-5'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-4 col-md-2 col-xs-3", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-4'>
				
				{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="creator,contributor,author"><div class="unit"><label>Creators and Contributors</label>
								<unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="creator,contributor,author"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>
							</div></ifcount>}}}
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="repository" min="1"><div class="unit"><label>Repository</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="repository"><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>}}}				
				
				{{{<ifdef code="ca_objects.summary">
					<div class='unit'><label>Summary</label>
						<span class="trimText">^ca_objects.summary</span>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.cultural_narrative">
					<div class='unit'><label>Cultural Narrative</label>
						<span class="trimText">^ca_objects.cultural_narrative</span>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.description">
					<div class='unit'><label>Description</label>
						<span class="trimText">^ca_objects.description</span>
					</div>
				</ifdef>}}}
			</div>
			<div class='col-md-12 col-lg-3'>
				<div id='detailTools' class='bgLightGray'>
<?php
				print "<div class='detailTool'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Loan Request", "", "", "Contact", "Form", array("inquire_type" => "loan", "table" => "ca_objects", "id" => $t_object->get("ca_objects.object_id")))."</div>";
				#print "<div class='detailTool'>".caNavLink($this->request, "<i class='fa fa-comments-o' aria-hidden='true'></i> Share Your Cultural Narrative", "", "", "Contact", "Form", array("inquire_type" => "cultural_narrative", "table" => "ca_objects", "id" => $t_object->get("ca_objects.object_id")))."</div>";
				print "<div class='detailTool'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Inquire About this Item", "", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_objects", "id" => $t_object->get("ca_objects.object_id")))."</div>";
				if ($vn_comments_enabled) {
					#$vn_num_comments = sizeof($va_comments) + sizeof($va_tags);
?>				
					<div class="detailTool culturalNarrative">
						<label>Share Your Cultural Narrative</label>
								<div>{{{detail_share_cultural_narrative}}}</div>
<?php
							
								if($this->request->isLoggedIn()){
									print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'CommentForm', array("tablename" => "ca_objects", "item_id" => $t_object->getPrimaryKey()))."\"); return false;' ><i class='fa fa-comments-o' aria-hidden='true'></i> "._t("Add your comment")."</a>";
								}else{
									print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' ><i class='fa fa-comments-o' aria-hidden='true'></i> "._t("Login/register to comment")."</a>";
								}
								#if($vn_num_comments){
								#	print "<br/><br/><a href='#comments'>Read All Comments <i class='fa fa-angle-right' aria-hidden='true'></i></a>";
								#}
?>
					</div>
<?php				
				}

?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="container">
				<div class="row bgLightGray detailBottom">
					<div class="col-sm-12 col-md-3">
						{{{<ifdef code="ca_objects.date|ca_objects.date_note"><div class="unit"><label>Date</label>^ca_objects.date<ifdef code="ca_objects.date_note"><ifdef code="ca_objects.date">, </ifdef>^ca_objects.date_note</ifdef></div></ifdef>}}}
						{{{<ifcount code="ca_entities" min="1" excludeRelationshipTypes="creator,contributor,author" restrictToTypes="organization"><div class="unit"><label>Related Organizations</label>
										<unit relativeTo="ca_entities" delimiter="<br/>" excludeRelationshipTypes="creator,contributor,author" restrictToTypes="organization"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>
									</div></ifcount>}}}
						{{{<ifcount code="ca_entities" min="1" excludeRelationshipTypes="creator,contributor,author" restrictToTypes="individual"><div class="unit"><label>Related People</label>
										<unit relativeTo="ca_entities" delimiter="<br/>" excludeRelationshipTypes="creator,contributor,author" restrictToTypes="individual"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>
									</div></ifcount>}}}
						{{{<ifdef code="ca_objects.type"><div class="unit"><label>Type</label>^ca_objects.type%delimiter=,_</div></ifdef>}}}
						{{{<ifdef code="ca_objects.format_material"><div class="unit"><label>Format/Material</label>^ca_objects.format_material%delimiter=,_</div></ifdef>}}}
						{{{<ifdef code="ca_objects.language"><div class="unit"><label>Language</label>^ca_objects.language%delimiter=,_</div></ifdef>}}}
						{{{<ifdef code="ca_objects.publisher_container.publisher|ca_objects.publisher_container.pub_place"><div class="unit"><label>Publisher</label>^ca_objects.publisher_container.publisher<ifdef code="ca_objects.publisher_container.pub_place">, ^ca_objects.publisher_container.pub_place</ifdef></div></ifdef>}}}
						{{{<ifcount min="1" code="ca_collections"><div class="unit"><label>Collection</label><unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></div></unit>}}}
						{{{<ifdef code="ca_objects.copies"><div class="unit"><label>Number of Copies</label>^ca_objects.copies</div></ifdef>}}}
						{{{<ifdef code="ca_objects.idno"><div class="unit"><label>Identifier</label>^ca_objects.idno</div></ifdef>}}}
					</div>
					{{{<ifdef code="ca_objects.sacred|ca_objects.content_warning|ca_objects.cultural_app_warning|ca_objects.category|ca_objects.subjects|ca_objects.terms_container.term|ca_objects.orthography">
						<div class="col-sm-12 col-md-3">			
				
						<ifdef code="ca_objects.sacred"><div class="unit"><label>Sacred Item</label>^ca_objects.sacred</div></ifdef>
						<ifdef code="ca_objects.content_warning"><div class="unit warning"><unit relativeTo="ca_objects.content_warning" delimiter="<br/>">^ca_objects.content_warning</unit></div></ifdef>
						<ifdef code="ca_objects.cultural_app_warning"><div class="unit warning"><unit relativeTo="ca_objects.content_warning" delimiter="<br/>"><unit relativeTo="ca_objects.cultural_app_warning" delimiter="<br/>">^ca_objects.cultural_app_warning</unit></div></ifdef>
						<ifdef code="ca_objects.category"><div class="unit"><label>Special Category</label>^ca_objects.category%delimiter=,_</div></ifdef>
					<?php
						if($links = caGetSearchLinks($t_object, 'ca_objects.subjects', ['linkTemplate' => '^LINK'])) {
					?>
							
							<div class="unit">
								<label>Subjects</label>
								<?= join(", ", $links); ?>
							</div>
					<?php
						}
					?>
						<ifdef code="ca_objects.terms_container.term"><div class="unit"><label>Related Terms</label><unit relativeTo="ca_objects.terms_container"><ifdef code="ca_objects.terms_container.term_link"><a href="^ca_objects.terms_container.term_link">^ca_objects.terms_container.term</a></ifdef><ifnotdef code="ca_objects.terms_container.term_link">^ca_objects.terms_container.term</ifnotdef></unit></div></ifdef>
						<ifdef code="ca_objects.orthography"><div class="unit"><label>Orthography</label>^ca_objects.orthography%delimiter=,_</div></ifdef>
				
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_objects.credit|ca_objects.rights|ca_objects.access_conditions|ca_objects.use_reproduction|ca_objects.source">
						<div class="col-sm-12 col-md-3">
							<ifdef code="ca_objects.credit"><div class="unit"><label>Credit Line</label>^ca_objects.credit</div></ifdef>
							<ifdef code="ca_objects.rights"><div class="unit"><label>Rights</label>^ca_objects.rights</div></ifdef>
							<ifdef code="ca_objects.access_conditions"><div class="unit"><label>Access Conditions</label>^ca_objects.access_conditions</div></ifdef>
							<ifdef code="ca_objects.use_reproduction"><div class="unit"><label>Use and Reproduction Conditions</label>^ca_objects.use_reproduction</div></ifdef>
							<ifdef code="ca_objects.source"><div class="unit"><label>Source</label>^ca_objects.source</div></ifdef>
						</div>
					</ifdef>}}}
					<div class="col-sm-12 col-md-3">
						{{{<ifcount code="ca_places" min="1" restrictToTypes="community"><div class="unit"><label>Related Communities</label>
										<unit relativeTo="ca_places" delimiter="<br/>" restrictToTypes="community"><l>^ca_places.preferred_labels</l> (^relationship_typename)</unit>
									</div></ifcount>}}}
						{{{<ifcount code="ca_places" min="1" excludeTypes="community"><div class="unit"><label>Related Places</label>
										<unit relativeTo="ca_places" delimiter="<br/>" excludeTypes="community"><l>^ca_places.preferred_labels</l> (^relationship_typename)</unit>
									</div></ifcount>}}}
						<div class="unit">{{{map}}}</div>
						
					</div><!-- end col -->
				</div><!-- end row --></div><!-- end container -->
<?php			
	$va_related_objects = $t_object->get("ca_objects.related.object_id", array("checkAccess" => $va_access_values, "returnAsArray" => true));
	$qr_res = caMakeSearchResult("ca_objects", $va_related_objects);
	if($qr_res && $qr_res->numHits()){
?>
<div class="row"><div class="col-sm-12 col-md-6 col-md-offset-3"><H3 class="featuredItems">Related Heritage Items</H3>  
		<div class="jcarousel-wrapper featuredItemsSlideShow">
			<!-- Carousel -->
			<div class="jcarousel featured featuredItemsSlide">
				<ul>
<?php
					while($qr_res->nextHit()){
						$vs_media = $qr_res->getWithTemplate("<div class='featuredItemMedia'><l>^ca_object_representations.media.large</l></div>", array("checkAccess" => $va_access_values));
						$vs_description = $qr_res->getWithTemplate("<div class='featuredItemTitle'><l>^ca_objects.preferred_labels.name</l></div>");
						$vs_button = $qr_res->getWithTemplate("<div class='text-center'><l><button class='btn btn-default'>More</button></l></div>");
						print "<li><div class='row'><div class='col-xs-5'>".$vs_media."</div><div class='col-xs-7'>".$vs_description.$vs_button."</div></div></li>";
						$vb_item_output = true;
						
					}
?>
				</ul>
			</div><!-- end jcarousel -->
<?php
			if($vb_item_output){
?>
			<!-- Prev/next controls -->
			<a href="#" class="jcarousel-control-prev featured"><i class="fa fa-angle-left"></i></a>
			<a href="#" class="jcarousel-control-next featured"><i class="fa fa-angle-right"></i></a>
		
			<!-- Pagination -->
			<p class="jcarousel-pagination featured">
			<!-- Pagination items will be generated in here -->
			</p>
<?php
			}
?>
		</div><!-- end jcarousel-wrapper -->
</div></div>
		<script type='text/javascript'>
			jQuery(document).ready(function() {
				/*
				Carousel initialization
				*/
				$('.featuredItemsSlide li').width($('.featuredItemsSlideShow').width());
				$( window ).resize(function() {
				  $('.featuredItemsSlide li').width($('.featuredItemsSlideShow').width());
				});
				
				$('.jcarousel.featured')
					.jcarousel({
						// Options go here
						wrap:'circular'
					});
					$('.jcarousel.featured').jcarouselAutoscroll({
					autostart: false,
					interval: 8000
				});
		
				/*
				 Prev control initialization
				 */
				$('.jcarousel-control-prev.featured')
					.on('jcarouselcontrol:active', function() {
						$(this).removeClass('inactive');
					})
					.on('jcarouselcontrol:inactive', function() {
						$(this).addClass('inactive');
					})
					.jcarouselControl({
						// Options go here
						target: '-=1'
					});
		
				/*
				 Next control initialization
				 */
				$('.jcarousel-control-next.featured')
					.on('jcarouselcontrol:active', function() {
						$(this).removeClass('inactive');
					})
					.on('jcarouselcontrol:inactive', function() {
						$(this).addClass('inactive');
					})
					.jcarouselControl({
						// Options go here
						target: '+=1'
					});
		
				/*
				 Pagination initialization
				 */
				$('.jcarousel-pagination.featured')
					.on('jcarouselpagination:active', 'a', function() {
						$(this).addClass('active');
					})
					.on('jcarouselpagination:inactive', 'a', function() {
						$(this).removeClass('active');
					})
					.jcarouselPagination({
						// Options go here
					});
			});
		</script>
<?php
	}
?>
			
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>
<?php
	if($t_object->get("ca_objects.content_warning") || ($t_object->get("ca_objects.sacred")) || $t_object->get("ca_objects.cultural_app_warning")){
?>
		<div class="detailAlert">
			<div class="detailAlertBox">
				<div class="detailAlertMessage"><b>Warning</b><br/>{{{detail_content_warning}}}
<?php
				if($t_object->get("ca_objects.content_warning")){
					print "<br/><br/><b>".$t_object->getWithTemplate("^ca_objects.content_warning", array("delimiter" => "br/"))."</b>";
				}
				if($t_object->get("ca_objects.sacred")){
					print "<br/><br/><b>Sacred Item</b>";
				}
				if($t_object->get("ca_objects.cultural_app_warning")){
					print "<br/><br/><b>".$t_object->getWithTemplate("^ca_objects.cultural_app_warning", array("delimiter" => "br/"))."</b>";
				}
				
?>
				<div class="enterButton"><?php print caNavLink($this->request, "Exit", "btn btn-default", "", "", ""); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-default" onclick="$('.detailAlert').remove(); return false;">Continue <i class='fa fa-arrow-right'></i></button></div></div>
				
			</div>
		</div>
<?php	
	}

?>