<?php
	$va_comments = $this->getVar("comments");
	$t_collection = $this->getVar("item");
	$va_collection_id = $t_collection->get('ca_collections.collection_id');
?>
<div class="container">
<div class="row">
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			<!--{{{resultsLink}}}<div class='detailPrevLink'>{{{previousLink}}}</div>-->
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-10 col-sm-10 col-md-10 col-lg-10'>

	</div>
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			<!--{{{nextLink}}}-->
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
<div class="row">
	<div class='col-sm-9 col-md-9 col-lg-9'>
			<H4>{{{^ca_collections.preferred_labels}}}{{{<ifdef code="ca_collections.idno"> (^ca_collections.idno)</ifdef>}}}</H4>
			<H6>{{{^ca_collections.type_id}}}</H6>
<?php
			$va_table_contents = array();
			if ($t_collection->get('ca_collections.fa_access') == 263) {
				#print $t_collection->get('ca_collections.component_notes');
				if ($va_abstract = $t_collection->get('ca_collections.abstract')) {
					print "<h6 id='abstract'>Abstract</h6><div class='trimText'>".$va_abstract."</div>";
					$va_table_contents[] = "<a href='#abstract'>Abstract</a>";
				}
				if ($va_creator = $t_collection->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('creator')))) {
					print "<h6 id='creator'>Creator</h6><div>".$va_creator."</div>";
					$va_table_contents[] = "<a href='#creator'>Creator</a>";
				}
				if ($va_dates = $t_collection->get('ca_collections.collection_dates', array('template' => '^collection_dates_value ^collection_date_types', 'convertCodesToDisplayText' => true))) {
					print "<h6 id='dates'>Date</h6><div>".$va_dates."</div>";
					$va_table_contents[] = "<a href='#dates'>Date</a>";
				}
				if ($va_extent = $t_collection->get('ca_collections.extent', array('template' => '^extent_value ^extent_units', 'convertCodesToDisplayText' => true, 'delimiter' => '; '))) {
					print "<h6 id='extent'>Extent</h6><div>".$va_extent."</div>";
					$va_table_contents[] = "<a href='#extent'>Extent</a>";
				}																
				if ($va_format_types = $t_collection->get('ca_collections.format_types')) {
					print "<h6 id='format'>Format Types</h6><div>".$va_format_types."</div>";
					$va_table_contents[] = "<a href='#format'>Format Types</a>";
				}				
				if ($va_language = $t_collection->get('ca_collections.language_of_materials', array('delimiter' => ', ', 'convertCodesToDisplayText' => true))) {
					print "<h6 id='language'>Languages</h6><div>".$va_language."</div>";
					$va_table_contents[] = "<a href='#language'>Languages</a>";
				}
				if ($va_repository = $t_collection->get('ca_collections.repository')) {
					print "<h6 id='repository'>Name and Location of Repository</h6><div>".$va_repository."</div>";
					$va_table_contents[] = "<a href='#repository'>Name and Location of Repository</a>";
				}
				if ($va_access_restrictions = $t_collection->get('ca_collections.access_restrictions')) {
					print "<h6 id='accessrest'>Access Restrictions</h6><div>".$va_access_restrictions."</div>";
					$va_table_contents[] = "<a href='#accessrest'>Access Restrictions</a>";
				}
				if ($va_physical_access = $t_collection->get('ca_collections.physical_access')) {
					print "<h6 id='access'>Physical Access</h6><div>".$va_physical_access."</div>";
					$va_table_contents[] = "<a href='#access'>Physical Access</a>";
				}
				if ($va_technical_access = $t_collection->get('ca_collections.technical_access')) {
					print "<h6 id='techaccess'>Technical Access</h6><div>".$va_technical_access."</div>";
					$va_table_contents[] = "<a href='#techaccess'>Technical Access</a>";
				}
				if ($va_use_restriction = $t_collection->get('ca_collections.use_restrictions')) {
					print "<h6 id='useres'>Use Restrictions</h6><div>".$va_use_restriction."</div>";
					$va_table_contents[] = "<a href='#useres'>Use Restrictions</a>";
				}
				if ($va_copyright = $t_collection->get('ca_collections.copyright_statement')) {
					print "<h6 id='copy'>Copyright Statement</h6><div>".$va_copyright."</div>";
					$va_table_contents[] = "<a href='#copy'>Copyright Statement</a>";
				}
				if ($va_citation = $t_collection->get('ca_collections.preferred_citation')) {
					print "<h6 id='citation'>Preferred Citation</h6><div>".$va_citation."</div>";
					$va_table_contents[] = "<a href='#citation'>Preferred Citation</a>";
				}
				if ($va_related_materials = $t_collection->get('ca_collections.related.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
					print "<h6 id='relmat'>Related Materials</h6><div>".$va_related_materials."</div>";
					$va_table_contents[] = "<a href='#relmat'>Related Materials</a>";
				}				
				if ($va_provenance = $t_collection->get('ca_collections.provenance')) {
					print "<h6 id='provenance'>Provenance</h6><div class='trimText'>".$va_provenance."</div>";
					$va_table_contents[] = "<a href='#provenance'>Provenance</a>";
				}
				if ($va_historical = $t_collection->get('ca_collections.bio_historical')) {
					print "<h6 id='historical'>Historical Note</h6><div class='trimText'>".$va_historical."</div>";
					$va_table_contents[] = "<a href='#historical'>Historical Note</a>";
				}
				if ($va_scope = $t_collection->get('ca_collections.scope_content')) {
					print "<h6 id='scope'>Scope and Content</h6><div class='trimText'>".$va_scope."</div>";
					$va_table_contents[] = "<a href='#scope'>Scope and Content</a>";
				}
				if ($va_arrangement = $t_collection->get('ca_collections.arrangement')) {
					print "<h6 id='arrangement'>Arrangement</h6><div>".$va_arrangement."</div>";
					$va_table_contents[] = "<a href='#arrangement'>Arrangement</a>";
				}																																																																								
			}
			if ($t_collection->get('ca_collections.children')) {
				print "<h6 id='contents'>Collection Contents</h6>";
				$va_table_contents[] = "<a href='#contents'>Collection Contents</a>";

				$va_hierarchy = $t_collection->hierarchyWithTemplate("<l>^ca_collections.preferred_labels.name</l>", array('collection_id' => $va_collection_id, 'sort' => 'ca_collections.preferred_labels.name'));
				foreach($va_hierarchy as $vn_i => $va_hierarchy_item) {
					$t_collection_item = new ca_collections($va_hierarchy_item['id']);
					
					if ($t_collection_item->get('ca_collections.fa_access') != 261 && $va_hierarchy_item['level'] != 0) {
						$va_indent = "style='margin-left:".(($va_hierarchy_item['level'] * 15) - 15)."px;' ";
						if ($va_hierarchy_item['level'] == 1) {
							$vn_top_level_collection_id = $va_hierarchy_item['id'];
							$vn_text_class = "";
						} else {
							$vn_text_class = "text".$vn_top_level_collection_id;
						}
						print "<div class='collName {$vn_text_class}' {$va_indent} >";
						if ($va_hierarchy_item['level'] == 1) {
							print "<i class='fa fa-square-o finding-aid down{$vn_top_level_collection_id}'  ></i>";
?>
					<script>
						$(function() {
						  $('.down<?php print $vn_top_level_collection_id;?>').click(function() {
							  if ($('.text<?php print $vn_top_level_collection_id;?>').css('display') == 'none') {
							  	 $('.down<?php print $vn_top_level_collection_id;?>').removeClass('fa-square');
							     $('.text<?php print $vn_top_level_collection_id;?>').fadeIn("300"); 
							  } else {
							  	$('.down<?php print $vn_top_level_collection_id;?>').addClass('fa-square');
							    $('.text<?php print $vn_top_level_collection_id;?>').fadeOut("300");
							  }
							  return false;
						  });
						})
					</script>
<?php							
						} else {
							print "<i class='fa fa-angle-right finding-aid {$vn_text_class}' ></i>";
						}
						if ($t_collection_item->get('ca_collections.fa_access') == 262) {
							print "<div class='text {$vn_text_class}'>";
								print caNavLink($this->request, $t_collection_item->get('ca_collections.preferred_labels')." (".$t_collection_item->get('ca_collections.idno').")", '', '', 'Browse', 'archives/facet/collections/id/'.$va_hierarchy_item['id']);
							print "</div><br/>";
						} else {
							print "<div class='text {$vn_text_class}'>".caNavLink($this->request, $t_collection_item->get('ca_collections.preferred_labels.name')." (".$t_collection_item->get('ca_collections.idno').")", '', '', 'Browse', 'archives/facet/collections/id/'.$va_hierarchy_item['id'])." <br/><div style='font-weight:200; width: 500px; margin-left: 30px;'>".$t_collection_item->get('ca_collections.component_notes')."</div></div><br/>";
						}
						print "</div><!-- end collName-->"; 
					}			
				}
			}
