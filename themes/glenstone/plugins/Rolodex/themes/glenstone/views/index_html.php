<div id="rolodex">

	<h1>Rolodex</h1>
<?php
	if ($this->request->user && ($this->request->user->hasUserRole("founders_new") || $this->request->user->hasUserRole("admin")  || $this->request->user->hasUserRole("curatorial_all_new") || $this->request->user->hasUserRole("curatorial_basic_new") || $this->request->user->hasUserRole("archives_new") || $this->request->user->hasUserRole("library_new"))){				
?>	
	<h5>Find contacts using the search fields below</h5> 

<?php
	print "<div class='row'>";
	print caFormTag($this->request, 'Index', 'caRolodexForm', null, 'post', 'multipart/form-data', '_top', array('disableUnsavedChangesWarning' => true, 'submitOnReturn' => true));
	print "<div class='col-sm-4'><span class='formLabel'>"._t('First name')."</span>".caHTMLTextInput("forename", array('width' => '250px'))."</div>";
	print "<div class='col-sm-4'><span class='formLabel'>"._t('Last name/Organization name')."</span>".caHTMLTextInput("surname", array('width' => '250px'))."</div>";
	//print "<div class='col-sm-4'><span class='formLabel'>"._t('Affiliation')."</span>".caHTMLTextInput("company", array());
	print "<div class='submit'>".caFormSubmitLink($this->request, _t('Search  >'), 'searchSubmit', 'caRolodexForm')."</div></div>";
?>
	
<?php
	print "</form>\n";
	print "</div>";	
	if ($o_results = $this->getVar('results')) {
		print "<br/><h1>Results</h1>";
		print "<hr>";
		while($o_results->nextHit()) {
			print "<div class='row results'>";
			print "<div class='col-sm-4'>".$o_results->getWithTemplate("<l><b>^ca_entities.preferred_labels.displayname</b></l><br/>\n");
			if ($o_results->get("ca_entities.job_title")) {
				print $o_results->getWithTemplate("^ca_entities.job_title<br/>");
			}
			print $o_results->getWithTemplate("^ca_entities.affiliation", array('delimiter' => "<br/>"));
			print "</div><!-- end col -->";
			print "<div class='col-sm-4'>";
			if ($va_addresses = $o_results->get("ca_entities.address", array('returnWithStructure' => true, 'convertCodesToDisplayText' => true))) {
				foreach ($va_addresses as $va_add_key => $va_address_t) {
					foreach ($va_address_t as $va_add_key => $va_address) {
						#print_r($va_address);
						if ($va_address['address1']) {
							print $va_address['address1']."<br/>";
						}
						if ($va_address['address2']) {
							print $va_address['address2']."<br/>";
						}
						if ($va_address['city']) {
							print $va_address['city'].", ";
						}
						print $va_address['stateprovince'];
						print " ".$va_address['postalcode'];
						print " ".$va_address['country'];
						if (trim($va_address['address1_type'])) {
							print "<br/>(".$va_address['address1_type'].") ";
						}					
						print "<br/><br/>";
					}
				}
			}
			print "</div><!-- end col -->";
			print "<div class='col-sm-4'>".$o_results->getWithTemplate("<unit delimiter='<br/>'>^ca_entities.telephone.telephone2 ^ca_entities.telephone.telephone3</unit>");
			print $o_results->getWithTemplate("^ca_entities.email_address");
			print "</div><!-- end col -->";
			print "</div><!-- end row -->";
			
			if (is_array($va_related_names = $o_results->get('ca_entities.related_names', array('returnWithStructure' => true))) && sizeof($va_related_names)) {
				print "<div class='row'>";
				print "<div class='col-sm-4'></div>";
				print "<div class='col-sm-4'><b>Staff</b></div>";
				print "<div class='col-sm-4'></div>";					
				print "</div><!-- end row -->";
				foreach ($va_related_names as $va_related_id => $va_related_name_t) {
					foreach ($va_related_name_t as $va_related_id => $va_related_name) {
						print "<hr style='width:66%;margin-left:34%; margin-bottom:10px;margin-top:10px;'>";
						print "<div class='row' style='padding-bottom:5px;'>";
						print "<div class='col-sm-4'></div>";
						print "<div class='col-sm-4'>";
						print $va_related_name['related_names_value']."<br/>".$va_related_name['related_names_title'];
						print "</div>";
						print "<div class='col-sm-4'>";
						print "<a href='mailto:".$va_related_name['related_names_email']."'>".$va_related_name['related_names_email']."</a>";
						if ($va_related_name['related_names_email'] && $va_related_name['related_names_phone']) {
							print "<br/>";
						}
						print $va_related_name['related_names_phone'];
						print "</div>";
						print "</div><!-- end row -->";
					}
				}
			}
			print "<hr>";
		}
	}
} else {
	print "Permission Denied";
}	
?>

</div>