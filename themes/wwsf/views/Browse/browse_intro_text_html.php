<?php
	global $g_ui_locale;
	
if ($g_ui_locale == en_US) {
?>
<p>
	In the LIBRARY, you can perform an easy, targeted search for photos and films of specific people, places, events, themes and emotions. The LIBRARY contains over 5,000 personal records for you to discover. Leave a comment and choose your favorites. Click <?php print caNavLink($this->request, "here", "", "", "About", "faq#5");?> to find out how.
</p>
<?php 
	} else {
?>
<p>
	ALLE BILDER ermöglicht Ihnen eine einfache und gezielte Suche über Lizenztypen, Objekttypen, Orte, Personen/Organisationen, Schlagwörter und Urheber. Verfeinern Sie Ihre Suche durch Auswahl mehrerer Begriffe. <?php print caNavLink($this->request, "So funktioniert's", "", "", "About", "faq#5");?>
</p>
<?php
	}
?>