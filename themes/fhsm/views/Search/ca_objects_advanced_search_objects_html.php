<div class="container">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h1>Specimen Advanced Search</h1>
			<p>Use this form to locate specific items in the Sternberg Museum's Paleontology Collections</p>
			<div class="detailDivider"></div>

{{{form}}}
	
	<div class='advancedContainer'>
		<div class="row">
			<div class="col-sm-2">
				<h5>General</h5>
			</div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					Specimen #:<br/>
					{{{ca_objects.preferred_labels.name}}}
				</div>
			</div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					Individuals/Organizations<br/>
					{{{ca_entities%width=400px}}}
				</div>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-sm-2">
				<h5>Taxonomy</h5>
			</div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					Kingdom<br/>
					{{{ca_occurrence_labels.name%filterTypes=kingdom}}}
				</div>
			</div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					Phylum<br/>
					{{{ca_occurrence_labels.name%filterTypes=phylum}}}
				</div>
			</div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					Subphylum<br/>
					{{{ca_occurrence_labels.name%filterTypes=subphylum}}}
				</div>
			</div>
			<div class="col-sm-3 col-sm-offset-2">
				<div class="advancedSearchField">
					Superclass<br/>
					{{{ca_occurrence_labels.name%filterTypes=superclass}}}
				</div>
			</div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					Class<br/>
					{{{ca_occurrence_labels.name%restrictToTypes=class}}}
				</div>
			</div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					Subclass<br/>
					{{{ca_occurrence_labels.name%filterTypes=subclass}}}
				</div>
			</div>
			<div class="col-sm-3 col-sm-offset-2">
				<div class="advancedSearchField">
					Superorder<br/>
					{{{ca_occurrence_labels.name%filterTypes=superorder}}}
				</div>
			</div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					Order<br/>
					{{{ca_occurrence_labels.name%filterTypes=order}}}
				</div>
			</div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					Suborder<br/>
					{{{ca_occurrence_labels.name%filterTypes=suborder}}}
				</div>
			</div>
			<div class="col-sm-3 col-sm-offset-2">
				<div class="advancedSearchField">
					Infraorder<br/>
					{{{ca_occurrence_labels.name%filterTypes=infraorder}}}
				</div>
			</div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					Superfamily<br/>
					{{{ca_occurrence_labels.name%filterTypes=superfamily}}}
				</div>
			</div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					Family<br/>
					{{{ca_occurrence_labels.name%filterTypes=family}}}
				</div>
			</div>
			<div class="col-sm-3 col-sm-offset-2">
				<div class="advancedSearchField">
					Subfamily<br/>
					{{{ca_occurrence_labels.name%filterTypes=subfamily}}}
				</div>
			</div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					Tribe<br/>
					{{{ca_occurrence_labels.name%filterTypes=tribe}}}
				</div>
			</div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					Subtribe<br/>
					{{{ca_occurrence_labels.name%filterTypes=subtribe}}}
				</div>
			</div>
			<div class="col-sm-3 col-sm-offset-2">
				<div class="advancedSearchField">
					Genus<br/>
					{{{ca_occurrence_labels.name%filterTypes=genus}}}
				</div>
			</div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					Subgenus<br/>
					{{{ca_occurrence_labels.name%filterTypes=subgenus}}}
				</div>
			</div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					Specific Epithet<br/>
					{{{ca_occurrences.preferred_labels.name%restrictToTypes=specificepithet}}}
				</div>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-sm-2">
				<h5>Chronostratigraphy</h5>
			</div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					Era<br/>
					{{{ca_objects.chronostratigraphy.earliestEra&ca_objects.chronostratigraphy.latestEra}}}
				</div>
			</div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					Period<br/>
					{{{ca_objects.chronostratigraphy.earliestPeriod&ca_objects.chronostratigraphy.latestPeriod}}}
				</div>
			</div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					Epoch<br/>
					{{{ca_objects.chronostratigraphy.earliestEpoch&ca_objects.chronostratigraphy.latestEpoch}}}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					Age<br/>
					{{{ca_objects.chronostratigraphy.earliestAge&ca_objects.chronostratigraphy.latestAge}}}
				</div>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-sm-2">
				<h5>Lithostratigraphy</h5>
			</div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					Group<br/>
					{{{ca_objects.lithostratigraphy.group}}}
				</div>
			</div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					Formation<br/>
					{{{ca_objects.lithostratigraphy.formation}}}
				</div>
			</div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					Member<br/>
					{{{ca_objects.lithostratigraphy.member}}}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					Local Fauna<br/>
					{{{ca_objects.localFauna}}}
				</div>
			</div>
		</div>
		<hr/>
		<div class="row">
			<div class="col-sm-2">
				<h5>Locality</h5>
			</div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					Country<br/>
					{{{ca_places.preferred_labels.name%restrictToTypes=country}}}
				</div>
			</div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					State/Province<br/>
					{{{ca_places.preferred_labels.name%restrictToTypes=stateProvince}}}
				</div>
			</div>
			<div class="col-sm-3">
				<div class="advancedSearchField">
					County<br/>
					{{{ca_places.preferred_labels%filterTypes=county}}}
				</div>
			</div>
		</div>
	</div>	
	<br style="clear: both;"/>
	
	<div style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
	<div style="float: right;">{{{submit%label=Search}}}</div>
{{{/form}}}

		</div>
	</div><!-- end row -->
</div><!-- end container -->
