<?php

include_once(__CA_LIB_DIR__."/ca/Search/ObjectSearch.php");
include_once(__CA_MODELS_DIR__."/ca_occurrences.php");
	
?>
<div class="container">
	<div class="row collection">
		<div class="col-sm-12">	
			<h1>Search Publications</h1>
			<div class="advSearch">
				
				{{{form}}}
					<div class="advancedSearchField">
						Keyword:<br/>
						{{{_fulltext%width=220px&height=25px}}}
					</div>
					<div class="advancedSearchField">
						Title:<br/>
						{{{ca_objects.preferred_labels.name%width=220px}}}
					</div>
					<div class="advancedSearchField">
						Author:<br/>
						{{{ca_entities.preferred_labels.displayname/author%width=220px&height=40px}}}
					</div>
					<div class="advancedSearchField">
						Publisher:<br/>
						{{{ca_entities.preferred_labels.displayname/publisher%width=220px&height=40px}}}
					</div>	
					<div class="advancedSearchField">
						Editor:<br/>
						{{{ca_entities.preferred_labels.displayname/editor%width=220px&height=40px}}}
					</div>									
					<div class="advancedSearchField">
						Date:<br/>
						{{{ca_objects.date%width=220px}}} 
					</div>
					<div class="advancedSearchField">
						Description:<br/>
						{{{ca_objects.description%width=220px&height=40px}}} 
					</div>					
					<div class="advancedSearchField">
						Format Type:<br/>
						{{{ca_objects.format_type%width=220px}}}
					</div>
					<div class="advancedSearchField">
						Language:<br/>
						{{{ca_objects.language%width=220px}}}
					</div>

					<br style="clear: both;"/>

					<div style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
					<div style="float: right;">{{{submit%label=Search}}}</div>
				{{{/form}}}
				<div class='clearfix'></div>
			</div>
		</div><!--end col-sm-8-->
	</div><!--end row-->
</div> <!--end container-->

