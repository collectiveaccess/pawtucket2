<?php
	$t_collection = $this->getVar('t_collection');
	$ps_template = $this->getVar('display_template');
	$vs_page_title = $this->getVar('page_title');
	$vs_intro_text = $this->getVar('intro_text');
	$va_open_by_default = $this->getVar('open_by_default');
	$va_access_values = caGetUserAccessValues($this->request); 

	$va_home = caNavLink($this->request, "City Readers", '', '', '', '');
	MetaTagManager::setWindowTitle($va_home." > Finding Aids"); 
	
	$qr_top_level_collections = ca_collections::find(array('parent_id' => null), array('returnAs' => 'searchResult', 'checkAccess' => $va_access_values));
	
	if (!$va_open_by_default) {
		$vs_hierarchy_style = "style='display:none;'";
	}
?>

<div class="page">
	<div class="wrapper">
		<div class="sidebar">
		</div>
		<div class="content-wrapper">
      		<div class="content-inner">
				<div class="container"><div class="row">
					<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='margin-top:15px;'>

	<h4><?php print $vs_page_title; ?></h4>
	<div class='findingIntro'><?php print $vs_intro_text; ?></div>
	<div id='findingAidCont'>
<?php	
	if ($qr_top_level_collections) {
		$vn_i = 0;
		while($qr_top_level_collections->nextHit()) { 
			$vn_top_level_collection_id = $qr_top_level_collections->get('ca_collections.collection_id');
			if ($qr_top_level_collections->get('ca_collections.access') == 0){continue;}
			//print $qr_top_level_collections->get('ca_collections.preferred_labels.name')."<br>\n";

				print "<div class='collHeader' >";
?>				
				<div><?php print "<h3>".$qr_top_level_collections->get('ca_collections.preferred_labels')."</h3>";?></div>
<?php				
				print "<div id='abstract".$vn_i."'>";
				print $qr_top_level_collections->get('ca_collections.abstract');
				print "</div>";
				print "</div>\n";
			$vn_i++;	
		}
	} else {
		print _t('No collections available');
	}
?>
	</div>

	
					</div> <!-- end col-->	
				</div> <!-- end container--></div> <!-- end row-->	
			</div> <!-- end content-inner -->
		</div> <!-- end content-wrapper -->	
	</div> <!-- end wrapper -->	
</div> <!-- end page -->		
	
	
	
	
