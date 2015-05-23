<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	
	$va_type = $t_item->get('ca_entities.type_id', array('convertCodesToDisplayText' => true));
	$va_title = ((strlen($t_item->get('ca_entities.preferred_labels')) > 40) ? substr($t_item->get('ca_entities.preferred_labels'), 0, 37)."..." : $t_item->get('ca_entities.preferred_labels'));	
	$va_home = caNavLink($this->request, "Project Home", '', '', '', '');
	MetaTagManager::setWindowTitle($va_home." > ".$va_type." > ".$va_title);
	
	#Circulation History
	$vs_first_date = null;
	$vs_buf = "";
	$va_rel_ids = $t_item->get('ca_objects_x_entities.relation_id', array('returnAsArray' => true));
	$qr_rels = caMakeSearchResult('ca_objects_x_entities', $va_rel_ids, array('sort' => 'ca_objects_x_entities.date_out', 'restrictToRelationshipTypes' => array('reader')));
	$va_non_read_books = $t_item->get('ca_objects.object_id', array('restrictToTypes' => array('bib', 'volume'), 'excludeRelationshipTypes' => array('reader'), 'returnAsArray' => true));
	// set all of the page object_ids
	$va_page_ids = array();
	if ($qr_rels > 0) {
	$va_result_count = $qr_rels->numHits();			
		while($qr_rels->nextHit()) {
			$va_page_ids[] = $qr_rels->get("ca_objects_x_entities.see_original_link", array('idsOnly' => 1));
		}

		$qr_pages = caMakeSearchResult('ca_objects', $va_page_ids);

		$va_parents = array();
		while($qr_pages->nextHit()) {
			$va_parents[$qr_pages->get('ca_objects.object_id')] = $qr_pages->get('ca_objects.parent.preferred_labels.name');
		}

		$qr_rels->seek(0);	// reset the result to the beginning so we can run through it again

		$vn_page_type_id = caGetListItemID('object_types', 'page');
		$vn_i = 0;
		$vs_has_circulation = false;
		while($qr_rels->nextHit()) {
			if ($qr_rels->get('ca_objects.type_id') == $vn_page_type_id) { continue; }
			if (in_array($qr_rels->get('ca_objects.object_id'), $va_non_read_books)) { continue; }
			$vs_buf.= "<div class='row ledgerRow'>";
				$vs_buf.= "<div class='col-xs-3 col-sm-3 col-md-3 col-lg-3  bookTitle' id='book".$vn_i."'>";
					$vs_buf.= "Transcribed: ".$qr_rels->get("ca_objects_x_entities.book_title")."<br/>";
					if ($qr_rels->get("ca_objects.parent.preferred_labels")) {
						$va_label_trunk = explode(':', $qr_rels->get("ca_objects.parent.preferred_labels"));
						$vs_buf.= caNavLink($this->request, $va_label_trunk[0], '', '', 'Detail', 'objects/'.$qr_rels->get("ca_objects.parent.object_id"));
					} else {
						$va_label_trunk = explode(':', $qr_rels->get("ca_objects.preferred_labels"));
						$vs_buf.= caNavLink($this->request, $va_label_trunk[0], '', '', 'Detail', 'objects/'.$qr_rels->get("ca_objects.object_id"));
					}

					$va_book_info = array();
					if ($va_author = $qr_rels->getWithTemplate('<unit relativeTo="ca_objects" ><unit relativeTo="ca_entities" restrictToRelationshipTypes="author">^ca_entities.preferred_labels</unit></unit>')) {
						$va_book_info[] = $va_author;
					} else {$va_author = null;}
					if ($va_publication_date = $qr_rels->get("ca_objects.publication_date")) {
						$va_book_info[] = $va_publication_date;
					} else { $va_publication_date = null; }
					if ($va_publisher = $qr_rels->get("ca_objects.publisher")) {
						$va_book_info[] = $va_publisher;
					} else { $va_publisher = null; }
					TooltipManager::add('#book'.$vn_i, $qr_rels->get('ca_objects.parent.preferred_labels.name')." ".$qr_rels->get('ca_objects.preferred_labels.name')."<br/>".join('<br/>', $va_book_info)); 						

				$vs_buf.= "</div>";

				$vs_buf.= "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
				if ($qr_rels->get("ca_objects.parent.preferred_labels")) {
					$vs_buf.= $qr_rels->get("ca_objects.preferred_labels.displayname", array('returnAsLink' => true));
				}
				$vs_buf.= "</div>";	

				$vs_buf.= "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
				$vs_buf.= $qr_rels->get("ca_objects_x_entities.date_out");
				if ($vs_first_date == null) {
					$vs_first_date = $qr_rels->get("ca_objects_x_entities.date_out");
				}
				$vs_buf.= "</div>";

				$vs_buf.= "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
				$vs_buf.= $qr_rels->get("ca_objects_x_entities.date_in");
				$vs_last_date = $qr_rels->get("ca_objects_x_entities.date_in");
				if (!$vs_last_date) {
					$vs_last_date = $qr_rels->get("ca_objects_x_entities.date_out");
				}
				$vs_buf.= "</div>";
					
				$vs_buf.= "<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>";
				$vs_buf.= $qr_rels->get("ca_objects_x_entities.fine");
				$vs_buf.= "</div>";

				$vs_buf.= "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
				$vs_buf.= $va_parents[$qr_rels->get("ca_objects_x_entities.see_original_link", array('idsOnly' => true))]." ".$qr_rels->get("ca_objects_x_entities.see_original_link", array('returnAsLink' => true,));
				if ($qr_rels->get("ca_objects_x_entities.see_original", array('convertCodesToDisplayText' => true)) == "Yes"){
					$vs_buf.= "<i class='fa fa-exclamation-triangle'></i>";
					TooltipManager::add('.fa-exclamation-triangle', "See original ledger entry"); 						
				}				
				$vs_buf.= "</div>";													
			$vs_buf.= "</div>";

			$vn_i++;
			$vs_has_circulation = true;
		}
	}	

		
