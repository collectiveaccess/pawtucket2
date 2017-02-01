<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
?>
<div class="container">
<div class="row">
	<div class='col-xs-12 objNav'><!--- only shown at small screen size -->
		<div class='resultsLink'>{{{resultsLink}}}</div><div class='previousLink'>{{{previousLink}}}</div><div class='nextLink'>{{{nextLink}}}</div>
	</div><!-- end detailTop -->
</div>
<div class="row">
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
<?php
		if ($vs_type = $t_item->get('ca_occurrences.type_id', array('convertCodesToDisplayText' => true))) {
			print "<h6 class='leader'>".$vs_type."</h6>";
		}
		print "<h1>".$t_item->get('ca_occurrences.preferred_labels')."</h1>";
		
		if ($va_authors = $t_item->get('ca_entities.entity_id', array('restrictToRelationshipTypes' => array('author'), 'returnAsArray' => true))) {
			print "<div class='unit'>";
			foreach ($va_authors as $va_key => $va_author) {
				$t_author = new ca_entities($va_author);
				print caNavLink($this->request, $t_author->get('ca_entities.preferred_labels'), '', 'Search', 'references', 'search/ca_entities.entity_id:'.$va_author)."<br/>";
			}
			print "</div>";
		}
		if ($va_publishers = $t_item->get('ca_entities.entity_id', array('restrictToRelationshipTypes' => array('publisher'), 'returnAsArray' => true))) {
			print "<div class='unit'>";
			foreach ($va_publishers as $va_key => $va_publisher) {
				$t_publisher = new ca_entities($va_publisher);
				print caNavLink($this->request, $t_publisher->get('ca_entities.preferred_labels'), '', 'Search', 'references', 'search/ca_entities.entity_id:'.$va_publisher)."<br/>";
			}
			print "</div>";
		}
		if ($va_institutions = $t_item->get('ca_entities.entity_id', array('restrictToRelationshipTypes' => array('institution'), 'returnAsArray' => true))) {
			print "<div class='unit'>";
			foreach ($va_institutions as $va_key => $va_institution) {
				$t_institution = new ca_entities($va_institution);
				print caNavLink($this->request, $t_institution->get('ca_entities.preferred_labels'), '', 'Search', 'references', 'search/ca_entities.entity_id:'.$va_institution)."<br/>";
			}
			print "</div>";
		}
		if ($va_date = $t_item->get('ca_occurrences.occurrence_dates')) {
			print "<div class='unit'>".caNavLink($this->request, $va_date, '', 'Search', 'references', 'search/ca_occurrences.occurrence_dates:"'.$va_date.'"')."</div>";
		}						
		
		if ($vs_remarks = $t_item->get('ca_occurrences.occurrence_notes')) {
			print "<div class='drawer' style='padding-top:0px;'>".$vs_remarks."</div>";
		}		

?>
	</div>
</div><!-- end row -->	
<div class="row">
	<div class="col-sm-1 col-md-1 col-lg-2"></div>
	<div class="col-sm-10 col-md-10 col-lg-8">{{{representationViewer}}}</div>
	<div class="col-sm-1 col-md-1 col-lg-2"></div>
</div>
<div class="row">
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
<?php
		
?>		
	</div>
</div>	
<div class="row">
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
<?php
		if ($vs_exhibitions = $t_item->getWithTemplate('<unit restrictToTypes="exhibition" delimiter="<br/>" relativeTo="ca_occurrences.related"><l>^ca_occurrences.preferred_labels</l><unit relativeTo="ca_entities" restrictToRelationshipTypes="venue">, ^ca_entities.preferred_labels<ifdef code="ca_entities.address.city">, ^ca_entities.address.city</ifdef><ifdef code="ca_entities.address.state">, ^ca_entities.address.state</ifdef><ifdef code="ca_entities.address.country">, ^ca_entities.address.country</ifdef></unit><ifdef code="ca_occurrences.display_date">, ^ca_occurrences.display_date</ifdef><if rule="^ca_occurrences.exhibition_origination =~ /yes/"> (originating institution)</ifdef></unit>')) {
			print "<div class='drawer'>";
			print "<h6><a href='#' onclick='$(\"#exhibitionDiv\").toggle(400);return false;'>Exhibitions <i class='fa fa-chevron-down'></i></a></h6>";
			print "<div id='exhibitionDiv'>".$vs_exhibitions."</div>";
			print "</div>";
		}
?>		
	</div>
</div>
<div class='row'>
	<div class='col-sm-12 col-md-12 col-lg-12'>
<?php
		if ($vs_reference = $t_item->getWithTemplate('<unit restrictToTypes="reference" delimiter="<br/>" relativeTo="ca_occurrences.related"><l>^ca_occurrences.preferred_labels<ifdef code="ca_occurrences.nonpreferred_labels">, ^ca_occurrences.nonpreferred_labels, </ifdef></l><unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="author">^ca_entities.preferred_labels</unit><ifdef code="ca_occurrences.display_date">, ^ca_occurrences.display_date</ifdef></unit>')) {
			print "<div class='drawer'>";
			print "<h6><a href='#' onclick='$(\"#referenceDiv\").toggle(400);return false;'>Related References <i class='fa fa-chevron-down'></i></a></h6>";
			print "<div id='referenceDiv'>".$vs_reference."</div>";
			print "</div>";
		}
?>		
	</div>
</div><!-- end row -->
{{{<ifcount code="ca_objects" relativeTo="ca_objects" restrictToTypes="side" min="1">
	<div class="row"><div class='col-sm-12'>
	
		<div id="browseResultsContainer">
			<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
		</div><!-- end browseResultsContainer -->
	</div><!-- end col --></div><!-- end row -->
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'artworks', array('search' => 'occurrence_id:^ca_occurrences.occurrence_id', 'detailNav' => 1), array('dontURLEncodeParameters' => true)); ?>", function() {
				jQuery('#browseResultsContainer').jscroll({
					autoTrigger: true,
					loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
					padding: 20,
					nextSelector: 'a.jscroll-next'
				});
			});
			
			
		});
	</script>
</ifcount>}}}		

</div>