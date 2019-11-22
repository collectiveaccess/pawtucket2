<div id="detailBody">
	<h1>Advanced Search</h1><br/>
	<div class="advancedSearchFormContainer">	
		{{{form}}}
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<H3>Steelcase Number:</H3>
						{{{ca_objects.idno%class=form-control}}}
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<H3>Collection:</H3>
						{{{ca_collections%class=form-control}}}
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<H3>Date:</H3>
						{{{ca_objects.creation_date%class=form-control}}}
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<H3>Style/Movement:</H3>
						{{{ca_objects.styles_movement%class=form-control}}}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<H3>Colors:</H3>
						{{{ca_objects.colors%class=form-control}}}
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<H3>Theme:</H3>
						{{{ca_objects.steelcase_themes%class=form-control}}}
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<H3>Material:</H3>
						{{{ca_objects.material%class=form-control}}}
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<H3>Creator:</H3>
						{{{ca_entities%class=form-control}}}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12"><div class="divide"></div><br/></div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<br/><br/>
					<span class="btn btn-default">{{{reset%label=Reset}}}</span>
					<span class="btn btn-default">{{{submit%label=Search}}}</span>		
				</div>
			</div>
		</div>		
	</div>		
	{{{/form}}}
</div>