<?php

require_once(__CA_MODELS_DIR__."/ca_sets.php");
$va_access_values = caGetUserAccessValues($this->request);

	if($vs_set_code = $this->request->config->get("featured_library_set")){
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
	$vs_library_set_code = $this->request->config->get("new_library_set");
	$vs_library_code = ca_sets::find(array('set_code' => $vs_library_set_code), array('returnAs' => 'firstId'));
?>
<div class="container">
	<div class="row">
		<div class="col-sm-8 library">
			<h1>Library Advanced Search</h1>
			<p>Enter your search terms in the fields below.</p>
			{{{form}}}
				<div class="advancedSearchField"> 
					{{{_fieldlist%width=200px&height=1&fieldListWidth=100&fieldListHeight=1&fields=_fulltext:Keyword;title:Title;ca_entities.preferred_labels.displayname/author:Author;ca_objects.pub_year:Date of Publication;ca_entities.preferred_labels.displayname/publisher:Publisher;ca_objects.ISBN:ISBN;ca_objects.series:Series;ca_objects.lcsh_terms:Subject;}}}
					{{{_fieldlist:boolean}}}
				</div>

				<div class="advancedSearchField">
					{{{_fieldlist%width=200px&height=1&fieldListWidth=100&fieldListHeight=1&fields=_fulltext:Keyword;title:Title;ca_entities.preferred_labels.displayname/author:Author;ca_objects.pub_year:Date of Publication;ca_entities.preferred_labels.displayname/publisher:Publisher;ca_objects.ISBN:ISBN;ca_objects.series:Series;ca_objects.lcsh_terms:Subject;}}}
					{{{_fieldlist:boolean}}}
				</div>

				<div class="advancedSearchField">
					{{{_fieldlist%width=200px&height=1&fieldListWidth=100&fieldListHeight=1&fields=_fulltext:Keyword;title:Title;ca_entities.preferred_labels.displayname/author:Author;ca_objects.pub_year:Date of Publication;ca_entities.preferred_labels.displayname/publisher:Publisher;ca_objects.ISBN:ISBN;ca_objects.series:Series;ca_objects.lcsh_terms:Subject;}}}
					
				</div>

				<div class="advancedSearchField">
					Format:<br/>
					{{{ca_objects.library_formats}}}
				</div>

				<div class="advancedSearchField">
					Date range <span><i>(e.g. 1970-1979)</i></span><br/>
					{{{ca_objects.pub_year%width=200px}}}
				</div>

				<div class="advancedSearchField">
					Language<br/>
					{{{ca_objects.language}}}
				</div>
				<br style="clear: both;"/>

				<div style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
				<div style="float: right;">{{{submit%label=Search}}}</div>
			{{{/form}}}				
		</div>
		<div class="col-sm-4" style='border-left:1px solid #ddd;'>
			<h1>Glenstone Library Resources</h1>
			<h3><?php print caNavLink($this->request, 'New Library Acquisitions', '', '', 'Lightbox', 'setDetail', array('set_id' => $vs_library_code)); ?></h3>
			<h3>Library Databases</h3>
			<p><a href='http://www.jstor.org/' target="_blank">JSTOR</a></p>
			<p><a href='http://www.artstor.org/index.shtml' target="_blank">ARTstor</a></p>
			<p><a href='https://www.worldcat.org/' target="_blank">WorldCat</a></p>
			<h3>Other Museum Library Catalogs</h3>
			<p><a href='https://library.nga.gov/' target="_blank">National Gallery of Art</a></p>
			<p><a href='http://library.phillipscollection.org:8080/?Config=ysm&section=search&term=#section=home' target="_blank">Phillips Collection</a></p>
			<p><a href='http://library.si.edu/research' target="_blank">Smithsonian Libraries</a></p>
			<p><a href='http://arcade.nyarc.org/' target="_blank">New York Art Resources Consortium</a></p>
			<p><a href='http://primo.getty.edu/primo_library/libweb/action/search.do?vid=GRI' target="_blank">Getty Research Institute</a></p>
		</div>
	</div>
</div> <!--end container-->