?>
<div class="page">
	<div class="wrapper">
		<div class="sidebar">		
			{{{representationViewer}}}
			<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
<?php	
			if ($va_occupations = $t_item->get('ca_entities.industry_occupations', array('returnAsArray' => true))) {
				print "<H6>Occupation</H6>";
				$va_as_text = $t_item->get('ca_entities.industry_occupations', array('returnAsArray' => true, 'convertCodesToDisplayText' => true));
				$va_occupations_list = array();
				foreach ($va_occupations as $va_key => $va_occupation) {
					foreach ($va_occupation as $va_key2 => $va_occupation_id) {
						if ($va_occupation_id == 551){continue;}
						$va_occupations_list[] = caNavLink($this->request, ucfirst($va_as_text[$va_key][$va_key2]), '', '', 'Browse', 'entities/facet/occupation_facet/id/'.$va_occupation_id)."</a>";
					}
				}
				print "<div>";
				print join(', ', $va_occupations_list);
				print "</div>";
			}
			if ($va_countries = $t_item->get('ca_entities.country_origin', array('returnAsArray' => true))) {
				print "<H6>Country of Origin</H6>";
				$va_country_as_text = $t_item->get('ca_entities.country_origin', array('returnAsArray' => true, 'convertCodesToDisplayText' => true));
				foreach ($va_countries as $va_key => $va_country) {
					foreach ($va_country as $va_key2 => $va_country_id) {
						if ($va_country_id == 746){continue;}
						print "<div>".caNavLink($this->request, ucfirst($va_country_as_text[$va_key][$va_key2]), '', '', 'Browse', 'entities/facet/country_facet/id/'.$va_country_id)."</a></div>";
					}
				}
			}	
			if ($va_gender = $t_item->get('ca_entities.gender')) {
				print "<H6>Gender</H6>";
				print "<div>".caNavLink($this->request, $t_item->get('ca_entities.gender', array('convertCodesToDisplayText' => true)), '', '', 'Browse', 'entities/facet/gender_facet/id/'.$t_item->get('ca_entities.gender'))."</a></div>";
			}		
			$va_ledgers_by_parent = array();
			if ($va_related_pages = $t_item->get('ca_objects', array('returnAsArray' => true, 'restrictToTypes' => array('page')))) {
				print "<div class='unit'><H6>Ledgers</H6>";
				foreach ($va_related_pages as $va_key => $va_related_page) {
					$t_page = new ca_objects($va_related_page['object_id']);
					$va_parent_name = $t_page->get('ca_objects.parent.preferred_labels');
					$va_ledgers_by_parent[$va_parent_name][$va_related_page['object_id']] = caNavLink($this->request, $t_page->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$t_page->get('ca_objects.object_id'));
				}
				$va_people_links = array();
				$vn_i = 0;
				foreach ($va_ledgers_by_parent as $va_parent => $va_page) {
					print "<div>";
						print "<a href='#' style='display:none;' class='closeLink".$vn_i."' onclick='$(\"#ent".$vn_i."\").slideUp();$(\".closeLink".$vn_i."\").hide();$(\".openLink".$vn_i."\").show();return false;'>".ucwords($va_parent)."<i class='fa fa-angle-down'></i></a>";
						print "<a href='#'  class='openLink".$vn_i."' onclick='$(\"#ent".$vn_i."\").slideDown();$(\".openLink".$vn_i."\").hide();$(\".closeLink".$vn_i."\").show();return false;'>".ucwords($va_parent)."<i class='fa fa-angle-up'></i></a>";						
						print "<div id='ent".$vn_i."' style='padding-left:10px; display:none;'>";
							print join('<br/>', $va_page)."<br/>";
						print "</div>";
					print "</div>";
					$vn_i++;
				}
				print "</div>";
			}	
			$vs_sidebar_buf = "";
			$va_opac_by_type = array();
			if ($vs_nysl_links = $t_item->get('ca_entities.entity_opac', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))){

				foreach ($vs_nysl_links as $va_atr_id => $va_nysl_link) {
					$va_opac_by_type[$va_nysl_link['entity_opac_type']][] = $va_nysl_link['entity_opac_URL'];
				}
				if ($va_nysl_link['entity_opac_URL']) {$vs_sidebar_buf.= "<h6>Connect to the New York Society Library Catalog</h6>";}
				foreach ($va_opac_by_type as $va_type => $va_opac_link) {
					foreach ($va_opac_link as $va_key => $va_link) {
						if ($va_type == 'author') {
							$vs_sidebar_buf.= "<a href='".$va_link."' target='_blank'>Books by ".$t_item->get('ca_entities.preferred_labels')."</a><br/>";
						}
						if ($va_type == 'subject') {
							$vs_sidebar_buf.= "<a href='".$va_link."' target='_blank'>Books about ".$t_item->get('ca_entities.preferred_labels')."</a><br/>";
						}
					}							
				}
			}
			if ($t_item->get('ca_entities.resources_link.resources_link_url') && $t_item->get('ca_entities.resources_link.resources_link_description')) {
				$vs_sidebar_buf.= "<br/><div class='unit'><span class='metaTitle'>Connect to Digital Resources From: </span>";
				$vs_sidebar_buf.= "<a href='".$t_item->get('ca_entities.resources_link.resources_link_url')."' target='_blank'>".$t_item->get('ca_entities.resources_link.resources_link_description')."</a>";
				$vs_sidebar_buf.= "</div>";
			} elseif ($t_item->get('ca_entities.resources_link.resources_link_url')) {
				$vs_sidebar_buf.= "<br/><div class='unit'><span class='metaTitle'>Connect to Digital Resources From: </span>";
				$vs_sidebar_buf.= "<a href='".$t_item->get('ca_entities.resources_link.resources_link_url')."' target='_blank'>".$t_item->get('ca_entities.resources_link.resources_link_url')."</a>";
				$vs_sidebar_buf.= "</div>";					
			}
			if ($va_collections = $t_item->get('ca_collections.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
				$vs_sidebar_buf.= "<div class='unit'><H6>Finding Aids</H6>";
				$vs_sidebar_buf.= $va_collections;
				$vs_sidebar_buf.= "</div>";
			}	
			if ($vs_sidebar_buf != "") {
				print "<h5 style='margin-top:30px;'>Learn More</h5>	";	
				print $vs_sidebar_buf;
			}
?>				
							
		</div>
		<div class="content-wrapper">
      		<div class="content-inner">
				<div class="container"><div class="row">
					<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
						<div class="container">
							<div class="row">
								<div class='col-md-12 col-lg-12'>
									<div class="detailNav">
										<div class='left'>
											<div class='resLink'>{{{resultsLink}}}</div>
										</div>
										<div class='right'>
											<div class='prevLink'>{{{previousLink}}}</div>
											<div class='nextLink'>{{{nextLink}}}</div>
										</div>
									</div>
									<H4>
										{{{^ca_entities.preferred_labels.displayname}}}
<?php
										if ($va_life_dates = $t_item->get('ca_entities.life_dates')) {
											print "<small>(".$va_life_dates.")</small>";
										}
?>									
									</H4>
									<H5>{{{<ifdef code="ca_entities.nonpreferred_labels"><i class="fa fa-paperclip"></i>&nbsp;^ca_entities.nonpreferred_labels.displayname}}}</ifdef></H5>
								</div><!-- end col -->
							</div><!-- end row -->
							<div class="row">			
								<div class='col-md-6 col-lg-6'>
								
				<?php

									if ($va_org_dates = $t_item->get('ca_entities.org_dates')) {
										print "<H6 style='padding-bottom:20px;'>".$va_org_dates."</H6>";
									}
									if ($vs_first_date && $vs_last_date) {
										print "<div class='unit'><i>".$t_item->get('ca_entities.relationship_to_library', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))."<br/>Borrowing activity from ".$vs_first_date." - ".$vs_last_date."</i></div>";
									}
									if ($va_buildings = $t_item->get('ca_occurrences.preferred_labels', array('restrictToTypes' => array('building'), 'returnAsLink' => true, 'delimiter' => '<br/>'))) {
										print "<div class='unit'><h6>Library Buildings</h6>".$va_buildings."</div>";
									}
