<?php
	$qr_res 			= $this->getVar('result');				// browse results (subclass of SearchResult)
	$va_facets 			= $this->getVar('facets');				// array of available browse facets
	$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
	$vs_browse_key 		= $this->getVar('key');					// cache key for current browse
	$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
	$vn_hits_per_block 	= (int)$this->getVar('hits_per_block');	// number of hits to display per block
	$vn_start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results

	$vb_ajax			= (bool)$this->request->isAjax();
	
	AssetLoadManager::register('timeline');
if (!$vb_ajax) {	// !ajax
?>
<div id='browseResults'>
	<div id="bViewButtons">
<?php
		print caNavLink($this->request, '<span class="glyphicon glyphicon-th"></span>', '', '*', '*', '*', array('view' => 'image', 'key' => $vs_browse_key));
		print " ";
		print caNavLink($this->request, '<span class="glyphicon glyphicon-time"></span>', 'active', '*', '*', '*', array('view' => 'timeline', 'key' => $vs_browse_key));
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
<?php
		} // !ajax
		
		
?>

<div id="timeline-embed"></div>
    <script>
		$(document).ready(function() {
			createStoryJS({
				type:       'timeline',
				width:      '800',
				height:     '600',
				source:     '<?php print caNavUrl($this->request, '*', '*', '*', array('view' => 'timelineData', 'key' => $vs_browse_key)); ?>',
				embed_id:   'timeline-embed'
			});
		});
	</script>

<?php
		if (!$vb_ajax) {	// !ajax
?>
		</div>

		</div><!-- end col-10 -->
		<div class="col-sm-4 col-md-3 col-lg-2">
<?php
			print $this->render("Browse/browse_refine_subview_html.php");
?>			
		</div><!-- end col-2 -->
	</div><!-- end row -->
</div><!-- end browseResults -->
<?php
		} //!ajax
?>