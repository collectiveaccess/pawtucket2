<?php
	$t_thread = $this->getVar("thread");
	$va_access_values = $this->getVar("access_values");
	$vn_set_id = $this->getVar("set_id");
?>
	<div class="row tanBg exploreRow narrativeThreadRow">
		<div class="col-sm-12">
			<H2>
<?php
			
			print caNavLink($this->request, "<i class='fa fa-arrow-circle-left' aria-hidden='true'></i> Narrative Thread: ", "uppercase", "", "Explore", "narrativethreads");
			print $t_thread->get("ca_list_items.preferred_labels.name_singular");
?>
			</H2>
			<p>
				<?php print $t_thread->get("ca_list_items.description"); ?>
			</p>
			<div class="text-center">
<?php
			print caNavLink($this->request, "Browse All Related Objects", "btn-default btn-lg", "", "Browse", "objects", array("facet" => "narrative_threads_facet", "id" => $t_thread->get("item_id")));
?>			
			</div>

		</div>
	</div>
	<div class='row'>
		<div class="col-lg-12">
			<div id="featured_set" class="gallery"></div>
		</div><!-- end col -->
	</div><!-- end row -->
<?php
	if($vn_set_id){
?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery("#featured_set").load("<?php print caNavUrl($this->request, '', 'Gallery', $vn_set_id); ?>");
		});
	</script>
<?php
	}
?>