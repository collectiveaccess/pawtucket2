<?php
	require_once(__CA_MODELS_DIR__.'/ca_occurrences.php');
	require_once(__CA_LIB_DIR__.'/ca/Search/OccurrenceSearch.php');
	$va_access_values = caGetUserAccessValues($this->request);
	
	$o_search = new OccurrenceSearch();
	$o_search->setTypeRestrictions(array('report'));
	$qr_res = $o_search->search("*", array('checkAccess' => $va_access_values));
	
	
		# -------------------------------------------------------
 		# Media attribute bundle download
 		# -------------------------------------------------------
 		/**
 		 * Initiates user download of media stored in a media attribute, returning file in response to request.
 		 * Adds download output to response directly. No view is used.
 		 *
 		 * @param array $pa_options Array of options passed through to _initView 
 		 */
 		if(!function_exists("caDownloadAttributeMedia")) {
			function caDownloadAttributeMedia($po_request, $po_response, $pn_occurrence_id, $ps_version, $pa_options=null) {
				$o_view = new View($po_request, $po_request->getViewsDirectoryPath().'/bundles/');
				$t_occurrence = new ca_occurrences($pn_occurrence_id);
				if (!$t_occurrence->getPrimaryKey()) { return null; }
			
				$vs_path = $t_occurrence->get('ca_occurrences.report_file', array('version' => $ps_version, 'return' => 'path'));
				$vs_path_ext = pathinfo($vs_path, PATHINFO_EXTENSION);
				if(!$vs_title = trim($t_occurrence->get('ca_occurrences.preferred_labels.name'))) { $vs_title = "report"; }
				$vs_name = _t(preg_replace('![^A-Za-z0-9\,\/\?\"\']+!', '_', $vs_title).".{$vs_path_ext}");
			
				$o_view->setVar('file_path', $vs_path);
				$o_view->setVar('file_name', $vs_name);
			
				// send download
			 	return $o_view->render('ca_attributes_download_media.php');
			}
		}
		
	
	
	if (
		($this->request->getParameter('download', pInteger) == 1)
		&&
		($vn_occurrence_id = $this->request->getParameter('occurrence_id', pInteger))
	) {
		$va_occurrence_ids = array();
		while($qr_res->nextHit()) {
			$va_occurrence_ids[] = $qr_res->get('ca_occurrences.occurrence_id');
		}
		if (!in_array($vn_occurrence_id, $va_occurrence_ids)) { die("Invalid id"); }
		print caDownloadAttributeMedia($this->request, $this->getVar('response'), $vn_occurrence_id, 'original');
		exit;
	}
?>
<div class="container">
	<div class="row">
		<div class="col-sm-8">
<?php
	

	if ($vn_c = $qr_res->numHits() > 0) {
?>	
			<H1><?php print ($vn_c == 1) ? _t('1 report is available.') : _t('%1 reports are available.', $vn_c); ?></H1>
<?php
		print "<ul>\n";
		while($qr_res->nextHit()) {
			print '<li><span class="caReportLabel">'.$qr_res->get('ca_occurrences.preferred_labels.name').'</span> '.caNavLink($this->request, 'Download', 'button', '*', '*', '*', array('download' => 1, 'occurrence_id' => $qr_res->get('occurrence_id'), 'version' => 'original'))."</li>\n";
		}
		print "</ul>\n";
	} else {
?>	
			<H1>No reports are available.</H1>
<?php
	}
?>
		</div><!--end col-sm-8-->	
		<div class="col-sm-4">
			
		</div> <!--end col-sm-4-->	
	</div><!-- end row -->
</div> <!--end container-->