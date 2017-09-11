<div id='travelerListContent'>
	<div class="container" id="travelerList">
		<div class="row">
<?php
	$vb_letter_specified = true;
	if (!$ps_letter = strtoupper($this->request->getParameter('l', pString))) {
		$ps_letter = 'A';
		$vb_letter_specified = false;
	}
	$qr_travelers = itineraGetTravelers($ps_letter);
	$va_active_letters = array_flip(itineraGetTravelersLetterBar());
	
	// Output letter bar
?>
		<div class="travelerListLetterBar">
<?php
		$va_letters = range('A', 'Z');
		foreach($va_letters as $vs_letter) {
			print array_key_exists($vs_letter, $va_active_letters) ? "<a href='#' class='".(($vs_letter == $ps_letter) ? 'activeLetter' : 'availableLetter')."'>{$vs_letter}</a>" : "<span class='disabledLetter'>{$vs_letter}</span>";
		}
?>
		</div>
<?php
	if ($qr_travelers) {
		// Output traveler list
		$vn_i = 0;
?>
	<div class="row">
		<div class="col-md-2 travelerListSectionHeading">Travelers</div>
		<div class="col-md-10">
			<div class="row">
<?php
		while($qr_travelers->nextHit()) {
?>
			<div class="col-sm-4">
				<a href='#' class='travelerListEntry' data-entity_id='<?php print $qr_travelers->get('ca_entities.entity_id'); ?>'><?php print $qr_travelers->get('ca_entities.preferred_labels.displayname'); ?></a>
			</div><!--end col-sm-4-->
<?php
			$vn_i++;
		
			if ($vn_i >= 3) {
?>
			</div>
			<div class="row">
<?php	
				$vn_i = 0;
			}
		}
?>
			</div>
		</div>
	</div>
<?php
	}
		
	$qr_objects = itineraGetObjects($ps_letter);
	if ($qr_objects->numHits()) {
?>
	<div class="row <?php print ($qr_travelers) ? 'travelerListSpacer' : ''; ?>">
		<div class="col-md-2 travelerListSectionHeading">Objects</div>
		<div class="col-md-10">
			<div class="row">
<?php
		// Output object list
		$vn_i = 0;
		while($qr_objects->nextHit()) {
?>
			<div class="col-sm-4">
				<a href='#' class='travelerListEntry' data-object_id='<?php print $qr_objects->get('ca_objects.object_id'); ?>'><?php print $qr_objects->get('ca_objects.preferred_labels.name'); ?></a>
			</div><!--end col-sm-4-->
<?php
			$vn_i++;
		
			if ($vn_i >= 3) {
?>
			</div>
			<div class="row">
<?php	
				$vn_i = 0;
			}
		}
?>
			</div>
		</div>
	</div>
<?php
	}
?>	
		</div><!-- end row -->
	</div> <!--end container-->
</div>
<div id='travelerListToggle'>Index</div>

<script type="text/javascript">
	jQuery("div.travelerListLetterBar .availableLetter").bind('click', function() {
		jQuery("#travelerList").load('<?php print caNavUrl($this->request, '*', '*', 'TravelerIndex'); ?>/l/' + jQuery(this).text());
	});
	jQuery(".travelerListEntry").bind('click', function() {
		var id, idname;
		if (id = jQuery(this).data('entity_id')) { 
			idname = 'id'; 
		} else {
			if (id = jQuery(this).data('object_id')) { idname = 'object_id'; }
		}
<?php
	if ($this->request->getController() == 'ChronologyOld') {
?>
		jQuery.get('<?php print caNavUrl($this->request, '*', '*', 'Get'); ?>/' + idname + '/' + id, function(d){ 
	  		jQuery(d).appendTo("#travelerContent");
		});
<?php
	} elseif($this->request->getController() == 'Chronology') {
?>
		jQuery.get('<?php print caNavUrl($this->request, '*', '*', 'Get'); ?>/' + idname + '/' + id +'/m/add', function(d){ 
	  		jQuery(d).appendTo("#travelerContentTimelineColumns");
		});
<?php
	} else {
?>
		jQuery("#travelerContent").load('<?php print caNavUrl($this->request, '*', '*', 'Get'); ?>/' + idname + '/' + id);
<?php
	}
?>
	});
	jQuery("#travelerListToggle").bind('click', function() { 
		jQuery('#travelerListContent:visible').animate({opacity: 'toggle', height: 'toggle'}, 250); 
		jQuery('#travelerListContent:hidden').animate({opacity: 'toggle', height: 'toggle'}, 250); 
	});
<?php
	if ($vb_letter_specified) {
?>
		jQuery('#travelerListContent').show();
<?php
	}
?>
</script>