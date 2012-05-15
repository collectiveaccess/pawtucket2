<?php
	require_once(__CA_MODELS_DIR__."/ca_objects.php");
	// get last search ('basic_search' is the find type used by the SearchController)
	$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
	$vs_search = $o_result_context->getSearchExpression();

?>
		<div id="nav">
			<div id="search"><form name="header_search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
					<input type="text" name="search" value="<?php print ($vs_search) ? $vs_search : ''; ?>"  autocomplete="off" size="100"/> <a href="#" name="searchButtonSubmit" onclick="document.forms.header_search.submit(); return false;"><?php print "<img src='".$this->request->getThemeUrlPath()."/graphics/cba/b_search.gif' width='41' height='16' border='0'>"; ?></a>
			</form></div>
<?php
			print "<div class='navLink'>".caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/cba/n_collection_home.gif' width='88' height='17' border='0'>", "", "", "", "")."</div>";
			print "<div class='navLink'>".caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/cba/n_browse.gif' width='40' height='17' border='0'>", "", "", "Browse", "clearCriteria")."</div>";
				$va_facets = $this->getVar('available_facets');
				foreach($va_facets as $vs_facet_name => $va_facet_info) {
					if($vs_facet_name == "source_facet"){
						$o_source_browse = new ObjectBrowse('', 'pawtucket2');
						foreach($o_source_browse->getFacet("source_facet") as $va_sources){
							print "<div class='navSubLink' id='".$vs_facet_name."Link".$va_sources['id']."'>".caNavLink($this->request, $va_sources['label'], '', '', 'Browse', 'modifyCriteria', array_merge(array('facet' => $vs_facet_name, 'id' => $va_sources['id'])))."</div>";
							# --- hard code in descriptions for individual collections based on the source_id
							$vs_facet_description = "";
							switch($va_sources['id']){
								case 202:
									$vs_facet_description = "Includes works that challenge the notions and boundaries of book arts and related media (i.e. papermaking and prints); contemporary interpretations of the book and related media as art objects; and examples of traditional bookmaking practices.";
								break;
								# -------------------------
								case 203:
									$vs_facet_description = "Includes instructional manuals and reference books; exhibition catalogues; materials such as models, maquettes and engraving blocks created for teaching purposes or as stages of production of the Center's publications; artist member files; and studio equipment, type specimens and type.";
								break;
								# -------------------------
								case 204:
									$vs_facet_description = "Includes materials and ephemera that document the history of the Center's programmatic and administrative operations such as exhibitions, classes, literary and publication programs and promotional materials.";
								break;
								# -------------------------
							}
							TooltipManager::add(
								"#{$vs_facet_name}Link{$va_sources['id']}", "<div class='tooltipCaption'>".$vs_facet_description."</div>"
							);
						}
					}else{
?>
						<div class="navSubLink" id="<?php print $vs_facet_name; ?>Link"><a href="#" onclick='caUIBrowsePanel.showBrowsePanel("<?php print $vs_facet_name; ?>")'><?php print $va_facet_info['label_plural']; ?></a></div>
<?php
						TooltipManager::add(
							"#{$vs_facet_name}Link", "<div class='tooltipCaption'>".$va_facet_info['description']."</div>"
						);
					}					
				}
			
			print "<div class='navLink'>".caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/cba/n_about.gif' width='32' height='17' border='0'>", "", "", "About", "index")."</div>";
				print "<div class='navLink'>".caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/cba/n_links.gif' width='27' height='17' border='0'>", "", "", "About", "links")."</div>";
?>
		</div><!-- end nav -->
		<div id="contentArea">

		<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
			<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browseSelectPanelButton"></a>
			<div id="splashBrowsePanelContent">
			
			</div>
		</div>
		<script type="text/javascript">
			var caUIBrowsePanel = caUI.initBrowsePanel({ facetUrl: '<?php print caNavUrl($this->request, '', 'Browse', 'getFacet'); ?>'});
		</script>
		<h1><?php print "<img src='".$this->request->getThemeUrlPath()."/graphics/cba/t_from_the_collection.gif' width='102' height='16' border='0'>"; ?></h1>
		<div id="hpfeatured">
<?php
			$va_featured_ids = $this->getVar("featured_ids");
			if(is_array($va_featured_ids) && (sizeof($va_featured_ids) > 0)){
 				$va_featured_ids = array_slice($va_featured_ids, 0, 3);
 				$vn_c = 1;
 				foreach($va_featured_ids as $vn_id){
 					$t_object = new ca_objects($vn_id);
 					$va_rep = $t_object->getPrimaryRepresentation(array('preview'));
?>
					<div class="itemContainer">
						<div class="item">
							<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $va_rep["tags"]["preview"], '', 'Detail', 'Object', 'Show', array('object_id' =>  $vn_id)); ?></td></tr></table>
						</div><!-- end item -->
						<?php print caNavLink($this->request, ((strlen($t_object->getLabelForDisplay()) > 90) ? trim(substr($t_object->getLabelForDisplay(), 0, 90))."..." : $t_object->getLabelForDisplay()), 'caption', 'Detail', 'Object', 'Show', array('object_id' =>  $vn_id)); ?>
					</div><!-- end itemContainer -->
<?php
 					if($vn_c <= 2){
 						print "<div class='spacer'>&nbsp;</div>";
 					}
 					$vn_c++;
 				}
			}
?>
		</div><!-- end hpFeatured -->
		<div id="hpText">
<?php
			print $this->render('Splash/splash_text_html.php');
?>
		</div>
