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
	$qr_readers = nysocGetBooks($ps_letter);
	$va_active_letters = array_flip(nysocGetBooksLetterBar());
	
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
			<div class="row">
<?php
		while($qr_readers->nextHit()) {
?>
			<div class="col-sm-4">
				<a href='#' class='readerListEntry' data-object_id='<?php print $qr_readers->get('ca_objects.object_id'); ?>'><?php print caTruncateStringWithEllipsis($qr_readers->get('ca_objects.preferred_labels.name'), 50); ?></a>
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
		<div class='readerListToggle openpanel'>close</div>
	</div>
<?php
	}
?>	
	</div> <!--end container-->
</div>


<script type="text/javascript">
	jQuery("div.readerListLetterBar .availableLetter").bind('click', function() {
		jQuery("#readerList").load('<?php print caNavUrl($this->request, '*', '*', 'bookIndex'); ?>/l/' + jQuery(this).text());
	});
	jQuery(".readerListEntry").bind('click', function(e) {
		var id = jQuery(this).data('object_id');
		
		jQuery("#readerContent").load('<?php print caNavUrl($this->request, '*', '*', 'GetBooks'); ?>/id/' + id);

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
</script>