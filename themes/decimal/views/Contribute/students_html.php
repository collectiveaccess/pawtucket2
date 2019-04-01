<?php
/* ----------------------------------------------------------------------
 * themes/decimal/views/Contribute/students_html.php : sample Contribute form
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2019 Whirl-i-Gig
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
			<div class="pull-right">
				<div class='contributeSubmit' style="margin-left: 20px;"><?php print caNavLink($this->request, 'Back to list', '', '*', '*', 'List');?></div>
			</div><!-- end detailTool -->
			<h1>Contribute</h1>
			<p>Submit Materials The Fabric of Digital Life Archive. Your media will be cataloged and added to the archive once reviewed. The content you submit will be viewable on the site in the near future.  Please contact us at <a href='mailto:decimal.lab.uoit@gmail.com'>decimal.lab.uoit@gmail.com</a> for assistance if needed.</p>
			
			{{{<ifdef code="errors"><div class="notificationMessage">^errors</div></ifdef>}}}
			
			{{{form}}}
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
				<div class='row' style='border-top:1px solid #ccc; padding-top:15px;'>			
					<div class="contributeField col-sm-6">
						{{{ca_objects.locationOnBody:error}}}
						<span class='title'>Location on body</span><br/>
						{{{ca_objects.locationOnBody%width=350px}}}   
					</div>							
					<div class="contributeField col-sm-6">
						{{{ca_objects.media_type:error}}}
						<span class='title'>Media type</span><br/>
						{{{ca_objects.media_type%width=350px}}}
					</div>				
				</div>
				<div class='row' style='border-top:1px solid #ccc; padding-top:15px;'>
					<div class="contributeField col-sm-6">
						{{{ca_objects.publication_title_name:error}}}
						<span class='title'>Publication title</span><br/>
						{{{ca_objects.publication_title_name%width=350px}}}   
					</div>										
					<div class="contributeField col-sm-6">
						{{{ca_objects.altID:error}}}
						<span class='title'>Alternate title</span><br/>
						{{{ca_objects.altID%width=350px}}}
					</div>				
				</div>
				<div class='row' style='border-top:1px solid #ccc; padding-top:15px;'>
					<div class="contributeField col-sm-6">
						{{{ca_objects.issued:error}}}
						<span class='title'>Publication date of original text</span><br/>
						{{{ca_objects.issued%width=350px}}}   
					</div>										
					<div class="contributeField col-sm-6">
						{{{ca_objects.createdOn:error}}}
						<span class='title'>Publication date of response</span><br/>
						{{{ca_objects.createdOn%width=350px}}}
					</div>				
				</div>
				<div class='row' style='border-top:1px solid #ccc; padding-top:15px;'>
					<div class="contributeField col-sm-6">
						{{{ca_objects.technology:error}}}
						<span class='title'>Technology related keywords</span><br/>
						{{{ca_objects.technology%width=350px&useTextDelimiters=keywords}}}   
					</div>										
					<div class="contributeField col-sm-6">
						{{{ca_objects.created:error}}}
						<span class='title'>Marketing related keywords</span><br/>
						{{{ca_objects.marketing%width=350px&useTextDelimiters=keywords}}}
					</div>				
				</div>
				<div class='row' style='border-top:1px solid #ccc; padding-top:15px;'>
					<div class="contributeField col-sm-6">
						{{{ca_objects.keywords:error}}}
						<span class='title'>Keywords</span><br/>
						{{{ca_objects.keywords%width=350px}}}   
					</div>										
					<div class="contributeField col-sm-6">
						{{{ca_objects.classification:error}}}
						<span class='title'>Classification</span><br/>
						{{{ca_objects.classification%width=350px}}}
					</div>				
				</div>
				<div class='row' style='border-top:1px solid #ccc; padding-top:15px;'>
					<div class="contributeField col-sm-6">
						{{{ca_objects.persuasive_intention:error}}}
						<span class='title'>Persuasive intention</span><br/>
						{{{ca_objects.persuasive_intention%width=350px}}}   
					</div>										
					<div class="contributeField col-sm-6">
						{{{ca_objects.augments:error}}}
						<span class='title'>Augments</span><br/>
						<p>Describe what aspect of being human the device augments, and write it as a verb ending in -ing.  For example, "seeing," "hearing," "communicating," "moving," etc.</p>
						{{{ca_objects.augments%width=350px}}}
					</div>				
				</div>
				<div class='row' style='border-top:1px solid #ccc; padding-top:15px;'>
					<div class="contributeField col-sm-6">
						{{{ca_objects.use:error}}}
						<span class='title'>Use</span><br/>
						{{{ca_objects.use%width=350px}}}   
					</div>										
					<div class="contributeField col-sm-6">
						{{{ca_objects.bibliographicCitation:error}}}
						<span class='title'>Citation</span><br/>
						{{{ca_objects.bibliographicCitation%width=350px}}}
					</div>				
				</div>
				<div class='row' >
					<div class="contributeField col-sm-6">
						{{{ca_objects.description:error}}}
						<span class='title'>Description</span><br/>
						<p>Please provide how the following submission contributes to the archive, is related to current artifacts within the archive, or is related to the research focus of the archive along with a general description of the artifact. </p>
						{{{ca_objects.description%width=350px&height=120px}}}  
					</div>
					<div class="contributeField col-sm-6">
						{{{ca_object_representations.media:error}}}
						
						{{{<ifcount code='ca_object_representations.media' min='1'><div>^ca_object_representations.media%previewExistingValues=1&delimiter=-</div></ifcount>}}}
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
				<!--<div class='row' style='border-top:1px solid #ccc; padding-top:15px;'>
					<div class="contributeField col-sm-12">
						{{{ca_objects.transcript:error}}}
						<span class='title'>Transcript</span><br/>
						{{{ca_objects.transcript%width=900px&height=120px}}}  
					</div>				
				</div>-->
				
				<div class='row' style='border-top:1px solid #ccc; padding-top:15px;'>
					<div class='col-sm-12'>
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
