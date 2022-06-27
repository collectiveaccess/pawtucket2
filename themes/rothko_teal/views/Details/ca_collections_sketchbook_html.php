<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_id = $t_item->get('ca_collections.collection_id');
	
	$t_list = new ca_lists();
	$yes_list_value_id =  $t_list->getItemIDFromList('yes_no', 'yes');
	$current_list_value_id =  $t_list->getItemIDFromList('current_previous', 'current');

?>
<div class="container">
	<div class="row">
		<div class="col-xs-1"><div class='previousLink'>{{{previousLink}}}</div></div>
		<div class="col-xs-10">


<div class="container">
	<div class="row detailHead">
		<div class='col-xs-6 objNav'><!--- only shown at small screen size -->
			<div class='resultsLink'>{{{resultsLink}}}</div>
		</div>
		<div class='col-xs-5 pdfLink'>
	<?php		
			#print caNavLink($this->request, caGetThemeGraphic($this->request, 'pdf.png'), 'faDownload', 'Detail', 'objects', $vn_id.'/view/pdf/export_format/_pdf_ca_objects_summary');
	?>	
		</div><!-- end col --> 
	</div>
<div class="row">
	<div class='col-xs-12 col-md-7 col-lg-7' style="padding-right:30px;margin-bottom:40px;">
		{{{representationViewer}}}
<?php
			if ($va_catalog_id = $t_item->get('ca_collections.institutional_id')) {
				print "<div class='objIdno'>".$va_catalog_id."</div>";
			}	
?>		
	</div>	
	<div class='col-xs-12 col-sm-10 col-sm-offset-1 col-md-offset-0 col-md-5 col-lg-5 artworkInfo'>
