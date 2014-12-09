<div id="detailBody">
	<h1>Fossil Vertebrate Advanced Search</h1><br/>
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
						<H3>Type Status:</H3>
						{{{ca_objects.track_type_status}}}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12"><div class="divide"></div><br/></div>
			</div>
			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<H3>Class:</H3>
						{{{ca_objects.taxonomic_rank%render=text}}}
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<H3>Order:</H3>
						{{{ca_objects.taxonomic_rank%render=text}}}
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<H3>Family:</H3>
						{{{ca_objects.taxonomic_rank%render=text}}}
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<H3>Genus:</H3>
						{{{ca_objects.taxonomic_rank%render=text}}}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12"><div class="divide"></div><br/></div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<H3>Description:</H3>
						{{{ca_objects.description%width=600px&height=27px}}}
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
						<H3>Epoch:</H3>
						{{{ca_places.epoch}}}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12"><div class="divide"></div><br/></div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<div class="form-group">
						<H3>Age/Stage:</H3>
						{{{ca_places.ageNALMA}}}
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<H3>Formation:</H3>
						{{{ca_places.formation%width=200px&height=27px}}}
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<H3>Member:</H3>
						{{{ca_places.member%width=200px&height=27px}}}
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

<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#caAdvancedSearch').find('input[type!="hidden"],textarea').val('');
		jQuery('#caAdvancedSearch').find('select.caAdvancedSearchBoolean').val('AND');
		jQuery('#caAdvancedSearch').find('select').prop('selectedIndex', 0);	
	});
</script>