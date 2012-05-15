<?php
	$va_sets = $this->getVar('sets');
	$va_first_items_from_sets = $this->getVar('first_items_from_sets');

if (!$this->request->isAjax()) {
?>
<h1><?php print _t("Memories"); ?></H1>

<div id="featuresLanding">
<?php
	print $this->render('memories_intro_text_html.php');
?>
	<div id="memoriesText">
		<div id="browseTabs">
			<ul>
<?php		
				print "<li>"._t("Browse By:")."</li>";
				print "<li><a href='#placeTab'>"._t("Place")."</a></li>";
				print "<li><a href='#tagTab'>"._t("Keywords")."</a></li>";
				print "<li><a href='#dateTab'>"._t("Date")."</a></li>";
?>
			</ul>
			
			<br style="clear: both;"/>
<?php
				
?>
			<div id="placeTab">
				<div id="location" style="width:267px; height: 400px; overflow: hidden; margin-bottom:15px;">
<?php
				print $this->getVar('map'); 
?>
				</div>

			</div>
<?php
	
		
		
		// TAG CLOUD
?>
		<div id="tagTab">
<?php
			print "<div id='tagCloud'>\n";
			foreach($this->getVar('set_terms') as $vn_item_id => $va_term) {
				$vn_font_size = $va_term['count']/4;
				if ($vn_font_size < 11) { $vn_font_size = 11; }
				if ($vn_font_size > 33) { $vn_font_size = 33; }
				//print "<a href='#' style='font-size:{$vn_font_size}px;'>".$va_term['label']."</a> ";
				print "<a href='#' onclick='wwsfLoadSetsForTerm(".intval($vn_item_id)."); return false;' style='font-size:{$vn_font_size}px;'>".$va_term['label']."</a> ";
			}
			
			print "</div>\n";
?>	
			<script type="text/javascript">
				function wwsfLoadSetsForTerm(item_id) {
					jQuery('#memoriesSearchList').load('<?php print caNavUrl($this->request, 'wwsf', 'Memories', 'searchSetsByTerm', array()); ?>', {item_id: item_id}, function() {
						jQuery('#memoriesList').hide();
						jQuery('#memoriesSearchList').show();
					});
					
				}
			</script>
		</div>
		
		<div id="dateTab">
<?php
			// DATE LIST
			
			print "<table id='memoryDates'><tr>";
			foreach($this->getVar('set_dates') as $vs_year => $va_month_list) {
				print "<td valign='top'>";
				
				print "<div class='heading'>{$vs_year}</div>";
				
				foreach($va_month_list as $vs_month) {
					print "<a href='#' onclick='wwsfLoadSetsForDate(\"".($vs_month.' '.$vs_year)."\"); return false;'>".$vs_month."</a><br/>\n";
				}
				
				print "</td>\n";
			}
			print "</tr></table>";
?>	
			<script type="text/javascript">
				function wwsfLoadSetsForDate(date) {
					jQuery('#memoriesSearchList').load('<?php print caNavUrl($this->request, 'wwsf', 'Memories', 'searchSetsByDate', array()); ?>', {date: date}, function() {
						jQuery('#memoriesList').hide();
						jQuery('#memoriesSearchList').show();
					});
					
				}
			</script>
		</div>
	</div>
</div>
<?php
}	

?>
<div id="featuresBox">	
	<div id="memoriesSearchList">
		
	</div>
	<div id="memoriesList">
<?php

		$vn_items_per_page = $this->getVar('itemsPerPage');
		if($this->getVar('numPages') > 1){
?>
			<div id='resultsNavBg'>
				<div id="resultsNav">
					<div id="paging">
<?php
				if ($this->getVar('page') > 1) {
					print "<a href='#' onclick='jQuery(\"#featuresBox\").load(\"".caNavUrl($this->request, 'wwsf', 'Memories', 'index', array('page' => $this->getVar('page') - 1))."\"); return false;'>&lsaquo; "._t("PREVIOUS")."</a>";
				}
				print '&nbsp;&nbsp;&nbsp;'._t('page').' '.$this->getVar('page').'/'.$this->getVar('numPages').'&nbsp;&nbsp;&nbsp;';
				if ($this->getVar('page') < $this->getVar('numPages')) {
					print "<a href='#' onclick='jQuery(\"#featuresBox\").load(\"".caNavUrl($this->request, 'wwsf', 'Memories', 'index', array('page' => $this->getVar('page') + 1))."\"); return false;'>"._t("NEXT")." &rsaquo;</a>";
				}
?>
					</div><!-- end paging -->
<?php
				print '<form action="#">'._t("Jump to page").': <input type="text" size="3" name="page" id="jumpToPageNum" value=""/> <a href="#" onclick=\'jQuery("#featuresBox").load("'.caNavUrl($this->request, 'wwsf', 'Memories', 'index', array()).'/page/" + jQuery("#jumpToPageNum").val());\'>'._t("GO").'</a></form>';
				print _t('Found %1 results.', $this->getVar("numResults"));
?>
				</div><!-- end resultsNav -->
			</div><!-- end resultsNavBg -->
<?php
		}	
