<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$vb_show_hierarchy_viewer = true;
	if($o_collections_config->get("do_not_display_collection_browser")){
		$vb_show_hierarchy_viewer = false;	
	}
	# --- get the collection hierarchy parent to use for exportin finding aid
	$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));

	$va_access_values = caGetUserAccessValues($this->request);
?>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			{{{<ifdef code="ca_collections.preferred_labels.name|ca_collections.collection_subtitle"><H2>^ca_collections.preferred_labels.name<ifdef code="ca_collections.collection_subtitle,ca_collections.preferred_labels.name">: </ifdef>^ca_collections.collection_subtitle</H2></ifdef>}}}
		</div>
	</div>

	<div class="row topicRelatedObjects">
		<div id="browseResultsContainer">
			<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
		</div><!-- end browseResultsContainer -->
		<p class="text-center">
			<?php print caNavLink($this->request, 'View All', 'btn btn-default', '', 'Browse', 'topicObjects', array('facet' => 'topic_collection_facet', 'id' => $t_item->get("ca_collections.collection_id"), 'view' => 'images'));?>
		</p>
	</div><!-- end row -->
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'topicObjects', array('facet' => 'topic_collection_facet', 'id' => $t_item->get("ca_collections.collection_id"), 'limit_num_results' => 8, 'view' => 'images', 'sort' => 'Title'), array('dontURLEncodeParameters' => true)); ?>", function() {
				/*
				Only want to show a few with link to all so just don't jscroll the results
				jQuery("#browseResultsContainer").jscroll({
					autoTrigger: true,
					loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
					padding: 20,
					nextSelector: "a.jscroll-next"
				});*/
				jQuery('.jscroll-next').hide();
			});
			
			
		});
	</script>		
<?php
	if($vs_show_slideshow && ($va_rep_ids = $t_item->get("ca_object_representations.representation_id", array("checkAccess" => $va_access_values, "returnAsArray" => true)))){
?>		
			<div class="row">
				<div class="col-sm-12">
					<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
<?php
					$vn_num_slides = sizeof($va_rep_ids);
					if($vn_num_slides > 1){
						print "<ol class='carousel-indicators'>";
						for($i = 0; $i < $vn_num_slides; $i++){
							print '<li data-target="#carouselExampleIndicators" data-slide-to="'.$i.'" '.(($i == 0) ? 'class="active"' : '').'></li>';
						}
						print "</ol>";					
					}
?>
					  <div class="carousel-inner">
<?php
						$t_rep = new ca_object_representations();
						$vb_output;
						foreach($va_rep_ids as $va_rep_id){
							$t_rep->load($va_rep_id);
?>
							<div class="item <?php print (!$vb_output) ? "active" : ""; ?>">
<?php 
								$vb_output = true;
								$vs_img = $t_rep->get("ca_object_representations.media.page");
								print str_replace("<img ", "<img class='d-block w-100' ", $vs_img);
								$vs_label = $t_rep->get("ca_object_representations.preferred_labels.name");
								if($vs_label){
?>
								<div class="carousel-caption d-none d-md-block">
								  <?php print $vs_label; ?>
								</div>
<?php
								}
?>
							</div>

<?php
						}
?>
														
					  </div>
					  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					  </a>
					  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					  </a>
					</div>
				</div>
			</div>
<?php
	}
?>		
			<div class="row">
				<div class='col-sm-12'>
					{{{<ifdef code="ca_collections.funder_logo"><div class="topicCollectionFunder">^ca_collections.funder_logo.small</div></ifdef>}}}
					{{{<ifdef code="ca_collections.about_objects"><div class="unit"><b>About the Objects</b><br/>^ca_collections.about_objects</div></ifdef>}}}
					{{{<ifdef code="ca_collections.topic_overview"><div class="unit"><b>Overview</b><br/>^ca_collections.topic_overview</ifdef></ifdef>}}}
					{{{<ifdef code="ca_collections.topic_related_resources"><div class="unit"><b>Related Resources</b><br/>^ca_collections.topic_related_resources</ifdef></ifdef>}}}
					{{{<ifcount code="ca_collections.children" min="1"><div class="unit"><H3>Related Series</H3><unit relativeTo="ca_collections.children" delimiter="<br/>" sort="ca_collections.preferred_labels" sortDirection="desc"><l>^ca_collections.preferred_labels.name</l></unit></ifdef></ifcount>}}}
					
				</div><!-- end col -->
			</div><!-- end row -->


		</div><!-- end container -->
