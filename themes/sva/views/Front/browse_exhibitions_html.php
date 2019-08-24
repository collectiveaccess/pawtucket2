<?php
	require_once(__CA_LIB_DIR__."/Browse/BrowseEngine.php");
	$browse = new BrowseEngine("ca_occurrences");
?> 

<div class="tab-pane" id="browse" role="tabpanel" aria-labelledby="browse-tab">
		<ul class="nav nav-pills nav justify-content-center">
			<li class="nav-item breadcrumbs--tab">
				<a class="nav-link active" id="bydate-tab" data-toggle="pill" href="#bydate" role="tab" aria-controls="bydate" aria-selected="true">By Date</a>
			</li>
			<li class="nav-item breadcrumbs--tab">
				<a class="nav-link" id="alpha-tab" data-toggle="pill" href="#alpha" role="tab" aria-controls="alpha" aria-selected="false">Alphabetical</a>
			</li>
			<li class="nav-item breadcrumbs--tab">
				<a class="nav-link" id="exhibitor-tab" data-toggle="pill" href="#exhibitor" role="tab" aria-controls="exhibitor" aria-selected="false">By Exhibitor</a>
			</li>
		</ul>
		<br/><br/>
	<div class="tab-content">
		<div class="tab-pane active" id="bydate" role="tabpanel" aria-labelledby="bydate-tab">
		
			<div id="dateBrowse">
				
			</div>
		</div>
		<div class="tab-pane" id="alpha" role="tabpanel" aria-labelledby="alpha-tab">
			<div class="row justify-content-center">
        		<div class="col-md-10">        	
					<ul class="sortby">
   						<li><a href="#number">#</a></li>
   						<li><a href="#A">A</a></li>
   						<li><a href="#B">B</a></li>
  						<li><a href="#C">C</a></li>
  						<li><a href="#D">D</a></li>
   						<li><a href="#E">E</a></li>
  						<li><a href="#F">F</a></li>
  						<li><a href="#G">G</a></li>
   						<li><a href="#H">H</a></li>
  						<li><a href="#I">I</a></li>
  						<li><a href="#J">J</a></li>
   						<li><a href="#K">K</a></li>
  						<li><a href="#L">L</a></li>
  						<li><a href="#M">M</a></li>
   						<li><a href="#N">N</a></li>
  						<li><a href="#O">O</a></li>
  						<li><a href="#P">P</a></li>
   						<li><a href="#Q">Q</a></li>
  						<li><a href="#R">R</a></li>
  						<li><a href="#S">S</a></li>
   						<li><a href="#T">T</a></li>
  						<li><a href="#U">U</a></li>
  						<li><a href="#V">V</a></li>
   						<li><a href="#W">W</a></li>
  						<li><a href="#X">X</a></li>
  						<li><a href="#Y">Y</a></li>
   						<li><a href="#Z">Z</a></li>
  					</ul>
       	 		</div>
       		 </div>
       	 <br/><br/>
       	 <div class="row">
       	 <div class="col-sm-1">
       	 	<img src="/themes/sva/assets/pawtucket/graphics/sharp-arrow_drop_down-24px.svg">
       	 </div>
				<ul class="select-list">
					<li><h2--list id="number">#</h2--list></li>
					<li class="masonry-title--list">8x8 is the name of an Exhibit, Which Is Even Longer | 1944-11-01 - 1940-12-14</li>				
					<li><h2--list id="A">A</h2--list></li>
					<li class="masonry-title--list">Alabama is the name of an Exhibit, Which Is Even Longer | 1944-11-01 - 1940-12-14</li>
					<li class="masonry-title--list">Aunt Tammy is the name of an Exhibit With Many Many Names Attached, Group Group | 1944-11-01 - 1940-12-14</li>
					<li class="masonry-title--list">Atwells is the name of an Exhibit With Many Many Names Attached, Group Group | 1944-11-01 - 1940-12-14</li>
					<li class="masonry-title--list">Azure is the name of an Exhibit With Many Many Names Attached, Group Group | 1944-11-01 - 1940-12-14</li>					
					<li><h2--list id="B">B</h2--list></li>
					<li class="masonry-title--list">Bertrand Russell is the name of an Exhibit, what if it doesn't have a date?</li>
					<li><h2--list id="C">C</h2--list></li>
					<li class="masonry-title--list">Capital is the name of an Exhibit, Which Is Even Longer | 1944-11-01 - 1940-12-14</li>
					<li class="masonry-title--list">Carla is the name of an Exhibit With Many Many Names Attached, Group Group | 1944-11-01 - 1940-12-14</li>
					<li class="masonry-title--list">Copious Captions is the name of an Exhibit With Many Many Names Attached, Group Group | 1944-11-01 - 1940-12-14</li>
					<li class="masonry-title--list">Criminal Custard is the name of an Exhibit With Many Many Names Attached, Group Group | 1944-11-01 - 1940-12-14</li>					
				</ul>
			</div>
			
		</div>
		<div class="tab-pane" id="exhibitor" role="tabpanel" aria-labelledby="exhibitor-tab">
		<div class="row justify-content-center">
			<div class="col-md-10">        	
					<ul class="sortby">
   						<li><a href="#number">#</a></li>
   						<li><a href="#A">A</a></li>
   						<li><a href="#B">B</a></li>
  						<li><a href="#C">C</a></li>
  						<li><a href="#D">D</a></li>
   						<li><a href="#E">E</a></li>
  						<li><a href="#F">F</a></li>
  						<li><a href="#G">G</a></li>
   						<li><a href="#H">H</a></li>
  						<li><a href="#I">I</a></li>
  						<li><a href="#J">J</a></li>
   						<li><a href="#K">K</a></li>
  						<li><a href="#L">L</a></li>
  						<li><a href="#M">M</a></li>
   						<li><a href="#N">N</a></li>
  						<li><a href="#O">O</a></li>
  						<li><a href="#P">P</a></li>
   						<li><a href="#Q">Q</a></li>
  						<li><a href="#R">R</a></li>
  						<li><a href="#S">S</a></li>
   						<li><a href="#T">T</a></li>
  						<li><a href="#U">U</a></li>
  						<li><a href="#V">V</a></li>
   						<li><a href="#W">W</a></li>
  						<li><a href="#X">X</a></li>
  						<li><a href="#Y">Y</a></li>
   						<li><a href="#Z">Z</a></li>
  					</ul>
       	 		</div>
       	 	</div>
		</div>
	</div>
</div>
</div>

<script type="text/javascript">
	pawtucketUIApps['exhbrowse'] = {
		'#dateBrowse': {
			'facetUrl': '<?php print caNavUrl('', 'FrontBrowse', 'occurrences', ['getFacet' => 'decade', 'download' => 1]); ?>',
			'browseUrl': '<?php print caNavUrl('', 'FrontBrowse', 'occurrences', ['facets' => 'decade:%value']); ?>'
		}
	};
</script>
