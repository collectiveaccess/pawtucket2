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
				<div class='contributeSubmit' style="margin-left: 20px;"><?php print caNavLink($this->request, 'Back to list', '', '*', '*', 'Index');?></div>
			</div><!-- end detailTool -->
			<h1>Contribute</h1>
			
			<p>Submit metadata for your artifact using the form below. It will be made visible on the site once it's been reviewed and edited. For more information on Fabric's metadata fields as well as guides on how to archive a variety of artifacts, please explore our instructional materials below. If you require further assistance, please contact us at <a href='mailto:decimal.lab.uoit@gmail.com'>decimal.lab.uoit@gmail.com</a>. Thank you for your contribution to Fabric!</p>
			
			<p>Registering an Account and Submitting Artifacts:</br>
<a href="https://docs.google.com/document/d/1uyxTsBonr3HBUUYXgd9v4zfDYGYnCEcq8_snJb6spjE/edit?usp=sharing" target="_ext">https://docs.google.com/document/d/1uyxTsBonr3HBUUYXgd9v4zfDYGYnCEcq8_snJb6spjE/edit?usp=sharing</a></p>
 
            <p>Metadata Guide:<br/>          <a href="https://docs.google.com/document/d/1FLDRRJilEOJ0mW5Pgf816rYS272m_2Ff6EIMDJx9odw/edit?usp=sharing" target="_ext">https://docs.google.com/document/d/1FLDRRJilEOJ0mW5Pgf816rYS272m_2Ff6EIMDJx9odw/edit?usp=sharing</a><p>

            <p>Video Guides:<br/>
            <a href="https://decimal.screencasthost.com/fabric" target="_ext">https://decimal.screencasthost.com/fabric</a> 
            </p>
			

			{{{<ifdef code="errors"><div class="notificationMessage">^errors</div></ifdef>}}}
			
			{{{form}}}
				<div class='row' style='border-top:1px solid #ccc; padding-top:15px;'>
					<div class='col-sm-12'><h4>Submission Information</h4></div>
					
					<div class="contributeField col-sm-6">
						{{{ca_objects.type_id:error}}}
						<span class='title'>Artifact type</span><br/>
						{{{ca_objects.type_id%width=350px&limitToItemsWithID=image,moving_image,text}}}  
					</div>										
					<div class="contributeField col-sm-6">
						{{{ca_objects.preferred_labels:error}}}
						<span class='title'>Name of artifact</span><br/>
						{{{ca_objects.preferred_labels.name%width=350px}}}
					</div>	
				</div>
				<div class='row' style='border-top:1px solid #ccc; padding-top:15px;'>	
					<div class="contributeField col-sm-6">
						{{{ca_objects.persuasive_intention:error}}}
						<span class='title'>Persuasive intention</span><br/>
						{{{ca_objects.persuasive_intention%width=350px}}}   
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
						{{{ca_objects.description:error}}}
						<span class='title' data-toggle="tooltip" title="Please provide how the following submission contributes to the archive, is related to current artifacts within the archive, or is related to the research focus of the archive along with a general description of the artifact.">Description</span><br/>
						{{{ca_objects.description%width=350px&height=120px}}}  
					</div>
					<div class="contributeField col-sm-6">
						{{{ca_objects.technology:error}}}
						<span class='title'>Technology related keywords</span><br/>
						<p>{{{ca_objects.technology%width=350px&useTextDelimiters=keywords&autocomplete=1&index=0}}}</p>
						<p>{{{ca_objects.technology%width=350px&useTextDelimiters=keywords&autocomplete=1&index=1}}}</p>
						<p>{{{ca_objects.technology%width=350px&useTextDelimiters=keywords&autocomplete=1&index=2}}}</p>
						<p>{{{ca_objects.technology%width=350px&useTextDelimiters=keywords&autocomplete=1&index=3}}}</p>
						<p>{{{ca_objects.technology%width=350px&useTextDelimiters=keywords&autocomplete=1&index=4}}}</p>
					</div>				
				</div>
				<div class='row' style='border-top:1px solid #ccc; padding-top:15px;'>									
					<div class="contributeField col-sm-6">
						{{{ca_objects.created:error}}}
						<span class='title'>Marketing related keywords</span><br/>
						<p>{{{ca_objects.marketing%width=350px&useTextDelimiters=keywords&autocomplete=1&index=0}}}</p>
						<p>{{{ca_objects.marketing%width=350px&useTextDelimiters=keywords&autocomplete=1&index=1}}}</p>
						<p>{{{ca_objects.marketing%width=350px&useTextDelimiters=keywords&autocomplete=1&index=2}}}</p>
						<p>{{{ca_objects.marketing%width=350px&useTextDelimiters=keywords&autocomplete=1&index=3}}}</p>
						<p>{{{ca_objects.marketing%width=350px&useTextDelimiters=keywords&autocomplete=1&index=4}}}</p>
					</div>	
					<div class="contributeField col-sm-6">
						{{{ca_objects.keywords:error}}}
						<span class='title'>Keywords</span><br/>
						<p>{{{ca_objects.keywords%width=350px&useTextDelimiters=keywords&autocomplete=1&index=0}}}</p>
						<p>{{{ca_objects.keywords%width=350px&useTextDelimiters=keywords&autocomplete=1&index=1}}}</p>
						<p>{{{ca_objects.keywords%width=350px&useTextDelimiters=keywords&autocomplete=1&index=2}}}</p>
						<p>{{{ca_objects.keywords%width=350px&useTextDelimiters=keywords&autocomplete=1&index=3}}}</p>
						<p>{{{ca_objects.keywords%width=350px&useTextDelimiters=keywords&autocomplete=1&index=4}}}</p>
					</div>				
				</div>
				<div class='row' style='border-top:1px solid #ccc; padding-top:15px;'>										
					<div class="contributeField col-sm-6">
						{{{ca_objects.classification:error}}}
						<span class='title'>Classification</span><br/>
						{{{ca_objects.classification%width=350px}}}
					</div>									
					<div class="contributeField col-sm-6">
						{{{ca_objects.ca_objects.related:error}}}
						<span class='title'>Allusions and responses (optional)</span><br/>
						<p></p>
						<p>{{{ca_objects.related%autocomplete=1&width=350px&relationshipType=allusion&index=0}}}</p>
						
						<p>{{{ca_objects.related%autocomplete=1&width=350px&relationshipType=allusion&index=1}}}</p>
					</div>				
				</div>
				<div class='row' style='border-top:1px solid #ccc; padding-top:15px;'>								
					<div class="contributeField col-sm-6">
						{{{ca_entities:error}}}
						<span class='title'>Author(s)</span><br/>
						<p></p>
						<p>{{{ca_entities%autocomplete=1&width=350px&relationshipType=creator&type=ind&index=0}}}</p>
						
						<p>{{{ca_entities%autocomplete=1&width=350px&relationshipType=creator&type=ind&index=1}}}</p>
						
						<p>{{{ca_entities%autocomplete=1&width=350px&relationshipType=creator&type=ind&index=2}}}</p>
						
						<div style="margin-top: 15px;">
                            <span class='title'>Contributor(s)</span><br/>
                            <p></p>
                            <p>{{{ca_entities%autocomplete=1&width=350px&relationshipType=contributor&type=ind&index=0}}}</p>
                        
                            <p>{{{ca_entities%autocomplete=1&width=350px&relationshipType=contributor&type=ind&index=1}}}</p>
                        
                            <p>{{{ca_entities%autocomplete=1&width=350px&relationshipType=contributor&type=ind&index=2}}}</p>
                        </div>
						
						<div style="margin-top: 15px;">
                            <span class='title'>Publisher(s)</span><br/>
                            <p></p>
                            <p>{{{ca_entities%autocomplete=1&width=350px&relationshipType=publisher&type=ind&index=0}}}</p>
                        
                            <p>{{{ca_entities%autocomplete=1&width=350px&relationshipType=publisher&type=ind&index=1}}}</p>
                        
                            <p>{{{ca_entities%autocomplete=1&width=350px&relationshipType=publisher&type=ind&index=2}}}</p>
                        </div>
					</div>
					<div class="contributeField col-sm-6">
						{{{ca_objects.locationOnBody:error}}}
						<span class='title'>Related body part</span><br/>
						{{{ca_objects.locationOnBody%width=350px&multiple=1}}}
					</div>				
				</div>
				<div class='row' style='border-top:1px solid #ccc; padding-top:15px;'>		
					<div class="contributeField col-sm-6">
						{{{ca_objects.augments:error}}}
						<span class='title' data-toggle="tooltip" title='Describe what aspect of being human the device augments, and write it as a verb ending in -ing.  For example, "seeing," "hearing," "communicating," "moving," etc.'>Augments</span><br/>
						<p>{{{ca_objects.augments%width=350px&index=0}}}</p>
						
						<p>{{{ca_objects.augments%width=350px&index=1}}}</p>
						
						<p>{{{ca_objects.augments%width=350px&index=2}}}</p>
						
						<p>{{{ca_objects.augments%width=350px&index=3}}}</p>
						
						<p>{{{ca_objects.augments%width=350px&index=4}}}</p>
					</div>		
					<div class="contributeField col-sm-6">
						{{{ca_objects.use:error}}}
						<span class='title'>Use</span><br/>
						{{{ca_objects.use%width=350px}}}   
					</div>	
				</div>
				<div class='row' style='border-top:1px solid #ccc; padding-top:15px;'>
				    <div class="contributeField col-sm-6">
						{{{ca_objects.source:error}}}
						<span class='title'>Source</span><br/>
						{{{ca_objects.source%width=350px}}}   
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
	
	<script>
	    $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
	</script>
