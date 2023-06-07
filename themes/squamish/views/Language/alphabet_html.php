<?php

	$va_access_values = $this->getVar("access_values");
	
	$item_id = $this->request->getParameter('item_id', pInteger);
	$pn_set_id = $this->getVar("set_id");
	$va_set_item_row_ids = $this->getVar("set_item_row_ids");
	$va_row_to_item_ids = $this->getVar("row_to_item_ids");
	$va_set_items = $this->getVar("set_items");
	$qr_alphabet_objects = $this->getVar("set_items_as_search_result");
	$pn_set_item_id = $this->getVar("set_item_id");
	
	$qr_vowel_objects = $this->getVar("vowel_set_items_as_search_result");
	$pn_vowel_set_id = $this->getVar("vowel_set_id");
	$va_vowel_set_item_row_ids = $this->getVar("vowel_set_item_row_ids");
	$va_vowel_row_to_item_ids = $this->getVar("vowel_row_to_item_ids");
	$va_vowel_set_items = $this->getVar("vowel_set_items");
	

?>
<div class="row bg_dark_eye pageHeaderRow">
	<div class="col-sm-12">
		<H1>Guide To Pronunciation</H1>
		<p>
		{{{alphabet_intro}}}
		</p>
	</div>
</div>
<div class='row'>
	<div class="col-lg-10 col-lg-offset-1 col-md-12">
		<div class="alphabetNavigation">
<?php
	if($qr_alphabet_objects && ($qr_alphabet_objects->numHits() > 0)){
		print "<div><b>Alphabet: </b>";
		while($qr_alphabet_objects->nextHit()){
			if(!$item_id){
				$item_id = $va_row_to_item_ids[$qr_alphabet_objects->get("ca_objects.object_id")];
			}
			print "<a href='#' class='btn btn-default' id='Letter".$va_row_to_item_ids[$qr_alphabet_objects->get("ca_objects.object_id")]."' onclick='jQuery(\"#alphabetItemContainer\").load(\"".caNavUrl($this->request, '', 'Language', 'AlphabetItem', array('item_id' => $va_row_to_item_ids[$qr_alphabet_objects->get("ca_objects.object_id")], 'set_id' => $pn_set_id))."\"); alphabetHighlightLetter(\"Letter".$va_row_to_item_ids[$qr_alphabet_objects->get("ca_objects.object_id")]."\"); return false;'>".$qr_alphabet_objects->get("ca_objects.preferred_labels.name")."</a>";
			#print "<a href='#' id='galleryIcon".$pa_set_item["item_id"]."' onclick='jQuery(\"#galleryDetailImageArea\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => $pa_set_item["item_id"], 'set_id' => $pn_set_id))."\"); jQuery(\"#galleryDetailObjectInfo\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pa_set_item["item_id"], 'set_id' => $pn_set_id))."\"); galleryHighlightThumbnail(\"galleryIcon".$pa_set_item["item_id"]."\"); return false;'>".$vs_rep."</a>";				
		}
		print "</div>";
	}
?>
		
<?php
	if($qr_vowel_objects && ($qr_vowel_objects->numHits() > 0)){
		print "<div><b>Vowel Combinations: </b>";
		while($qr_vowel_objects->nextHit()){
			if(!$item_id){
				$item_id = $va_vowel_row_to_item_ids[$qr_vowel_objects->get("ca_objects.object_id")];
			}
			print "<a href='#' class='btn btn-default' id='Letter".$va_row_to_item_ids[$qr_vowel_objects->get("ca_objects.object_id")]."' onclick='jQuery(\"#alphabetItemContainer\").load(\"".caNavUrl($this->request, '', 'Language', 'AlphabetItem', array('item_id' => $va_vowel_row_to_item_ids[$qr_vowel_objects->get("ca_objects.object_id")], 'set_id' => $pn_vowel_set_id))."\"); alphabetHighlightLetter(\"Letter".$va_row_to_item_ids[$qr_vowel_objects->get("ca_objects.object_id")]."\"); return false;'>".$qr_vowel_objects->get("ca_objects.preferred_labels.name")."</a>";
				
		}
		print "</div>";
	}
?>
		</div>
	</div>
</div>
<div class='row'>
	<div class="col-lg-10 col-lg-offset-1 col-md-12">
		<div id="alphabetItemContainer">
		</div>
	</div>
</div>


<script type='text/javascript'>
		jQuery(document).ready(function() {		
			jQuery("#alphabetItemContainer").load("<?php print caNavUrl($this->request, '', 'Language', 'AlphabetItem', array('item_id' => $item_id, 'set_id' => $pn_set_id)); ?>");
			alphabetHighlightLetter("Letter<?php print $item_id; ?>");
		});
		function alphabetHighlightLetter(id) {		
			jQuery(".alphabetNavigation a").removeClass("letterActive");
			jQuery("#" + id).addClass("letterActive");
		}
</script>