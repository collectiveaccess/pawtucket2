<?php
	$t_collection = $this->getVar('t_collection');
	$ps_template = $this->getVar('display_template');
	$vs_page_title = $this->getVar('page_title');
	$vs_intro_text = $this->getVar('intro_text');
	$va_open_by_default = $this->getVar('open_by_default');
	$va_access_values = caGetUserAccessValues($this->request);
		
	$vn_collection_type = $t_collection->getTypeIDForCode('collection');
	$qr_top_level_collections = ca_collections::find(array('type_id' => $vn_collection_type), array('returnAs' => 'searchResult', 'checkAccess' => $va_access_values));
	
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
					<div class='col-xs-6 col-sm-6 col-md-6 col-lg-6' style='margin-top:15px;'>

	<h2><?php print $vs_page_title; ?></h2>
	<div class='findingIntro'><?php print $vs_intro_text; ?></div>
	<div id='findingAidCont'>
<?php	
	if ($qr_top_level_collections) {
		while($qr_top_level_collections->nextHit()) { 
			$vn_top_level_collection_id = $qr_top_level_collections->get('ca_collections.collection_id');
			//print $qr_top_level_collections->get('ca_collections.preferred_labels.name')."<br>\n";

				print "<div class='collHeader' >";
				print $qr_top_level_collections->get('ca_collections.preferred_labels', array('returnAsLink' => true));
				print "</div>\n";	
		}
	} else {
		print _t('No collections available');
	}
?>
	</div>
					</div><!-- end col --> 
					<div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 archivesRight' >
<?php
					print caGetThemeGraphic($this->request, 'archives.jpg');
?>					
	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eget quam eu turpis pulvinar bibendum. Cras eu pellentesque mi. Donec quam ex, finibus et rhoncus quis, tristique et arcu. Nam suscipit sed diam sed pulvinar. Cras laoreet imperdiet leo ut rutrum. Suspendisse molestie commodo eros quis porta. Sed vulputate velit ac lacinia viverra. Curabitur scelerisque tristique massa, ac sollicitudin sem dignissim sed.
					</div> <!-- end col-->	
				</div> <!-- end container--></div> <!-- end row-->	
			</div> <!-- end content-inner -->
		</div> <!-- end content-wrapper -->	
	</div> <!-- end wrapper -->	
</div> <!-- end page -->		
	
	
	
	
