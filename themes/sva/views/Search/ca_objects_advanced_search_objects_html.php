<?php

require_once(__CA_MODELS_DIR__."/ca_sets.php");
include_once(__CA_LIB_DIR__."/ca/Search/OccurrenceSearch.php");
include_once(__CA_MODELS_DIR__."/ca_occurrences.php");

$va_access_values = caGetUserAccessValues($this->request);

	if($vs_set_code = $this->request->config->get("featured_art_set")){
	 	AssetLoadManager::register("carousel");
		$t_set = new ca_sets();
		$t_set->load(array('set_code' => $vs_set_code));
		# Enforce access control on set
		if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
			$va_item_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 0))) ? $va_tmp : array());
		}
		if(is_array($va_item_ids) && sizeof($va_item_ids)){
			$t_object = new ca_objects();
			$va_item_media = $t_object->getPrimaryMediaForIDs($va_item_ids, array("slideshowsmall"), array('checkAccess' => caGetUserAccessValues($this->request)));
		}
	}	
?>
<div class="container" style='clear:both;'>
	<div class="row collection">
		<div class="col-sm-12">	
			<div class="advSearch">
				<h1>Search Collection</h1>
				{{{form}}}

					<div class="advancedSearchField">
						<span class='advTitle'>Title</span><br/>
						{{{ca_objects.preferred_labels.name%width=300px}}}
					</div>
					<div class="advancedSearchField">
						<span class='advTitle'>Identifier</span><br/>
						{{{ca_objects.idno%width=300px}}}
					</div>
					<div class="advancedSearchField">
						<span class='advTitle'>Type</span><br/>
						{{{ca_objects.type_id%width=300px}}}
					</div>
					<div class="advancedSearchField">
						<span class='advTitle'>Date</span><br/>
						{{{ca_objects.dates.dates_value%width=300px}}} 
					</div>

					<div class="advancedSearchField">
						<span class='advTitle'>People</span><br/>
						{{{ca_entities.preferred_labels%width=300px}}}
					</div>

					<br style="clear: both;"/>

					<div class='advsubmit'>{{{submit%label=Search}}}</div>
					<div class='advreset'>{{{reset%label=Reset}}}</div>
					
				{{{/form}}}
				<div class='clearfix'></div>
			</div>
		</div><!--end col-sm-12-->
	</div><!--end row-->
</div> <!--end container-->

