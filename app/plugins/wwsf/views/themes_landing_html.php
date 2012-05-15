<?php
	$va_sets = $this->getVar('sets');
	$va_first_items_from_sets = $this->getVar('first_items_from_sets');

if (!$this->request->isAjax()) {
?>
<h1><?php print _t("Themes"); ?></H1>

<div id="featuresLanding">
	<div id="themesText">
<?php
		print $this->render('themes_intro_text_html.php');
?>
		<!-- list of all themes in categories -->
		<H2><?php print _t("Exhibition themes"); ?></H2>
<?php
			$va_exhibition_themes = array(300, 302, 303, 304, 305, 306);
			print "<ul>";
			$t_set = new ca_sets();
			foreach($va_exhibition_themes as $vn_set_id){
 				$t_set->load($vn_set_id);
 				$va_item_id = array_keys($t_set->getItems(array("limit" => 1, "returnRowIdsOnly" => 1)));
 				print "<li>".caNavLink($this->request, $t_set->getLabelForDisplay(), '', 'Detail', 'Object', 'Show', array('set_id' => $vn_set_id, 'object_id' => $va_item_id[0]))."</li>";
			}
			print "</ul>";
?>
		<H2><?php print _t("Topics"); ?></H2>
<?php
			$va_topics = array(312, 313, 314, 315, 316, 317, 318, 319, 320, 322, 283, 333, 413, 321, 436);
			$t_set = new ca_sets();
 			$va_topic_info = array();
 			
			foreach($va_topics as $vn_set_id){
 				$t_set->load($vn_set_id);
 				$va_item_id = array_keys($t_set->getItems(array("limit" => 1, "returnRowIdsOnly" => 1)));
 				$va_topic_info[$vn_set_id] = array("name" => $t_set->getLabelForDisplay(), "object_id" => $va_item_id[0]);
 			}
			asort($va_topic_info);
			print "<ul>";
			foreach($va_topic_info as $vn_set_id => $va_info){
				print "<li>".caNavLink($this->request, $va_info["name"], '', 'Detail', 'Object', 'Show', array('set_id' => $vn_set_id, 'object_id' => $va_info["object_id"]))."</li>";
			}
			print "</ul>";
?>		
		<H2><?php print _t("Aesthetic categories"); ?></H2>
<?php
			$va_aestethic = array(237, 238, 240, 418, 419, 420);
			$t_set = new ca_sets();
 			$va_aestethic_info = array();
 			foreach($va_aestethic as $vn_set_id){
 				$t_set->load($vn_set_id);
 				$va_item_id = array_keys($t_set->getItems(array("limit" => 1, "returnRowIdsOnly" => 1)));
 				$va_aestethic_info[$vn_set_id] = array("name" => $t_set->getLabelForDisplay(), "object_id" => $va_item_id[0]);
 			}
 			asort($va_aestethic_info);
			print "<ul>";
			foreach($va_aestethic_info as $vn_set_id => $va_info){
				print "<li>".caNavLink($this->request, $va_info["name"], '', 'Detail', 'Object', 'Show', array('set_id' => $vn_set_id, 'object_id' => $va_info["object_id"]))."</li>";
			}
			print "</ul>";
?>
	</div>
<?php
}	

?>
<div id="featuresBox">	
<?php

		$vn_items_per_page = $this->getVar('itemsPerPage');
		if($this->getVar('numPages') > 1){
?>
			<div id='resultsNavBg'>
				<div id="resultsNav">
					<div id="paging">
<?php
				if ($this->getVar('page') > 1) {
					print "<a href='#' onclick='jQuery(\"#featuresBox\").load(\"".caNavUrl($this->request, 'wwsf', 'Themes', 'index', array('page' => $this->getVar('page') - 1))."\"); return false;'>&lsaquo; "._t("PREVIOUS")."</a>";
				}
				print '&nbsp;&nbsp;&nbsp;'._t('page').' '.$this->getVar('page').'/'.$this->getVar('numPages').'&nbsp;&nbsp;&nbsp;';
				if ($this->getVar('page') < $this->getVar('numPages')) {
					print "<a href='#' onclick='jQuery(\"#featuresBox\").load(\"".caNavUrl($this->request, 'wwsf', 'Themes', 'index', array('page' => $this->getVar('page') + 1))."\"); return false;'>"._t("NEXT")." &rsaquo;</a>";
				}
?>
					</div><!-- end paging -->
<?php
				print '<form action="#">'._t("Jump to page").': <input type="text" size="3" name="page" id="jumpToPageNum" value=""/> <a href="#" onclick=\'jQuery("#featuresBox").load("'.caNavUrl($this->request, 'wwsf', 'Themes', 'index', array()).'/page/" + jQuery("#jumpToPageNum").val());\'>'._t("GO").'</a></form>';
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
					print "<a href='#' onclick='jQuery(\"#featuresBox\").load(\"".caNavUrl($this->request, 'wwsf', 'Themes', 'index', array('page' => $this->getVar('page') - 1))."\"); return false;'>&lsaquo; "._t("PREVIOUS")."</a>";
				}
				print '&nbsp;&nbsp;&nbsp;'._t('page').' '.$this->getVar('page').'/'.$this->getVar('numPages').'&nbsp;&nbsp;&nbsp;';
				if ($this->getVar('page') < $this->getVar('numPages')) {
					print "<a href='#' onclick='jQuery(\"#featuresBox\").load(\"".caNavUrl($this->request, 'wwsf', 'Themes', 'index', array('page' => $this->getVar('page') + 1))."\"); return false;'>"._t("NEXT")." &rsaquo;</a>";
				}
?>
					</div><!-- end paging -->
<?php
				print '<form action="#">'._t("Jump to page").': <input type="text" size="3" name="page" id="jumpToPageNum" value=""/> <a href="#" onclick=\'jQuery("#featuresBox").load("'.caNavUrl($this->request, 'wwsf', 'Themes', 'index', array()).'/page/" + jQuery("#jumpToPageNum").val());\'>'._t("GO").'</a></form>';
				print _t('Found %1 results.', $this->getVar("numResults"));
?>
				</div><!-- end resultsNav -->
			</div><!-- end resultsNavBg -->
<?php
		}	
?>
	</div><!-- end featuresBox -->
<?php
	if (!$this->request->isAjax()) {
?>
</div><!-- end featuresLanding -->
<?php
	}
?>