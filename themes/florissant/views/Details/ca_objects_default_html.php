<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
	#
	# Sharing/Social Information
	#
	$vn_share_enabled = $this->getVar("shareEnabled");
	$og_title = $t_object->get('ca_objects.preferred_labels');
	if($t_object->get('ca_objects.taxonomy_specimen.scientific_name')){
		$og_title = $t_object->get('ca_objects.taxonomy_specimen.scientific_name').' ('.$og_title.')';
	}
	$va_primaryMedia = $t_object->getPrimaryRepresentationInstance();
	$vs_share_link = "http://idigpaleo.whirl-i-gig.com".caDetailUrl($this->request, 'ca_objects', $t_object->get('object_id'), '', '', array('absolute' => true));
	if($va_primaryMedia){
		$va_repInfo = $va_primaryMedia->getMediaInfo('media', 'large');
		$vs_repLink = 'http://idigpaleo.whirl-i-gig.com/media/idigpaleo/images/'.$va_repInfo['HASH'].'/'.$va_repInfo['MAGIC'].'_'.$va_repInfo['FILENAME'];
	}
	#Facebook and Twitter Tags
	MetaTagManager::addMeta('og:url', $vs_share_link);
	if($va_primaryMedia){
		MetaTagManager::addMeta('og:image', $vs_repLink);
		MetaTagManager::addMeta('og:image:width', $va_repInfo['WIDTH']);
		MetaTagManager::addMeta('og:image:height', $va_repInfo['HEIGHT']);
	}
	MetaTagManager::addMeta('og:title', $og_title);
	MetaTagManager::addMeta('fb:app_id', '1818796581723078');
	MetaTagManager::addMeta('og:description', 'A fossil from the Cretaceous World project');
	MetaTagManager::addMeta('twitter:card', 'summary_large_image');
	MetaTagManager::addMeta('twitter:site', '@FossilInsectTCN');
	MetaTagManager::addMeta('twitter:image:alt', 'Image of '.$va_voucher);
?>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1818796581723078',
      xfbml      : true,
      version    : 'v2.8'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
