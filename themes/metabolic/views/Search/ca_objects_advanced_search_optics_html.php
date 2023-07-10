<div id="caAdvancedSearchFormBorder"><div id="caAdvancedSearchForm">
		<H1><?php print _t("Optics Division Search"); ?><small> <?php print caNavLink('or search all collections', '', 'Search', 'advanced', 'objects');?></small></H1>

{{{form}}}
	
	<div class='advancedContainer'>
		<div class='advancedRow'>
			<div class="advancedSearchField">
				<span class="advSearchLabel">Keywords</span><br/>
				{{{_fulltext%width=350px&height=25px}}}
			</div>
			<div class="advancedSearchField">
				<span class="advSearchLabel">Optics Title</span><br/>
				{{{ca_objects.preferred_labels.name%width=350px&height=1}}}
			</div>			
		</div>
		<div class='advancedRow'>
			<div class="advancedSearchField">
				<span class="advSearchLabel">Optics Identifier (LCC*, LBD*, DES*)</span> <br/>
				{{{ca_objects.altID%width=350px&height=1}}}
				{{{ca_objects.altID:boolean}}}
			</div>
			<div class="advancedSearchField">
				<span class="advSearchLabel">Optics Identifier (LCC*, LBD*, DES*)</span> <br/>
				{{{ca_objects.altID%width=350px&height=1}}}
			</div>
		</div>
		<div class='advancedRow'>		
			<div class="advancedSearchField">
				<span class="advSearchLabel">Optics Type </span><br/>
				{{{ca_objects.optics_type%width=350px&height=1}}}
				{{{ca_objects.optics_type:boolean}}}
			</div>
			<div class="advancedSearchField">
				<span class="advSearchLabel">Optics Type </span><br/>
				{{{ca_objects.optics_type%width=350px&height=1}}}
			</div>					
		</div>
		<div class='advancedRow'>
			<div class="advancedSearchField">
				<span class="advSearchLabel">Optics Subject</span><br/>
				{{{ca_list_items.preferred_labels%width=350px&height=1}}}
				{{{ca_list_items.preferred_labels:boolean}}}
			</div>
			<div class="advancedSearchField">
				<span class="advSearchLabel">Optics Subject</span><br/>
				{{{ca_list_items.preferred_labels%width=350px&height=1}}}
			</div>					
		</div>
		<div class='advancedRow'>						
			<div class="advancedSearchField">
				<span class="advSearchLabel">Date (<i>eg 2014-2016</i>)</span><br/>
				{{{ca_objects.date.dates_value%width=350px&height=1}}}
			</div>
			<div class="advancedSearchField">
				<span class="advSearchLabel">Optics Technique</span><br/>
				{{{ca_objects.techniquePhoto%width=350px&height=1}}}
			</div>								
		</div>								
	</div>	
	
	<br style="clear: both;"/>
	
	<div class="formLabelText submit" style="float: right; margin-right: 20px; margin-left: 20px;">{{{reset%label=Reset}}}</div>
	<div class="formLabelText submit" style="float: right;">{{{submit%label=Search}}}</div>
{{{/form}}}


	</div><!-- end caAdvancedSearchForm -->
</div><!-- end caAdvancedSearchFormBorder -->