<?php
		$vn_label_col = "col-sm-4";
		$vn_data_col = "col-sm-8";
		print "<h1>".$t_item->get('ca_collections.preferred_labels')."</h1>";
		if ($vs_date = $t_item->get('ca_collections.display_date')) {
			print "<div class='unit row'><div class='{$vn_label_col} label'>Date</div><div class='$vn_data_col'>".$vs_date."</div></div>";
		}		
		$vs_verso_collection = null;
		if ($qr_collections = $t_item->get('ca_collections_x_collections.relation_id', array('returnAsSearchResult' => true))) {
			#print "hits=".$qr_collections->numHits(); 
			while($qr_collections->nextHit()) {
				if ($qr_collections->get('ca_collections.deleted') === null) { continue; } // you check for null because get() won't return info about deleted items
				
				if ($qr_collections->get('ca_collections_x_collections.current_collection') == $current_list_value_id) {
					$vn_current_collection_id = $qr_collections->get('ca_collections_x_collections.collection_id');
					$t_collection = new ca_collections($vn_current_collection_id);
					if ($t_collection->get('ca_collections.public_private', array('convertCodesToDisplayText' => true)) != 'private'){
						print "<div class='unit row'><div class='{$vn_label_col} label'>Collection</div><div class='$vn_data_col'>".$qr_collections->getWithTemplate('<unit relativeTo="ca_collections" restrictToTypes="collection,other"><l>^ca_collections.preferred_labels</l></unit>');
						$vs_verso_collection = $qr_collections->getWithTemplate('<unit relativeTo="ca_collections" restrictToTypes="collection,other"><l>^ca_collections.preferred_labels</l></unit>');
					} else {
						print "<div class='unit row'><div class='{$vn_label_col} label'>Collection</div><div class='$vn_data_col'>".$qr_collections->getWithTemplate('<unit relativeTo="ca_collections" restrictToTypes="collection,other">^ca_collections.preferred_labels</unit>');
						$vs_verso_collection = $qr_collections->getWithTemplate('<unit relativeTo="ca_collections" restrictToTypes="collection,other">^ca_collections.preferred_labels</unit>');
					}
					if ($vs_credit_line = $qr_collections->get('ca_collections_x_collections.collection_line', array('restrictToTypes' => array('collection', 'other')))) {
						print ", ".$vs_credit_line;
					}
					if ($qr_collections->get('ca_collections_x_collections.uncertain') == $yes_list_value_id){
						"<span class='rollover' data-toggle='popover' data-trigger='hover' data-content='uncertain'><i class='fa fa-question-circle' ></i></span>";
					}
					print "</div></div><!-- end unit -->";							
				}		
			}
		}		
		if ($vs_credit = $t_item->get('ca_collections.collection_line')) {
			print "<div class='unit row'><div class='{$vn_label_col} label'>Credit</div><div class='$vn_data_col'>".$vs_credit."</div></div>";
		}
		if ($vs_inst = $t_item->get('ca_collections.institutional_id')) {
			print "<div class='unit row'><div class='{$vn_label_col} label'>Institution Identifier</div><div class='$vn_data_col'>".$vs_inst."</div></div>";
		}				
		if ($vs_provenance_note = $t_item->get('ca_collections.provenance_note')) {
			print "<div class='unit row'><div class='{$vn_label_col} label'>Provenance Notes</div><div class='$vn_data_col'>".$vs_provenance_note."</div></div>";
		}	
		if ($vs_object_note = $t_item->get('ca_collections.object_note')) {
			print "<div class='unit row'><div class='{$vn_label_col} label'>Note</div><div class='$vn_data_col'>".$vs_object_note."</div></div>";
		}	
		if ($va_keywords = $t_item->get('ca_list_items.item_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
			$va_keyword_links = array();
			foreach ($va_keywords as $va_key => $va_keyword_id) {
				$va_keyword_links[] = caNavLink($this->request, ucFirst(caGetListItemByIDForDisplay($va_keyword_id)), '', '', 'Browse', 'artworks/facet/term_facet/id/'.$va_keyword_id);	
			}
			print "<div class='unit row'><div class='{$vn_label_col} label'>Tags</div><div class='$vn_data_col'>".join(', ', $va_keyword_links)."</div></div>";
		}
		print "<div class='detailDivider row' style='margin-bottom:60px;'></div>";							
?>			
	</div><!-- end col -->
</div><!-- end row -->
<div class='row'>
	<div class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2'>
<?php
		if ($vs_remarks = $t_item->get('ca_collections.remarks')) {
			print "<div class='drawer'>";
			print "<h6><a href='#' data-toggleDiv='remarksDiv' class='togglertronic'>Remarks <i class='fa fa-minus drawerToggle'></i></a></h6>";
			print "<div id='remarksDiv'>".$vs_remarks."</div>";
			print "</div>";
		}
?>		
	</div><!-- end col -->
</div><!-- end row -->
<?php
	$vs_provenance = "";
	if ($va_provenance = $t_item->get('ca_collections_x_collections.relation_id', array('returnWithStructure' => true, 'restrictToTypes' => array('collection', 'other'), 'sort' => 'ca_collections_x_collections.rank', 'sortOrder' => 'ASC'))) {
		foreach ($va_provenance as $va_key => $va_relation_id) {
			$t_prov_rel = new ca_collections_x_collections($va_relation_id);
			$va_collection_ids = $t_prov_rel->get('ca_collections.collection_id', array('returnAsArray' => true));
			if(($key = array_search($vn_id, $va_collection_ids)) !== false) {
				unset($va_collection_ids[$key]);
			}
			$t_prov = new ca_collections($va_collection_ids[0]);
			if ($t_prov->get('ca_collections.public_private', array('convertCodesToDisplayText' => true)) == 'private') {
				$vs_provenance.= "<div>";
				$vs_provenance.= $t_prov->get('ca_collections.preferred_labels');
				if ($vs_display_date = $t_prov_rel->get('ca_collections_x_collections.display_date')) {
					$vs_provenance.= ", ".$vs_display_date;
				}				
				if ($vs_remark = $t_prov_rel->get('ca_collections_x_collections.collection_line')) {
					$vs_provenance.= ", ".$vs_remark;
				}				
				$vs_provenance.= "</div>";
			} elseif ($t_prov->get('access') != 0 ){
				$va_provenance_id = $t_prov->get('ca_collections.collection_id');
				$vs_provenance_line = $t_prov->get('ca_collections.preferred_labels');				
				if ($t_prov_rel) {
					$vs_buf = array();
					if ($vs_auction_name = $t_prov_rel->get('ca_collections_x_collections.auction_name')) {
						$vs_buf[]= $vs_auction_name;
					}						
					if ($vs_sale = $t_prov_rel->get('ca_collections_x_collections.sale_name')) {
						$vs_buf[]= $vs_sale;
					}
					if ($vs_display_date = $t_prov_rel->get('ca_collections_x_collections.display_date')) {
						$vs_buf[]= $vs_display_date;
					}
					if ($vs_lot_number = $t_prov_rel->get('ca_collections_x_collections.lot_number')) {
						$vs_buf[]= "Lot number ".$vs_lot_number;
					}
					if ($t_prov_rel->get('ca_collections_x_collections.gift_artist') == $yes_list_value_id) {
						$vs_buf[] = "gift of the artist";
					}
					if ($t_prov_rel->get('ca_collections_x_collections.sold_yn') == 163) { 
						$vs_buf[]= "(not sold)";
					}	
					if (is_array($vs_buf) && (sizeof($vs_buf) > 0)){
						$vs_provenance_line.= ", ".join(', ', $vs_buf);
					}
					if ($vs_remark = $t_prov_rel->get('ca_collections_x_collections.collection_line')) {
						$vs_provenance_line.= ", ".$vs_remark;
					}
				}
				if ($t_prov_rel->get('ca_collections_x_collections.uncertain') == $yes_list_value_id) {
					$vs_provenance_line.= " <span class='rollover' data-toggle='popover' data-trigger='hover' data-content='uncertain'><i class='fa fa-question-circle' ></i></span>";
				}
				$vs_provenance_line.= "<i class='fa fa-chevron-right'></i><!-- end prov entry -->";
				$vs_provenance.= "<div>".caNavLink($this->request, $vs_provenance_line, '', '', 'Detail', 'collections/'.$va_provenance_id)."</div>";
			}
		}
	}
	if ($vs_provenance != "") {
		print "<div class='row'><div class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2'><div class='drawer'>";
		print "<h6><a href='#' data-toggleDiv='provenanceDiv' class='togglertronic'>Provenance <i class='fa fa-minus drawerToggle'></i></a></h6>";
		print "<div id='provenanceDiv'>";
		print $vs_provenance;
		print "</div><!-- end provenanceDiv -->";
		print "</div><!-- end drawer --></div><!-- end col --></div><!-- end row -->";
	}
?>

{{{<ifcount code="ca_objects" relativeTo="ca_objects"  min="1">
	
	<div class="row"><div class='col-sm-12'>

		<div id="browseResultsContainer">
			<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
		</div><!-- end browseResultsContainer -->
	</div><!-- end col --></div><!-- end row -->
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'worksInCollection', array('facet' => 'collection', 'id' => '^ca_collections.collection_id', 'detailNav' => 1), array('dontURLEncodeParameters' => true)); ?>", function() {
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
					
<script>
	jQuery(document).ready(function() {
		$('.rollover').popover(); 

        jQuery('.togglertronic').on('click', function(e) {
            var state = jQuery(this).data('togglestate');
            
            var toggle = this;
            if (state == 'open') {
                jQuery('#' + jQuery(toggle).data('togglediv')).slideUp(200, function() {
                    jQuery(toggle).data('togglestate', 'closed').find('.drawerToggle').hide().attr("class", "fa fa-plus drawerToggle").show();
                });
            } else {
                jQuery('#' + jQuery(toggle).data('togglediv')).slideDown(200, function() {
                    jQuery(toggle).data('togglestate', 'open').find('.drawerToggle').hide().attr("class", "fa fa-minus drawerToggle").show();
                });
                
            }
            e.preventDefault();
            return false;
        });	
	});

</script>

	


</div><!-- end container -->

		</div><!-- end col -->
		<div class="col-xs-1"><div class='nextLink'>{{{nextLink}}}</div></div>
	</div>
</div>
