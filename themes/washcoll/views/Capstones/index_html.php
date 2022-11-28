<?php
	$o_collections_config = $this->getVar("collections_config");
	$qr_collections = $this->getVar("collection_results");

	if($this->request->isLoggedIn()){
?>
	<div class="row">
		<div class='col-md-12 col-lg-12 collectionsList'>
			<h1>Senior Capstone Collection</h1>
			<p>{{{capstones_intro_text_logged_in}}}</p>
<?php	
	$vn_i = 0;
	if($qr_collections && $qr_collections->numHits()) {
		while($qr_collections->nextHit()) {			
			if ( $vn_i == 0) { print "<div class='row'>"; } 
			print "<div class='col-sm-6'><div class='collectionTile'><div class='title'>".caDetailLink($this->request, $qr_collections->get("ca_collections.preferred_labels"), "", "ca_collections",  $qr_collections->get("ca_collections.collection_id"))."</div>";	
			if (($o_collections_config->get("description_template")) && ($vs_scope = $qr_collections->getWithTemplate($o_collections_config->get("description_template")))) {
				print "<div>".$vs_scope."</div>";
			}
			print "</div></div>";
			$vn_i++;
			if ($vn_i == 2) {
				print "</div><!-- end row -->\n";
				$vn_i = 0;
			}
		}
		if (($vn_i < 2) && ($vn_i != 0) ) {
			print "</div><!-- end row -->\n";
		}
	} else {
		print _t('No collections available');
	}
?>
		</div>
	</div>
<?php
	}else{
?>
	<div class="row">
		<div class='col-md-12 col-lg-12'>
			<h1>Senior Capstone Collection</h1>
			<p>{{{capstones_intro_text_not_logged_in}}}</p>
		</div>
	</div>
	<div class="row">
		<div class='col-md-12 col-lg-12'>
			<H2 class="text-center">Login or register for access to the Capstones Collection</H2>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-2 col-sm-offset-4">
			<a href='#' class='btn-default' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array()); ?>"); return false;' >Login</a>
		</div><!--end col-sm-8-->
		<div class="col-xs-12 col-sm-2">
			<?php print caNavLink($this->request, "Register", "btn-default", "", "LoginReg", "RegisterFOrm"); ?>
		</div><!--end col-sm-8-->	
	</div><!-- end row -->
<?php	
	}
?>