<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_id = $t_item->get('ca_occurrences.occurrence_id');	
	
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
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H4>{{{^ca_occurrences.preferred_labels.name}}}</H4>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-md-6 col-lg-6'>
<?php
				if ($va_author = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author'), 'delimiter' => ', ', 'returnAsLink' => true, 'checkAccess' => $va_access_values))) {
					print "<div class='unit'><h6>Author</h6>".$va_author."</div>";
				}
				if ($va_publisher = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('publisher'), 'delimiter' => ', ', 'returnAsLink' => true, 'checkAccess' => $va_access_values))) {
					print "<div class='unit'><h6>Publisher</h6>".$va_publisher."</div>";
				}
				if ($va_link = $t_item->get('ca_occurrences.links')) {
					print "<div class='unit'><h6>Link</h6><a href='".$va_link."' target='_blank'>".$va_link."</a></div>";
				}
				if ($va_citation = $t_item->get('ca_occurrences.publication_info')) {
					print "<div class='unit'><h6>Citation</h6>".$va_citation."</div>";
				}				
				if ($va_description = $t_item->get('ca_occurrences.description')) {
					print "<div class='unit'><h6>Description</h6>".$va_description."</div>";
				}				
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
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
				<div class='col-md-6 col-lg-6'>
				{{{representationViewer}}}
<?php
				$vs_rel_doc = "";
				if ($va_related_documents = $t_item->get('ca_occurrences.attachment.thumbnail', array('returnWithStructure' => true))) {
					$o_db = new Db();
					$vn_media_element_id = ca_metadata_elements::getElementID('attachment');
					foreach ($va_related_documents as $va_key => $va_related_document_t) {
						foreach ($va_related_document_t as $vn_doc_id => $va_related_document) {
							$qr_res = $o_db->query('SELECT value_id FROM ca_attribute_values WHERE attribute_id = ? AND element_id = ?', array($vn_doc_id, $vn_media_element_id)) ;
							if ($qr_res->nextRow()) {
								$vs_rel_doc.= "<div class='col-sm-3' style='border:1px solid #eee;'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'GetMediaOverlay', 'ca_occurrences', array('context' => 'occurrences', 'id' => $vn_id, 'value_id' => $qr_res->get('value_id')))."\"); return false;'>".$va_related_document['attachment']."</a></div>";
								#$vs_rel_doc.= "<div><a href='#' onclick='caMediaPanel.showPanel(\"/index.php/Detail/GetRepresentationInfo/object_id/".$vn_id."/representation_id/".$qr_res->get('value_id')."/overlay/1\"); return false;'>".$va_related_document['object_document_file']."</a></div>";
							}	 		
						}
					}
				}	
				if ($vs_rel_doc != "") {
					print "<div class='unit row'><h6>Related Documents</h6>";
					print $vs_rel_doc;
					print "</div>";
				}
?>				
					{{{<ifcount code="ca_collections" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><H6>Related collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					
					{{{<ifcount code="ca_occurrences.related" min="1" max="1"><H6>Related occurrence</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences.related" min="2"><H6>Related occurrences</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences.related" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}					
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'occurrence_id:^ca_occurrences.occurrence_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
</ifcount>}}}		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
