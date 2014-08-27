<div id="detailBody">
	<h1>Fossil Eggshell Advanced Search</h1><br/>
	<div class="advancedSearchFormContainer">	
		{{{form}}}
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<H3>Specimen Number:</H3>
						{{{ca_objects.idno}}}
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<H3>Formation:</H3>
						{{{ca_places.formation%width=200px&height=27px}}}
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<H3>Period:</H3>
						{{{ca_places.period}}}
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<H3>Order:</H3>
						{{{ca_places.order%width=200px&height=27px}}}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<H3>Family:</H3>
						{{{ca_places.family%width=200px&height=27px}}}
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<H3>Genus:</H3>
						{{{ca_places.genus%width=200px&height=27px}}}
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<H3>Species:</H3>
						{{{ca_places.species%width=200px&height=27px}}}
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<H3>Parataxon:</H3>
						{{{ca_places.parataxon%width=200px&height=27px}}}
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