
<div class="row mb-5">
	<div class="col-md-8">
		<h1><?= _t("Objects Advanced Search"); ?></h1>
        <p><?= _t("Enter your search terms in the fields below."); ?></p>

		<form class="row g-4">
			<div class="col-md-6">
				<label for="inputKeyword" class="form-label"><?= _t("Keyword"); ?></label>
				<input type="text" class="form-control" id="inputKeyword" aria-describedby="keywordDescrip">
				<div id="keywordDescrip" class="form-text">
					<?= _t("Search across all fields in the database."); ?>
				</div>
			</div>

			<div class="col-md-6">
				<label for="inputTitle" class="form-label"><?= _t("Title"); ?></label>
				<input type="text" class="form-control" id="inputTitle" aria-describedby="titleDescrip">
				<div id="titleDescrip" class="form-text">
					<?= _t("Limit your search to Object Titles only."); ?>
				</div>
			</div>

			<div class="col-md-6">
				<label for="inputId" class="form-label"><?= _t("Accession Number"); ?></label>
				<input type="text" class="form-control" id="inputId" aria-describedby="idDescrip">
				<div id="idDescrip" class="form-text">
					<?= _t("Search object identifiers."); ?>
				</div>
			</div>

			<div class="col-md-6">
				<label for="inputDate" class="form-label"><?= _t("Date Range <em>(e.g. 1970-1979)</em>"); ?></label>
				<input type="text" class="form-control" id="inputDate" aria-describedby="dateDescrip">
				<div id="dateDescrip" class="form-text">
					<?= _t("Search records of a particular date or date range."); ?>
				</div>
			</div>

			<div class="col-md-6">
				<label for="inputType" class="form-label"><?= _t("Type"); ?></label>
				<select id="inputType" class="form-select" aria-describedby="typeDescrip">
					<option selected>Choose...</option>
					<option>...</option>
				</select>
				<div id="typeDescrip" class="form-text">
					<?= _t("Limit your search to object types."); ?>
				</div>
			</div>

			<div class="col-md-6">
				<label for="inputDate" class="form-label"><?= _t("Collection"); ?></label>
				<input type="text" class="form-control" id="inputDate" aria-describedby="collDescrip">
				<div id="collDescrip" class="form-text">
					<?= _t("Search records within a particular collection."); ?>
				</div>
			</div>

			<div class="col-12 mb-3">
				<button type="submit" class="btn btn-primary"><?= _t("Reset"); ?></button>
				<button type="submit" class="btn btn-primary"><?= _t("Search"); ?></button>
			</div>
		</form>

		<!-- {{{form}}}

			<div class='advancedContainer'>
				<div class='row'>
					<div class="advancedSearchField col-sm-12">
						<label for="_fulltext" class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search across all fields in the database.') ?>"><?php _p('Keyword') ?></label>
						{{{_fulltext%width=200px&height=1}}}
					</div>			
				</div>		
				<div class='row'>
					<div class="advancedSearchField col-sm-12">
						<label for='ca_objects_preferred_labels_name' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to Object Titles only.') ?>"><?php _p('Title') ?></label>
						{{{ca_objects.preferred_labels.name%width=220px}}}
					</div>
				</div>
				<div class='row'>
					<div class="advancedSearchField col-sm-6">
						<label for='ca_objects_idno' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search object identifiers.') ?>"><?php _p('Accession number') ?></label>
						{{{ca_objects.idno%width=210px}}}
					</div>
					<div class="advancedSearchField col-sm-6">
						<label for='ca_objects_type_id' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Limit your search to object types.') ?>"><?php _p('Type') ?></label>
						{{{ca_objects.type_id%height=30px&id=ca_objects_type_id}}}
					</div>
				</div>
				<div class='row'>
					<div class="advancedSearchField col-sm-12">
						<label for='ca_objects.date.dates_value[]' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search records of a particular date or date range.') ?>"><?php _p('Date range <i>(e.g. 1970-1979)</i>') ?></label>
						{{{ca_objects.dates.dates_value%width=200px&height=40px&useDatePicker=0}}}
					</div>
				</div>
				<div class='row'>
					<div class="advancedSearchField col-sm-12">
						<label for='ca_collections_preferred_labels' class='formLabel' data-toggle="popover" data-trigger="hover" data-content="<?php _p('Search records within a particular collection.') ?>"><?php _p('Collection') ?></label>
						{{{ca_collections.preferred_labels%restrictToTypes=collection%width=200px&height=40px}}}
					</div>
				</div>

				<br style="clear: both;"/>

				<div class='advancedFormSubmit'>
					<span class='btn btn-default'>{{{reset%label=Reset}}}</span>
					<span class='btn btn-default' style="margin-left: 20px;">{{{submit%label=Search}}}</span>
				</div>
			</div>	

		{{{/form}}} -->

	</div>

	<div class="col-md-4 border-start">
		<h1><?= _t("Helpful Links"); ?></h1>
		<p><?= _t("Include some helpful info for your users here."); ?></p>

		<h2>Boolean Operators</h2>
		<p>You can combine search terms in a single search box using "AND" and "OR":</p>

		<ul>
			<li><strong>AND</strong> retrieves records that contain all your search terms</li>
			<li><strong>OR</strong> retrieves records that contain only one of your terms</li>
			<li><strong>NOT</strong> retrieves records that do not contain your search terms</li>
		</ul>

		<p>If you do not include AND/OR between search terms, AND is assumed; records containing all terms will be retrieved.</p>
		<p>AND is assumed when search terms are entered in more than one box.</p>
		<p>Use "quotation marks" to search for exact phrases.</p>
		<p>e.g. "Squamish language" AND "phonetics"</p>

		<h2>Wildcard</h2>
		<p>For a better search return, consider using the asterisk (*) after the root of a word. For example, camp* will retrieve records containing the word "camp", "camps", and "camping".</p>
	</div>

</div><!-- end row -->
