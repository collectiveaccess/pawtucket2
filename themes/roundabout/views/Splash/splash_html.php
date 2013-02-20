<?php
	$va_access_values = $this->getVar("access_values");
		$va_facets 				= $this->getVar('available_facets');
	$va_facets_with_content	= $this->getVar('facets_with_content');
	$va_facet_info 			= $this->getVar('facet_info');
	$va_criteria 			= is_array($this->getVar('criteria')) ? $this->getVar('criteria') : array();
	$va_results 			= $this->getVar('result');
	
	$vs_browse_target		= $this->getVar('target');
?>
<div id="right-col">
	<div class="promo-block">
		<div class="shadow"></div>
		<p>Through dedicated funding from the Leon Levy Foundation, the Roundabout Theatre Company Archives were officially launched in 2008. During your visit, you'll discover production photographs, publicity materials, set and costume sketches, scripts, audio and video interviews, cast recordings, costumes, institutional records, theatre reconstruction documentation, and records chronicling our education program.</p>
		<?php print caNavLink($this->request, 'more', 'block-btn', '', 'About', 'Index');?>
		
    <!--end .promo-block -->
    </div>

	<div class="promo-block recently-added added-<?php echo $num_thumbs; ?>">
		<div class="shadow"></div>
		<h3><?php print _t("Recently Added"); ?></h3>
		<!-- RECENTLY ADDED-->
		
		<div class="favoritesColumn" id="recentlyAddedCol">
			<div id="scrollRecentlyAdded">
				<div id="scrollRecentlyAddedContainer">
					<?php
						$vn_scrollingColHeight = 600;
						$vn_numItemsPerCol = 3;
					?>
					<?php
						$vn_recently_added_count = 0;
						$va_recently_added = $this->getVar("recently_added_objects");
						if(is_array($va_recently_added) && sizeof($va_recently_added) > 0){
							foreach($va_recently_added as $vn_object_id => $va_recently_added_item){
								#print_r($va_recently_added_item);
								$t_object = new ca_objects($vn_object_id);
								$va_object_title = $t_object->get('ca_objects.preferred_labels');
								print "<p style='padding:5px 0px 5px 0px;'>".caNavLink($this->request, $va_object_title, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</p>";
							$vn_recently_added_count++;
							if ($vn_recently_added_count == 5) {break;};
							} //end foreach
						} //endif
					?>
				</div><!-- end scrollRecentlyAddedContainer -->
			</div><!-- end scrollRecentlyAdded -->

			<?php if($vn_recently_added_count > $vn_numItemsPerCol) { ?>
				<a href="#" onclick="scrollRecentlyAddedItems(); return false;" class="block-btn hide-no-js"><?php print _t("View More"); ?></a>
			<?php } ?>
		</div><!-- end favoritesColumn -->
		<?php if($vn_recently_added_count > $vn_numItemsPerCol) { ?>
			<script type="text/javascript">
				var scrollRecentlyAddedItemsCurrentPos = 0;
				function scrollRecentlyAddedItems() {
					var t = parseInt(jQuery('#scrollRecentlyAddedContainer').css('top'));
					if (!t) { t = 0; }
					if ((scrollRecentlyAddedItemsCurrentPos + <?php print $vn_numItemsPerCol; ?>) >= <?php print $vn_recently_added_count; ?>) { 
						t = <?php print $vn_scrollingColHeight; ?>; scrollRecentlyAddedItemsCurrentPos = -<?php print $vn_numItemsPerCol; ?>;

					}
					jQuery('#scrollRecentlyAddedContainer').animate({'top': (t - <?php print $vn_scrollingColHeight; ?>) + 'px'}, {'queue':true, 'duration': 600, 'complete': function() { jQuery('#scrollRecentlyAddedContainer').stop(true); scrollRecentlyAddedItemsCurrentPos += <?php print $vn_numItemsPerCol; ?>; }});
				}
			</script>
		<?php } ?>
		
		<div class="clearfix"></div>
		
    <!--end .promo-block -->
    </div>
    	
    <div class="promo-block">
		<div class="shadow"></div>
		<h3>Contact the Archivist</h3>
		<p>Call 212-719-9393 or <a href="mailto:archives@roundabouttheatre.org">email us</a>.</p>
		<p>Want access to our physical archives?</p>
		<a href="http://archive.roundabouttheatre.org/pdf/RoundaboutTheatreCompany_Archives_PhysicalAccessForm.pdf" target="_blank" class="block-btn">Download Form</a>
		
    <!--end .promo-block -->
    </div>

<!--end .right-col-->
</div>

<div id="left-col">
	
	<h1 class="visuallyhidden">Roundabout Theatre Archives</h1>
	
	<div>
		<div class='splashHeader'><h3 style='float:left; margin-right:10px;'>Browse the Collection</h3> <?php print caNavLink($this->request, 'View More', 'block-btn', '', 'Browse', 'Index'); ?></div>
<?php		
if (sizeof($va_facets)) { 
					//Roundabout added config options
					$ra_categories = array(
						'productions' => $this->request->config->get('ra_browse_productions'),
						'photographs' => $this->request->config->get('ra_browse_photographs'),
						'playbills' => $this->request->config->get('ra_browse_playbills'),
						'video' => $this->request->config->get('ra_browse_video'),
						'artists' => $this->request->config->get('ra_browse_artists'),
						'costumes' => $this->request->config->get('ra_browse_costumes'),
						#'orchestrations' => $this->request->config->get('ra_browse_orchestrations'),
						#'posters' => $this->request->config->get('ra_browse_posters'),	
						#'scripts' => $this->request->config->get('ra_browse_scripts'),
						#'sketch' => $this->request->config->get('ra_browse_sketch'),	
					);
					$va_available_facets = $this->getVar('available_facets'); 
?>
					
					<ul class="browse-thumbs-list">
					
<?php
					//print "<div class='startBrowsingBy'>"._t("Start browsing by:")."</div>";
					//print "<div id='facetList'>";
					$array_categories = array();
					foreach($va_available_facets as $vs_facet_code => $va_facet_info) {
						if($va_facet_info['label_plural'] != 'Object types') {
							$desc = $ra_categories[strtolower($va_facet_info['label_plural'])]['description'];
							$newDesc = (strlen($desc) > 120) ? substr($desc, 0, 120).'...' : $desc;
							$sort_no = $ra_categories[strtolower($va_facet_info['label_plural'])]['sort'];
?>		
							
<?php 
							  
							$html =	"<li>";
							$html .= "<a href='#' onclick='caUIBrowsePanel.showBrowsePanel(\"{$vs_facet_code}\");' class='thumb-link'>";		
							$html .= 	"<img src='".$this->request->getThemeUrlPath()."/img/".$ra_categories[strtolower($va_facet_info['label_plural'])]['thumb']."' />";
							$html .= "</a>";

							$html .= "<a href='#' onclick='caUIBrowsePanel.showBrowsePanel(\"{$vs_facet_code}\");'>";	
							$html .=    "<h4>".$va_facet_info['label_plural']."</h4>";
							$html .= 	"<p>".$newDesc."</p>";
							$html .= "</a>"; 
							$html .= "</li>";
									
							$array_categories[$sort_no] = $html;
							/*	echo "<li>";
								echo "<a href='#' onclick='caUIBrowsePanel.showBrowsePanel(\"{$vs_facet_code}\");' class='thumb-link'>";		
								echo 	"<img src='".$this->request->getThemeUrlPath()."/img/".$ra_categories[strtolower($va_facet_info['label_plural'])]['thumb']."' />";
								echo "</a>";
								
								echo "<a href='#' onclick='caUIBrowsePanel.showBrowsePanel(\"{$vs_facet_code}\");'>";	
								echo    "<h4>".$va_facet_info['label_plural']."</h4>";
								echo 	"<p>".$newDesc."</p>";
								echo "</a>"; 
								echo "</li>";
							*/
?>
							
<?php
						} //end if
					} // end foreach
					
					foreach($ra_categories as $category => $value) { 
						if($category != 'artists' && $category != 'productions') {
							$desc = $value['description'];
							$newDesc = (strlen($desc) > 120) ? substr($desc, 0, 120).'...' : $desc;
							$sort_no = $value['sort'];

							$html = '<li>';
							$html .=	'<a href="' .caNavUrl($this->request, '', 'Browse', 'modifyCriteria'). '/facet/objects_facet/id/' .$value['id']. '/mod_id/0" class="thumb-link">';
							$html .=		'<img src="' .$this->request->getThemeUrlPath(). '/img/' .$value['thumb']. '" />';
							$html .=	'</a>';
							$html .=	'<a href="' .caNavUrl($this->request, '', 'Browse', 'modifyCriteria'). '/facet/objects_facet/id/' .$value['id']. '/mod_id/0">';
							$html .=		'<h4>' .$value['title']. '</h4>';
							$html .=		'<p>' .$newDesc. '</p>';
							$html .=	'</a>';
							$html .='</li> ';
								
							$array_categories[$sort_no] = $html;
						} // end if
					} // end foreach
					ksort($array_categories, SORT_STRING);
					foreach($array_categories as $listItem) {
						print $listItem;
					}
?>
					</ul>
					
<?php 			} // end if
?>

	<div>
		<div class='splashHeader'><h3 style='float:left; margin-right:10px;'>Video Archives</h3> <?php print caNavLink($this->request, 'View More', 'block-btn', '', 'About', 'Video'); ?></div>
<?php
		print "<img src='".$this->request->getThemeUrlPath()."/img/video.png' border='0' width='638' height='415'>";
?>		
	</div>
<!--
	<div class="search-callout hide-no-js">
		<h3>Search the Archives</h3>
		<form name="header_search_home" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
			<input type="text" name="search" placeholder="" onclick='jQuery("#quickSearch_home").select();' id="quickSearch_home"  autocomplete="off" />
			<a href="#" class="block-btn" name="searchButtonSubmit" onclick="document.forms.header_search_home.submit(); return false;">Go</a>
		</form>

		<a href="<?php print caNavUrl($this->request, '', 'AdvancedSearch', 'Index'); ?>" class="advanced-search-link">Advanced Search</a>
	
	</div>
-->

<!--
	<div class="home-info-col">
		<h2>On the<br />Archives</h2>

		<p><a href="/Support/New-Play-Initiative.aspx"><img alt="" style="width: 270px; height: 140px" src="/Roundabout/media/Roundabout/Homepage%20Touts/NPI02_270x140.jpg" /></a></p>

		<p>Since launching on December 6, 2011, Roundabout&rsquo;s digital archives drew the attention of online show/ticket site broadwayworld.com, who published an interview with our archivist, Tiffany Nixon, and ten days of featured items from our collection.</p>

		<p><a class="block-btn" href="http://broadwayworld.com/article/Inside-the-Roundabout-Archives-An-Interview-with-Archivist-Tiffany-Nixon-20120125" target="_blank">Read the Interview</a></p>

		<p><a class="block-btn" href="http://broadwayworld.com/article/Inside-the-Roundabout-Archives-Day-1-NINE-20120126" target="_blank">Inside the Archives</a></p>
	</div>
	
	<div class="home-info-col">
		<h2>Research Articles</h2>
		
		<p><a href="/Shows-Events/Spring-Gala-2012.aspx"><img alt="" style="width: 270px; height: 140px" src="/Roundabout/media/Roundabout/Production%20Photos/Gala/Gala06_270x140.jpg" /></a></p>

		<p>Due to the nature of our collection, Roundabout&rsquo;s archives are of interest to other theatre companies, performing arts libraries/repositories and archivists in general. <a href="http://www.nycarchivists.org/metro_archivist" target="_blank">The Archivists Roundtable of Metropolitan NY, Inc.</a> included an article about the Stephen Sondheim Theatre written by our archivist, Tiffany Nixon, in its Winter 2012 newsletter.</p>

		<p><a class="block-btn" href="http://www.nycarchivists.org/Resources/Documents/2012_1.pdf" target="_blank">Download the Article</a></p>
	</div>

	<div style="clear:left;"></div>
-->
	
<!--	
	<h2>Highlights from the Collection</h2>
	
	<?php
	$t_featured = new ca_sets();
	$featured_sets = $this->request->config->get('featured_sets');
	$len = count($featured_sets);
	if($len > 3) { $len = 3; }
	for($i = 0; $i < $len; $i++) {
		$t_featured->load(array('set_code' => $featured_sets[$i]));
		$set_id = $t_featured->getPrimaryKey();
		$set_title = $t_featured->getLabelForDisplay();
		$set_desc = $t_featured->getAttributeFromSets('description', Array(0 => $set_id ) );
		$va_featured_ids = array_keys(is_array($va_tmp = $t_featured->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 0))) ? $va_tmp : array());	// These are the object ids in the set
		if(is_array($va_featured_ids) && (sizeof($va_featured_ids) > 0)){
			$t_object = new ca_objects($va_featured_ids[0]);
			$va_rep = $t_object->getPrimaryRepresentation(array('preview', 'preview170'), null, array('return_with_access' => $va_access_values));
			$featured_set_id_array[$i] = array(
				'featured_set_code' => $featured_sets[$i],
				'featured_content_id' => $va_featured_ids[0],
				'featured_content_small' => $va_rep["tags"]["preview"],
				'featured_content_label' => $set_title,
				'featured_content_description' => $set_desc[$set_id][0],
				'featured_set_id' => $set_id
			);
		}
	}
	?>
	
	<?php if(isset($featured_set_id_array)) { ?>
	<table class="featured-list" cell-padding="0" cell-spacing="0">
		<tr>
			<?php
			foreach($featured_set_id_array as $feature_array) {
				echo '<td>'.caNavLink($this->request, $feature_array['featured_content_small'], 'thumb-link', 'simpleGallery', 'Show', 'displaySet', array('set_id' => $feature_array['featured_set_id'])).'</td>';
			} ?>
		</tr>
		<tr>
			<?php
			foreach($featured_set_id_array as $feature_array) {
				//echo '<th><h3>'.$feature_array['featured_content_label'].'</h3></th>';
				echo '<th><h3>'.caNavLink($this->request, $feature_array['featured_content_label'], '', 'simpleGallery', 'Show', 'displaySet', array('set_id' => $feature_array['featured_set_id'])).'</h3></th>';
			} ?>
		</tr>
		<tr>
			<?php
			foreach($featured_set_id_array as $feature_array) {
				echo '<td class="featured-desc">';
				echo 	'<div class="desc">'.(strlen($feature_array['featured_content_description']) > 120 ? substr(strip_tags($feature_array['featured_content_description']), 0, 120)."..." : $feature_array['featured_content_description']);
				echo 	'</div>';
				echo caNavLink($this->request, 'More', 'block-btn', 'simpleGallery', 'Show', 'displaySet', array('set_id' => $feature_array['featured_set_id']));
				echo '</td>';
			} ?>
		</tr>
	</table>
	<?php }else { ?>
		<p>No Featured items available</p>
	<?php } ?>
-->	
	
	
	
	
<!--end #left-col-->
<script type="text/javascript">
	
		var caUIBrowsePanel = caUI.initBrowsePanel({ facetUrl: '/index.php/Browse/getFacet'});
	
</script>	
</div>	
<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
	<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browseSelectPanelButton"></a>
	<div id="splashBrowsePanelContent">
	
	</div>
</div>