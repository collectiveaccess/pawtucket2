<li class="timeline-item">
	<div class="timeline-badge primary" style="background-color:#<?php print $this->getVar("color"); ?> !Important;"><i class="glyphicon glyphicon-chevron-down"></i></div>
	<div class="timeline-panel">
		<div class="travelerMapItemSummaryImg"><?php print $this->getVar("icon"); ?></div>
		<div class="travelerMapItemSummaryText">
			<strong><?php print $this->getVar("name"); ?></strong><br/>
			<?php print $this->getVar("date"); ?><br/>
			<div class="travelerMapItemSummaryTextScroll">
			<?php print $this->getVar("description"); ?>
	<?php
			if($vs_tpl_source = $this->getVar("source")){
				print "<br/><br/><em>Source: ".$vs_tpl_source."</em>";
			}
	?>
			</div>
		</div>
	</div>
</li>