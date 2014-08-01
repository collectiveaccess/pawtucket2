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
		while($o_results->nextHit()) {
			print $o_results->getWithTemplate("<l>^ca_entities.preferred_labels.displayname</l><br>\n");
			print $o_results->getWithTemplate("^ca_entities.address.city<br>\n");
		}
	}
?>

</div>