?>				

<!-- Related Artworks -->
<?php			
		if ($va_artwork_ids = $t_collection->get('ca_objects.object_id', array('checkAccess' => caGetUserAccessValues($this->request), 'restrictToTypes' => array('audio', 'moving_image', 'image', 'ephemera', 'document'), 'returnAsArray' => true))) {	
?>		
			<div id="detailRelatedArchives">
				<div class='contents'>
<?php				
					print caNavLink($this->request, 'view all', '', 'Browse', 'archives', 'facet/collections/id/'.$va_collection_id);
					#print "<span class='findingAid'><i class='fa fa-archive' style='padding-right:5px;'></i>".caNavLink($this->request, 'view finding aid', '', '', 'FindingAid', 'Collection/Index')."</span>";

?>
				 </div>
				<div class="jcarousel-wrapper">
					<div id="detailScrollButtonNextArchive"><i class="fa fa-angle-right"></i></div>
					<div id="detailScrollButtonPreviousArchive"><i class="fa fa-angle-left"></i></div>
					<!-- Carousel -->
					<div class="jcarouselarchive">
						<ul>
<?php
						foreach ($va_artwork_ids as $va_object_id => $va_artwork_id) {
							$t_object = new ca_objects($va_artwork_id);
							print "<li>";
							print "<div class='detailObjectsResult'>".caNavLink($this->request, $t_object->get('ca_object_representations.media.library'), '', '', 'Detail', 'artworks/'.$va_artwork_id)."</div>";
							print "<div class='caption'>".caNavLink($this->request, $t_object->get('ca_objects.preferred_labels')."<br/> ".$t_object->get('ca_objects.dc_date.dc_dates_value'), '', '', 'Detail', 'artworks/'.$va_artwork_id)."</div>";
							print "</li>";
						}
?>						
						</ul>
					</div><!-- end jcarousel -->
					
				</div><!-- end jcarousel-wrapper -->
			</div><!-- end detailRelatedObjects -->
			<script type='text/javascript'>
				jQuery(document).ready(function() {
					/*
					Carousel initialization
					*/
					$('.jcarouselarchive')
						.jcarousel({
							// Options go here
						});
			
					/*
					 Prev control initialization
					 */
					$('#detailScrollButtonPreviousArchive')
						.on('jcarouselcontrol:active', function() {
							$(this).removeClass('inactive');
						})
						.on('jcarouselcontrol:inactive', function() {
							$(this).addClass('inactive');
						})
						.jcarouselControl({
							// Options go here
							target: '-=1'
						});
			
					/*
					 Next control initialization
					 */
					$('#detailScrollButtonNextArchive')
						.on('jcarouselcontrol:active', function() {
							$(this).removeClass('inactive');
						})
						.on('jcarouselcontrol:inactive', function() {
							$(this).addClass('inactive');
						})
						.jcarouselControl({
							// Options go here
							target: '+=1'
						});
				});
			</script>
<?php
		}
