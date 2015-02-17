<?php
	$va_comments = $this->getVar("comments");
	$t_item = $this->getVar("item");
	$va_access_values = $this->getVar('access_values');

?>
<div class="container">
	<div class="row">
		<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
			<div class="detailNavBgLeft">
				{{{resultsLink}}}<div class='detailPrevLink'>{{{previousLink}}}</div>
			</div><!-- end detailNavBgLeft -->
		</div><!-- end col -->
		<div class='col-xs-10 col-sm-10 col-md-10 col-lg-10'>
	
		</div>
		<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
			<div class="detailNavBgRight">
				{{{nextLink}}}
			</div><!-- end detailNavBgLeft -->
		</div><!-- end col -->
	</div>
	<div class="row">
		<div class='col-md-12 col-lg-12'>
			<H4>Loan</H4>
			<H6></H6>
		</div><!-- end col 12-->
	</div><!-- end row -->
	<div class="row">
		<div class='col-xs-12 col-sm-7 col-md-6 col-lg-6'>
			<div class="row">
<?php
				$va_related_artworks = $t_item->get('ca_objects.object_id', array('checkAccess' => caGetUserAccessValues($this->request), 'returnAsArray' => true));
				foreach ($va_related_artworks as $vn_id => $va_related_artwork) {
					$t_object = new ca_objects($va_related_artwork);

					$va_reps = $t_object->getPrimaryRepresentation(array('versions' => 'medium'), null, array("checkAccess" => $va_access_values, 'scaleCSSHeightTo' => '260px', 'scaleCSSWidthTo' => '220px'));
					print "<div class='col-xs-12 col-sm-6 col-md-6 col-lg-6 relatedLoan'>"; 

					print "<div class='loanImg'>".caNavLink($this->request, $va_reps['tags']['medium'], '', '', 'Detail', 'artworks/'.$va_related_artwork)."</div>";
					print "<div class='lotCaption'>";
					print "<p>".caNavLink($this->request, $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist'))), '', '', 'Detail', 'artworks/'.$va_related_artwork)."</p>";
					print "<p>".caNavLink($this->request, "<i>".$t_object->get('ca_objects.preferred_labels')."</i>, ".$t_object->get('ca_objects.creation_date'), '', '', 'Detail', 'artworks/'.$va_related_artwork)."</p>";
					print "<p>".$t_object->get('ca_objects.medium')."</p>";
					print "<p>".$t_object->get('ca_objects.dimensions.display_dimensions')."</p>";
					if ($this->request->user->hasUserRole("founders_new") || $this->request->user->hasUserRole("admin") || $this->request->user->hasUserRole("curatorial_all_new") || $this->request->user->hasUserRole("curatorial_basic_new") || $this->request->user->hasUserRole("archives_new") || $this->request->user->hasUserRole("library_new")){
						print "<p>".$t_object->get('ca_objects.idno')."</p>";
					}				
					print "</div><!-- end lotCaption -->";
					print "</div>";
				}
?>				
			</div><!-- end row -->	
		</div><!-- end col 6-->		
		<div class='col-xs-12 col-sm-5 col-md-6 col-lg-6'>				
			{{{<ifcount code="ca_entities" min="1" relativeTo="ca_entities" restrictToRelationshipTypes="borrower" ><div class="unit"><span class='metaTitle'>Borrower: </span><span class="meta"><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="borrower"><l>^ca_entities.preferred_labels.displayname</l></unit></span></div></ifcount>}}}
			{{{<ifdef code="ca_loans.exhibition_title"><div class="unit"><span class='metaTitle'>Exhibition Title: </span><span class="meta"><i>^ca_loans.exhibition_title</i></span></div></ifdef>}}}			
			{{{<ifdef code="ca_loans.exhibition_dates"><div class="unit"><span class='metaTitle'>Exhibition Dates: </span><span class="meta">^ca_loans.exhibition_dates</span></div></ifdef>}}}			
			{{{<ifcount code="ca_loans.traveling_info" min="1"><div class="unit"><span class='metaTitle'>Location: </span><span class="meta"><unit delimiter="<br/>">^ca_loans.traveling_info.institution<span>:</span><br/> ^ca_loans.traveling_info.institution_dates</unit></span></div></ifcount>}}}			
			{{{<ifdef code="ca_loans.lent_by"><div class="unit"><span class='metaTitle'>Lender: </span><span class="meta">^ca_loans.lent_by</span></div></ifdef>}}}			
			{{{<ifdef code="ca_loans.loan_credit"><div class="unit"><span class='metaTitle'>Credit Line: </span><span class="meta">^ca_loans.loan_credit</span></div></ifdef>}}}			
			{{{<ifdef code="ca_loans.gf_contact"><div class="unit"><span class='metaTitle'>Glenstone Contact: </span><span class="meta">^ca_loans.gf_contact</span></div></ifdef>}}}			
			{{{<ifdef code="ca_loans.loan_period"><div class="unit"><span class='metaTitle'>Loan Period: </span><span class="meta">^ca_loans.loan_period</span></div></ifdef>}}}						
			{{{<ifdef code="ca_loans.loan_note"><div class="unit"><span class='metaTitle'>Description: </span><span class="meta">^ca_loans.loan_note</span></div></ifdef>}}}			
			
			{{{<ifdef code="ca_loans.approval"><div class="unit"><span class='metaTitle'>Approval Status: </span><span class="meta">^ca_loans.approval.approval_list ^ca_loans.approval.approval_date</span></div></ifdef>}}}			
			{{{<ifdef code="ca_loans.aggreement_received"><div class="unit"><span class='metaTitle'>Agreement Received: </span><span class="meta">^ca_loans.aggreement_received.aggreement_list ^ca_loans.aggreement_received.aggreement_date</span></div></ifdef>}}}			
<?php
			if ($this->request->user->hasUserRole("founders_new") || $this->request->user->hasUserRole("admin") || $this->request->user->hasUserRole("curatorial_all_new") || $this->request->user->hasUserRole("art_insurance_loan")){
				if ($va_insurance_value = $t_object->get('ca_loans.loan_insurance.loan_insurance_value', array('delimiter' => '<br/>'))) {
					print '<div class="unit"><span class="metaTitle">Loan Insurance: </span><span class="meta">'.$va_insurance_value.'</span></div>';
				}
			}
?>			
			{{{<ifdef code="ca_loans.loan_conditions"><div class="unit"><span class='metaTitle'>Loan Conditions: </span><span class="meta">^ca_loans.loan_conditions</span></div></ifdef>}}}			
<?php
			if ($t_item->get('ca_loans.loan_documents.loan_documents_media')){
				$va_loan_images = $t_item->get('ca_loans.loan_documents', array('returnAsArray' => true, 'ignoreLocale' => true, 'rawDate' => 1, 'version' => 'icon')); 
				print '<div class="unit "><span class="metaTitle">&nbsp;</span><span class="meta">';

				$o_db = new Db();
				$vn_media_element_id = $t_item->_getElementID('loan_documents_media');
				foreach ($va_loan_images as $vn_loan_id => $va_loan_image) {
					if ($va_loan_image['loan_documents_primary'] == 162) {
						$qr_res = $o_db->query('SELECT value_id FROM ca_attribute_values WHERE attribute_id = ? AND element_id = ?', array($vn_loan_id, $vn_media_element_id)) ;
						if ($qr_res->nextRow()) {
							print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaInfo/ca_loans', array('loan_id' => $vn_loan_id, 'value_id' => $qr_res->get('value_id')))."\"); return false;'>".$va_loan_image['loan_documents_media']."</a>";

						}
					}
				}
				print "</span><div class='clearfix'></div></div>";
			}

?>			
		</div><!-- end col -->
	</div>	<!-- end row-->
</div>
