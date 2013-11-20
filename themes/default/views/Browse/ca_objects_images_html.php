<?php
	$qr_res 			= $this->getVar('result');				// browse results (subclass of SearchResult)
	$va_facets 			= $this->getVar('facets');				// array of available browse facets
	$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
	$vs_browse_key 		= $this->getVar('key');					// cache key for current browse
	$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
	$vn_hits_per_block 	= (int)$this->getVar('hits_per_block');	// number of hits to display per block
	$vn_start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results

	$vb_ajax			= (bool)$this->request->isAjax();
	
if (!$vb_ajax) {	// !ajax
?>
<div id='pageArea' class='browse'>
	<div id='pageTitle'>
<?php 
		print _t('Browse Objects');
		
		print $this->render("Browse/browse_refine_subview_html.php");	
?>		
	</div>
	<div id='contentArea'>
		<!--<div id='alphaSort'>
			A B C D E F G H I J K L M N O P Q R S T U V W X Y Z <span class='viewAll'>VIEW ALL</span>
		</div>-->
		<div id='sortMenu' class='view'>
<?php
			print caNavLink($this->request, _t('View by image'), '', '*', '*', '*', array('view' => 'image', 'key' => $vs_browse_key));
			print " | ";
			print caNavLink($this->request, _t('View by timeline'), '', '*', '*', '*', array('view' => 'timeline', 'key' => $vs_browse_key));
?>
		</div>
		<div class='clearfix'></div>

	<?php
		if (sizeof($va_criteria) > 0) {
			print "<div class='chosenFacet'>";
			foreach($va_criteria as $va_criterion) {
				print "<span class='chosenFacet'>".$va_criterion['facet'].': '.$va_criterion['value'].'   '."</span>";
			}
			print " (".$qr_res->numHits().")</div>";
			
			print "<div class='startOver'>".caNavLink($this->request, _t('Start over'), '', '*', '*','*', array('clear' => 1))."</div>";
		}
?>
		<div class='browseResults'>
<?php
		} // !ajax
		
	if ($vn_start < $qr_res->numHits()) {
		$vn_c = 0;
		$qr_res->seek($vn_start);
		while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
			print "<div class='browseResult artist'>";
			
			$va_entity_id = $qr_res->get('ca_entities.idno');
			$va_related_objects = $qr_res->get('ca_objects.object_id', array('returnAsArray' => true));
			$va_first_object_id = $va_related_objects[0];
			$t_object = new ca_objects($va_first_object_id);
			
			$va_rep = $t_object->getPrimaryRepresentation('small', null, array("checkAccess" => $va_access_values));
			$va_rep_id = $va_rep['representation_id'];
			$t_object_representation = new ca_object_representations($va_rep_id);
			$vn_image_width = $t_object_representation->getMediaInfo('ca_object_representations.media', 'small', 'WIDTH');

			if ($t_object->get('ca_collections.date.dates_value')){
				$va_dates_value = ", ".$t_object->get('ca_collections.date.dates_value');
			} else {
				$va_dates_value = "";
			}
			
			print "<div class='resultImg'>";
			print $t_object_representation->getMediaTag('ca_object_representations.media', 'small');
			print "</div>";
			
			print "<div class='artworkInfo' style='max-width:500px;'>".caNavLink($this->request, $t_object->get('ca_collections.preferred_labels')."".$va_dates_value, '', '', 'Detail', 'Entities/'.$va_entity_id)."</div>";			
			print "<div class='artistName' style='max-width: 500px;'>".caNavLink($this->request, $qr_res->get('ca_entities.preferred_labels.displayname'), '', '', 'Detail', 'Entities/'.$va_entity_id)."</div>";
			print "</div>";
			
			$vn_c++;
		}
		
		print caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '*', '*', '*', array('s' => $vn_start + $vn_hits_per_block, 'key' => $vs_browse_key));
	}
		if (!$vb_ajax) {	// !ajax
?>
		</div>

	</div><!-- end contentArea-->
</div><!-- end pageArea-->	

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('.browseResults').jscroll({
			autoTrigger: true,
			loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
			padding: 20,
			nextSelector: 'a.jscroll-next'
		});
	});
</script>
<?php
			print $this->render('Browse/browse_panel_subview_html.php');
		} //!ajax
?>