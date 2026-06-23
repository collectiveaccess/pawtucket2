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


	<div class="row collection">
		<div class="col-sm-6">	
			<div class="contributeForm">
				<h1>Search Collection</h1>
				
				<div class="notificationMessage">{{{errors}}}</div>
				
				{{{form}}}
					
					<div class="contributeField">
						{{{ca_objects.preferred_labels:error}}}
						Title:<br/>
						{{{ca_objects.preferred_labels.name%width=220px}}}
					</div>
					<div class="contributeField">
						{{{ca_entities.preferred_labels:error}}}
						Artist:<br/>
						{{{ca_entities.preferred_labels.displayname%width=220px&height=40px&relationshipType=artist&type=ind}}}
					</div>
					<div class="contributeField">
						{{{ca_objects.date:error}}}
						Date:<br/>
						{{{ca_objects.date%width=220px}}}   
					</div>
					<div class="contributeField">
						{{{ca_objects.description:error}}}
						Description:<br/>
						{{{ca_objects.description%width=220px&height=120px}}}   
					</div>
					
					<div class="contributeField">
						{{{ca_object_representations.media:error}}}
						Media(1):<br/>
						
						Title: {{{ca_object_representations.preferred_labels.name}}} 
						{{{ca_object_representations.media}}} <br/>
						
						{{{ca_object_representations.media:error}}}
						Media(2):<br/>
						
						Title: {{{ca_object_representations.preferred_labels.name}}} 
						{{{ca_object_representations.media}}} <br/>
						
						{{{ca_object_representations.media:error}}}
						Media(3):<br/>
						
						Title: {{{ca_object_representations.preferred_labels.name}}} 
						{{{ca_object_representations.media}}} <br/>
					</div>

					<br style="clear: both;"/>
<?php					
			print $this->render('Contribute/spam_check_html.php');
			print $this->render('Contribute/terms_and_conditions_check_html.php');
?>

					<div style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
					<div style="float: right;">{{{submit%label=Save}}}</div>
				{{{/form}}}
				<div class='clearfix'></div>
			</div>
		</div>
	</div>