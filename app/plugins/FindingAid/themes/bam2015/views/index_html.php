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
				<div class="container">
					<div class="row">
						<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'></div>
						<div class='col-xs-10 col-sm-10 col-md-10 col-lg-10'>
							<div class='detailHead'>
								<div class='leader'>Finding Aids</div>
								<h2>Archival and Manuscript Collections</h2>
								<p style='margin-top:15px;'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec blandit, nulla eget rhoncus mollis, nunc lacus interdum neque, a suscipit nisl nisi at tellus. Ut nec nisl et ipsum porttitor bibendum eu eget ante. Quisque nunc erat, euismod in felis et, eleifend elementum ex.</p>
							</div>
						</div>
						<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'></div>
					</div>
					<div class="row">
					<hr class='divide'>

	
<?php	
	if ($qr_top_level_collections) {
		while($qr_top_level_collections->nextHit()) { 
			$vn_top_level_collection_id = $qr_top_level_collections->get('ca_collections.collection_id');
				$vn_collection_image = $qr_top_level_collections->getWithTemplate('<unit relativeTo="ca_objects" length="1"><unit relativeTo="ca_object_representations" length="1">^ca_object_representations.media.widepreview</unit></unit>', array('checkAccess' => $va_access_values));
			//print $qr_top_level_collections->get('ca_collections.preferred_labels.name')."<br>\n";
				print "<div class='col-xs-6 col-sm-6 col-md-6 col-lg-6'>";
				print "<div class='row'>";
				print "<div class='collectionGraphic col-xs-4 col-sm-4 col-md-4 col-lg-4'>";
				print $vn_collection_image;
				print "</div>";
				print "<div class='col-xs-8 col-sm-8 col-md-8 col-lg-8'>";
				print "<div class='collectionName' >";
				print $qr_top_level_collections->get('ca_collections.preferred_labels', array('returnAsLink' => true));
				print "</div>\n";
				if (strlen($qr_top_level_collections->get('ca_collections.scopeContent')) > 250) {
					print "<p>".substr($qr_top_level_collections->get('ca_collections.scopeContent'), 0, 247)."...</p>";				
				} else {
					print "<p>".$qr_top_level_collections->get('ca_collections.scopeContent')."</p>";
				}
				print "</div>\n";
				print "</div>\n";
				print "</div>\n";	
		}
	} else {
		print _t('No collections available');
	}
?>
	
						
				</div> <!-- end container--></div> <!-- end row-->	
			</div> <!-- end content-inner -->
		</div> <!-- end content-wrapper -->	
	</div> <!-- end wrapper -->	
</div> <!-- end page -->		
	
	
	
	
