<div class="container">
	<div class="row">
	<div class="col-lg-12">
	<?php
	 	print $this->render("Front/featured_set_slideshow_2col_html.php");
?>
	</div>
	
		<div class="col-sm-6 col-md-4">
		<h2>Vision</h2><hr>
			<H1>{{{hpVision}}}</H1>
		</div><!--end col-sm-8-->
	<div class="col-sm-6 col-md-5">
<?php
	 	print $this->render("Front/spotlight_set_grid_html.php");
?>
	</div> <!--end col-sm-4 -->	
	
		<div class="col-sm-6 col-md-3">
			<h2>Browse by Topic  <a href="../Gallery/Index"><button class="pull-right btn-default">View all</button></a></h2>
			
			<?php
			print caGetGallerySetsAsList($this->request, "nav nav-pills nav-stacked", array("limit" => 5));
			?>
		</div> <!--end col-sm-4-->	
	</div><!-- end row -->
</div> <!--end container-->