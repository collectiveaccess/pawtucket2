<div class="container advancedSearch">
	<div class="row">
		<div class="col-sm-8 ">
			<h2><?php print _t("Advanced Search"); ?></h2>

{{{form}}}
	<div class='row'>
		<div class="col-sm-8 field">
			<?php print _t("Keyword"); ?>
			{{{_fulltext%width=200px&height=1}}}
		</div>
		<div class="col-sm-4 field">
			<div style="float: right; margin-top:20px; margin-left: 20px;">{{{resetTag}}}<?php print _t('Reset');?>{{{/resetTag}}}</div>
			<div style="float: right; margin-top:20px; ">{{{submitTag}}}<?php print _t('Search');?>{{{/submitTag}}}</div>
		</div>			
	</div>	
	<hr>
	<div class='row'>
		<div class="col-sm-6 field">
			<?php print _t("Author"); ?><br/>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=author}}}
		</div>
		<div class="col-sm-6 field">
			<?php print _t("Place of Publication"); ?><br/>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=bookseller}}}
		</div>		
				

	</div>	
	<div class='row'>
		<div class="col-sm-12 field">
			<?php print _t("Uniform Title"); ?><br/>
			{{{ca_objects.CCSSUSA_Uniform}}}
		</div>			
			
	</div>
	<div class='row'>
		<div class="col-sm-4 field">
			<?php print _t("Printer"); ?><br/>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=printer}}}
		</div>			
		<div class="col-sm-4 field">
			<?php print _t("Translator"); ?><br/>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=translator}}}
		</div>
		<div class="col-sm-4 field">
			<?php print _t("Publisher"); ?><br/>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=publisher}}}
		</div>					
	</div>
	<div class='row'>
		<div class="col-sm-6 field">
			<?php print _t("Language"); ?><br/>
			{{{ca_objects.041_lang}}}
		</div>	
		<div class="col-sm-6 field">
			<?php print _t("Bookseller / Distributor"); ?><br/>
			{{{ca_entities.preferred_labels%restrictToRelationshipTypes=bookseller}}}
		</div>		
	</div>		
	<hr>		
	<div class='row'>		
		<div class="col-sm-6 field">
			<?php print _t("Date Range"); ?> <i>(e.g., 1776-1792)</i><br/>
			{{{ca_objects.260_date%width=200px&height=1&useDatePicker=0}}}
		</div>
		<div class="col-sm-6 field">
			<?php print _t("Comedias Sueltas Database ID#"); ?><br/>
			{{{ca_objects.object_id}}}
		</div>
	</div>	
	<hr>
	<div class='row'>
		<div class="col-sm-6 field">
			<?php print _t("Caption Title"); ?><br/>
			{{{ca_objects.caption_title%width=200px&height=1}}}
		</div>
		<div class="col-sm-6 field">
			<?php print _t("Holding Institution"); ?> <br/>
			{{{ca_collections.collection_id%width=200px&height=1&select=1&sort=ca_collections.preferred_labels.name}}}
		</div>			
	
					
	</div>	
	<div class='row'>
		<div class="col-sm-6 field">
			<?php print _t("Physical Description"); ?> <br/>
			{{{ca_objects.physical_description%width=200px&height=1}}}
		</div>
		<div class="col-sm-6 field">
			<?php print _t("Presence of Ornament(s)"); ?><br/>
			{{{ca_objects.ornaments%width=200px&height=1&render=is&value=yes}}}
		</div>		
					
	</div>
	<div class='row'>
		<div class="col-sm-6 field">
			<?php print _t("Printers' Evidence"); ?> <br/>
			{{{ca_objects.from_printers%inUse=1&render=select}}}
		</div>
		<div class="col-sm-6 field">
			<?php print _t("Item Specific Information"); ?> <br/>
			{{{ca_objects.item_specific_info%inUse=1&render=select}}}
		</div>		
					
	</div>
	<div class='row'>
		<div class="col-sm-6 field">
			<?php print _t("Local Note(s)"); ?><br/>
			{{{ca_objects.590_local%width=200px&height=1}}} 
		</div>	
		<div class="col-sm-6 field">
			<?php print _t("Attribution Issues"); ?><br/>
			{{{ca_objects.attribution_issues%width=200px&height=1&render=is&value=yes}}}
		</div>						
	</div>			
	<div class='row'>
		<div class="col-sm-6 field">
			<?php print _t("Ownership"); ?> <br/>
			{{{ca_objects.561_ownership%width=200px&height=1}}}
		</div>
		<div class="col-sm-6 field">
			<?php print _t("Holding Institution Call Number"); ?><br/>
			{{{ca_objects.idno%width=210px}}}
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 field">
			<div style="float: right; margin-top:20px; margin-left: 20px; ">{{{resetTag}}}<?php print _t('Reset');?>{{{/resetTag}}}</div>
			<div style="float: right; margin-top:20px;">{{{submitTag}}}<?php print _t('Search');?>{{{/submitTag}}}</div>
		</div>						
	</div>
	

{{{/form}}}

		</div>
		<div class="col-sm-4" style='border-left:1px solid #ddd;min-height:500px;'>
			<h2><?php print _t("User&rsquo;s guide"); ?></h2>
<?php			
	print "<p>"._t("Enter your search terms in the fields to the left")."</p>";
?>
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->