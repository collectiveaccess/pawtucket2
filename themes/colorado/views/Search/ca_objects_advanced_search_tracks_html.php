<div id="detailBody">
	<h1>Fossil Tracks Advanced Search</h1><br/>
	<div class="advancedSearchFormContainer">	
		{{{form}}}
		<div class="container">
			<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
						<H3>UCM Number:</H3>
						{{{ca_objects.idno}}}
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<H3>Other Catalog Number:</H3>
						{{{ca_objects.other_catalog_number%width=200px&height=27px}}}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12"><div class="divide"></div><br/></div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
						<H3>Trace Type:</H3>
						{{{ca_objects.trace_type}}}
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<H3>Natural Cast or True Track:</H3>
						{{{ca_objects.natura_true}}}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12"><div class="divide"></div><br/></div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
						<H3>Taxonomy:</H3>
						{{{ca_objects.taxonomic_rank%render=text}}}
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<H3>Ichnogenus:</H3>
						{{{ca_objects.ichnogenus}}}
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<H3>Ichnospecies:</H3>
						{{{ca_objects.ichnospecies}}}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12"><div class="divide"></div><br/></div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
						<H3>Locality Number:</H3>
						{{{ca_places.idno}}}
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<H3>Geographic Location:</H3>
						{{{ca_places.preferred_labels.name}}}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12"><div class="divide"></div><br/></div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
						<H3>Era:</H3>
						{{{ca_places.era}}}
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<H3>Period:</H3>
						{{{ca_places.period}}}
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<H3>Formation:</H3>
						{{{ca_places.formation%width=200px&height=27px}}}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12"><div class="divide"></div><br/></div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<br/><br/>
					<span class='btnClass'>{{{reset%label=Reset}}}</span>
					<span class='btnClass'>{{{submit%label=Search}}}</span>		
				</div>
			</div>
		</div>		
	</div>		
	{{{/form}}}
</div>