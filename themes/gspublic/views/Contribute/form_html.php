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
	$vs_errors = $this->getVar('errors');	
?>

{{{form}}}
	<div class="row">
		<div class="col-sm-12">
			<h1>Contribute to the Girl Scouts of the USA Collection</h1>
<?php
				if($vs_errors){
					print '<div class="notificationMessage">'.$vs_errors.'</div>';
				}
?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">	
			<div class="contributeForm">
					<div class="form-group<?php print (($this->getVar("ca_objects.preferred_labels.name:error")) ? " has-error" : ""); ?>">
						<label for="preferred_labels">Title/Name</label>
						{{{ca_objects.preferred_labels.name:error}}}
						{{{ca_objects.preferred_labels.name%class=form-control}}}
					</div>
					<div class="form-group<?php print (($this->getVar("ca_objects.overall_date:error")) ? " has-error" : ""); ?>">
						<label for="overall_date">Date</label>
						{{{ca_objects.overall_date:error}}}
						{{{ca_objects.overall_date%class=form-control}}}   
					</div>
					<div class="form-group<?php print (($this->getVar("ca_objects.description:error")) ? " has-error" : ""); ?>">
						<label for="description">Description/Narrative</label>
						{{{ca_objects.description:error}}}
						{{{ca_objects.description%class=form-control&height=120px}}}   
					</div>
					<div class="form-group<?php print (($this->getVar("ca_objects.item_notes:error")) ? " has-error" : ""); ?>">
						<label for="name">Additional Comments</label>
						{{{ca_objects.item_notes:error}}}
						{{{ca_objects.item_notes%class=form-control&height=120px}}}   
					</div>
				</div>
			</div>
			<div class="col-sm-6">	
				<div class="contributeForm">

					<div class="form-group<?php print (($this->getVar("ca_objects.contribution_people:error")) ? " has-error" : ""); ?>">
						<label for="contribution_people">Related People</label>
						{{{ca_objects.contribution_people:error}}}
						{{{ca_objects.contribution_people%class=form-control&height=120px}}}   
					</div>
					<div class="form-group<?php print (($this->getVar("ca_objects.contribution_places:error")) ? " has-error" : ""); ?>">
						<label for="contribution_places">Related Places</label>
						{{{ca_objects.contribution_places:error}}}
						{{{ca_objects.contribution_places%class=form-control&height=120px}}}   
					</div>
					
					<div class="form-group<?php print (($this->getVar("ca_object_representations.media:error")) ? " has-error" : ""); ?>">
						<label for="media">Media</label>
						{{{ca_object_representations.media:error}}}
						{{{ca_object_representations.media%class=form-control}}}
					</div>
					
					<div class="form-group<?php print (($this->getVar("ca_object_representations.preferred_labels:error")) ? " has-error" : ""); ?>">	
						<label for="title">Media Title</label>
						{{{ca_object_representations.preferred_labels.name:error}}}
						{{{ca_object_representations.preferred_labels.name%class=form-control}}} 
						
					</div>

				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">	
				<div class="contributeForm">
					<div class="form-group">

<?php					
			print $this->render('Contribute/spam_check_html.php');
			print $this->render('Contribute/terms_and_conditions_check_html.php');
?>
					</div>
					<div class="form-group">
						<button class="btn-default">{{{submit%label=Submit}}}</v>
					</div>
			</div>
		</div>
	</div>
{{{/form}}}