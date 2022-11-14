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


	<div class="row">
		<div class="col-sm-12 col-md-offset-3 col-md-6">	
			<div id="contentArea" class="contribute"><div class="contributeForm">

				<h1>Submit Your Materials to The Archive</h1>
<?php
				if($vs_intro = $this->getVar('contribute_introduction')){
					print "<p class='contributeIntro'>".$vs_intro."</p>";
				}
				
				if($vs_error = $this->getVar('errors')){
					print "<div class='notificationMessage'>".$vs_error."</div>";
				}
?>
				{{{form}}}
					
					<div class="form-group">
						{{{ca_objects.uc_format:error}}}
						<label for="ca_objects.uc_submitted_by[]">Format of work</label>
						{{{ca_objects.uc_format%class=form-control&width=100%}}}
					</div>
					<div class="form-group elementRequired">
						{{{ca_objects.uc_submitted_by:error}}}
						<label for="ca_objects.uc_submitted_by[]">Your name <span class="required">(* Required)</span></label>
						{{{ca_objects.uc_submitted_by%class=form-control&width=100%}}}
					</div>
					<div class="form-group">
						{{{ca_objects.uc_creator:error}}}
						<label for="ca_objects.uc_creator[]">Creator(s) name (person who created the item)</label>
						{{{ca_objects.uc_creator%class=form-control&width=100%}}}
					</div>
					<div class="form-group elementRequired">
						{{{ca_objects.preferred_labels.name:error}}}
						<label for="ca_objects_preferred_labels_name">Title (do you wish to title this item?) <span class="required">(* Required)</span></label>
						{{{ca_objects.preferred_labels.name%width=220px&class=form-control&width=100%}}}
					</div>
					<div class="form-group">
						{{{ca_objects.frontend_location:error}}}
						<label for="ca_objects.frontend_location[]">Where was it created? (City, State if known.  Be as specific as you like.)</label>
						{{{ca_objects.frontend_location%class=form-control&width=100%}}}
					</div>
					<div class="form-group">
						{{{ca_objects.date:error}}}
						<label for="ca_objects.date[]">When was it created? (e.g. July 20, 2020 or July 2020 or 2020)</label>
						{{{ca_objects.date.dates_value%class=form-control&width=100%&useDatePicker=0}}}
						<div style="width:30px; float:left;">{{{ca_objects.date.date_approximate2%class=form-control&width=20%}}}</div><label for="ca_objects.date[]" style="float:left; margin-top:15px;">Date is approximate.</label>
						{{{ca_objects.date.dates_type%force=created}}}
						<div style="clear:both;"></div>
					</div>
					<div class="form-group">
						{{{ca_objects.uc_people_depicted:error}}}
						<label for="ca_objects.uc_people_depicted[]">The names of people who appear (in photos, videos, audio)</label>
						{{{ca_objects.uc_people_depicted%class=form-control&width=100%}}}
					</div>
					<div class="form-group elementRequired">
						{{{ca_objects.description_w_type.description:error}}}
						<label for="ca_objects.description_w_type.description[]">What would you like people to know about this item? <span class="required">(* Required)</span></label>
						{{{ca_objects.description_w_type.description%class=form-control&width=100%&height=5}}}
					</div>
					<div class="form-group">
						{{{ca_objects.description_w_type.description:error}}}
						<label for="ca_objects.uc_text[]">Essay, poem, or other writing. Please enter into the box below:</label>
						{{{ca_objects.uc_text%class=form-control&width=100%&height=5}}}
					</div>
					<div class="form-group elementRequired">
						{{{ca_objects.uc_contact:error}}}
						<label for="ca_objects.uc_contact[]">How may we contact you? <span class="required">(* Required)</span></label>
						{{{ca_objects.uc_contact%class=form-control&width=100%}}}
					</div>
					<div class="form-group">
						{{{ca_objects.uc_donate:error}}}
						<label for="ca_objectsuc_donate[]">Do you wish to donate this digital item or piece of writing to Appalshop's Digital Archive, where it may be viewed by researchers and the public as part of Appalshop Archive's collections? Your digital object will not be sold or redistributed, copied or distributed as a photograph, electronic file, or any other media without express written consent from you--or the copyright holder--and the Appalshop Archive. At any time you may request that the submitted item be removed from the Appalshop Archive website.</label>
						{{{ca_objects.uc_donate%class=form-control&width=100%}}}
					</div>
					<div class="form-group">
						{{{ca_object_representations.media:error}}}
<?php	
						$vs_existing_media = $t_subject->get("ca_object_representations.media.small");
						if($vs_existing_media){
							print "<div class='row'><div class='col-sm-6 col-md-4'>".$vs_existing_media."</div><div class='col-sm-6 col-md-8'>";
						}
?>
						<label>Media<?php print ($vs_existing_media) ? "(Use to replace exisiting media)" : ""; ?></label>
						{{{ca_object_representations.media}}}
<?php	
						if($vs_existing_media){
							print "</div></div>";
						}
?>

					</div>
					

					
<?php					
			print $this->render('Contribute/spam_check_html.php');
#			print $this->render('Contribute/terms_and_conditions_check_html.php');
?>

					<div class="text-center"><br/><button class='btn btn-default'>{{{submit%label=Submit}}}</button>&nbsp;&nbsp;&nbsp;<button class='btn btn-default'>{{{reset%label=Reset}}}</button></div>
				{{{/form}}}
				<div class='clearfix'></div>
			</div></div>
		</div>
	</div>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('#ContributeForm').submit(function() {
				var vb_show_required_message = false
				$('.elementRequired input').each(function(i, obj) {
					if(!$(this).val()){
						vb_show_required_message = true;
					}
				});
				if(vb_show_required_message){
					alert("<?php print _t("Please enter all required fields."); ?>");
					return false;
				}
			});
		});
	</script>