?>						
									<div class='unit trimText'>{{{<ifdef code="ca_entities.biography.biography_text">^ca_entities.biography.biography_text<br/></ifdef>}}}</div>
<?php
									if ($t_item->get('ca_entities.references.references_list')) {
										$va_references = $t_item->get('ca_entities.references', array('delimiter' => '', 'convertCodesToDisplayText' => true, 'template' => '<p style="padding-left:15px;">^references_list page ^references_page</p>'));
										print "<div class='unit'>";
										print "<a href='#' class='openRef' onclick='$(\"#references\").slideDown(); $(\".openRef\").hide(); $(\".closeRef\").show(); return false;'><h6><i class='fa fa-pencil-square-o'></i>&nbsp;Bibliography & Works Cited</h6></a>";
										print "<a href='#' class='closeRef' style='display:none;' onclick='$(\"#references\").slideUp(); $(\".closeRef\").hide(); $(\".openRef\").show(); return false;'><h6><i class='fa fa-pencil-square-o'></i>&nbsp;Bibliography & Works Cited</h6></a>";
										print "<div id='references' style='display:none;'>".$va_references."</div></div>";
									}															
									if ($va_catalog = $t_item->get('ca_objects.preferred_labels', array('restrictToTypes' => array('catalog'), 'returnAsLink' => true, 'delimiter' => '<br/>'))) {
										print "<div class='unit'><h6>Related Catalog</h6>".$va_catalog."</div>";
									}
																																		
