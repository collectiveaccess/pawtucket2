<?php
	AssetLoadManager::register("carousel");
	$va_results = $this->getVar('results');
	$va_result_count = $va_results['_info_']['totalCount'];
?>
		<small class='pull-right jumpLinks'><?php
		$i = 0;
		foreach($this->getVar('blockNames') as $vs_block) {
			if ($va_results[$vs_block]['count'] == 0) { continue; }
			$i++;
			if($i > 1){
				print " | ";
			}
			print "<a href='#{$vs_block}'>".$va_results[$vs_block]['displayName']." (".$va_results[$vs_block]['count'].")</a>";
		}
?></small>
		<h1><?php print _t("Search results for %1", caUcFirstUTF8Safe($this->getVar('searchForDisplay'))); ?></h1>

<div id="siteBlock" class="resultBlock">
		<a name='siteResults'></a>
		<H3>Site (<span class='siteCount'></span>)</H3>

		<div class="jcarousel-wrapper blockResults">
			<!-- Carousel -->
			<div class="jcarousel">
				<ul id="siteSearchResults">
	
	
				</ul>
			</div>
			<a href="#" class="jcarousel-prev scrollButtonPrevious"><i class="fa fa-angle-left"></i></a>
			<a href="#" class="jcarousel-next scrollButtonNext"><i class="fa fa-angle-right"></i></a>
		</div>
		
		<script type='text/javascript'>
			jQuery(document).ready(function() {

			});
		</script>		
</div>	
	
	
	
	
<?php
	if ($va_result_count > 0) {
		// 
		// Print out block content (results for each type of search)
		//
		foreach($this->getVar('blockNames') as $vs_block) {
?>
			<a name='<?php print $vs_block; ?>'></a>
			<div id="<?php print $vs_block; ?>Block"<?php print ($vs_block != "objects_search") ? " class='resultBlock'" : ""; ?>>
				<?php print $va_results[$vs_block]['html']; ?>
			</div>
<?php
		} 
	} else {
		print "<H1 class='noResultsMsg' style='display:none;'>"._t("Your search for %1 returned no results", caUcFirstUTF8Safe($this->getVar('search')))."</H1>";
		
		
	}
?>
<?php
	TooltipManager::add('#Block', 'Type of record');
?>
<script type="text/javascript">
	jQuery("#siteBlock").css("display", "none");
	jQuery(document).ready(function() {
		// grab search results
		jQuery.getJSON("https://stormking.org/wp-json/wp/v2/pages", <?php print json_encode(array('search' => $this->getVar('search'), 'per_page' => 100)); ?>, function(d) {
			
			var hits = [];
			var numHits = 0;
			var colCount = 0;
			if (d && (d.length > 0)) {
				jQuery(d).each(function(k, v) {
					var result = "";
					if(colCount == 0){
						result = result + "<li class='authoritySet'>";
					}
					result = result + "<div class='siteResult authorityResult'><a href='" + v['link'] + "'>" + v['title']['rendered'] + "</a></div>";
					
					
					numHits++;
					colCount++;
					if(colCount == 3){
						colCount = 0;
						result = result + "</li>";
					}
					if((numHits == d.length) && (colCount > 0)){
						result = result + "</li>";
					}
					hits.push(result);
				});
			}
			if (numHits === 0){
				jQuery(".noResultsMsg").css("display", "block");
			} else {
				jQuery("#siteBlock").css("display", "block");
				jQuery(".noResultsMsg").css("display", "none");
				jQuery("#siteSearchResults").html(hits.join("\n"));
				jQuery(".siteCount").html(d.length);
				var anchorLink = "<a href='#siteResults'>Site (" + d.length + ")</a>";
				if(jQuery(".jumpLinks").html().length){
					anchorLink = anchorLink + " | ";
				}
				jQuery(".jumpLinks").prepend(anchorLink);
				
				
								/*
				Carousel initialization
				*/
				$('.jcarousel')
					.jcarousel({
						// Options go here
						wrap:null
					});
		
				/*
				 Prev control initialization
				 */
				$('.jcarousel-prev')
					.on('jcarouselcontrol:active', function() {
						$(this).removeClass('inactive');
					})
					.on('jcarouselcontrol:inactive', function() {
						$(this).addClass('inactive');
					})
					.jcarouselControl({
						// Options go here
						target: '-=1'
					});
		
				/*
				 Next control initialization
				 */
				$('.jcarousel-next')
					.on('jcarouselcontrol:active', function() {
						$(this).removeClass('inactive');
					})
					.on('jcarouselcontrol:inactive', function() {
						$(this).addClass('inactive');
					})
					.jcarouselControl({
						// Options go here
						target: '+=1'
					});
		
				/*
				 Pagination initialization
				 */
				$('.jcarousel-pagination')
					.on('jcarouselpagination:active', 'a', function() {
						$(this).addClass('active');
					})
					.on('jcarouselpagination:inactive', 'a', function() {
						$(this).removeClass('active');
					})
					.jcarouselPagination({
						// Options go here
					});
			}
			
			
		}).fail(function() {
			jQuery("#siteBlock").css("display", "none");
		});
	});
</script>