<div role="main">
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
					<!-- Print out buttons to jump to different metadata sections -->
					<div class="row">
						<div class="col-sm-8">
							<h6 class="jumpLinks">Jump To:</h6>
							<h6 id="taxonJump" class="jumpLinks"><a href="#taxonomy">Taxonomy</a></h6>
							<h6 id="collectionJump" class="jumpLinks"><a href="#related">Collection Info</a></h6>
						</div>
						<div class="col-sm-4 text-right shareLinks">
								<h6>SHARE {{{shareLink}}} <a href="https://twitter.com/intent/tweet?text=<?php print $vs_subject; ?>&url=<?php print urlencode($vs_share_link); ?>&via=fossilInsectTCN"><i class="fa fa-twitter" aria-label="twitter"></i></a> <a href="https://www.facebook.com/dialog/share?app_id=1818796581723078&quote=<?php print $og_title; ?>&href=<?php print urlencode($vs_share_link); ?>&href=<?php print $vs_share_link; ?>&display=iframe"><i class="fa fa-facebook" aria-label="facebook"></i></a></h6>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 headerLine">
							<hr/>
						</div>
					</div>
					<div class="row">	
						<div class="col-xs-6">
		<!--Scientific Name-->
							<?php
							$va_taxonomy = $t_object->get("ca_objects.taxonomy_specimen", ["returnWithStructure" => true]);
							foreach($va_taxonomy as $va_container){
								foreach($va_container as $va_hierarchy){
									foreach(['scientific_name', 'genus', 'subgenus', 'subfamily', 'family', 'superfamily', 'suborder', 'order', 'subclass', 'class', 'subphylum', 'phylum', 'kingdom'] as $vs_name){
										if($va_hierarchy[$vs_name] && $va_hierarchy[$vs_name] != ' '){
											$vs_displayName = $va_hierarchy[$vs_name];
											if($vs_name == 'scientific_name'){
												$vs_displayName = '<em>'.$vs_displayName.'</em>';
											}
											break;
										}
									}
								}
							}
							?>
							<H4><?php print $vs_displayName; ?></ifdef></H4>
		<!--Vernacular Name-->
							<H5 class="headingVernacularName">{{{<ifdef code="ca_objects.taxonomy_specimen.vernacular_name"><a href="^ca_objects.taxonomy_specimen.vernacular_url" target="_blank">^ca_objects.taxonomy_specimen.vernacular_name</a></ifdef>}}}</H5>
						</div>
						<div class="col-xs-6 text-right">
							<!--idno/catalog no-->
							{{{<ifdef code="ca_objects.preferred_labels"><h5 class="headingInfoRight">^ca_objects.preferred_labels</h5></ifdef>}}}
							<!--Source Institutions-->
							{{{<ifdef code="ca_objects.source_id"><h5 class="headingInfoRight">^ca_objects.source_id</h5></ifdef>}}}
						</div>
					</div>
				</div>
			</div>
			<?php if($t_object->getRepresentationCount()){ ?>
				<div class="row">
					<div class='col-sm-10 col-sm-offset-1'>
						{{{representationViewer}}}
						<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-2 col-md-2 col-xs-2", "version" => "iconlarge")); ?>
						
					</div><!-- end col -->
				</div>
			<?php } ?>
			<div class="row">
				<div class="col-sm-12">
					<hr/>
				</div>
			</div>					
			<div class="row">
				<div class="col-xs-6 col-sm-4 specimenInfoColumn">
					<h3>Taxonomy</h3><a name='taxonomy'></a>
					<div class="row taxonDisplay">
						<div class="col-xs-6 col-sm-5">
							<strong>Kingdom</strong>
						</div>
						<div class="col-xs-6 col-sm-7">
							{{{^ca_objects.taxonomy_specimen.kingdom}}}
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-6 col-sm-5">
							<strong>Phylum</strong>
						</div>
						<div class="col-xs-6 col-sm-7">
							{{{^ca_objects.taxonomy_specimen.phylum}}}
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-6 col-sm-5">
							<strong>Subphylum</strong>
						</div>
						<div class="col-xs-6 col-sm-7">
							{{{^ca_objects.taxonomy_specimen.subphylum}}}
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-6 col-sm-5">
							<strong>Class</strong>
						</div>
						<div class="col-xs-6 col-sm-7">
							{{{^ca_objects.taxonomy_specimen.class}}}
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-6 col-sm-5">
							<strong>Subclass</strong>
						</div>
						<div class="col-xs-6 col-sm-7">
							{{{^ca_objects.taxonomy_specimen.subclass}}}
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-6 col-sm-5">
							<strong>Order</strong>
						</div>
						<div class="col-xs-6 col-sm-7">
							{{{^ca_objects.taxonomy_specimen.order}}}
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-6 col-sm-5">
							<strong>Suborder</strong>
						</div>
						<div class="col-xs-6 col-sm-7">
							{{{^ca_objects.taxonomy_specimen.suborder}}}
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-6 col-sm-5">
							<strong>Superfamily</strong>
						</div>
						<div class="col-xs-6 col-sm-7">
							{{{^ca_objects.taxonomy_specimen.superfamily}}}
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-6 col-sm-5">
							<strong>Family</strong>
						</div>
						<div class="col-xs-6 col-sm-7">
							{{{^ca_objects.taxonomy_specimen.family}}}
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-6 col-sm-5">
							<strong>Subfamily</strong>
						</div>
						<div class="col-xs-6 col-sm-7">
							{{{^ca_objects.taxonomy_specimen.subfamily}}}
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-6 col-sm-5">
							<strong>Genus</strong>
						</div>
						<div class="col-xs-6 col-sm-7">
							{{{^ca_objects.taxonomy_specimen.genus}}}
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-6 col-sm-5">
							<strong>Subgenus</strong>
						</div>
						<div class="col-xs-6 col-sm-7">
							{{{^ca_objects.taxonomy_specimen.subgenus}}}
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-6 col-sm-5">
							<strong>Species</strong>
						</div>
						<div class="col-xs-6 col-sm-7">
							{{{^ca_objects.taxonomy_specimen.species}}}
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-6 col-sm-5">
							<strong>Scientific Name</strong>
						</div>
						<div class="col-xs-6 col-sm-7">
							{{{^ca_objects.taxonomy_specimen.scientific_name}}}
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-6 col-sm-5">
							<strong>Authorship</strong>
						</div>
						<div class="col-xs-6 col-sm-7">
							{{{^ca_objects.taxonomy_specimen.scientific_authorship}}}
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-sm-4 specimenInfoColumn">
					<h3>Florissant</h3>
					<h4>Chronostratigraphy</h4>
					<div class="row taxonDisplay">
						<div class="col-xs-6 col-sm-5">
							<strong>Period</strong>
						</div>
						<div class="col-xs-6 col-sm-7">
							Paleogene
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-6 col-sm-5">
							<strong>Epoch</strong>
						</div>
						<div class="col-xs-6 col-sm-7">
							Eocene
						</div>
					</div>
					<h5>Lithostratigraphy</h5>
					<div class="row taxonDisplay">
						<div class="col-xs-6 col-sm-5">
							<strong>Formation</strong>
						</div>
						<div class="col-xs-6 col-sm-7">
							Florissant
						</div>
					</div>
					<h5>Locality</h5>
					<div class="row taxonDisplay">
						<div class="col-xs-6 col-sm-5">
							<strong>State</strong>
						</div>
						<div class="col-xs-6 col-sm-7">
							Colorado
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-6 col-sm-5">
							<strong>County</strong>
						</div>
						<div class="col-xs-6 col-sm-7">
							Teller
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-6 col-sm-5">
							<strong>Locality</strong>
						</div>
						<div class="col-xs-6 col-sm-7">
							{{{^ca_objects.locality_specimen.locality}}}
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 specimenInfoColumnRight hidden-xs">
					<h3>Other Information</h3>
					
					<h4>Collection</h4>
					<div class="row taxonDisplay">
						<div class="col-xs-4 col-sm-5">
							<strong>Collector</strong>
						</div>
						<div class="col-xs-8 col-sm-7">
							<?php print $t_object->get("ca_entities.preferred_labels", array('delimiter' => ', ', 'restrictToRelationshipTypes' => array('collector'))); ?>
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-4 col-sm-5">
							<strong>Identifier</strong>
						</div>
						<div class="col-xs-8 col-sm-7">
							<?php print $t_object->get("ca_entities.preferred_labels", array('delimiter' => ', ', 'restrictToRelationshipTypes' => array('identifier'))); ?>
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-4 col-sm-5">
							<strong>Provider</strong>
						</div>
						<div class="col-xs-8 col-sm-7">
							<?php print $t_object->get("ca_entities.preferred_labels", array('delimiter' => ', ', 'restrictToRelationshipTypes' => array('provider'))); ?>
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-4 col-sm-5">
							<strong>Date Identified</strong>
						</div>
						<div class="col-xs-8 col-sm-7">
							{{{^ca_objects.date_identified}}}
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-4 col-sm-5">
							<strong>Type Status</strong>
						</div>
						<div class="col-xs-8 col-sm-7">
							{{{^ca_objects.type_status}}}
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-4 col-sm-5">
							<strong>Element</strong>
						</div>
						<div class="col-xs-8 col-sm-7">
							{{{^ca_objects.element}}}
						</div>
					</div>	
					<div class="row">
						<div class="col-xs-12">
							{{{<ifdef code="ca_objects.related_publications"><h5>Original Reference</h5></ifdef>}}}
							{{{^ca_objects.related_publications}}}
						</div>
					</div>	
				<a name='related'></a>
