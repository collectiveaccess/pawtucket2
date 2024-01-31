<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
	$vs_inventory_text = $this->getVar("collections_inventory_text");
					
	$va_sorts = array("title", "date");
	$ps_sort = $this->request->getParameter('sort', pString);

	if(!$ps_sort){
		$ps_sort = Session::getVar("collection_section_sort");
	}elseif(in_array($ps_sort, $va_sorts)){
		Session::setVar("collection_section_sort", $ps_sort);
	}
	if(!$ps_sort){
		$ps_sort = "title";
	}

	$va_results = array();
	$va_sort_results = array();
	if($qr_collections && $qr_collections->numHits()) {
		while($qr_collections->nextHit()) {
			switch($ps_sort){
				case "date":
					$va_date = array_pop(array_pop($qr_collections->get("ca_collections.collection_date2.collection_date_inclusive", array("returnWithStructure" => true, "rawDate" => true))));
					$va_sort_results[$qr_collections->get("ca_collections.collection_id")] = $va_date["collection_date_inclusive"]["start"];
				break;
				# ----------------------
				case "title":
				default:
					$va_sort_results[$qr_collections->get("ca_collections.collection_id")] = $qr_collections->get("ca_collections.preferred_labels");
				break;
				# ----------------------
			}
			$vs_link_text = "";
			$vs_link_text = trim($qr_collections->get("ca_collections.preferred_labels"));
			if($vs_tmp = $qr_collections->get("ca_collections.collection_date2.collection_date_inclusive")){
				$vs_link_text .= ", ".$vs_tmp;
			}
			$va_results[$qr_collections->get("ca_collections.collection_id")] = $vs_link_text; 
		}
		# --- sort array
		asort($va_sort_results);
		
	}
?>
	<div class="row">
		<div class='col-md-12'>
			<h1><?php print $this->getVar("section_name"); ?></h1>
<?php
			#print "<p>Click here for the ".caNavLink($this->request, _t("Manuscript Collections Advanced Search"), "", "Search", "Advanced", "collections").".</p>";
			if($vs_inventory_text){
?>
				<p><?php print $vs_inventory_text; ?></p>
<?php
			}
?>
			<p>{{{collections_intro_text}}}</p>
<?php
			$vs_xls = $this->getVar("collections_inventory_xls");
			$vs_pdf = $this->getVar("collections_inventory_pdf");
			if($vs_xls || $vs_pdf){
?>
				<p class="text-center">
<?php
				if($vs_xls){
?>
					<span class="inventoryDownloadLink">&nbsp;<a href="<?php print $vs_xls; ?>" class="btn-default">Download Inventory (Excel)</a>&nbsp;</span>
<?php
				}
				if($vs_pdf){
?>
					<span class="inventoryDownloadLink">&nbsp;<a href="<?php print $vs_pdf; ?>" class="btn-default">Download Inventory (PDF)</a>&nbsp;</span>
<?php
				}
?>
				</p>
<?php
			}
?>
		</div>
	</div>
	<div class="row">
		<div class='col-md-12 col-lg-12 collectionsList'>
<?php	
	$vn_i = 0;
	
	if(is_array($va_sort_results) && sizeof($va_sort_results)) {
?>
		<div class='row'>
			<div class='col-md-8 col-md-offset-2 text-center'><div class='collectionUnit'>
				<h5 id="bSortByList">
					<ul>
						<li><strong>Sort by:</strong></li>
						<li <?php print ($ps_sort == 'title') ? 'class="selectedSort"' : ''; ?>><?php print caNavLink($this->request, "Title", "", "", "Collections", "Index", array("sort" => "title")); ?></li>
						<li class="divide">&nbsp;</li>
						<li <?php print ($ps_sort == 'date') ? 'class="selectedSort"' : ''; ?>><?php print caNavLink($this->request, "Date", "", "", "Collections", "Index", array("sort" => "date")); ?></li>
					</ul>
				</h5>
			</div></div>
		</div>
<?php
		foreach($va_sort_results as $vn_collection_id => $vs_sort_val){
			$vs_link_text = $va_results[$vn_collection_id];
			print "<div class='row'><div class='col-md-8 col-md-offset-2'><div class='collectionUnit'>";
			print "<div class='viewCollectionLinkList'>".caDetailLink($this->request, "View <span class='glyphicon glyphicon-circle-arrow-right'></span>", "", "ca_collections",  $vn_collection_id)."</div>";
			print "<div class='title'>".caDetailLink($this->request, $vs_link_text, "", "ca_collections",  $vn_collection_id)."</div></div>";
			print "</div></div>";

		}
	} else {
		print _t('No collections available');
	}
?>
		</div>
	</div>
