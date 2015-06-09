<?php
	$vn_entity_id = $this->getVar('entity_id');
?>
<div id='travelerList' class='clearfix'>
	
</div>


<div class="container">
	<div class="row">
		<div class="col-sm-9" id='travelerContent'>
			
		</div>
		<div class="col-sm-3" id='travelerCardContainer'>
			<div id='travelerCard'>
 			
			</div>
		</div>
	</div>
</div>

<?php
	//
	// Load traveler index via ajax
	//
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#travelerList").load('<?php print caNavUrl($this->request, '*', '*', 'TravelerIndex'); ?>');
<?php
	if ($vn_entity_id > 0) {
?>
		jQuery("#travelerContent").load('<?php print caNavUrl($this->request, '*', '*', 'Get', array('id' => $vn_entity_id)); ?>');
<?php
	}	
?>
	});
</script>