<?php
					if($rel_objs = $t_object->get("ca_objects.related", ['returnAsArray' => true, 'returnAsLink' => true])){
						print "<h5>Related Objects</h5>";
						$row_count = 0;
						print "<div class='row'>";
					
						foreach($rel_objs as $obj){
							print "<div class='col-xs-6'>{$obj}</div>";
							$row_count++;
							if($row_count == 2){
								print "</div><div class='row'>";
								$row_count = 0;
							}
						}
						print "</div>";
					}		
?>				
				</div>
			</div><!-- end row -->
			<div class="row">
				<div class="col-xs-12 col-sm-4 specimenInfoColumnRight visible-xs">
					<hr/>
					<h3>Other Information</h3>
					
					<h5>Collection</h5>
					<div class="row taxonDisplay">
						<div class="col-xs-4 col-sm-5">
							<strong>Collector</strong>
						</div>
						<div class="col-xs-8 col-sm-7">
							<?php print $t_object->get("ca_entities.preferred_labels", array('delimiter' => ', ', 'restrictToRelationshipTypes' => array('collector'))); ?>
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-4 col-sm-5">
							<strong>Identifier</strong>
						</div>
						<div class="col-xs-8 col-sm-7">
							<?php print $t_object->get("ca_entities.preferred_labels", array('delimiter' => ', ', 'restrictToRelationshipTypes' => array('identifier'))); ?>
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-4 col-sm-5">
							<strong>Provider</strong>
						</div>
						<div class="col-xs-8 col-sm-7">
							<?php print $t_object->get("ca_entities.preferred_labels", array('delimiter' => ', ', 'restrictToRelationshipTypes' => array('provider'))); ?>
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-4 col-sm-5">
							<strong>Date Identified</strong>
						</div>
						<div class="col-xs-8 col-sm-7">
							{{{^ca_objects.date_identified}}}
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-4 col-sm-5">
							<strong>Type Status</strong>
						</div>
						<div class="col-xs-8 col-sm-7">
							{{{^ca_objects.type_status}}}
						</div>
					</div>
					<div class="row taxonDisplay">
						<div class="col-xs-4 col-sm-5">
							<strong>Element</strong>
						</div>
						<div class="col-xs-8 col-sm-7">
							{{{^ca_objects.element}}}
						</div>
					</div>					
					<div class="row">
						<div class="col-xs-12">
							{{{<ifdef code="ca_objects.related_publications"><h5>Original Reference</h5></ifdef>}}}
							{{{^ca_objects.related_publications}}}
						</div>
					</div>	
				<a name='related'></a>
<?php
					if($rel_objs = $t_object->get("ca_objects.related", ['returnAsArray' => true, 'returnAsLink' => true])){
						print "<h5>Related Objects</h5>";
						$row_count = 0;
						print "<div class='row'>";
					
						foreach($rel_objs as $obj){
							print "<div class='col-xs-6'>{$obj}</div>";
							$row_count++;
							if($row_count == 2){
								print "</div><div class='row'>";
								$row_count = 0;
							}
						}
						if($row_count != 0){
							print "</div>";
						}
					}		
?>				
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<hr/>
				</div>
			</div>		
			<div class="row">
				<div class="col-xs-6 col-sm-4 text-center">
<?php
					if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
						print "<div class='detailTool'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array('object_id' => $t_object->get("object_id")))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>".$va_add_to_set_link_info["icon"].$va_add_to_set_link_info["link_text"]."</a></div><!-- end detailTool -->";
					}
?>
				</div>
				<div class="col-xs-6 col-sm-4 col-sm-offset-4 text-center">
					<div class="detailTool">
						<a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a>
					</div><!-- end detailTool -->
					<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
				</div>
					
			</div>
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
</div>
