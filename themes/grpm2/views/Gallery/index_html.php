<?php
	$this->config = caGetGalleryConfig();
	$va_sets = $this->getVar("sets");
?>
<div class="row"><div class="col-sm-12">
	<H1><?php print $this->getVar("section_name"); ?></H1>
	<p class="teacherGalleryIntro">	
		{{{curator_galleries_intro}}}
	</p>
	<hr>
	</div>
</div>
<?php
	if(is_array($va_sets) && sizeof($va_sets)){
?>
		<div class="container">			
<?php

						$va_set_ids = array();
						
							print '<div class="row">';
							
							$va_set_ids = array_keys($va_sets);
							$r_sets = caMakeSearchResult("ca_sets", $va_set_ids, array("sort" => array("ca_sets.set_rank"), "sortDirection" => "asc"));
							$t_set = new ca_sets();
							$va_first_items_from_set = $t_set->getPrimaryItemsFromSets($va_set_ids, array("version" => "medium", "checkAccess" => $this->opa_access_values));
							$vn_col_no = 1;
							$vn_rule_no = 1;
							$va_layout = array();
							foreach($va_sets as $vn_set_id => $va_set_info){
								$t_set = new ca_sets($vn_set_id);
								$va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
								#$t_set_creator = new ca_users($t_set->get('ca_users.user_id'));
								#$vs_creator = $t_set_creator->get("ca_users.fname");
								
								if ($va_first_item['representation_tag']) {
									$va_layout[$vn_col_no][]= ( $vn_rule_no > 4 ? "<hr>" : "" )."<div class='setCascade'><div class='setCascadeImage'>".caNavLink($this->request, $va_first_item['representation_tag'], '', '', 'Gallery', $vn_set_id)."</div><div class='setCascadeInfo'><div class='setCascadeTitle'>".caNavLink($this->request, $va_set_info['name'], '', '', 'Gallery', $vn_set_id)." <small>(".$va_set_info['item_count']." items)</small></div>".(($vs_creator) ? "<div>Created by: ".$vs_creator."</div>" : "")."<div>".$t_set->get('ca_sets.set_description')."</div></div></div>";
									$vn_col_no++;
									$vn_rule_no++;
									if ($vn_col_no == 5) {
										$vn_col_no = 1;
									}
								}
							}
							foreach ($va_layout as $va_col_no => $vs_item) {
								print "<div class='col-sm-3'>";
								foreach ($vs_item as $va_key => $vs_item_link) {
									print $vs_item_link;
								}
								print "</div>";
							}
							print "</div><!-- end row -->";					


?>									
	</div><!-- end container -->		
<?php
	}
?>		