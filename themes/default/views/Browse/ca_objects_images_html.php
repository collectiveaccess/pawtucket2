<?php
	$qr_res 			= $this->getVar('result');				// browse results (subclass of SearchResult)
	$va_facets 			= $this->getVar('facets');				// array of available browse facets
	$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
	$vs_browse_key 		= $this->getVar('key');					// cache key for current browse
	$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
	$vn_hits_per_block 	= (int)$this->getVar('hits_per_block');	// number of hits to display per block
	$vn_start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results
	$vs_view			= $this->getVar('view');

	$vb_ajax			= (bool)$this->request->isAjax();
	
if (!$vb_ajax) {	// !ajax
?>
<div id='browseResults'>
	<div id="bViewButtons">
<?php
		print caNavLink($this->request, '<span class="glyphicon glyphicon-th"></span>', 'active', '*', '*', '*', array('view' => 'image', 'key' => $vs_browse_key));
		print " ";
		print caNavLink($this->request, '<span class="glyphicon glyphicon-time"></span>', '', '*', '*', '*', array('view' => 'timeline', 'key' => $vs_browse_key));
?>
	</div>		
	<H1>
<?php 
		print _t('%1 Object %2', $qr_res->numHits(), ($qr_res->numHits() == 1) ? "Result" : "Results");	
?>		
		<div class="btn-group">
			<i class="fa fa-gear bGear" data-toggle="dropdown"></i>
			<ul class="dropdown-menu" role="menu">
				<!--<li class="divider"></li>-->
<?php
				if (sizeof($va_criteria) > 0) {
					print "<li><a href='".caNavUrl($this->request, '', '*', '*', array('view' => $vs_view))."' >"._t("Start Over")."</a></li>";
				}	
?>
			</ul>
		</div><!-- end btn-group -->
	</H1>
	<div class="row" style="clear:both;">
		<div class='col-sm-8 col-md-9 col-lg-10'>
			<H2>
<?php
			if (sizeof($va_criteria) > 0) {
				$i = 0;
				foreach($va_criteria as $va_criterion) {
					print "<strong>".$va_criterion['facet'].':</strong> '.$va_criterion['value'];
					$i++;
					if($i < sizeof($va_criteria)){
						print ", ";
					}
				}
			}
?>		
			&nbsp;</H2>
			<div class="row">
				<div id="browseResultsContainer">
<?php
} // !ajax
			
		$vn_col_span = 3;
		$vn_col_span_sm = 4;
		$vn_col_span_sm = 2;
		$vb_refine = false;
		if(is_array($va_facets) && sizeof($va_facets)){
			$vb_refine = true;
			$vn_col_span = 3;
			$vn_col_span_sm = 6;
			$vn_col_span_xs = 6;
		}
		if ($vn_start < $qr_res->numHits()) {
			$vn_c = 0;
			$qr_res->seek($vn_start);
			while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
				$va_rep_id = $qr_res->get('ca_object_representations.representation_id');
				$t_object_representation = new ca_object_representations($va_rep_id);
				$vn_image_width = $t_object_representation->getMediaInfo('ca_object_representations.media', 'small', 'WIDTH');
				print "<div class='bResultItemCol col-xs-".$vn_col_span_xs." col-sm-".$vn_col_span_sm." col-md-".$vn_col_span."'>\n";
				print "<div class='bResultItem' onmouseover='jQuery(\"#bResultItemExpandedInfo".$qr_res->get("ca_objects.object_id")."\").show();'  onmouseout='jQuery(\"#bResultItemExpandedInfo".$qr_res->get("ca_objects.object_id")."\").hide();'>";
				print "<div class='bResultItemContent'><div class='text-center bResultItemImg'>".caDetailLink($this->request, $t_object_representation->getMediaTag('ca_object_representations.media', 'small'), '', 'ca_objects', $qr_res->get("ca_objects.object_id"))."</div>\n";
				print "<div class='bResultItemText'>";
				print "<small>".caDetailLink($this->request, $qr_res->get('ca_objects.idno'), '', 'ca_objects', $qr_res->get("ca_objects.object_id"))."</small><br/>\n";
				print caDetailLink($this->request, $qr_res->get('ca_objects.preferred_labels.name'), '', 'ca_objects', $qr_res->get("ca_objects.object_id"))."\n";
				print "</div><!-- end bResultItemText -->";
				print "</div><!-- end bResultItemContent -->\n";
				print "<div class='bResultItemExpandedInfo' id='bResultItemExpandedInfo".$qr_res->get("ca_objects.object_id")."'><hr>expanded info here<br/>more info here<br/><br/><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Sets', 'addItemForm', array("object_id" => $qr_res->get("ca_objects.object_id")))."\"); return false;' title='add to lightbox'><span class='glyphicon glyphicon-folder-open'></span></a></div><!-- bResultItemExpandedInfo -->";
				print "</div><!-- end bResultItem -->\n";
				print "</div><!-- end col -->";
				$vn_c++;
			}
			
			print caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '*', '*', '*', array('s' => $vn_start + $vn_hits_per_block, 'key' => $vs_browse_key));
		}
if (!$vb_ajax) {	// !ajax
?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
		</div><!-- end col-10 -->
		<div class="col-sm-4 col-md-3 col-lg-2">
<?php
			print $this->render("Browse/browse_refine_subview_html.php");
?>			
		</div><!-- end col-2 -->
	</div><!-- end row -->
</div><!-- end browseResults -->	

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#browseResultsContainer').jscroll({
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