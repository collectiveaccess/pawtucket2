<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");
			
	$vs_directory = __CA_THEME_DIR__."/assets/pawtucket/graphics/research/";
	$vn_filecount = 0;
	$va_files = glob($vs_directory . "*");
	if ($va_files){
	 $vn_filecount = count($va_files);
	}
?>
	<h1>Research</h1>
<?php
	print "<div class='bannerImg'>".caGetThemeGraphic($this->request, 'research/'.rand(1,$vn_filecount).'.jpg')."</div>";
?>
	<div class="row">
		<div class="col-sm-12 ">				
			<div class="quote">
				<div class="quoteText">
					"I am enclosing herewith original of Mrs. Harding's resignation as Honorary President of the Girl Scouts. I think it might be placed among the Girl Scout archives. Are you having kept a special file of historically interesting documents, as distinct from your regular routine files? Such a procedure always proves valuable."	
				</div>
				<div class="quoteCredit">&mdash; Lou Henry Hoover to Jane Deeter Rippin, September 15, 1923.</div>
			</div>		
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 ">
			<div class="band">
				<div>Research the Collection</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class='col-md-12 col-lg-12'>
<?php	
	$vs_col_1 = "";
	$vs_col_2 = "";
	
	if($qr_collections && $qr_collections->numHits()) {
		while($qr_collections->nextHit()) { 
			$vs_tmp = "";
			$vs_tmp .= "<div class='collectionBlock'><p>".caDetailLink($this->request, $qr_collections->get("ca_collections.preferred_labels"), "", "ca_collections",  $qr_collections->get("ca_collections.collection_id"))."</p>";	
			if (($o_collections_config->get("description_template")) && ($vs_scope = $qr_collections->getWithTemplate($o_collections_config->get("description_template")))) {
				$vs_tmp .= "<div>".caTruncateStringWithEllipsis($vs_scope, 230)."</div>";
			}
			$vs_tmp .= "</div>";
			if($qr_collections->get("institutional_collection")){
				$vs_col_1 .= $vs_tmp;
			}else{
				$vs_col_2 .= $vs_tmp;
			}
		}
?>
		<div class="row">
			<div class='col-md-6 collectionsLeftCol'>
				<h2>Institutional Collections</H2>
				<?php print $vs_col_1; ?>
			</div>
			<div class='col-md-6 collectionsRightCol'>
				<H2>Related Collections</H2>
				<?php print $vs_col_2; ?>
			</div>
		</div>
<?php
	} else {
		print _t('No collections available');
	}
?>
					</div>
				</div>
			</div>
