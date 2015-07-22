<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
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
				<div class='col-md-12 col-lg-12'>
					<H4>{{{^ca_entities.preferred_labels.displayname}}}</H4>
					<H4>{{{^ca_entities.nonpreferred_labels.displayname}}}</H4>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-md-6 col-lg-6'>
					<H6 style='padding-bottom:20px;'>{{{^ca_entities.life_dates}}}</H6>
					<div class='unit'>{{{<ifdef code="ca_entities.country_origin"><span class='metaTitle'>Country of Origin: </span>^ca_entities.country_origin</ifdef>}}}</div>
					<div class='unit'>{{{<ifdef code="ca_entities.gender"><span class='metaTitle'>Gender: </span>^ca_entities.gender</ifdef>}}}</div>
<?php
					if ($vs_occupations = $t_item->get('ca_entities.industry_occupations', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))) {
						print "<div class='unit'><span class='metaTitle'>Occupation: </span>";
						print $vs_occupations;
						print "</div>";
					}
?>						
					<div class='unit'>{{{<ifdef code="ca_entities.biography.biography_text"><H6>Biography</H6>^ca_entities.biography.biography_text<br/></ifdef>}}}</div>
<?php
					if ($t_item->get('ca_entities.resources_link.resources_link_url') && $t_item->get('ca_entities.resources_link.resources_link_description')) {
						print "<br/><div class='unit'><span class='metaTitle'>External Resource: </span>";
						print "<a href='".$t_item->get('ca_entities.resources_link.resources_link_url')."'>".$t_item->get('ca_entities.resources_link.resources_link_description')."</a>";
						print "</div>";
					} elseif ($t_item->get('ca_entities.resources_link.resources_link_url')) {
						print "<br/><div class='unit'><span class='metaTitle'>External Resource: </span>";
						print "<a href='".$t_item->get('ca_entities.resources_link.resources_link_url')."'>".$t_item->get('ca_entities.resources_link.resources_link_url')."</a>";
						print "</div>";					
					}
?>	
					{{{<ifcount code="ca_entities.related" min="1" max="1"><H6>Related person</H6></ifcount>}}}
					{{{<ifcount code="ca_entities.related" min="2"><H6>Related people</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities.related" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
									

					
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
<?php
					if ($t_item->get('ca_object_representations')) {
						$va_rep = $t_item->getPrimaryRepresentation(array('large'), null, array('return_with_access' => $va_access_values, 'tagsOnly' => true));
						print "<div class='entityThumb'>".$va_rep['tags']['large']."</div>";
					}
?>
					<div id="detailTools">
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
						<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
					</div><!-- end detailTools -->
									
					{{{<ifcount code="ca_collections" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><H6>Related collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}
					

					{{{<ifcount code="ca_occurrences" min="1" max="1"><H6>Related occurrence</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="2"><H6>Related occurrences</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}				
				</div><!-- end col -->
			</div><!-- end row -->
			<hr/>
{{{<ifcount code="ca_objects" min="2">
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
						//print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); 
						
			$va_rel_ids = $t_item->get('ca_objects_x_entities.relation_id', array('returnAsArray' => true));
			$qr_rels = caMakeSearchResult('ca_objects_x_entities', $va_rel_ids, array('sort' => 'ca_objects_x_entities.date_out'));
			
			// set all of the page object_ids
			$va_page_ids = array();
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
			while($qr_rels->nextHit()) {
				if ($qr_rels->get('ca_objects.type_id') == $vn_page_type_id) { continue; }
				print "<div class='row ledgerRow'>";
					print "<div class='col-xs-3 col-sm-3 col-md-3 col-lg-3' id='book".$vn_i."'>";
						if ($qr_rels->get("ca_objects.parent.preferred_labels")) {
							$va_label_trunk = explode(':', $qr_rels->get("ca_objects.parent.preferred_labels"));
							print caNavLink($this->request, $va_label_trunk[0], '', '', 'Detail', 'objects/'.$qr_rels->get("ca_objects.parent.object_id"));
						} else {
							$va_label_trunk = explode(':', $qr_rels->get("ca_objects.preferred_labels"));
							print caNavLink($this->request, $va_label_trunk[0], '', '', 'Detail', 'objects/'.$qr_rels->get("ca_objects.object_id"));
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
				
					print "</div>";
			
					print "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
					if ($qr_rels->get("ca_objects.parent.preferred_labels")) {
						print $qr_rels->get("ca_objects.preferred_labels.displayname", array('returnAsLink' => true));
					}
					print "</div>";	
					
					print "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
					print $qr_rels->get("ca_objects_x_entities.date_out");
					print "</div>";

					print "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
					print $qr_rels->get("ca_objects_x_entities.date_in");
					print "</div>";
											
					print "<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>";
					print $qr_rels->get("ca_objects_x_entities.fine");
					print "</div>";
					
					print "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
					print $va_parents[$qr_rels->get("ca_objects_x_entities.see_original_link", array('idsOnly' => true))]." ".$qr_rels->get("ca_objects_x_entities.see_original_link", array('returnAsLink' => true));
					print "</div>";													
				print "</div>";
				
				$vn_i++;
			}
						
					?>
			<script type="text/javascript">
//				jQuery(document).ready(function() {
//					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'entity_id:^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
//						jQuery('#browseResultsContainer').jscroll({
//							autoTrigger: true,
//							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
//							padding: 20,
//							nextSelector: 'a.jscroll-next'
//						});
//					});					
//				});
			</script>
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->