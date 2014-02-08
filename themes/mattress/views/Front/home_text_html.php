<div id="frontPageText">

	<div class='blockTitle'>About</div>
	<div class='blockAbout'>
		<div class='aboutText'>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel lectus nunc. Donec ipsum purus, tempor sed urna nec, facilisis fringilla sem. Curabitur diam justo, faucibus vitae bibendum at, consequat in est. Donec et convallis sapien. Curabitur sit amet neque facilisis, porttitor nisi nec, ultrices urna. Suspendisse at tincidunt neque. Cras commodo mauris vitae justo bibendum semper. Pellentesque mattis rhoncus gravida. Vivamus aliquam orci orci, et semper mi egestas et. Vestibulum vel quam lacinia, iaculis nibh nec, ultricies tellus. Phasellus laoreet elit sed vehicula hendrerit. Sed ultrices tristique enim, a egestas quam dapibus nec. Nunc in sem at erat accumsan ornare. Donec dictum libero sed nunc lobortis faucibus sit amet ut nulla. Pellentesque non orci vitae quam tincidunt blandit.
		</div>
		<div class='homeLinks'>
<?php
			print "<div>".caNavLink($this->request, _t('Collections'), '', '', 'List', 'Collections')."</div>";
			print "<div>".caNavLink($this->request, _t('Browse Artists'), '', '', 'Browse', 'Artists')."</div>";
			print "<div>".caNavLink($this->request, _t('Exhibition + Event Chronology'), '', '', 'Browse', 'Exhibitions')."</div>";
			print "<div>".caNavLink($this->request, _t('P{art}icipate'), '', '', 'Browse', 'Artists')."</div>";
?>			
		</div>
	</div>
	
	<div class='clearfix'></div>
</div>