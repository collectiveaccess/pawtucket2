<?php
	$va_access_values 				= caGetUserAccessValues($this->request);
?>
<div class="transcription educationalResources container textContent">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h1><a href="/About/Teachers"><?= _t('For Teachers'); ?></a> &gt; <a href="/EducationalResources/Index"><?= _t('Educational Resources'); ?></a></H1>
			<p>
			 	<?= _t('Welcome to #NovaMuseEd, our teacher resource section, where you can help your students make connections to the world, past and present. Anything in this section can be downloaded and used for educational purposes. Learning activities are also customizable so you can better meet the unique needs of learners, classes and programs.'); ?>
			</p><p>
			<?= _t('We would love to see these resources in action. Feel free to tag us at @NovaMuse_ca or #NovaMuseEd. If you have ideas for additional resources, please contact us. This is a new initiative, and we look forward to building resources with you and for you.'); ?>
			</p>
			<p><?= _t('Visit the').' <a href="/About/guide">'._t('help').'</a> '._t('page to learn more.'); ?></p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-9 col-md-offset-1 text-center">
			<h2><?= _t('Explore educational resources'); ?>:</h2>
			<a role="button" class="btn btn-primary btn-lg landingBtn" href="/EducationalResources/Browse/facet/type_facet/id/1615"><?= _t('Learning Activities'); ?></a>
			<a role="button" class="btn btn-success btn-lg landingBtn" href="/EducationalResources/Browse/facet/type_facet/id/1614"><?= _t('Colouring, Games and Puzzles'); ?></a>
			<a role="button" class="btn btn-warning btn-lg landingBtn" href="/EducationalResources/Browse/facet/type_facet/id/1616"><?= _t('Audio/Video'); ?></a>
			<a role="button" class="btn btn-info btn-lg landingBtn" href="/EducationalResources/Browse/facet/type_facet/id/1860"><?= _t('Stories'); ?></a>
			<a role="button" class="btn btn-danger btn-lg landingBtn" href="/Gallery/Index"><?= _t('Create Your Own Gallery'); ?></a>
		</div>
	</div>
	
	<div class="row recent">
		<h2><?= _t('What\'s New'); ?></h2>
		<div class="recent jcarousel-wrapper">
			<div class="recent jcarousel" style="height: 310px;">
				<ul>
<?php
		$occ = new ca_occurrences();
		$va_recently_added_items = $occ->getRecentlyAddedItems(20, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1));	
		$va_labels = $occ->getPreferredDisplayLabelsForIDs(array_keys($va_recently_added_items));
 		$va_media = $occ->getPrimaryMediaForIDs(array_keys($va_recently_added_items), array('iconlarge', 'small', 'medium'), array("checkAccess" => $va_access_values));
		foreach($va_recently_added_items as $vn_occurrence_id => $va_occurrence_info){
			print "<li><div class='memberTile'>";
			print "<div class='memberImageCrop'>".caNavLink($this->request, $va_media[$vn_occurrence_id]['tags']['small'], '', '', '*', 'Resource', ['id' => $vn_occurrence_id])."</div>";
			print "<p>".caNavLink($this->request, $va_labels[$vn_occurrence_id], '', '', '*', 'Resource', ['id' => $vn_occurrence_id])."</p>";

			print "</div></li>";
		}	
		
		$o_context = new ResultContext($this->request, 'ca_occurrences', 'front');
		$x = array_keys($va_recently_added_items);
		array_unshift($x, 0);
		$o_context->setResultList($x);	
		$o_context->setAsLastFind();	
		$o_context->saveContext();
?>
				</ul>
			</div>	<!-- end jc  -->
			<!-- Prev/next controls -->
			<a href="#" class="recent jcarousel-control-prev"><i class="fa fa-angle-left"></i></a>
			<a href="#" class="recent jcarousel-control-next"><i class="fa fa-angle-right"></i></a>
		
			<!-- Pagination -->
			<p class="recent jcarousel-pagination">
			<!-- Pagination items will be generated in here -->
			</p>			
		</div>	<!-- end jc wrapper -->	
		<script type='text/javascript'>
			jQuery(document).ready(function() {
				/*
				Carousel initialization
				*/
				$('.recent.jcarousel')
					.jcarousel({
						// Options go here
						wrap:'circular'
					});
		
				/*
				 Prev control initialization
				 */
				$('.recent.jcarousel-control-prev')
					.on('recent.jcarouselcontrol:active', function() {
						$(this).removeClass('inactive');
					})
					.on('recent.jcarouselcontrol:inactive', function() {
						$(this).addClass('inactive');
					})
					.jcarouselControl({
						// Options go here
						target: '-=1'
					});
		
				/*
				 Next control initialization
				 */
				$('.recent.jcarousel-control-next')
					.on('recent.jcarouselcontrol:active', function() {
						$(this).removeClass('inactive');
					})
					.on('recent.jcarouselcontrol:inactive', function() {
						$(this).addClass('inactive');
					})
					.jcarouselControl({
						// Options go here
						target: '+=1'
					});
		
				/*
				 Pagination initialization
				 */
				$('.recent.jcarousel-pagination')
					.on('jcarouselpagination:active', 'a', function() {
						$(this).addClass('active');
					})
					.on('jcarouselpagination:inactive', 'a', function() {
						$(this).removeClass('active');
					})
					.jcarouselPagination({
						// Options go here
					});
			});
		</script>
	</div><!-- end row recent -->
</div>