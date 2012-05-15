<?php
	global $g_ui_locale;
?>
<div class="textContent">
	<div id="aboutMenu">
		<ul>
			<li>
				<?php print caNavLink($this->request, ($g_ui_locale=="de_DE" ? "Kollektion und Distribution" : "Collection und Distribution"), '', '', 'About', 'index', array('section' => 'default')); ?>
			</li>
			<li>
				<?php print caNavLink($this->request, ($g_ui_locale=="de_DE" ? "Sammlungsmanagement" : "Managing the Collection"), '', '', 'About', 'index', array('section' => 'collection_management')); ?>
			</li>
			<li>
				<?php print caNavLink($this->request, ($g_ui_locale=="de_DE" ? "Partner" : "Partners"), '', '', 'About', 'index', array('section' => 'partner')); ?>
			</li>
			<li>
				<?php print caNavLink($this->request, ($g_ui_locale=="de_DE" ? "Perspektiven" : "Perspectives"), '', '', 'About', 'index', array('section' => 'perspective')); ?>
			</li>
			<li>
				<?php print caNavLink($this->request, ($g_ui_locale=="de_DE" ? "Geschichte" : "Background"), '', '', 'About', 'index', array('section' => 'history')); ?>
			</li>
			<li>
				<?php print caNavLink($this->request, ($g_ui_locale=="de_DE" ? "Verleihbedingungen" : "Distribution Terms and Conditions"), '', '', 'About', 'index', array('section' => 'terms')); ?>
			</li>
			<li>
				<?php print caNavLink($this->request, ($g_ui_locale=="de_DE" ? "Impressum" : "Legal Information"), '', '', 'About', 'index', array('section' => 'imprint')); ?>
			</li>
		</ul>
	</div>
<?php
	$vs_section = $this->request->getParameter("section",pString);
	switch($vs_section) {
		case 'collection_management':
			print $this->render('About/about_collection_management.php');
			break;
		case 'history':
			print $this->render('About/about_history.php');
			break;
		case 'imprint':
			print $this->render('About/about_imprint.php');
			break;
		case 'partner':
			print $this->render('About/about_partner.php');
			break;
		case 'perspective':
			print $this->render('About/about_perspective.php');
			break;
		case 'terms':
			print $this->render('About/about_terms.php');
			break;
		default:
			print $this->render('About/about_collection.php');
			break;
	}
?>
</div>