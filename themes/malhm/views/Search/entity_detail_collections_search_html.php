<?php
$count = $this->getVar('count');
$qr = $this->getVar('result');
?>


<h3>Archival Collections <?= "({$count})"; ?></h3>

<?php
	if($qr && ($qr->numHits() > 0)) {
?>
<div class="jcarousel-wrapper col-sm-12" id="collections-list">
	<div class="jcarousel">
		<ul>
<?php
		while($qr->nextHit()){		
			print "<li ><div class='setTile oneItem'>";
			print "<div class='setImage'>".caNavLink($this->request, $qr->get('ca_object_representations.media.large'), '', '', 'Detail', 'Collections/'.$qr->getPrimaryKey(), [])."</div>";
				
			print "<div class='name' style='clear: both;'>".caNavLink($this->request, $qr->get('ca_collections.preferred_labels.name'), '', 'Detail', 'Collections/'.$qr->getPrimaryKey(), [])."</div>";
			
			print "</div></li>";
		}
?>
		</ul>
	</div>
	<a href="#" class="jcarousel-control-prev"><i class="fa fa-angle-left"></i></a>
	<a href="#" class="jcarousel-control-next"><i class="fa fa-angle-right"></i></a>	
	
<!-- Pagination -->
<p class="jcarousel-pagination">
	<!-- Pagination items will be generated in here -->
</p>					
</div>	<!-- end jc wrapper -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		/*
		Carousel initialization
		*/
		$('#collections-list .jcarousel')
			.jcarousel({
				// Options go here
				wrap:'none'
			});

		/*
		 Prev control initialization
		 */
		$('#collections-list .jcarousel-control-prev')
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
		$('#collections-list .jcarousel-control-next')
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
		$('#collections-list .jcarousel-pagination')
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
	} else {
?>
	<!-- empty -->
<?php
	}	
?>