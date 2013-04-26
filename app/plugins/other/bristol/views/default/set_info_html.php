<?php
/* ----------------------------------------------------------------------
 * app/plugins/bristol/set_info_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2011 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
 
$t_set 				= $this->getVar('t_set');
$va_items 		= $this->getVar('items');

$va_set_list 		= $this->getVar('sets');
$va_first_items_from_sets 	= $this->getVar('first_items_from_sets');
?>

<div id="bristolSetDetail">
<?php

# --- selected set info - description and a grid of items with links to open panel with more info
?>
<div class="bristolInfo">
	<h1><?php print $this->getVar('set_title'); ?></h1>
<?php
	if($vs_set_number = sizeof($va_items)){
		print "<div class='numberItems'>".$vs_set_number.' '.(($vs_set_number == 1) ? _t('item') : _t('items'))."</div>\n";
	}
	if($vs_set_creator = $this->getVar('set_creator')){
		print "<div class='unit'><b>"._t('Creator')."</b>: {$vs_set_creator}</div>\n";
	}
	if($vs_set_date = $this->getVar('set_date')){
		print "<div class='unit'><b>"._t('Set created on')."</b>: {$vs_set_date}</div>\n";
	}
	if($vs_set_expiration_date = $this->getVar('set_expiration_date')){
		print "<div class='unit'><b>"._t('You have access until')."</b>: {$vs_set_expiration_date}</div>\n";
	}
	if($vs_set_description = $this->getVar('set_description')) {
		print "<div class='unit'>{$vs_set_description}</div>\n";
	}
?>
<!--<span style="color:#666;"><b>Export as PDF >></b></span>-->
</div>

	<div id='setItemsGrid'>
		<div id='bristolSort'>
			<?php print caNavLink($this->request, _t('Back to list'), '', 'bristol', 'Show', 'Index'); ?>
		</div>
				
		<div id="bristolbox" style="display:none;">
			<a href="#"><div class="close"><!-- empty --></div></a>
			<div id="bristolboxContent">
				<!-- This div is what we load ajax stuff into -->
			</div>
		</div>

<script type="text/javascript">	
//
// This is a function that is called by the item links below. It takes a single parameter called "item_id" that is the set item to show
//
function showOverlayForItem(item_id) {
	 jQuery('#bristolbox').lightbox_me({			// #bristolbox is what will be lightboxed on trigger
        centered: true, 
        closeSelector: '.close',
        onLoad: function() { 								// #bristolboxContent is what actually gets filled with content; #bristolbox wraps #bristolboxContent... if we loaded directly into #bristolbox then we'd have a harder time controlling presentation in some cases.
            jQuery('#bristolboxContent').load('<?php print caNavUrl($this->request, 'bristol', 'Show', 'setItemInfo', array('set_id' => $t_set->get("set_id"))); ?>/set_item_id/' + item_id);
        },
        onClose: function() {
        	  jQuery('#bristolboxContent').html('');	
        }
    });
}
</script>

<?php
	$t_object = new ca_objects();
	foreach($va_items as $va_item) {
		$t_object->load($va_item['row_id']);
?>
		
			<a href="#" onclick="showOverlayForItem(<?php print $va_item['item_id']; ?>); return false;">
			<div class="setItemContainer">
				<div class="setItem" id="item<?php print $va_item['item_id']; ?>"><?php print $va_item['representation_tag_widepreview']; ?><br/></div>
				<div class="setItemCaption">
<?php 	
				print "<b>".$t_object->get("ca_objects.preferred_labels")."</b><br/>";
				print "ID: ".$t_object->get("ca_objects.idno")."<br/>";
				print "Date: ".$t_object->get("ca_objects.date")."<br/>";
				print "Runtime: ".$t_object->get("ca_objects.length");
?>
				</div>
			</div></a>


<?php
		if($va_item['caption'] || $va_item['representation_tag_medium']){
			// set view vars for tooltip
			$this->setVar('tooltip_image_name', $t_object->get("ca_objects.preferred_labels"));
			$this->setVar('tooltip_text', "ID: ".$t_object->get("ca_objects.idno")."<br/>Date: ".$t_object->get("ca_objects.date")."<br/>Runtime: ".$t_object->get("ca_objects.length"));
			$this->setVar('tooltip_image', $va_item['representation_tag_medium']);
			TooltipManager::add(
				"#item{$va_item['item_id']}", $this->render('default/tooltip_html.php')
			);
		}
	}
	print "</div><!-- end setItemsGrid --></div>";

?>
