<?php

include_once(__CA_LIB_DIR__."/ca/Search/ObjectSearch.php");
include_once(__CA_MODELS_DIR__."/ca_occurrences.php");
	
?>
<div class="container">
	<div class="row collection">
		<div class="col-sm-12">	
			<div class="container advSearch">
				<div class="row">
					{{{form}}}
						<div class="col-sm-6 col-md-6 col-lg-6 advSearchField">
							Major:<br/>
							{{{ca_occurrences.occurrence_id%width=220px&height=40px&select=1}}}
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 advSearchField">
							Project Type:<br/>
							{{{ca_objects.project_types%width=220px}}} 
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 advSearchField">
							Reader:<br/>
							{{{ca_entities.preferred_labels.displayname/first_reader;second_reader;third_reader%width=220px&height=40px}}}
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 advSearchField">
							Student:<br/>
							{{{ca_entities.preferred_labels.displayname/student%width=220px&height=40px}}}
						</div>
						<div class="col-sm-6 col-md-6 col-lg-6 advSearchField">
							Title:<br/>
							{{{ca_objects.preferred_labels.name%width=220px}}}
						</div>																									
						<div class="col-sm-6 col-md-6 col-lg-6 advSearchField">
							Keyword:<br/>
							{{{_fulltext%width=220px&height=25px}}}
							<br style="clear: both;"/>	
							<div class='searchButton'>{{{reset%label=Reset}}}</div>
							<div class='searchButton'>{{{submit%label=Search}}}</div>
						</div>					
						<div class="col-sm-6 col-md-6 col-lg-6 advSearchField">
							Graduation Year:<br/>
							{{{ca_objects.graduation_year%width=220px}}}
						</div>

						

					{{{/form}}}
					<div class='clearfix'></div>
				</div><!-- end row -->
			</div><!-- end container -->
		</div><!--end col-sm-8-->
	</div><!--end row-->
</div> <!--end container-->

