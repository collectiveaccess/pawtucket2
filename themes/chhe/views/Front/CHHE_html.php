<div id="frontPage" class="container subhomeslide">



<?php
	$va_item_ids = $this->getVar('featured_set_item_ids');
	if(is_array($va_item_ids) && sizeof($va_item_ids)){
		$t_object = new ca_objects();
		$va_item_media = $t_object->getPrimaryMediaForIDs($va_item_ids, array("mediumlarge"), array('checkAccess' => caGetUserAccessValues($this->request)));
		$va_item_labels = $t_object->getPreferredDisplayLabelsForIDs($va_item_ids);
	}
	if(is_array($va_item_media) && sizeof($va_item_media)){
?>   
		<div class="jcarousel-wrapper slidecontainer">
			<!-- Carousel -->
			<div class="jcarousel">
				<ul>
<?php
					foreach($va_item_media as $vn_object_id => $va_media){
						print "<li>".caDetailLink($this->request, $va_media["tags"]["mediumlarge"], '', 'ca_objects', $vn_object_id)."</li>";
					}
?>
				</ul>
			</div><!-- end jcarousel -->
<?php
			if(sizeof($va_item_media) > 1){
?>
			<!-- Prev/next controls -->
			<a href="#" class="jcarousel-control-prev">&lsaquo;</a>
			<a href="#" class="jcarousel-control-next">&rsaquo;</a>
		
			<!-- Pagination -->
			<p class="jcarousel-pagination">
			<!-- Pagination items will be generated in here -->
			</p>
<?php
			}
?>
		</div><!-- end jcarousel-wrapper -->
		<script type='text/javascript'>
			jQuery(document).ready(function() {
				/*
				Carousel initialization
				*/
				$('.jcarousel')
					.jcarousel({
						// Options go here
					});
		
				/*
				 Prev control initialization
				 */
				$('.jcarousel-control-prev')
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
				$('.jcarousel-control-next')
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
			});
		</script>
<?php
	}
?>


<div class="col-sm-3">
<?php print caGetThemeGraphic($this->request, "chhe_int.png"); ?>
</div>     
<div class="col-sm-1"></div>           
<div class="col-sm-7 subintro">The Center for Holocaust &amp; Humanity Education 
promotes tolerance, inclusion, and social justice based on lessons from the Holocaust. </div>      

</div>
  


<div class="container subhomebody">
	

		<div class="col-sm-3 mainmenu">
		<!--main menu will go here-->
		<ol>
		<li class="selected"><a href="#">Jewish Holidays &amp; Festivals</a></li>
		<li><a href="#">Jewish Life Cycles</a></li>
		<li><a href="#">Torah &amp; Synagogue</a></li>
		<li><a href="#">Jewish Community</a></li>
		<li><a href="#">World War II & The Holocaust</a></li>
		<li><a href="#">Zionism &amp; State of Israel</a></li>
		<li><a href="#">Jewish Art</a></li>
		<li><a href="#">Cincinnati Judaica</a></li>
		<li><a href="#">Jewish Medals, Tokens, Plaques & Pins</a></li>
		</ol>
		<!--
		<ul>
		<li><a href="#">Subjects</a></li>
		<li><a href="#">Events</a></li>
		<li><a href="#">Collections</a></li>
		<li><a href="#">People</a></li>
		<li><a href="#">Organizations</a></li>
		<li><a href="#">Object Type</a></li>
		<li><a href="#">Places</a></li>
		<li><a href="#">Years</a></li>
		<li><a href="#">Decade</a></li>
		</ul>-->
		</div>
		<div class="col-sm-9"> <h1>Jewish Holidays &amp; Festivals</h1>
			<div class="row">
			<div class="col-sm-7 sectionpreview">
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis varius iaculis dolor. Proin elementum leo a ipsum consectetur, mattis rutrum lacus eleifend. In viverra fermentum lectus, ut varius mi tempor ut. Suspendisse congue dapibus sapien, sit amet interdum risus aliquet eu. Nullam euismod at erat eget pulvinar. Aenean posuere nec libero eu auctor. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Mauris aliquam rutrum cursus. Morbi feugiat condimentum augue, interdum blandit ligula dignissim ac. Sed nec massa sit amet sem convallis congue vel blandit arcu.</p>

<p>Vivamus tortor ligula, accumsan ac sapien vitae, sagittis egestas magna. Integer sodales ornare ullamcorper. Vivamus ut lacinia magna. Curabitur rutrum tortor lorem, et elementum nisl fermentum eu. Praesent elementum sed eros quis elementum. Nulla enim sem, suscipit eu sem non, feugiat mollis massa. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nullam in hendrerit ipsum, at faucibus nisl.</p>
			
			</div>
			
			<div class="col-sm-5 submenu">
			<ul>
			<li><a href="#">Shabbat</a></li>
			<li><a href="#">Rosh Hashanah (the Jewish New Year)</a></li>
			<li><a href="#">Yom Kippur (the Day of Atonement)</a></li>
			<li><a href="#">Sukkot (the Festival of Booths)</a></li>
			<li><a href="#">Shemini Atzeret & Simchat Torah</a></li>
			<li><a href="#">Hanukah (the Festival of Lights)</a></li>
			<li><a href="#">Tu BiShvat (New Year for Trees)</a></li>
			<li><a href="#">Purim</a></li>
			<li><a href="#">Passover</a></li>
			<li><a href="#">Counting of the Omer</a></li>
			<li><a href="#">Lag B'Omer</a></li>
			<li><a href="#">Yom HaShoah (Holocaust Memorial Day)</a></li>
			<li><a href="#">Yom HaZikaron (Israeli Memorial Day)</a></li>
			<li><a href="#">Yom HaAtzma'ut (Israeli Independence Day)</a></li>
			<li><a href="#">Yom Yerushalayim (Jerusalem Day)</a></li>
			<li><a href="#">Shavuot</a></li>
			<li><a href="#">&quot;The Three Week&quot; &amp; Tish'a B'Av</a></li>
(Fast Commemorating the Destruction of the Temple in Jerusalem)</a></li>
			<li><a href="#">Elul & Selichot</a></li>
			<li><a href="#">5 Minor Fast Days</a></li>
			<li><a href="#">Rosh Chodesh (Beginning of the New Month)</a></li>
			<li><a href="#">Shmita (the Sabbatical Year in the Land of Israel)</a></li>
			</ul>
			</div>
			
			</div>
			
		</div>
		

	</div> <!--end container main body-->	
	
	
  	
</div><!--end col-sm-8-->
	
</div> <!--end container-->

	</div>