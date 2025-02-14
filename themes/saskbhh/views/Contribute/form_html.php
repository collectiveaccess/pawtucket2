<?php
/* ----------------------------------------------------------------------
 * themes/decimal/views/Contribute/students_html.php : sample Contribute form
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2025 Whirl-i-Gig
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
				<div class='contributeSubmit'><?= caNavLink($this->request, 'Back to list', '', '*', '*', 'Index');?></div>
			</div><!-- end detailTool -->
			<h1>Contribute</h1>
			
			<p>
				Submit metadata for your artifact using the form below. 
				It will be made visible on the site once it's been reviewed and edited.
			</p>
			
			{{{<ifdef code="errors"><div class="notificationMessage">^errors</div></ifdef>}}}
			
			{{{form}}}
				<div class='row''>
					<div class='col-sm-12'><h4>Submission Information</h4></div>
					
					<div class="contributeField col-sm-6">
						{{{ca_objects.type_id:error}}}
						<span class='title'>Artifact type</span><br/>
						{{{ca_objects.type_id%width=350px}}}  
					</div>										
					<div class="contributeField col-sm-6">
						{{{ca_objects.preferred_labels:error}}}
						<span class='title'>Name of artifact</span><br/>
						{{{ca_objects.preferred_labels.name%width=350px}}}
					</div>	
				</div>
				
				
				<div class='row'>
					<div class="contributeField col-sm-6">
						{{{ca_objects.description:error}}}
						<span class='title' data-toggle="tooltip" title="Please provide how the following submission contributes to the archive, is related to current artifacts within the archive, or is related to the research focus of the archive along with a general description of the artifact.">Description</span><br/>
						{{{ca_objects.description%width=350px&height=120px&default=desc+goes+here}}}  
					</div>
					<div class="contributeField col-sm-6">
						{{{ca_objects.accession_num:eror}}}
						<span class='title' data-toggle="tooltip" title="Accession number of item.">Accession number</span><br/>
						{{{ca_objects.accession_num%width=350px&height=120px&default=}}}  
					</div>
				</div>
				
				<div class='row'>
					<div class="contributeField col-sm-6">
						{{{ca_entities:error}}}
						<span class='title' data-toggle="tooltip" title="Creator of item">Creator</span><br/>
						
						<p>{{{ca_entities%autocomplete=1&width=350px&relationshipType=creator&type=ind&index=0&placeholder=creator+goes+here}}}</p>
                        
						<p>{{{ca_entities%autocomplete=1&width=350px&relationshipType=creator&type=ind&index=1}}}</p>
					
						<p>{{{ca_entities%autocomplete=1&width=350px&relationshipType=creator&type=ind&index=2}}}</p>
						
					</div>
					<div class="contributeField col-sm-6">
					</div>
				</div>

				<div class='row'>
				    <div class="contributeField col-sm-6">
						
					</div>	
					<div class="contributeField col-sm-6">
						{{{ca_object_representations.media:error}}}
						
						{{{<ifcount code='ca_object_representations.media' min='1'><div>^ca_object_representations.media%previewExistingValues=1&delimiter=-</div></ifcount>}}}
						<span class='title'>Media</span>{{{ca_object_representations.media%autocomplete=0}}} 
					</div>
				</div><!-- end row -->
				
				<div class='row' style='border-top:1px solid #ccc; padding-top:15px;'>
					<div class='col-sm-12'>
					</div><!-- end col -->
				</div><!-- end row -->
				
				<div class='submitButtons'>
					{{{submit%label=Save}}}
					{{{reset%label=Reset}}} 
				</div>
			{{{/form}}}
			</div><!-- end container -->
		</div><!-- end Contribute form -->
		<div class='clearfix'></div>
	</div>
	
	<div class="col-sm-1"></div>
	</div><!-- end row --></div><!-- end container -->
