<?php
	$t_collection = $this->getVar('t_collection');
	$ps_template = $this->getVar('display_template');
	$vs_page_title = $this->getVar('page_title');
	$vs_intro_text = $this->getVar('intro_text');
	$vs_open_default = $this->getVar('open_by_default');
	#AssetLoadMananger::register('readmore');
	AssetLoadManager::register("readmore");
	
	$qr_top_level_collections = ca_collections::find(array('type_id' => 119), array('returnAs' => 'searchResult', 'sort' => 'ca_collections.preferred_labels.name'));
 
?>
<div class="container">
<div class="row">
	<div class="col-sm-8 ">
		<h1><?php print $vs_page_title; ?></h1>
		<div class='findingIntro'><?php print $vs_intro_text; ?></div>
		<div id='findingAidCont'>
	<?php	
		if ($qr_top_level_collections) {
			while($qr_top_level_collections->nextHit()) {
				$vn_top_level_collection_id = $qr_top_level_collections->get('ca_collections.collection_id', array('checkAccess' => caGetUserAccessValues($this->request)));
				$va_hierarchy = $t_collection->hierarchyWithTemplate($ps_template, array('collection_id' => $vn_top_level_collection_id));
				foreach($va_hierarchy as $vn_i => $va_hierarchy_item) {
					$t_collection_item = new ca_collections($va_hierarchy_item['id']);
					if (($t_collection_item->get('ca_collections.fa_access') != 261) && ($va_hierarchy_item['level'] == 0)) {
						print "<div class='collHeader' >";
							print "<i class='fa fa-square-o finding-aid' {$va_opacity}></i>";
							if ($t_collection_item->get('ca_collections.fa_access') == 262) {
								print "<div class='text'>".caNavLink($this->request, $t_collection_item->get('ca_collections.preferred_labels')." (".$t_collection_item->get('ca_collections.idno').")", '', '', 'Detail', 'collections/'.$va_hierarchy_item['id'])."</div><br/>";
							} else {
								print "<div class='text'>".caNavLink($this->request, $t_collection_item->get('ca_collections.preferred_labels.name')." (".$t_collection_item->get('ca_collections.idno').")", '', '', 'Detail', 'collections/'.$va_hierarchy_item['id'])." <br/><div style='font-weight:200; width: auto; margin-left: 30px;' class='trimText'>".$t_collection_item->get('ca_collections.abstract')."</div></div><br/>";
							}
						print "</div><!-- end collHeader-->";
					}		
				}
			}
		} else {
			print _t('No collections available');
		}
	?>
		</div><!-- findingAid Cont-->
	</div><!-- end col -->
	<div class="col-sm-4" style='border-left:1px solid #ddd;'>
		<div id='archivesSidebar'>
			<h1>Archival Research Assistance</h1>
			<h3><a href='mailto:ray.barker@glenstone.org'>Contact the Archives</a></h3>
			<h3>SOCIETY OF AMERICAN ARCHIVISTS GUIDES</h3>
				<p><a href='http://www2.archivists.org/usingarchives' target='_blank'>Guide to Archival Research</a></p>
				<p><a href='http://www2.archivists.org/glossary' target='_blank'>Glossary of Terminology</a></p>
				<p><a href='http://www2.archivists.org/statements/saa-core-values-statement-and-code-of-ethics' target='_blank'>Archivist Code of Ethics</a></p>
			<h3>OTHER ART MUSEUM ARCHIVES</h3>
				<p><a href='http://www.aaa.si.edu/' target='_blank'>Archives of American Art</a></p>
				<p><a href='http://metmuseum.org/research/libraries-and-study-centers/museum-archives' target='_blank'>Metropolitan Museum of Art Archives</a></p>
				<p><a href='http://www.moma.org/learn/resources/archives/index' target='_blank'>Museum of Modern Art Archives</a></p>
				<p><a href='http://www.nga.gov/resources/gadesc.shtm' target='_blank'>National Gallery of Art Archives</a></p>
		</div>
	</div><!-- end col -->
</div><!-- end row -->
</div><!-- end container -->	

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 100
		});
	});
</script>	

<script type="text/javascript">
	jQuery(document).ready(function() {
		var offsetBrowseResultsContainer = $("H1:first").offset();
		var lastOffset = $("#archivesSidebar").offset();
		$("body").data("lastOffsetTop", lastOffset.top);
		$(window).scroll(function() {
			if(($(document).scrollTop() < $(document).height() - ($("#archivesSidebar").height() + 250)) && (($(document).scrollTop() < $("body").data("lastOffsetTop")) || ($(document).scrollTop() > ($("body").data("lastOffsetTop") + ($("#archivesSidebar").height() - ($(window).height()/3)))))){
				var offset = $("#archivesSidebar").offset();
				if($(document).scrollTop() < offsetBrowseResultsContainer.top){
					jQuery("#archivesSidebar").offset({top: offsetBrowseResultsContainer.top, left: offset.left});
				}else{
					jQuery("#archivesSidebar").offset({top: $(document).scrollTop(), left: offset.left});
				}
			}
			clearTimeout($.data(this, 'scrollTimer'));
			$.data(this, 'scrollTimer', setTimeout(function() {
				// do something
				var lastOffset = $("#archivesSidebar").offset();
				$("body").data("lastOffsetTop", lastOffset.top);
				
			}, 250));
		});
	});
</script>
