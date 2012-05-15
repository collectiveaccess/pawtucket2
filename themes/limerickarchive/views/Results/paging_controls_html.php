<?php
	$vo_result = 			$this->getVar('result');
	$vs_current_view = 		$this->getVar('current_view');
	$vo_result_context = $this->getVar('result_context');
	
	# --- indicates the search is being displayed in the tab on the collection detail page
	$vn_collection_search = $this->request->getParameter("collectionSearch", pInteger);
?>

	<div id='searchNavBg'><div class='searchNav'>
<?php
		# --- mapped results are not paged
		if(($this->getVar('num_pages') > 1)){
			print "<div class='nav'>";
			if ($this->getVar('page') > 1) {
				print "<a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $this->getVar('page') - 1, 'collectionSearch' => $vn_collection_search))."\"); return false;'>&lsaquo; "._t("Previous")."</a>";
			}else{
				print "<span class='linkOff'>&lsaquo; "._t("Previous")."</span>";
			}
			print '&nbsp;&nbsp;&nbsp;'._t('page').' '.$this->getVar('page').'/'.$this->getVar('num_pages').'&nbsp;&nbsp;&nbsp;';
			if ($this->getVar('page') < $this->getVar('num_pages')) {
				print "<a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $this->getVar('page') + 1, 'collectionSearch' => $vn_collection_search))."\"); return false;'>"._t("Next")." &rsaquo;</a>";
			}else{
				print "<span class='linkOff'>"._t("Next")." &rsaquo;</span>";
			}
			print '</div>';
			print '<form action="#">'._t("Jump to page").': <input type="text" size="3" name="page" id="jumpToPageNum" value=""/> <a href="#" onclick=\'jQuery("#resultBox").load("'.caNavUrl($this->request, '', $this->request->getController(), 'Index', array()).'/collectionSearch/'.$vn_collection_search.'/page/" + jQuery("#jumpToPageNum").val()); return false;\'>'._t("GO").'</a></form>';
		}
		
		
?>
	</div><!-- end searchNav --></div><!-- end searchNavBg -->