<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$t_list = new ca_lists();
	
 	$vn_member_institution_id = $t_list->getItemIDFromList('entity_types', 'member_institution');
 	$vn_organization_id = $t_list->getItemIDFromList('entity_types', 'org');
 	$vn_individual_id = $t_list->getItemIDFromList('entity_types', 'ind');
 	$vn_family_id = $t_list->getItemIDFromList('entity_types', 'fam');	
?>
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
				<div class='col-md-12 col-lg-12'>
					<H4>{{{^ca_entities.preferred_labels.displayname}}}</H4>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-md-6 col-lg-6'>
				
					<div class='unit'><a href="#" onclick="$('#shareWidgetsContainer').slideToggle(); return false;" class="shareButton">Share</a></div>
					<!-- AddThis Button BEGIN -->
					<div id="shareWidgetsContainer" style="margin-top:25px;">
						<div class="addthis_toolbox addthis_default_style addthis_entity_page">
							<a class="addthis_button_pinterest_pinit"></a>
							<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
							<a class="addthis_button_tweet"></a>
							<a class="addthis_counter addthis_pill_style"></a>
						</div>
						<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-50278eb55c33574f"></script>
					</div>						
					<!-- AddThis Button END -->
<?php						
					if($this->request->config->get('ca_entities_description_attribute')){
						if($vs_description_text = $t_item->get("ca_entities.".$this->request->config->get('ca_entities_description_attribute'))){
							print "<div class='unit'>".$vs_description_text."</div><!-- end unit -->";				
						}
					}
					switch($t_item->get("ca_entities.type_id")){
					case $vn_member_institution_id:
						if($t_item->get("ca_entities.mem_inst_image")){
							print "<div class='unit'>".$t_item->get("ca_entities.mem_inst_image", array("version" => "small", "return" => "tag"))."</div>";
						}
						if($t_item->get("ca_entities.address")){
							if($t_item->get("ca_entities.mem_inst_region")){
								print "<div class='unit'><span class='subtitletextcaps'>"._t("Region").":</span> ".caNavLink($this->request, $t_item->get("ca_entities.mem_inst_region", array('convertCodesToDisplayText' => true)), "", "", "Browse", "clearAndAddCriteria", array("facet" => "region_facet", "id" => $t_item->get("ca_entities.mem_inst_region")))."</div>";
							}
							print "<div class='unit'><span class='subtitletextcaps'>"._t("Address").":</span><br/>";
							if($t_item->get("ca_entities.address.address1")){
								print $t_item->get("ca_entities.address.address1")."<br/>";
							}
							if($t_item->get("ca_entities.address.address2")){
								print $t_item->get("ca_entities.address.address2")."<br/>";
							}
							$va_address_line3 = array();
							if($t_item->get("ca_entities.address.city")){
								$va_address_line3[] = $t_item->get("ca_entities.address.city");
							}
							if($t_item->get("ca_entities.address.county")){
								$va_address_line3[] = $t_item->get("ca_entities.address.county");
							}
							if($t_item->get("ca_entities.address.stateprovince")){
								$va_address_line3[] = $t_item->get("ca_entities.address.stateprovince");
							}
							if($t_item->get("ca_entities.address.postalcode")){
								$va_address_line3[] = $t_item->get("ca_entities.address.postalcode");
							}
							if($t_item->get("ca_entities.address.country")){
								$va_address_line3[] = $t_item->get("ca_entities.address.country");
							}
							if(sizeof($va_address_line3) > 0){
								print join(", ", $va_address_line3);
							}
							print "</div><!-- end unit -->";
						}
						if($t_item->get("ca_entities.external_link.url_entry")){
							print "<div class='unit'><span class='subtitletextcaps'>"._t("Link").":</span> <a href='".$t_item->get("ca_entities.external_link.url_entry")."' target='_blank'>".$t_item->get("ca_entities.external_link.url_entry")."</a></div><!-- end unit -->";
						}
					
					break;
					# --------------------------
					case $vn_organization_id:
					
						if($t_item->get("ca_entities.business_type")){
							print "<div class='unit'><span class='subtitletextcaps'>"._t("Business Type").":</span> ".$t_item->get("ca_entities.business_type")."</div>";
						}
						if($t_item->get("ca_entities.entity_founded")){
							print "<div class='unit'><span class='subtitletextcaps'>"._t("Date Founded").":</span> ".$t_item->get("ca_entities.entity_founded")."</div>";
						}
						if($t_item->get("ca_entities.entity_incorporated")){
							print "<div class='unit'><span class='subtitletextcaps'>"._t("Date Incorporated").":</span> ".$t_item->get("ca_entities.entity_incorporated")."</div>";
						}
						if($t_item->get("ca_entities.entity_liquidated")){
							print "<div class='unit'><span class='subtitletextcaps'>"._t("Date Liquidated").":</span> ".$t_item->get("ca_entities.entity_liquidated")."</div>";
						}
						if($t_item->get("ca_entities.entity_brands")){
							$va_brands = array();
							foreach($t_item->get("ca_entities.entity_brands", array("returnAsArray" => 1)) as $i => $va_brand_info){
								$va_brands[] = $va_brand_info["entity_brands"];
							}
							print "<div class='unit'><span class='subtitletextcaps'>"._t("Brand(s)").":</span> ".join(", ", $va_brands)."</div>";
						}
						if($t_item->get("ca_entities.products")){
							print "<div class='unit'><span class='subtitletextcaps'>"._t("Product(s)").":</span> ".$t_item->get("ca_entities.products")."</div>";
						}
						if($t_item->get("ca_entities.add_info")){
							print "<div class='unit'><span class='subtitletextcaps'>"._t("Additional Info").":</span> ".$t_item->get("ca_entities.add_info")."</div>";
						}
						if($t_item->get("ca_entities.remarks")){
							print "<div class='unit'><span class='subtitletextcaps'>"._t("Remarks").":</span> ".$t_item->get("ca_entities.remarks")."</div>";
						}
						if($t_item->get("ca_entities.remarks_source")){
							print "<div class='unit'><span class='subtitletextcaps'>"._t("Remarks Source").":</span> ".$t_item->get("ca_entities.remarks_source")."</div>";
						}
						if($t_item->get("ca_entities.address")){
							print "<div class='unit'><span class='subtitletextcaps'>"._t("Address").":</span><br/>";
							if($t_item->get("ca_entities.address.address1")){
								print $t_item->get("ca_entities.address.address1")."<br/>";
							}
							if($t_item->get("ca_entities.address.address2")){
								print $t_item->get("ca_entities.address.address2")."<br/>";
							}
							$va_address_line3 = array();
							if($t_item->get("ca_entities.address.city")){
								$va_address_line3[] = $t_item->get("ca_entities.address.city");
							}
							if($t_item->get("ca_entities.address.county")){
								$va_address_line3[] = $t_item->get("ca_entities.address.county");
							}
							if($t_item->get("ca_entities.address.stateprovince")){
								$va_address_line3[] = $t_item->get("ca_entities.address.stateprovince");
							}
							if($t_item->get("ca_entities.address.postalcode")){
								$va_address_line3[] = $t_item->get("ca_entities.address.postalcode");
							}
							if($t_item->get("ca_entities.address.country")){
								$va_address_line3[] = $t_item->get("ca_entities.address.country");
							}
							if(sizeof($va_address_line3) > 0){
								print join(", ", $va_address_line3);
							}
							print "</div><!-- end unit -->";
						}
						if($t_item->get("ca_entities.external_link.url_entry")){
							print "<div class='unit'><span class='subtitletextcaps'>"._t("Link").":</span> <a href='".$t_item->get("ca_entities.external_link.url_entry")."'>".$t_item->get("ca_entities.external_link.url_entry")."</a></div><!-- end unit -->";
						}
					break;
					# --------------------------
					# --- individuals and families
					default:
						if($t_item->get("ca_entities.lifespan")){
							print "<div class='unit'><span class='subtitletextcaps'>"._t("Lifetime").":</span> ".$t_item->get("ca_entities.lifespan")."</div><!-- end unit -->";
						}
						if($t_item->get("ca_entities.nationality")){
							print "<div class='unit'><span class='subtitletextcaps'>"._t("Nationality").":</span> ".$t_item->get("ca_entities.nationality")."</div><!-- end unit -->";
						}
					
					break;
					# --------------------------
				}					
?>				
									
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
					{{{map}}}
					<div id="detailTools">
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
					</div><!-- end detailTools -->
								
					{{{<ifcount code="ca_collections" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><H6>Related collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_entities.related" min="1" max="1"><H6>Related person</H6></ifcount>}}}
					{{{<ifcount code="ca_entities.related" min="2"><H6>Related people</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.related.preferred_labels.displayname</l></unit>}}}
					
					{{{<ifcount code="ca_occurrences" min="1" max="1"><H6>Related occurrence</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="2"><H6>Related occurrences</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}				
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="2">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'entity_id:^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
</ifcount>}}}
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->