?>	
									{{{<ifcount code="ca_collections" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
									{{{<ifcount code="ca_collections" min="2"><H6>Related collections</H6></ifcount>}}}
									{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}						
							
								</div><!-- end col -->
								<div class='col-md-6 col-lg-6'>
								
									<div id="detailTools">
										<div class="detailTool"><a href='#detailComments' onclick='jQuery("#detailComments").slideToggle();return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
										<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
										<div class="detailTool"><span class="glyphicon glyphicon-send"></span><a href='#'>Contribute</a></div><!-- end detailTool -->
									</div><!-- end detailTools -->
																	
									<div class='vizPlaceholder'><i class='fa fa-picture-o'></i></div>
									
									<!--{{{map}}}-->
<?php
									#if ($t_item->get('ca_entities.ind_georeference.city')) {
									#	$va_locations = $t_item->get('ca_entities.ind_georeference', array('returnAsArray' => true, 'convertCodesToDisplayText' => true));
									#	print "<div class='unit'><h6>Locations</h6>";
									#		foreach ($va_locations as $va_key => $va_location) {
									#			if ($va_location['address_dates'] || $va_location['address_types']) {
									#				print $va_location['address_types']." ".$va_location['address_dates']."<br/>";
									#			}
									#			if ($va_location['address1']) {
									#				print $va_location['address1']."<br/>";
									#			}
									#			if ($va_location['city'] || $va_location['stateprovince'] || $va_location['country']) {
									#				print $va_location['city']." ".$va_location['stateprovince']." ".$va_location['country']."<br/>";
									#			}
									#			if ($va_location['address_references']) {
									#				print "Source: ".$va_location['address_references']."<br/>";
									#			}
									#			if ($va_location['ind_address_notes']) {
									#				print $va_location['ind_address_notes'];
									#			}
									#			print "<br/>";																																
									#		}
									#	print "</div>";
									#}						
?>				
								</div><!-- end col -->
							</div><!-- end row -->
						</div><!-- end container -->
						
						<div id='entityTable'>
							<ul class='row'>
<?php
								if ($vs_has_circulation == true) {
									print '<li><a href="#circTab">Borrowing History</a></li>';
									$vs_style = "style='display:block;'";												
								} else {
									$vs_style = "style='display:none;'";
								}
?>								
								<li><a href="#bookTab">Related Books</a></li>
								<li><a href="#entTab">Related People & Organizations</a></li>
								<li><a href="#docTab">Related Documents</a></li>
								
							  </ul>
							<div id='circTab' <?php print $vs_style; ?>>
								<div class='container'>	
									<hr/ style='margin-left:-15px; margin-right:-15px;'>
							
									{{{<ifcount code="ca_objects" min="1">
									<div class="row titleBar">
										<div class='col-sm-3 col-md-3 col-lg-3'>
											Full Title
										</div>
										<div class='col-sm-2 col-md-2 col-lg-2'>
											Volume
										</div>
										<div class='col-sm-2 col-md-2 col-lg-2'>
											Date Out
										</div>
										<div class='col-sm-2 col-md-2 col-lg-2'>
											Date In
										</div>	
										<div class='col-sm-1 col-md-1 col-lg-1'>
											Fine
										</div>		
										<div class='col-sm-2 col-md-2 col-lg-2'>
											Ledger
										</div>
									</div><!-- end row -->
									</ifcount>}}}
		<?php 
									print $vs_buf;								
		?>
								</div><!-- end container -->
							</div><!-- end circTab -->
						
							<div id='entTab' >
								<div class='container'>
									<div class='row'>
										<div class='col-sm-12 col-md-12 col-lg-12'>
	<?php						
										$va_people_by_rels = array();
											if ($va_related_people = $t_item->get('ca_entities', array('returnAsArray' => true, 'sort' => 'ca_entities.type_id'))) {
												
												foreach ($va_related_people as $va_key => $va_related_person) {
													$va_people_by_rels[$va_related_person['relationship_typename']][$va_related_person['entity_id']] = $va_related_person['label'];
												}
												$va_people_links = array();
												foreach ($va_people_by_rels as $va_role => $va_person) {
													print "<div class='row'>";
														print "<a href='#' class='closeLink".$va_role."' onclick='$(\"#ent".$va_role."\").slideUp();$(\".closeLink".$va_role."\").hide();$(\".openLink".$va_role."\").show();return false;'><h6>".ucwords($va_role)."&nbsp;<i class='fa fa-angle-down'></i></h6></a>";
														print "<a href='#' style='display:none;' class='openLink".$va_role."' onclick='$(\"#ent".$va_role."\").slideDown();$(\".openLink".$va_role."\").hide();$(\".closeLink".$va_role."\").show();return false;'><h6>".ucwords($va_role)."&nbsp;<i class='fa fa-angle-up'></i></h6></a>";						
														print "<div id='ent".$va_role."'>";
															foreach ($va_person as $va_entity_id => $va_name) {
																print "<div class='col-sm-3 col-md-3 col-lg-3'><div class='entityButton'>".caNavLink($this->request, $va_name, 'entityName', '', 'Detail', 'entities/'.$va_entity_id)."</div></div>";
															}

														print "</div><!-- end entrole -->";
													print "</div><!-- end row -->";
												}
											}
	?>									
										</div>	<!-- end col -->
									</div>	<!-- end row -->
								</div>	<!-- end container -->		
							</div><!-- end entTab -->
							<div id='bookTab'>
								<div class='container'>
									<div class='row'>
										<div class='col-sm-12 col-md-12 col-lg-12'>
<?php
										$va_books_by_rels = array();
										if ($va_related_books = $t_item->get('ca_objects', array('excludeRelationshipTypes' => array('reader'), 'restrictToTypes' => array('bib'),'returnAsArray' => true))) {
											print "<div class='unit row'>";
											foreach ($va_related_books as $va_key => $va_related_book) {
												$va_books_by_rels[$va_related_book['relationship_typename']][$va_related_book['object_id']] = $va_related_book['label'];
											}
											$va_book_links = array();
											foreach ($va_books_by_rels as $va_role => $va_book) {
												print "<h6>".ucwords($va_role)." of</h6>";
												foreach ($va_book as $va_book_id => $va_title) {
													print "<div class='col-sm-4 col-md-4 col-lg-4'><p class='bookButton'><i class='fa fa-book'></i>&nbsp;".caNavLink($this->request, $va_title, '', '', 'Detail', 'objects/'.$va_book_id)."</p></div>";
												}
											}
											print "</div>";
										}
?>										
										</div><!-- end col -->
									</div><!-- end row -->
								</div><!-- end container -->
							</div><!-- end bookTab -->
							<div id='docTab'>
								<div class='container'>
									<div class='row'>
										<div class='col-sm-12 col-md-12 col-lg-12'>
<?php
										if ($va_documents = $t_item->get('ca_objects.preferred_labels', array('restrictToTypes' => array('document'), 'returnAsLink' => true))) {
											print "<div class='unit'><h6>Related Documents</h6>";
											print $va_documents;
											print "</div>";
										}
?>										
										</div><!-- end col -->
									</div><!-- end row -->
								</div><!-- end container -->
							</div><!-- end docTab -->							
						</div><!-- end entityTable -->
					</div><!-- end col -->
				</div><!-- end row -->
				<div class='row'>
					<div class='col-sm-12 col-md-12 col-lg-12'>
						<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
					</div><!-- end col -->
				</div><!-- end row --></div><!-- end container -->
			</div><!--end content-inner -->
		</div><!--end content-wrapper-->
	</div><!--end wrapper-->
</div><!--end page-->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 135
		});
		$('#entityTable').tabs();
	});
</script>
<script>
	$('a[href^="#"]').on('click', function(event) {

		var target = $( $(this).attr('href') );

		if( target.length ) {
			event.preventDefault();
			$('html, body').animate({
				scrollTop: target.offset().top
			}, 1000);
		}

	});
</script>
