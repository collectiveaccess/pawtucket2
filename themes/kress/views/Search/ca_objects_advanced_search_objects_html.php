
<div class="row">
	<div class="col-sm-12 col-md-8 col-md-offset-2">
		<h1><?php _p('Art Objects Advanced Search') ?></h1>

        <p><?php _p("Enter your search terms in the fields below."); ?></p>
{{{form}}}

		<div class='advancedContainer'>
			<div class='row'>
				<div class="advancedSearchField col-sm-12">
					<label for='ca_objects_preferred_labels_name' class='formLabel'><?php _p('Title') ?></label>
					{{{ca_objects.preferred_labels.name%width=220px}}}
				</div>
			</div>
			<div class='row'>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects.Object_KressCatalogNumber[]' class='formLabel'><?php _p('Kress Catalogue Number') ?></label>
					{{{ca_objects.Object_KressCatalogNumber%width=220px}}}
				</div>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_entities_preferred_labels_artist' class='formLabel'><?php _p('Artist') ?></label>
					{{{ca_entities.preferred_labels%restrictToRelationshipTypes=artist,additional_artist%width=200px&id=ca_entities_preferred_labels_artist}}}
				</div>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects.Object_Date_Filter[]' class='formLabel'><?php _p('Date') ?></label>
					{{{ca_objects.Object_Date_Filter%width=220px}}}
				</div>
			</div>
			<div class='row'>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects.Object_Nationality[]' class='formLabel'><?php _p('Nationality') ?></label>
					{{{ca_objects.Object_Nationality%width=220px}}}
				</div>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects.Object_Medium[]' class='formLabel'><?php _p('Medium') ?></label>
					{{{ca_objects.Object_Medium%width=220px}}}
				</div>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects.Object_Classification[]' class='formLabel'><?php _p('Type of Object') ?></label>
					{{{ca_objects.Object_Classification%width=220px}}}
				</div>
			</div>
			<div class='row'>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_entities_preferred_labels_location' class='formLabel'><?php _p('Location') ?></label>
					{{{ca_entities.preferred_labels%restrictToRelationshipTypes=location%width=200px&id=ca_entities_preferred_labels_location}}}
				</div>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_entities_preferred_labels' class='formLabel'><?php _p('Historical Attribution') ?></label>
					{{{ca_entities.preferred_labels%restrictToRelationshipTypes=attribution%width=200px}}}
				</div>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects.Object_Provenance[]' class='formLabel'><?php _p('Provenance') ?></label>
					{{{ca_objects.Object_Provenance%width=220px}}}
				</div>
			</div>
			<div class='row'>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects.Object_Note[]' class='formLabel'><?php _p('Note') ?></label>
					{{{ca_objects.Object_Note%width=220px}}}
				</div>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects_idno' class='formLabel'><?php _p('Identifier') ?></label>
					{{{ca_objects.idno%width=220px}}}
				</div>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects.Object_CurrentAccNo[]' class='formLabel'><?php _p('Accession Number') ?></label>
					{{{ca_objects.Object_CurrentAccNo%width=220px}}}
				</div>
			</div>
			<div class='row'>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects.Object_KressAssNumber[]' class='formLabel'><?php _p('Kress Assigned number') ?></label>
					{{{ca_objects.Object_KressAssNumber%width=220px}}}
				</div>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects.Object_AltKressNumber[]' class='formLabel'><?php _p('Legacy Kress Number') ?></label>
					{{{ca_objects.Object_AltKressNumber%width=220px}}}
				</div>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects.Object_PichettoNo[]' class='formLabel'><?php _p('Pichetto Number') ?></label>
					{{{ca_objects.Object_PichettoNo%width=220px}}}
				</div>
			</div>
			<div class='row'>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects.Object_DreyfusNumber[]' class='formLabel'><?php _p('Dreyfus Number') ?></label>
					{{{ca_objects.Object_DreyfusNumber%width=220px}}}
				</div>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects.Object_NGAOldNumber[]' class='formLabel'><?php _p('Legacy NGA Number') ?></label>
					{{{ca_objects.Object_NGAOldNumber%width=220px}}}
				</div>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects.Object_NGAOldLoanNumber[]' class='formLabel'><?php _p('NGA Loan Number') ?></label>
					{{{ca_objects.Object_NGAOldLoanNumber%width=220px}}}
				</div>
			</div>
			<br style="clear: both;"/>
			<div class='advancedFormSubmit'>
				<span class='btn btn-default'>{{{reset%label=Reset}}}</span>
				<span class='btn btn-default' style="margin-left: 20px;">{{{submit%label=Search}}}</span>
			</div>
		</div>	

{{{/form}}}

	</div>
</div><!-- end row -->

<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover(); 
	});
	
</script>