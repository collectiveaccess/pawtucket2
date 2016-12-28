<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Contribute/form_html.php : sample Contribute form
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2016 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
 
	$t_subject = $this->getVar('t_subject');	
?>

<div class="container">
	<div class="row collection">
		<div class="col-sm-12">	
			<div class="contributeForm">
				<div class="textContent">
					<p>Please provide the following information to contribute your media to the Metabolic Studio archive. Required fields are marked with an *. When you have finished your submission, place the hard copy in the designated physical archive space. If you need further assistance, please contact the studio archivists.</p>
				</div>
				<div class="notificationMessage">{{{errors}}}</div>
				
				{{{form}}}
					
					<div class="contributeField">
						{{{ca_objects.preferred_labels:error}}}
						<span class="formLabelText" data-toggle="popover" data-trigger="hover" data-html="true" data-content="<h3>Title</h3>Enter a descriptive title for your media" data-original-title="" title="">Title*</span>
						<br/>
						{{{ca_objects.preferred_labels.name%width=400px&height=1}}}
					</div>
					<div class="contributeField">
						{{{ca_objects.date:error}}}
						<span class="formLabelText">Date</span><br/>
						{{{ca_objects.date.dates_value%width=400px&height=1&useDatePicker=0}}}   
					</div>
					<div class="contributeField">
						{{{ca_objects.description:error}}}
						<span class="formLabelText" data-toggle="popover" data-trigger="hover" data-html="true" data-content="<h3>General Notes/Relationships*</h3>Please list all relevant relationships to people, actions, objects, etc.  <br/><br/>Also indicate any Main Projects that apply: <br>1888 / Gopher Plan <br>Anabolic Monument <br>Annenberg Foundation <br>AgH2O / Silver and Water <br>Chora <br>Farmlab <br>Metabolic Studio <br>Not a Cornfield <br>Strawberry Flag<br>" data-original-title="" title="">General Notes/Relationships*</span>
						<br/>
						{{{ca_objects.generalNotes%width=400px&height=4}}}   
					</div>					
					<div class="contributeField" style='border-bottom:0px;'>
						<span class="formLabelText" data-toggle="popover" data-trigger="hover" data-html="true" data-content="<h3>Upload Media*</h3>Upload your media here" data-original-title="" title="">Upload Media*</span>
						<br/>
						{{{ca_object_representations.media:error}}}
						
						Media title: {{{ca_object_representations.preferred_labels%width=400px}}} 
						{{{ca_object_representations.media}}} <br/>
						
						{{{ca_object_representations.media:error}}}
						
						Media Title: {{{ca_object_representations.preferred_labels%width=400px}}} 
						{{{ca_object_representations.media}}} <br/>
						
						{{{ca_object_representations.media:error}}}
						
						Media Title: {{{ca_object_representations.preferred_labels%width=400px}}} 
						{{{ca_object_representations.media}}} <br/>
					</div>

					<br style="clear: both;"/>
<?php					
			#print $this->render('Contribute/spam_check_html.php');
			#print $this->render('Contribute/terms_and_conditions_check_html.php');
?>

					<div class="formLabelText submit" style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
					<div class="formLabelText submit" style="float: right;">{{{submit%label=Save}}}</div>
				{{{/form}}}
				<div class='clearfix'></div>
			</div>
		</div>
	</div>
</div>
<script>
	jQuery(document).ready(function() {
		$('.contributeField span').popover(); 
	});
	
</script>