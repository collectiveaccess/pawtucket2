<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
?>

	<div class="row">
		<div class="col-sm-12">
			<H1 class="meow"><?php print _t("About"); ?></H1>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
	<nav class="nav nav-pills flex-column flex-sm-row">
	  <a class="text-center text-md-left nav-item nav-link active" href="#pillTab1" data-toggle="tab">Pill Tab 1</a>
	  <a class="text-center text-md-left nav-item nav-link" href="#pillTab2" data-toggle="tab">Pill Tab 2</a>
	  <a class="text-center text-md-left nav-item nav-link" href="#pillTab3" data-toggle="tab">Pill tab 3</a>
	  <a class="text-center text-md-left nav-item nav-link disabled" href="#pillTab4" data-toggle="tab">Disabled</a>
	</nav>
	<div class="tab-content">
	  <div class="tab-pane container active" id="pillTab1"><p>Pill-Tab 1 content</p></div>
	  <div class="tab-pane container fade" id="pillTab2"><p>Pill-Tab 2 content</p></div>
	  <div class="tab-pane container fade" id="pillTab3"><p>Pill-Tab 3 content</p></div>
	  <div class="tab-pane container fade" id="pillTab4"><p>Pill-Tab 4 content</p></div>
	</div>
	<br/><br/><br/><br/><br/><br/>
		
			<div class="nav nav-tabs flex-column flex-sm-row">
				<a class="nav-item nav-link text-center text-md-left active " data-toggle="tab" href="#tab1">tab 1</a>
				<a class="nav-item nav-link text-center text-md-left" data-toggle="tab" href="#tab2">Tab 2</a>
				<a class="nav-item nav-link text-center text-md-left" data-toggle="tab" href="#tab3">Tab 3 asdas da sd asd ass dsa </a>
			</div>

				<!-- Tab panes -->
				<div class="tab-content">
				  <div class="tab-pane container active" id="tab1"><p>Tab 1 content</p></div>
				  <div class="tab-pane container fade" id="tab2"><p>Tab 2 content</p></div>
				  <div class="tab-pane container fade" id="tab3"><p>Tab 3 content</p></div>
				</div>
				<br/><br/><br/><br/><br/><br/>
		</div>
	</div>
	<div id="anotherClock"></div>
	<div class="row">
		<div class="col-sm-8">
			<h3>Contact The Archives</h3>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec ligula erat. Pellentesque nibh leo, pharetra et posuere vel, accumsan vitae sapien. Phasellus a tortor id felis scelerisque blandit. Curabitur a tristique tortor. Morbi non tortor eget dui blandit laoreet. Quisque lacus quam, auctor sit amet volutpat dictum, scelerisque sit amet neque. Vivamus non massa finibus, ultrices nunc vel, scelerisque dui. Aliquam commodo, quam eget fringilla finibus, enim diam sodales ligula, sollicitudin faucibus ligula lorem vitae arcu. Sed efficitur nisi sit amet lobortis malesuada. Ut quis imperdiet elit. Mauris blandit suscipit leo, non tristique est ultrices eu.</p>
		</div>
		<div class="col-sm-3 col-sm-offset-1">
			<h6>&nbsp;</h6><address>Archives<br>			100 Second Avenue, 2nd floor<br>			New York, NY 10010</address>
		
			<address>Jennifer Smith, Archivist<br>			<span class="info">Phone</span> — 212 222.2222<br>			<span class="info">Fax</span> — 212 222.2223<br>			<span class="info">Email</span> — <a href="#">email@archive.edu</a></address>
		</div>
	</div>
	
	

<script>	
	let pawtucketUIApps = {
		'clock': {
			'selector': '#anotherClock',
			'data': {
				'message': "This is an about page clock!!!!!"
			}
		}
	}; 
</script>
