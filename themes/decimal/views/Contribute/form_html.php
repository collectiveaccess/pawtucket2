<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Contribute/form_html.php : sample Contribute form
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
	<div class="container"><div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">

	<div id="contentArea" class="contribute">	
		<div class="contributeForm">
			<div class='container'>
			<div class="pull-right detailTool generalToolSocial">
				<a href='https://twitter.com/home?status=http%3A//fabricofdigitallife.com<?php print caNavUrl($this->request, '', 'Contribute', 'materials'); ?>'><i class="fa fa-twitter-square" aria-hidden="true"></i></a>
				<a href='https://www.facebook.com/sharer/sharer.php?u=http%3A//fabricofdigitallife.com<?php print caNavUrl($this->request, '', 'Contribute', 'materials'); ?>'><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
				<a href='https://plus.google.com/share?url=http%3A//fabricofdigitallife.com<?php print caNavUrl($this->request, '', 'Contribute', 'materials'); ?>'><i class="fa fa-google-plus-square" aria-hidden="true"></i></a>
			</div><!-- end detailTool -->
			<h1>Contribute</h1>
			<p>Submit Materials The Fabric of Digital Life Archive. Your media will be cataloged and added to the archive once reviewed. The content you submit will be viewable on the site in the near future.  Please contact us at <a href='mailto:decimal.lab.uoit@gmail.com'>decimal.lab.uoit@gmail.com</a> for assistance if needed.</p>
			
			{{{<ifdef code="errors"><div class="notificationMessage">^errors</div></ifdef>}}}
			
			{{{form}}}
				<div class='row' style='border-top:1px solid #ccc; padding-top:15px;'>
					<div class='col-sm-12'><h4>Your Information</h4></div>
					<div class="contributeField col-md-6">
						{{{ca_objects.username:error}}}
						<span class='title'>Name</span><br/>
						{{{ca_objects.username%width=350px&height=20px}}} 
					</div>						
					<div class="contributeField col-md-6">
						<div style='margin-bottom:5px;'>
							{{{ca_objects.institution:error}}}
							<span class='title'>School or Institution</span><br/>
							{{{ca_objects.institution%width=350px&height=20px}}} 
						</div>
						<div style='margin-bottom:5px;'>
							{{{ca_objects.user_country:error}}}
							<span class='title'>Country</span><br/>
							{{{ca_objects.user_country%width=350px&height=20px}}} 
						</div>
						<div style='margin-bottom:5px;'>
							{{{ca_objects.user_email:error}}}
							<span class='title'>Your Email Address</span><br/>
							{{{ca_objects.user_email%width=350px&height=20px}}}
						</div>
					</div>							
				</div>
				<div class='row' style='border-top:1px solid #ccc; padding-top:15px;'>
					<div class='col-sm-12'><h4>Submission Information</h4></div>
					<div class="contributeField col-sm-6">
						{{{ca_objects.date:error}}}
						<span class='title'>Date</span><br/>
						{{{ca_objects.date.dates_value%width=350px}}}   
						{{{ca_objects.date.dc_dates_types%force=created}}}
					</div>										
					<div class="contributeField col-sm-6">
						{{{ca_objects.preferred_labels:error}}}
						<span class='title'>Title of Submission</span><br/>
						{{{ca_objects.preferred_labels.name%width=350px}}}
					</div>				
				</div>
				<div class='row' >

					<div class="contributeField col-sm-6">
						{{{ca_objects.user_notes:error}}}
						<span class='title'>Description</span><br/>
						<p>Please provide how the following submission contributes to the archive, is related to current artifacts within the archive, or is related to the research focus of the archive along with a general description of the artifact. </p>
						{{{ca_objects.user_notes%width=350px&height=120px}}}  
					</div>
				
					<div class="contributeField col-sm-6">
						{{{ca_object_representations.media:error}}}
						<span class='title'>Media (1)</span>{{{ca_object_representations.media}}} 
						<br/>
					
						{{{ca_object_representations.media:error}}}
						<span class='title'>Media (2)</span>{{{ca_object_representations.media}}}
						 <br/>
					
						{{{ca_object_representations.media:error}}}
						<span class='title'>Media (3)</span>{{{ca_object_representations.media}}}
						 <br/>
					</div>
				</div><!-- end row -->
				<div class='row' style='border-top:1px solid #ccc; padding-top:15px;'>
					<div class='col-sm-12'>

<?php					
					print $this->render('Contribute/spam_check_html.php');
					print $this->render('Contribute/terms_and_conditions_check_html.php');
?>
					</div><!-- end col -->
				</div><!-- end row -->
				
				<div class='submitButtons'>
					<div class='contributeSubmit' style="margin-left: 20px;">{{{reset%label=Reset}}}</div>
					<div class='contributeSubmit'>{{{submit%label=Save}}}</div>
				</div>
			{{{/form}}}
			</div><!-- end container -->
		</div><!-- end Contribute form -->
		<div class='clearfix'></div>
	</div>
	
	<div class="col-sm-1"></div>
	</div><!-- end row --></div><!-- end container -->
