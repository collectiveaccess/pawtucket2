<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2015 Whirl-i-Gig
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
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$va_access_values = caGetUserAccessValues($this->request);

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
		<div class="container"><div class="row">
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
				
<?php		
				#if ($this->request->isLoggedIn()) {		
					print $this->getVar("representationViewer");				
				
					print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); 
				#} else {
				#	print $t_object->get('ca_object_representations.media.medium');
				#	print "<div class='detailMediaPlaceholderCaption'>Please <a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a> or <a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a> to view media</div>";
				#}	

				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
					print '<div id="detailTools">';
?>
					<div class="detailTool detailToolSocial">
						<a href='https://twitter.com/home?status=http%3A//fabricofdigitallife.com<?php print caNavUrl($this->request, '', 'Detail', 'objects/'.$t_object->get("ca_objects.object_id")); ?>'><i class="fa fa-twitter-square" aria-hidden="true"></i></a>
						<a href='https://www.facebook.com/sharer/sharer.php?u=http%3A//fabricofdigitallife.com<?php print caNavUrl($this->request, '', 'Detail', 'objects/'.$t_object->get("ca_objects.object_id")); ?>'><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
						<a href='https://plus.google.com/share?url=http%3A//fabricofdigitallife.com<?php print caNavUrl($this->request, '', 'Detail', 'objects/'.$t_object->get("ca_objects.object_id")); ?>'><i class="fa fa-google-plus-square" aria-hidden="true"></i></a>
					</div><!-- end detailTool -->
						
<?php						
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools -->';
				}				
