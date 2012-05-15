<?php 
				$is_home_page = $this->getVar('is_home_page');
				echo $is_home_page;
				if(isset($is_home_page)) {
?>
					<a href="" class="header-img">
						<img src="<?php echo $this->request->getThemeUrlPath(); ?>/img/<?php echo $this->request->config->get('header_img'); ?>" />
						<div class="header-callout">
							<div class="header-callout-top">
								<p>Photos, design sketches, publicity materials and more—almost 50 years of Roundabout’s storied history for you to explore.</p>
								<p class="link">Learn More »</p>
							</div> 
							<div class="header-callout-btm"></div>					
						</div>
					</a> 
<?php
				} // end if
?>
				<h2 class="ir">Roundabout Archives</h2>
			<!-- end #header -->
			</div>
			
			<div id="main" role="main">