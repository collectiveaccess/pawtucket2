<?php
	$t_collection = $this->getVar('t_collection');
	$ps_template = $this->getVar('display_template');
	$vs_page_title = $this->getVar('page_title');
	$vs_intro_text = $this->getVar('intro_text');
	$va_open_by_default = $this->getVar('open_by_default');
	
	$qr_top_level_collections = ca_collections::find(array('parent_id' => null), array('returnAs' => 'searchResult'));
	
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

	<h1><?php print $vs_page_title; ?></h1>
	<div class='findingIntro'><?php print $vs_intro_text; ?></div>
	<div id='findingAidCont'>
<?php	
	if ($qr_top_level_collections) {
		while($qr_top_level_collections->nextHit()) { 
			$vn_top_level_collection_id = $qr_top_level_collections->get('ca_collections.collection_id');
			//print $qr_top_level_collections->get('ca_collections.preferred_labels.name')."<br>\n";

				print "<div class='collHeader' >";
				print $qr_top_level_collections->get('ca_collections.preferred_labels', array('returnAsLink' => true));
				print " (".$qr_top_level_collections->get('ca_collections.idno').")";
				print "<br/>";
				print $qr_top_level_collections->get('ca_collections.adminbiohist');
				print "</div>\n";	
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
	
	
	
	
