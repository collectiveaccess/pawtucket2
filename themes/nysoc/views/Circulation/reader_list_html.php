<?php
	// List of all readers
?>
<div id='readerListContent'>
	<div class="container" id="readerList">
		<div class="row">
<?php
	// Generate list of active letters (those that will return at least one reader) 
	$vb_letter_specified = true;
	if (!$ps_letter = strtoupper($this->request->getParameter('l', pString))) {
		$ps_letter = 'A';
		$vb_letter_specified = false;
	}
	$qr_readers = nysocGetReaders($ps_letter);
	$va_active_letters = array_flip(nysocGetreadersLetterBar());
	
	// Output letter bar
?>
			<div class="col-md-12 readerListLetterBar">
<?php
			$va_letters = range('A', 'Z');
			foreach($va_letters as $vs_letter) {
				print array_key_exists($vs_letter, $va_active_letters) ? "<a href='#' class='".(($vs_letter == $ps_letter) ? 'activeLetter' : 'availableLetter')."'>{$vs_letter}</a>" : "<span class='disabledLetter'>{$vs_letter}</span>";
			}
?>
			</div>
			
		</div>
<?php
	if ($qr_readers) {
		// Output reader list
		$vn_i = 0;
?>
	<div class="row">
		<div class="col-md-12 readerListContent">
<?php
		$va_rows = [];
		$vs_row = '';
		while($qr_readers->nextHit()) {
			$vs_row .= "
			<div class='col-sm-3'>
				<a href='#' class='readerListEntry' data-entity_id='".$qr_readers->get('ca_entities.entity_id')."'><i class='fa fa-plus' style='padding-right:10px'></i> ".$qr_readers->get('ca_entities.preferred_labels.displayname')."</a>
			</div><!--end col-sm-3-->
			";
			$vn_i++;
		
			if ($vn_i >= 4) {
				$va_rows[] = $vs_row;
				$vs_row = '';
				$vn_i = 0;
			}
		}
		
		if ($vs_row) { $va_rows[] = $vs_row; }
		
		foreach($va_rows as $vs_row) {
			print "<div class='row'>{$vs_row}</div>";
		}
?>
		</div>
		<div class='readerListToggle openpanel'>close</div>
	</div>
<?php
	}
?>	
	</div> <!--end container-->
</div>


<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("div.readerListLetterBar .availableLetter").bind('click', function() {
			jQuery("#readerList").load('<?php print caNavUrl($this->request, '*', '*', 'readerIndex'); ?>/l/' + jQuery(this).text());
		});
		jQuery(".readerListEntry").bind('click', function(e) {
			var id = jQuery(this).data('entity_id');
		
			jQuery("#readerContent").load('<?php print caNavUrl($this->request, '*', '*', 'GetReaders'); ?>/id/' + id);

			e.preventDefault();
			return false;
		});
		jQuery(".readerListToggle").bind('click', function(e) { 
			jQuery('#readerListContent:visible').animate({opacity: 'toggle', height: 'toggle'}, 250); 
			jQuery('#readerListContent:hidden').animate({opacity: 'toggle', height: 'toggle'}, 250); 
		
			e.preventDefault();
			return false;
		});
<?php
		if ($vb_letter_specified) {
?>
			jQuery('#readerListContent').show();
<?php
		}
?>
	});
</script>