?>
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<HR>
<?php

				if ($va_publications = $t_object->get('ca_objects.publication_title_name', array('returnAsArray' => true))) {
					#print_r($va_publications);
					print "<div class='unit'><h6>Publication Title</h6>";
					foreach($va_publications as $vs_publication){
						print caNavLink($this->request, $vs_publication, '', '', 'Browse', 'objects', array('facet' => 'analytics_pub_title', 'id' => ca_attribute_values::getValueIDFor(ca_metadata_elements::getElementID('publication_title_name'), $vs_publication)));
					}
					print "</div>";
				}
				if ($va_issued = $t_object->get('ca_objects.issued', array('delimiter' => ', '))) {
					print "<div class='unit'><h6>Publication/Creation Date</h6>".$va_issued."</div>";
				}
				#if ($va_creator = $t_object->getWithTemplate('<unit delimiter=", " restrictToRelationshipTypes="creator,contributor,rightsHolder" relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>')) {
				#	print "<div class='unit'><h6>Creators/Contributors</h6>".$va_creator."</div>";
				#}
				if ($va_creators = $t_object->get('ca_entities', array('returnWithStructure' => true, 'checkAccess' => $va_access_values, 'restrictToRelationshipTypes' => array('creator','rightsHolder', 'contributor')))) {

					print "<div class='unit'><h6>Creators/Contributors</h6>";
					foreach ($va_creators as $va_pr => $va_creator) {
						print caNavLink($this->request, ucwords($va_creator['label']), '', '', 'Browse', 'objects/facet/entity/id/'.$va_creator['entity_id'])." (".$va_creator['relationship_typename'].")";
						if (end($va_creators) != $va_creator) { print "<br/>";}
					}					
					print "</div>";
				}				
				if ($va_media_types = $t_object->get('ca_objects.media_type', array('returnAsArray' => true))) {
					print "<div class='unit'><h6>Media Type</h6>";
					foreach ($va_media_types as $va_p => $va_media_type) {
						print caNavLink($this->request, ucwords(caGetListItemByIDForDisplay($va_media_type)), '', '', 'Browse', 'objects/facet/media_type/id/'.$va_media_type);
					}
					print "</div>";
				}
				if ($va_pers = $t_object->get('ca_objects.persuasive_intention', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Persuasive Intent</h6>";
					foreach ($va_pers as $va_p => $va_per) {
						print caNavLink($this->request, ucwords($va_per), '', '', 'Search', 'objects', array('search' => "ca_objects.persuasive_intention:\"".$va_per."\""), [], ['dontURLEncodeParameters' => true]);
						if (end($va_pers) != $va_per) { print ", ";}
					}
					print "</div>";
				}
				if ($va_classes = $t_object->get('ca_objects.classification', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
					$ids = $t_object->get('ca_objects.classification', array('returnAsArray' => true, 'convertCodesToDisplayText' => false));
					print "<div class='unit'><h6>Discursive Type</h6>";
					foreach ($va_classes as $va_p => $va_class) {
						print caNavLink($this->request, ucwords($va_class), '', '', 'Search', 'objects', array('search' => "ca_objects.classification:\"".$ids[$va_p]."\""), [], ['dontURLEncodeParameters' => true]);
						if (end($va_classes) != $va_class) { print ", ";}
					}
					print "</div>";
				}
				
				if ($va_description = $t_object->get('ca_objects.description', array('delimiter' => ', '))) {
					print "<div class='unit'><h6>Description</h6>".$va_description."</div>";
				}
				if ($va_uses = $t_object->get('ca_objects.use', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>HCI Platform</h6>";
					foreach ($va_uses as $va_p => $va_use) {
						print caNavLink($this->request, ucwords($va_use), '', '', 'Search', 'objects', array('search' => "ca_objects.use:\"".$va_use."\""), [], ['dontURLEncodeParameters' => true]);
					}					
					print "</div>";
				}	
				if ($rels_to_body = $t_object->get('ca_objects.relation_to_body', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Relation to Body</h6>";
					foreach ($rels_to_body as $va_p => $rel_to_body) {
						print caNavLink($this->request, ucwords($rel_to_body), '', '', 'Search', 'objects', array('search' => "ca_objects.relation_to_body:\"".$rel_to_body."\""), [], ['dontURLEncodeParameters' => true]);
					}					
					print "</div>";
				}	
				if ($va_body = $t_object->get('ca_objects.locationOnBody', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Related Body Part</h6>";
					foreach ($va_body as $va_p => $va_bod) {
						print caNavLink($this->request, ucwords($va_bod), '', '', 'Search', 'objects', array('search' => "ca_objects.locationOnBody:\"".$va_bod."\""), [], ['dontURLEncodeParameters' => true]);
						if (end($va_body) != $va_bod) { print ", ";}
					}					
					print "</div>";
				}
						
				
				if ($va_augments = $t_object->get('ca_objects.augments', array('returnAsArray' => true))) {
					print "<div class='unit'><h6>Augments</h6>";
					foreach ($va_augments as $va_p => $va_augment) {
						print caNavLink($this->request, ucwords($va_augment), '', '', 'Search', 'objects', array('search' => "ca_objects.augments:\"".$va_augment."\""), [], ['dontURLEncodeParameters' => true]);
						if (end($va_augments) != $va_augment) { print ", ";}
					}
					print "</div>";
				}
				if ($va_techs = $t_object->get('ca_objects.technology', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Technology Keywords</h6>";
					foreach ($va_techs as $va_p => $va_tech) {
						print caNavLink($this->request, ucwords($va_tech), '', '', 'Search', 'objects', array('search' => "ca_objects.technology:\"".$va_tech."\""), [], ['dontURLEncodeParameters' => true]);
						if (end($va_techs) != $va_tech) { print ", ";}
					}					
					print "</div>";
				}
				if ($va_keywords = $t_object->get('ca_objects.keywords', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Keywords</h6>";
					foreach ($va_keywords as $va_p => $va_keyword) {
						print caNavLink($this->request, ucwords($va_keyword), '', '', 'Search', 'objects', array('search' => "ca_objects.keywords:\"".$va_keyword."\""), [], ['dontURLEncodeParameters' => true]);
						if (end($va_keywords) != $va_keyword) { print ", ";}
					}					
					print "</div>";
				}
				if ($va_marketing_keywords = $t_object->get('ca_objects.marketing', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Marketing Keywords</h6>";
					foreach ($va_marketing_keywords as $va_p => $va_marketing_keyword) {
						print caNavLink($this->request, ucwords($va_marketing_keyword), '', '', 'Search', 'objects', array('search' => "ca_objects.marketing:\"".$va_marketing_keyword."\"", [], ['dontURLEncodeParameters' => true]));
						if (end($va_marketing_keywords) != $va_marketing_keyword) { print ", ";}
					}					
					print "</div>";
				}				
				#if ($va_citation = $t_object->get('ca_objects.bibliographicCitation', array('delimiter' => ', '))) {
				#	print "<div class='unit'><h6>Citation</h6>".$va_citation."</div>";
				#}	
				if ($va_source = $t_object->get('ca_objects.source', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Source</h6>".$va_source."</div>";
				}	
										
?>				
				

				
				
				<hr></hr>
					<div class="row">
						<div class="col-sm-12">
<?php
							if ($va_productions = $t_object->get('ca_occurrences', array('returnWithStructure' => true, 'restrictToTypes' => array('production'), 'checkAccess' => $va_access_values))) {

								print "<div class='unit'><h6>Related Film</h6>";
								foreach ($va_productions as $va_pr => $va_production) {
									print caNavLink($this->request, ucwords($va_production['label']), '', '', 'Browse', 'objects/facet/occurrence/id/'.$va_production['occurrence_id']);
									if (end($va_productions) != $va_production) { print ", ";}
								}					
								print "</div>";
							}
							if ($va_related_objects = $t_object->get('ca_objects.related.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>', 'checkAccess' => $va_access_values))) {
								print "<div class='unit'><h6>Related Objects</h6>".$va_related_objects."</div>";
							}
							if ($va_people = $t_object->get('ca_entities', array('returnWithStructure' => true, 'checkAccess' => $va_access_values))) {

								print "<div class='unit'><h6>Related Items</h6>";
								foreach ($va_people as $va_pr => $va_person) {
									print caNavLink($this->request, ucwords($va_person['label']), '', '', 'Browse', 'objects/facet/entity/id/'.$va_person['entity_id']);
									if (end($va_people) != $va_person) { print "<br/>";}
								}					
								print "</div>";
							}
							if ($va_collections = $t_object->get('ca_collections', array('returnWithStructure' => true, 'checkAccess' => $va_access_values))) {

								print "<div class='unit'><h6>Related Collections</h6>";
								foreach ($va_collections as $va_co => $va_collection) {
									print caNavLink($this->request, ucwords($va_collection['label']), '', '', 'Browse', 'objects/facet/collection/id/'.$va_collection['collection_id']);
									if (end($va_collections) != $va_collection) { print "<br/>";}
								}					
								print "</div>";
							}
							
							print "<div class='unit'><h6>Date archived</h6>";
							print $t_object->get('ca_objects.created', ['timeOmit' => true])."</div>";
														
							print "<div class='unit'><h6>Last edited</h6>";
							print $t_object->get('ca_objects.lastModified', ['timeOmit' => true])."</div>";
							
							$vs_citation = "";
							if ($vs_creator = $t_object->get('ca_entities.preferred_labels', array('checkAccess' => $va_access_values, 'restrictToRelationshipTypes' => array('creator','rightsHolder'), 'delimiter' => ', '))) {
								$vs_citation.= $vs_creator.". ";
							}
							if ($vs_date = $t_object->get('ca_objects.issued', array('delimiter' => ', '))) {
								$vs_citation.= " (".$vs_date."). ";
							}
							$vs_citation.= ' "'.$t_object->get('ca_objects.preferred_labels').'". ';	
							if ($vs_publication = $t_object->get('ca_objects.publication_title_name', array('delimiter' => ', '))) {
								$vs_citation.= $vs_publication.". ";
							}
							if ($vs_publisher = $t_object->get('ca_entities', array('checkAccess' => $va_access_values, 'restrictToRelationshipTypes' => array('publisher'), 'delimiter' => ', '))) {
								$vs_citation.= $vs_publisher.". ";
							}
							$vs_citation.= "Fabric of Digital Life. ";
							$vn_object_id = $t_object->get('ca_objects.object_id');	
							$record_link = caNavUrl($this->request, 'Detail', 'objects', $vn_object_id, array(), array('absolute' => 1));
							$vs_citation.= "<a href='".$record_link."'>".$record_link."</a>";
							print "<div class='unit' style='margin:12px 0px;'><h6>How to cite this entry</h6>".$vs_citation."</div>";
?>								

						</div><!-- end col -->				

					</div><!-- end row -->
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
