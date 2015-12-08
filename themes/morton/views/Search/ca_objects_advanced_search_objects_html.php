<?php
 			$o_result_context = new ResultContext($this->request, 'ca_objects', 'multisearch');
 			$o_result_context->setAsLastFind();
?> 

<div class="container">
	<div class="row">
		<div class="col-sm-8 ">
			<h1>Objects Advanced Search</h1>

<?php			
	print "<p>Enter your search terms in the fields below.</p>";
?>

{{{form}}}
	
	<div class='advancedContainer row'>
		<div class='col-sm-12 col-md-12 col-lg-12'>
			<div class="advancedSearchField">
				Title<br/>
				{{{ca_objects.preferred_labels.name%width=380px}}}
				<!--{{{ca_objects.preferred_labels:boolean}}}-->
			</div>
		</div>
		<div class='col-sm-12 col-md-12 col-lg-12'>			
			<div class="advancedSearchField">
				Keyword<br/>
				{{{_fulltext%width=380px&height=1}}}
				<!--{{{_fulltext:boolean}}}-->
			</div>
		</div>
		<div class='col-sm-12 col-md-12 col-lg-12'>
			<div class="advancedSearchField">
				Collection <br/>
				{{{ca_collections.preferred_labels%width=380px&height=40px}}}
				<!--{{{ca_collections.preferred_labels:boolean}}}-->
			</div>
		</div>				
		<div class='col-sm-12 col-md-12 col-lg-12'>
			<div class="advancedSearchField">
				Type<br/>
				{{{ca_objects.type_id:boolean}}}
				{{{ca_objects.type_id}}}
			</div>
		</div>	
		<div class='col-sm-12 col-md-12 col-lg-12'>	
			<div class="advancedSearchField">
				Date range <i>(e.g. 1970-1979)</i><br/>
				{{{ca_objects.date.date_value%width=380px&height=40px&useDatePicker=0}}}
				<!--{{{ca_objects.date.date_value:boolean}}}-->
			</div>
		</div>	
		<div class='col-sm-12 col-md-12 col-lg-12'>	
			<div class="advancedSearchField">
				Has Media<br/>
				{{{ca_object_representations.md5%render=is_set&label=Has+media}}}
			</div>
		</div>
		<div class='col-sm-12 col-md-12 col-lg-12'>	
			<div class="advancedSearchFieldTall">
				Entity <br/>
				{{{ca_entities.preferred_labels.displayname%width=200px&height=90px}}}
				{{{ca_entities.preferred_labels.displayname:relationshipTypes%width=180px&height=90px&multiple=1}}}
				<br style='clear: both;'/>
			</div>
		</div>	
		<div class='col-sm-12 col-md-12 col-lg-12'>	
			<div class="advancedSearchField">
				Language <br/>
				{{{ca_objects.language:boolean}}}
				{{{ca_objects.language%width=250px&height=40px}}}
			</div>
		</div>
		<div class='col-sm-12 col-md-12 col-lg-12'>	
			<div class="advancedSearchField">
				Reproduction <br/>
				{{{ca_objects.reproduction:boolean}}}
				{{{ca_objects.reproduction%width=250px&height=40px}}}
			</div>
		</div>	
	<br style="clear: both;"/>
	<div style='margin-right:230px;'>
		<div style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
		<div style="float: right;">{{{submit%label=Search}}}</div>
	</div>								
	</div>	
	

{{{/form}}}

		</div>
		<div class="col-sm-4" style='border-left:1px solid #ddd;'>
			<h2>Other Resources</h2>
			<p><a href='http://www.mortonarb.org/visit-explore/sterling-morton-library' target='_blank'>Sterling Morton Library Home</a></p>
<?php			
	// Load "advanced" search history
	$o_adv_result_context = new ResultContext($this->request, 'ca_objects', 'search_advanced', $this->request->getActionExtra());
	
	// Add it to quick search history
	$va_recent_searches = array_merge($o_result_context->getSearchHistory(), $o_adv_result_context->getSearchHistory()); 

	if (is_array($va_recent_searches) && sizeof($va_recent_searches)) {
?>	
			<h2 style='margin-top:50px;'>Recent Searches</h2>
			<ul class='recentSearch'> 
<?php
			$v_i = 0;
			foreach($va_recent_searches as $vs_search => $va_search_info) {
				print "<li>".caNavLink($this->request, $o_adv_result_context->getSearchExpressionForDisplay($va_search_info['display']), '', '', 'MultiSearch', 'Index', array('search' => $vs_search))."</li>";
				$v_i++;
				if ($v_i == 10) {
					break;
				}
			}
?>
			</ul>
			
<?php
	}
?>		
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->