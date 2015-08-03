<div class="container" id="advancedSearchFormObjects">
	<div class="row">
		<div class="col-sm-6">
			{{{form}}}
			<div class="form-group">
				<label for="keyword"><?php print _t("Search term:"); ?></label>
				{{{_fulltext%height=35px&class=form-control}}}
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				<label for="Term">Keyword:</label>
				{{{ca_list_items.preferred_labels.name_plural%class=form-control&select=1}}}
			</div>		
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group advSearchGroup">
				<label for="Medium">Medium:</label>
				{{{ca_objects.medium%class=form-control}}}
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group advSearchGroup">
				<label for="Type">Type:</label>
				{{{ca_objects.type_id%class=form-control}}}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 text-right">
			{{{submit%label=Search}}}
			
			{{{/form}}}
		</div>
	</div>
</div>