?>
		<div id="resultsOutline">
<?php
	$vn_count = 0;
	$t_set_item = new ca_objects();
	foreach($va_sets as $vn_set_id => $va_set_info){
		$va_item = $va_first_items_from_sets[$vn_set_id][array_shift(array_keys($va_first_items_from_sets[$vn_set_id]))];
		print "<div class='setInfo'>";
		print "<div class='setTitle'>".caNavLink($this->request, (strlen($va_set_info["name"]) > 32 ? substr($va_set_info["name"], 0, 29)."..." : $va_set_info["name"]), '', 'Detail', 'Object', 'Show', array('set_id' => $vn_set_id, 'object_id' => $va_item["object_id"]))."</div>";
?>
		<table cellpadding="0" cellspacing="0" class="bg"><tr><td valign="middle" align="center" class="imageContainer" id="imageContainerForSet_<?php print $vn_set_id; ?>">
<?php
		$t_set_item->load($va_item["object_id"]);
		if($t_set_item->get("type_id") == 5){
			# --- video so print out icon
			print "<div class='videoIconThemesMemories'><img src='".$this->request->getThemeUrlPath()."/graphics/video.gif' width='26' height='26' border='0'></div>";
		}
		print caNavLink($this->request, $va_item['representation_tag'], '', 'Detail', 'Object', 'Show', array('set_id' => $vn_set_id, 'object_id' => $va_item["object_id"]));
?>
		</td></tr></table>

<?php
		print "<div class='setCount'>".(($va_set_info["item_count"] == 1) ? _t("%1 image", $va_set_info["item_count"]) : _t("%1 images", $va_set_info["item_count"]))."</div>";
		print "</div><!-- end setInfo -->";
	
		$vn_count++;
	}

?>
		<div style="clear:both;"><!-- empty --></div></div><!-- end resultsOutline -->
<?php
		if($this->getVar('numPages') > 1){
?>
			<div id='resultsNavBg'>
				<div id="resultsNav">
					<div id="paging">
<?php
				if ($this->getVar('page') > 1) {
					print "<a href='#' onclick='jQuery(\"#featuresBox\").load(\"".caNavUrl($this->request, 'wwsf', 'Memories', 'index', array('page' => $this->getVar('page') - 1))."\"); return false;'>&lsaquo; "._t("PREVIOUS")."</a>";
				}
				print '&nbsp;&nbsp;&nbsp;'._t('page').' '.$this->getVar('page').'/'.$this->getVar('numPages').'&nbsp;&nbsp;&nbsp;';
				if ($this->getVar('page') < $this->getVar('numPages')) {
					print "<a href='#' onclick='jQuery(\"#featuresBox\").load(\"".caNavUrl($this->request, 'wwsf', 'Memories', 'index', array('page' => $this->getVar('page') + 1))."\"); return false;'>"._t("NEXT")." &rsaquo;</a>";
				}
?>
					</div><!-- end paging -->
<?php
				print '<form action="#">'._t("Jump to page").': <input type="text" size="3" name="page" id="jumpToPageNum" value=""/> <a href="#" onclick=\'jQuery("#featuresBox").load("'.caNavUrl($this->request, 'wwsf', 'Memories', 'index', array()).'/page/" + jQuery("#jumpToPageNum").val());\'>'._t("GO").'</a></form>';
				print _t('Found %1 results.', $this->getVar("numResults"));
?>
				</div><!-- end resultsNav -->
			</div><!-- end resultsNavBg -->
<?php
		}	
?>
		</div><!-- end memoriesList -->
	</div><!-- end featuresBox -->
<?php
	if (!$this->request->isAjax()) {
?>
</div><!-- end featuresLanding -->
<?php
	}
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#browseTabs').tabs();
	});
</script>