?>			
		<!-- Related Artworks -->
			
		</div><!-- end col -->
		<div class='col-sm-3 col-md-3 col-lg-3'>
			<div id='collectionContents'>
				<h2>Collection Guide</h2>
<?php
				foreach ($va_table_contents as $va_table_content) {
					print "<p>".$va_table_content."</p>";
				}
?>
			</div>		
		</div><!-- end col -->
	</div><!-- end row -->
</div>	<!-- end container -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>

<script type="text/javascript">
	jQuery(document).ready(function() {
		var offsetBrowseResultsContainer = $("h2:first").offset();
		var lastOffset = $("#collectionContents").offset();
		$("body").data("lastOffsetTop", lastOffset.top);
		$(window).scroll(function() {
			if(($(document).scrollTop() < $(document).height() - ($("#collectionContents").height() + 250)) && (($(document).scrollTop() < $("body").data("lastOffsetTop")) || ($(document).scrollTop() > ($("body").data("lastOffsetTop") + ($("#collectionContents").height() - ($(window).height()/3)))))){
				var offset = $("#collectionContents").offset();
				if($(document).scrollTop() < offsetBrowseResultsContainer.top){
					jQuery("#collectionContents").offset({top: offsetBrowseResultsContainer.top, left: offset.left});
				}else{
					jQuery("#collectionContents").offset({top: $(document).scrollTop(), left: offset.left});
				}
			}
			clearTimeout($.data(this, 'scrollTimer'));
			$.data(this, 'scrollTimer', setTimeout(function() {
				// do something
				var lastOffset = $("#collectionContents").offset();
				$("body").data("lastOffsetTop", lastOffset.top);
				
			}, 250));
		});
	});
</script>
