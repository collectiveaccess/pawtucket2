<div class='containerWrapper'>
	<div class="row"><div class="col-sm-12">
	<H1><?php print $this->getVar("section_name"); ?></H1>
	<p>
		Explore connections across all our collections. See what items appear in galleries created by the contributing institutions and visitors like you. Make your own connections between objects by <?php print caNavLink($this->request, 'creating your own', '', '', 'Lightbox', 'Index').". Creating a <a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >Login</a>"; ?> on MNCollections allows you to save items, add comments, and share your galleries if you wish.
	</p><br/>
	<p class="text-center"><?php print caNavLink($this->request, '<span class="btn-default">Create My Gallery</span>', '', '', 'Lightbox', 'Index');?></p>
	<hr>
<?php
	$va_access_values = caGetUserAccessValues($this->request);
	$va_sets = $this->getVar("sets");
	$va_sets_by_type = $this->getVar("sets_by_type");
	$va_first_items_from_set = $this->getVar("first_items_from_sets");
	
	$this->config = caGetGalleryConfig();
	$va_set_confs = $this->config->get('set_types');

	if(is_array($va_sets_by_type) && sizeof($va_sets_by_type)){
		# --- main area with info about selected set loaded via Ajax
		#$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
?>
		<div class="container">			
<?php
				foreach ($va_sets_by_type as $vs_typename => $va_sets) {
					#foreach ($va_set_info_t as $vs_set_name => $va_set_infos) {
						$va_set_ids = array();
						//if ($vs_typename == "user") {
							$va_set_ids = array_keys($va_sets);
							$r_sets = caMakeSearchResult("ca_sets", $va_set_ids, array("sort" => array("ca_sets.preferred_labels.name"), "sortDirection" => "asc"));
							print '<div class="row">';
							print "<hr><h2>".$va_set_confs[$vs_typename]['name']." ".caNavLink($this->request, '<small> | see all <i class="fa fa-external-link"></i></small>', '', 'Gallery', 'featured', $vs_typename)."</h2>";
							print "<div class='lightboxDescription textContent'>".$va_set_confs[$vs_typename]['description']."</div>";
							print '
								<div class="jcarousel-wrapper col-sm-12">
									<div class="jcarousel">
										<ul>';
								

								if($r_sets->numHits()){
									while($r_sets->nextHit()){
										if ($r_sets->get('ca_sets.hide', array('convertCodesToDisplayText' => true)) != "No") {					
											$vn_set_id = $r_sets->get("set_id");
											$t_set = new ca_sets($vn_set_id);
											$va_set_items = caExtractValuesByUserLocale($t_set->getItems(array("thumbnailVersions" => array("iconlarge", "icon"), "checkAccess" => $va_access_values, "limit" => 3)));
											#$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
											$va_set_info = $va_sets[$vn_set_id];
											if (sizeof($va_set_items) == 1 ) { $vs_one_image = "oneItem";} else { $vs_one_image = "";}
											if (sizeof($va_set_items) > 0 ) {
												print "<li ><div class='setTile ".$vs_one_image."'>";
												$vs_item = 0;
												foreach ($va_set_items as $va_key => $va_set_item) {
													if ($vs_item == 0) {
														print "<div class='setImage'>".caNavLink($this->request, $va_set_item['representation_tag_iconlarge'], '', '', 'Gallery', $vn_set_id)."</div>";
													} else {
														print "<div class='imgPreview'>".$va_set_item['representation_tag_iconlarge']."</div>";
													}
													$vs_item++;
												}
												print "<div class='name'>".caNavLink($this->request, $va_set_info['name'], '', '', 'Gallery', $vn_set_id)." <small>(".$va_set_info['item_count']." items)</small></div>";
												$t_u = new ca_users($r_sets->get('ca_users.user_id'));
												if($t_u->getPreference('user_profile_username')){
													print "<div class='user'>created by: ".$t_u->getPreference('user_profile_username')."</div>";
												}
												print "</div></li>";
											}
										}
									}	
								}
								print "</ul></div><!-- end jcarousel -->";
					
								print '<a href="#" class="jcarousel-control-prev"><i class="fa fa-angle-left"></i></a>';
								print '<a href="#" class="jcarousel-control-next"><i class="fa fa-angle-right"></i></a>';
?>			
								<!-- Pagination -->
								<p class="jcarousel-pagination">
								<!-- Pagination items will be generated in here -->
								</p>					
							</div>	<!-- end jc wrapper -->
							<script type='text/javascript'>
								jQuery(document).ready(function() {
									/*
									Carousel initialization
									*/
									$('.jcarousel')
										.jcarousel({
											// Options go here
											wrap:'circular'
										});
	
									/*
									 Prev control initialization
									 */
									$('.jcarousel-control-prev')
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
									$('.jcarousel-control-next')
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
									/*
									 Pagination initialization
									 */
									$('.jcarousel-pagination')
										.on('jcarouselpagination:active', 'a', function() {
											$(this).addClass('active');
										})
										.on('jcarouselpagination:inactive', 'a', function() {
											$(this).removeClass('active');
										})
										.jcarouselPagination({
											// Options go here
										});	
								});
							</script>
							</div><!-- end row -->
<?php							
						// } else {
// 							print '<div class="row">';
// 							print "<h2>".$va_set_confs[$vs_typename]['name']." ".caNavLink($this->request, '<small> | see all <i class="fa fa-external-link"></i></small>', '', 'Gallery', 'featured', $vs_typename)."</h2>";
// 							print "<div class='lightboxDescription textContent'>".$va_set_confs[$vs_typename]['description']."</div>";
// 
// 							$va_set_ids = array_keys($va_sets);
// 							$r_sets = caMakeSearchResult("ca_sets", $va_set_ids, array("sort" => array("ca_sets.set_rank"), "sortDirection" => "asc"));
// 							$t_set = new ca_sets();
// 							$va_first_items_from_set = $t_set->getPrimaryItemsFromSets($va_set_ids, array("version" => "medium", "checkAccess" => $va_access_values));
// 							$vn_col_no = 1;
// 							$vn_rule_no = 1;
// 							$va_layout = array();
// 							if($r_sets->numHits()){
// 								while($r_sets->nextHit()){
// 									$vn_set_id = $r_sets->get("set_id");
// 									$t_set = new ca_sets($vn_set_id);
// 									$va_set_info = $va_sets[$vn_set_id];
// 									$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
// 									# --- if this set was made by a contributor, created them with link to their contributor page
// 									$t_set_creator = new ca_users($t_set->get('ca_users.user_id'));
// 									$vs_contributor_credit = null;
// 									$t_contributor = null;
// 									if($t_set_creator->hasRole("member")){
// 										# --- is there a contributor entity related to the suer account that made the set?
// 										$t_contributor = new ca_entities($t_set_creator->get("entity_id"));
// 										$vs_contributor_credit = caDetailLink($this->request, $t_contributor->get("ca_entities.preferred_labels.displayname"), '', 'ca_entities',  $t_set_creator->get("entity_id"));
// 									}else{
// 										$vs_contributor_credit = $t_set_creator->getPreference('user_profile_username');
// 									}
// 									if ($va_first_item['representation_tag']) {
// 										$vs_description = $t_set->get('ca_sets.set_description');
// 										if(mb_strlen($vs_description) > 250){
// 											$vs_description = substr($vs_description, 0, 250)."...";
// 										}
// 										$va_layout[$vn_col_no][]= ( $vn_rule_no > 4 ? "<hr>" : "" )."<div class='setCascade'><div class='setCascadeImage'>".caNavLink($this->request, $va_first_item['representation_tag'], '', '', 'Gallery', $vn_set_id)."</div><div class='name'>".caNavLink($this->request, $va_set_info['name'], '', '', 'Gallery', $vn_set_id)." <small>(".$va_set_info['item_count']." items)</small></div>".(($vs_contributor_credit) ? "<div>Curated by: ".$vs_contributor_credit."</div>" : "")."<div>".$vs_description."</div></div>";
// 										$vn_col_no++;
// 										$vn_rule_no++;
// 										if ($vn_col_no == 5) {
// 											$vn_col_no = 1;
// 										}
// 									}
// 								}
// 							}
// 							foreach ($va_layout as $va_col_no => $vs_item) {
// 								print "<div class='col-sm-3'>";
// 								foreach ($vs_item as $va_key => $vs_item_link) {
// 									print $vs_item_link;
// 								}
// 								print "</div>";
// 							}
// 							print "</div><!-- end row -->";					
					//	}				
					#}			
				}

?>									
	</div><!-- end container -->		
<?php
	}
?>	
	</div></div></div>	