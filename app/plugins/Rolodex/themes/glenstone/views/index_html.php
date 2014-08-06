<div id="rolodex">

	<h1>Rolodex</h1>
	<h5>Find contacts using the search fields below</h5> 

<?php
	print "<div class='row'>";
	print caFormTag($this->request, 'Index', 'caRolodexForm', null, 'post', 'multipart/form-data', '_top', array('disableUnsavedChangesWarning' => true));
	print "<div class='col-sm-4'><span class='formLabel'>"._t('First name')."</span>".caHTMLTextInput("forename", array())."</div>";
	print "<div class='col-sm-4'><span class='formLabel'>"._t('Last name')."</span>".caHTMLTextInput("surname", array())."</div>";
	print "<div class='col-sm-4'><span class='formLabel'>"._t('Company')."</span>".caHTMLTextInput("company", array());
	print "<div class='submit'>".caFormSubmitLink($this->request, _t('Search  >'), 'searchSubmit', 'caRolodexForm')."</div></div>";
	print "</form>\n";
	print "</div>";	
	if ($o_results = $this->getVar('results')) {
		print "<h1>Results</h1>";
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
			if ($va_addresses = $o_results->get("ca_entities.address", array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
				foreach ($va_addresses as $va_add_key => $va_address) {
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
					if ($va_address['address1_type']) {
						print "<br/>(".$va_address['address1_type'].") ";
					}					
					print "<br/><br/>";
				}
			}
			print "</div><!-- end col -->";
			print "<div class='col-sm-4'>".$o_results->getWithTemplate("^ca_entities.telephone.telephone2 ^ca_entities.telephone.telephone3<br/>", array('delimiter' => ""));
			print $o_results->getWithTemplate("^ca_entities.email_address");
			print "</div><!-- end col -->";
			print "</div><!-- end row -->";
			print "<hr>";
		}
	}
?>

</div>