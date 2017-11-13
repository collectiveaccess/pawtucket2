<div id="caAdvancedSearchFormBorder"><div id="caAdvancedSearchForm">
		<H1><?php print _t("Collections Search"); ?><small> <?php print caNavLink($this->request, 'or search optics division', '', 'Search', 'advanced', 'optics');?></small></H1>

{{{form}}}
	
	<div class='advancedContainer'>
		<div class='advancedRow'>
			<div class="advancedSearchField">
				<span class="advSearchLabel">Title</span><br/>
				{{{ca_objects.preferred_labels.name%width=350px&height=1}}}
			</div>
			<div class="advancedSearchField">
				<span class="advSearchLabel">Alternate titles</span><br/>
				{{{ca_objects.nonpreferred_labels%width=350px&height=1}}}
			</div>
		</div>
		<div class='advancedRow'>
			<div class="advancedSearchField">
				<span class="advSearchLabel">Object identifier</span><br/>
				{{{ca_objects.idno%width=350px&height=1}}}
			</div>
			<div class="advancedSearchField">
				<span class="advSearchLabel">Optics Identifier (LCC*, LBD*, DES*)</span> <br/>
				{{{ca_objects.altID%width=350px&height=1}}}
			</div>			
		</div>
		<div class='advancedRow'>
			<div class="advancedSearchField">
				<span class="advSearchLabel">People and Organizations</span> <br/>
				{{{ca_entities.preferred_labels%width=350px&height=1}}}
			</div>
			<div class="advancedSearchField">
				<span class="advSearchLabel">Keywords</span><br/>
				{{{_fulltext%width=350px&height=25px}}}
			</div>
		</div>		
		<div class='advancedRow'>
			<div class="advancedSearchField">
				<span class="advSearchLabel">Type </span><br/>
				{{{ca_objects.type_id%width=200px&height=1}}}
			</div>
			<div class="advancedSearchField">
				<span class="advSearchLabel">Date</span><br/>
				{{{ca_objects.date.dates_value}}}
			</div>			
		</div>
			
		<div class='advancedRow'>
			<div class="advancedSearchField">
				<div style="margin-bottom:25px;"><span class="advSearchLabel">Technique </span><br/>
				{{{ca_objects.technique%width=200px&height=1}}}
				</div>
				<div style="margin-bottom:25px;"><span class="advSearchLabel">Optics Type </span><br/>
				{{{ca_objects.optics_type%width=200px&height=1}}}
				</div>				
				<span class="advSearchLabel">Material/Medium</span><br/>
				{{{ca_objects.materialMedium%width=200px&height=1}}}
			</div>
			<div class="advancedSearchField">
				<span class="advSearchLabel">Description</span><br/>
				{{{ca_objects.description%width=200px&height=5}}}
				{{{ca_objects.type_id%width=350px&height=1}}}
				{{{ca_objects.type_id:boolean}}}
			</div>
			<div class="advancedSearchField">
				<span class="advSearchLabel">Type </span><br/>
				{{{ca_objects.type_id%width=350px&height=1}}}
			</div>		
		</div>
		<div class='advancedRow'>
			<div class="advancedSearchField"><span class="advSearchLabel">Technique </span><br/>
				{{{ca_objects.technique%width=350px&height=1}}}
				{{{ca_objects.technique:boolean}}}
			</div>
			<div class="advancedSearchField"><span class="advSearchLabel">Technique </span><br/>
				{{{ca_objects.technique%width=350px&height=1}}}
			</div>						
		</div>	
		<div class='advancedRow'>
			<div class="advancedSearchField"><span class="advSearchLabel">Material/Medium</span><br/>
				{{{ca_objects.materialMedium%width=350px&height=1}}}
				{{{ca_objects.materialMedium:boolean}}}
			</div>
			<div class="advancedSearchField"><span class="advSearchLabel">Material/Medium</span><br/>
				{{{ca_objects.materialMedium%width=350px&height=1}}}
			</div>						
		</div>	
		<div class='advancedRow'>
			<div class="advancedSearchField"><span class="advSearchLabel">Silos/Signature Projects</span><br/>
				{{{ca_collections.preferred_labels%width=350px&height=1}}}
				{{{ca_collections.preferred_labels:boolean}}}
			</div>
			<div class="advancedSearchField"><span class="advSearchLabel">Silos/Signature Projects</span><br/>
				{{{ca_collections.preferred_labels%width=350px&height=1}}}
			</div>						
		</div>
		<div class='advancedRow'>
			<div class="advancedSearchField"><span class="advSearchLabel">Projects</span><br/>
				{{{ca_collections.preferred_labels%width=350px&height=1}}}
				{{{ca_collections.preferred_labels:boolean}}}
			</div>
			<div class="advancedSearchField"><span class="advSearchLabel">Projects</span><br/>
				{{{ca_collections.preferred_labels%width=350px&height=1}}}
			</div>						
		</div>						
		<div class='advancedRow'>
			<div class="advancedSearchField">
				<span class="advSearchLabel">Date (<i>eg 2014-2016</i>)</span><br/>
				{{{ca_objects.date.dates_value%width=350px&height=1}}}
			</div>
			<div class="advancedSearchField"><span class="advSearchLabel">Optics Type </span><br/>
				{{{ca_objects.optics_type%width=350px&height=1}}}
			</div>		
		</div>
		<div class='advancedRow'>					
			<div class="advancedSearchField">
				<span class="advSearchLabel">Description</span><br/>
				{{{ca_objects.description%width=350px&height=5}}}
			</div>
		</div>	
	</div>	
	
	<br style="clear: both;"/>
	
	<div class="formLabelText submit" style="float: right; margin-right: 20px; margin-left: 20px;">{{{reset%label=Reset}}}</div>
	<div class="formLabelText submit" style="float: right;">{{{submit%label=Search}}}</div>
{{{/form}}}


	</div><!-- end caAdvancedSearchForm -->
</div><!-- end caAdvancedSearchFormBorder -->