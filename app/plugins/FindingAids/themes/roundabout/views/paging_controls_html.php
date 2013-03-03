<?php
	$vo_result = 			$this->getVar('result');
	$vs_current_view = 		$this->getVar('current_view');
?>
	<div class="browse-paging">
	<?php
			# --- mapped results are not paged
			if(($this->getVar('num_pages') > 1)){
				print "<div class='browse-goto-page'>";
				
					print	'<form action="#">';
					print		'<ul>';				
					print 			'<li><span>'._t("Jump to page").': </span></li>';
					print 			'<li><input type="text" size="3" name="page" id="jumpToPageNum" value=""/></li>';
					print 			'<li><a href="#" onclick=\'POP.browseToPage();\' class="block-btn">'._t("GO").'</a></li>';
					print		'</ul>';
					print 	'</form>';
					
				print "</div>";
				print "<div class='browse-prev-next'>";
					if ($this->getVar('page') > 1) {
						print "<a href='#' onclick='POP.browsePrev(); return false;'>&lsaquo; "._t("Previous")."</a>";
					}else{
						print "<span class='linkOff'>&lsaquo; "._t("Previous")."</span>";
					}
					print '&nbsp;&nbsp;&nbsp;'._t('page').' '.$this->getVar('page').'/'.$this->getVar('num_pages').'&nbsp;&nbsp;&nbsp;';
					if ($this->getVar('page') < $this->getVar('num_pages')) {
						print "<a href='#' onclick='POP.browseNext(); return false;'>"._t("Next")." &rsaquo;</a>";
					}else{
						print "<span class='linkOff'>"._t("Next")." &rsaquo;</span>";
					}
				print "</div>";
				
			}
	?>
		<div class="clearfix"></div>
	</div>
	
	<div class='browse-nav-bar'>
		<div class="browse-found-results">
			<h3>
				
<?php		
				$vn_num_hits = $this->getVar('num_hits');
				print _t('Your %1 found %2 %3.', $this->getVar('mode_type_singular'), $vn_num_hits, ($vn_num_hits == 1) ? _t('result') : _t('results'));
?>
			</h3>
		</div>
		<script>
			POP.browseNext = function() {
				jQuery("#resultBox").load(
					"<?php echo caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $this->getVar('page') + 1)); ?>",
					function() {
						POP.runCufon();
					}
				);
			};
			POP.browsePrev = function() {
				jQuery("#resultBox").load(
					"<?php echo caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $this->getVar('page') - 1)); ?>",
					function() {
						POP.runCufon();
					}
				);
			};
			POP.browseToPage = function() {
				jQuery("#resultBox").load(
					"<?php echo caNavUrl($this->request, '', $this->request->getController(), 'Index', array()); ?>/page/" + jQuery("#jumpToPageNum").val(),
					function() {
						POP.runCufon();
					}
				);
			};
		</script>

	
		<div class="clearfix"></div>
	</div>
	
	
	
