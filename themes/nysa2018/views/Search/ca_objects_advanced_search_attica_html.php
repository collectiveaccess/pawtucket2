
<div class="row">
	<div class="col-sm-12 " style='border-right:1px solid #ddd;'>
		<h1>The Attica Uprising and Aftermath:<br/>Selected Documents from the Office of the Attorney General</h1>

{{{form}}}

<div class='advancedContainer'>
	<div class='row'>
		<div class="col-sm-6">
			<div class='menuLink first'><?php print caNavLink($this->request, 'Browse', '', '', 'Browse', 'attica'); ?></div> | 
			<div class='menuLink'><?php print caNavLink($this->request, 'Timeline', '', '', 'About', 'timeline'); ?></div> | 
			<div class='menuLink'><?php print caNavLink($this->request, 'Related Records in the State Archives', '', '', 'About', 'relatedrecords'); ?></div>
		</div>
		<div class="advancedSearchField col-sm-6">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search across all fields in the database.">Search Selected Attica Litigation Documents</span>
			{{{_fulltext%width=200px&height=1}}}<span class='btn btn-default' >{{{submit%label=Search}}}</span>
		</div>			
	</div>		
</div>	

{{{/form}}}

	</div>
</div><!-- end row -->
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
			  <ol class="carousel-indicators">
				<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
				<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
				<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
				<li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
				<li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
			  </ol>
			  <div class="carousel-inner">
				<div class="item active">
					<?php print caGetThemeGraphic($this->request, 'attica1.jpg', array('class' => 'd-block w-100'));?>
					<div class="carousel-caption d-none d-md-block">
					  This collection represents a collaborative effort between the New York State Office of the Attorney General and New York State Archives to provide access to materials related to one of the most infamous prison riots in American history, the 1971 uprising at Attica Correctional Facility in Western New York.
					</div>
				</div>
				<div class="item">
					<?php print caGetThemeGraphic($this->request, 'attica2.jpg', array('class' => 'd-block w-100'));?>
					<div class="carousel-caption d-none d-md-block">
					  Most of the documents being made available in this collection pertain to the case of Akil Al-Jundi, on behalf of himself and others similarly situated, Plaintiff vs. The Estate of Nelson A. Rockefeller, Russell Oswald, John Monahan, Vincent Mancusi and Karl Pfeil, Defendants. 
					</div>		  
				</div>
				<div class="item">
					<?php print caGetThemeGraphic($this->request, 'attica3.jpg', array('class' => 'd-block w-100'));?>
					<div class="carousel-caption d-none d-md-block">
					  The Akil Al-Jundi litigation records provide both a general overview and a detailed account of the events at Attica Correctional facility in September of 1971 and the decades of litigation that followed. 
					</div>		  
				</div>
				<div class="item">
					<?php print caGetThemeGraphic($this->request, 'attica4.jpg', array('class' => 'd-block w-100'));?>
					<div class="carousel-caption d-none d-md-block">
					  The original copies of the records in this digital collection and the special investigation and litigation files from which they were selected remain in the custody of the Attorney General's Office. 
					</div>		  
				</div>
				<div class="item">
					<?php print caGetThemeGraphic($this->request, 'attica5.jpg', array('class' => 'd-block w-100'));?>
					<div class="carousel-caption d-none d-md-block">
					  Requests for information should be directed to the <a href="http://www.ag.ny.gov/foil/contact" target="_blank">Attorney General's Office</a> <i class="fa fa-link-external"></i>.<br/><br/>
						For further information and access policies regarding related records held by the State Archives, contact the Researcher Services unit by email at <a href="mailto:archref@nysed.gov">archref@nysed.gov</a> or by telephone at 518-474-8955.
					</div>		  
				</div>								
			  </div>
			  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			  </a>
			  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			  </a>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="accordion" id="accordionExample">
			  <div class="card">
				<div class="card-header" id="headingOne">
				  <h5 class="mb-0">
					<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					  <h4><i class="fa fa-chevron-down"></i> What records are available here?</h4>
					</button>
				  </h5>
				</div>

				<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
				  <div class="card-body">
					{{{atticaInfo}}}
				  </div>
				</div>
			  </div>
			  <div class="card">
				<div class="card-header" id="headingTwo">
				  <h5 class="mb-0">
					<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
					  <h4><i class="fa fa-chevron-down"></i> How were records selected for this collection?</h4>
					</button>
				  </h5>
				</div>
				<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
				  <div class="card-body">
					{{{recordsSelected}}}
				  </div>
				</div>
			  </div>
			  <div class="card">
				<div class="card-header" id="headingThree">
				  <h5 class="mb-0">
					<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
					  <h4><i class="fa fa-chevron-down"></i> What records are available elsewhere?</h4>
					</button>
				  </h5>
				</div>
				<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
				  <div class="card-body">
					{{{whatRecords}}}
				  </div>
				</div>
			  </div>
			  <div class="card">
				<div class="card-header" id="headingFour">
				  <h5 class="mb-0">
					<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
					  <h4><i class="fa fa-chevron-down"></i> How can I access records in this collection?</h4>
					</button>
				  </h5>
				</div>
				<div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
				  <div class="card-body">
					{{{recordAccess}}}
				  </div>
				</div>
			  </div>
			  <div class="card">
				<div class="card-header" id="headingFive">
				  <h5 class="mb-0">
					<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
					  <h4><i class="fa fa-chevron-down"></i> Whom can I contact for more information?</h4>
					</button>
				  </h5>
				</div>
				<div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
				  <div class="card-body">
					{{{contact}}}
				  </div>
				</div>
			  </div>
			</div>	<!-- end accordion -->		
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->
<script>
	jQuery(document).ready(function() {
		$('.advancedSearchField .formLabel').popover(); 
		$('#myCollapsible').collapse({
		  toggle: false
		});
		$('.carousel').carousel()
	});
	
</script>