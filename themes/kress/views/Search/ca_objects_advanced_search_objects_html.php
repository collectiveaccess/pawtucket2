
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
					<label for='ca_objects.Object_KressCatalogNumber[]' class='formLabel'  data-toggle="popover" title="Kress Catalogue Number" data-content="Identifier used to reference objects in the <i>Complete Catalogue of the Samuel H. Kress Collection</i>"><?php _p('Kress Catalogue Number') ?></label>
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
					<label for='ca_objects.Object_Nationality[]' class='formLabel' data-toggle='popover' title='Nationality' data-content='Nationality of artist'><?php _p('Nationality') ?></label>
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
					<label for='ca_entities_preferred_labels_location' class='formLabel' data-toggle="popover" title="Location" data-content="Current owner"><?php _p('Location') ?></label>
					{{{ca_entities.preferred_labels%restrictToRelationshipTypes=location%width=200px&id=ca_entities_preferred_labels_location}}}
				</div>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_entities_preferred_labels' class='formLabel' data-toggle='popover' title='Historical Attribution' data-content='Previous artist attribution'><?php _p('Historical Attribution') ?></label>
					{{{ca_entities.preferred_labels%restrictToRelationshipTypes=attribution%width=200px}}}
				</div>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects.Object_Provenance[]' class='formLabel' data-toggle='popover' title='Provenance' data-content='Chronology of the ownership, custody or location of an art object'><?php _p('Provenance') ?></label>
					{{{ca_objects.Object_Provenance%width=220px}}}
				</div>
			</div>
			<div class='row'>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects.Object_Note[]' class='formLabel'><?php _p('Note') ?></label>
					{{{ca_objects.Object_Note%width=220px}}}
				</div>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects_idno' class='formLabel' data-toggle="popover" title="Identifier" data-content="Unique system-generated record identifier"><?php _p('Identifier') ?></label>
					{{{ca_objects.idno%width=220px}}}
				</div>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects.Object_CurrentAccNo[]' class='formLabel' data-toggle="popover" title="Accession Number" data-content="Identifier assigned to objects by institution (current owner)"><?php _p('Accession Number') ?></label>
					{{{ca_objects.Object_CurrentAccNo%width=220px}}}
				</div>
			</div>
			<div class='row'>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects.Object_KressAssNumber[]' class='formLabel' data-toggle="popover" title="Kress Number" data-content="Identifier assigned to objects by Kress Foundation."><?php _p('Kress Number') ?></label>
					{{{ca_objects.Object_KressAssNumber%width=220px}}}
				</div>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects.Object_AltKressNumber[]' class='formLabel' data-toggle="popover" title="Legacy Kress Number" data-content="Former identifier assigned to objects by Kress Foundation"><?php _p('Legacy Kress Number') ?></label>
					{{{ca_objects.Object_AltKressNumber%width=220px}}}
				</div>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects.Object_PichettoNo[]' class='formLabel' data-toggle="popover" title="Pichetto Number" data-content="Identifier assigned to objects by restorer Stephen Pichetto"><?php _p('Pichetto Number') ?></label>
					{{{ca_objects.Object_PichettoNo%width=220px}}}
				</div>
			</div>
			<div class='row'>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects.Object_DreyfusNumber[]' class='formLabel' data-toggle="popover" title="Dreyfus Number" data-content="Identifier assigned to Dreyfus Collection objects by Duveen Brothers"><?php _p('Dreyfus Number') ?></label>
					{{{ca_objects.Object_DreyfusNumber%width=220px}}}
				</div>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects.Object_NGAOldNumber[]' class='formLabel' data-toggle="popover" title="Legacy NGA Number" data-content="Former accession number assigned to objects by National Gallery of Art"><?php _p('Legacy NGA Number') ?></label>
					{{{ca_objects.Object_NGAOldNumber%width=220px}}}
				</div>
				<div class="advancedSearchField col-sm-4">
					<label for='ca_objects.Object_NGAOldLoanNumber[]' class='formLabel' data-toggle="popover" title="NGA Loan Number" data-content="Identifier assigned to objects previously on loan to National Gallery of Art"><?php _p('NGA Loan Number') ?></label>
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

<script type='text/javascript'>
	jQuery(document).ready(function() {
		var options = {
			placement: function () {
				return "auto left";
				

			},
			trigger: "hover",
			html: "true"
		};

		$('[data-toggle="popover"]').each(function() {
			if($(this).attr('data-content')){
				$(this).popover(options).click(function(e) {
					$(this).popover('toggle');
				});
			}
		});
	});
</script>