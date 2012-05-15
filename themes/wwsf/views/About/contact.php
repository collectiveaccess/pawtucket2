<?php
	global $g_ui_locale;
?>
		<div id="contentArea">
			<div id="aboutLinks">
<?php
				print "<div><img src='".$this->request->getThemeUrlPath()."/graphics/arrow_right_gray.gif' width='9' height='10' border='0'> ".caNavLink($this->request, _t("Project Description"), "", "", "About", "Index")."</div>";
				print "<div><img src='".$this->request->getThemeUrlPath()."/graphics/arrow_right_gray.gif' width='9' height='10' border='0'> ".caNavLink($this->request, _t("How to Participate"), "", "", "About", "participate")."</div>";
				print "<div><img src='".$this->request->getThemeUrlPath()."/graphics/arrow_right_gray.gif' width='9' height='10' border='0'> ".caNavLink($this->request, _t("Partners"), "", "", "About", "partners")."</div>";
				print "<div><img src='".$this->request->getThemeUrlPath()."/graphics/arrow_right_gray.gif' width='9' height='10' border='0'> ".caNavLink($this->request, _t("FAQ"), "", "", "About", "faq")."</div>";
				print "<div><img src='".$this->request->getThemeUrlPath()."/graphics/arrow_right_gray.gif' width='9' height='10' border='0'> ".caNavLink($this->request, _t("Imprint"), "", "", "About", "imprint")."</div>";
				print "<div><img src='".$this->request->getThemeUrlPath()."/graphics/arrow_right_gray.gif' width='9' height='10' border='0'> ".caNavLink($this->request, _t("Contact &amp; Press"), "", "", "About", "contact")."</div>";
?>
			</div>
			<div id="aboutContent">
				<h1><?php print _t("Contact &amp; Press"); ?></h1>
<?php
			if ($g_ui_locale == 'en_US') {
?>
				QUESTIONS, SUGGESTIONS, COMMENTS

				<br/><br/>We’d be happy to receive your mails!

				<br/><br/><a href="mailto:info@wir-waren-so-frei.de">info@wir-waren-so-frei.de</a>
				<br/>Tel.: 030 300 903 645
				<br/><br/>
				<?php print caNavLink($this->request, "Don't forget to check out our FAQ page.", "", "", "About", "faq"); ?>

				<br/><br/><br/>FILM USE ENQUIRY

				<br/><br/>Anke Hahn
				<br />Tel.: +49-30-300 903-31
				<br /><a href="ahahn@deutsche-kinemathek.de">ahahn@deutsche-kinemathek.de</a>

				<br/><br/><br/>PHOTO- AND FILM SUBMISSIONS

				<br/><br/>Send your photos and/or films to:

				<br/><br/>Deutsche Kinemathek – Museum für Film und Fernsehen
				<br/>Projekt "Wir waren so frei ... Momentaufnahmen 1989/1990"
				<br/>Potsdamer Straße 2
				<br/>10785 Berlin

				<br/><br/>Tel.: +49-30-300 903-0
				<br/>Fax: +49-30-300 903-13

				<br/><br/><br/>PRESS

				<br/><br/>Press inquiries should be directed to:

				<br/><br/>Heidi Berit Zapke
				<br />Tel.: +49-30-300 903-820
				<br /><a href="mailto:hbzapke@deutsche-kinemathek.de">hbzapke@deutsche-kinemathek.de</a>

<?php
			}else{
?>
				FRAGEN, ANREGUNGEN, KRITIK

				<br/><br/>Wir freuen uns über Ihre Post!

				<br/><br/><a href="mailto:info@wir-waren-so-frei.de">info@wir-waren-so-frei.de</a>
				<br/>Tel.: 030 300 903 645
				<br/><br/>
				<?php print caNavLink($this->request, "Bitte beachten Sie auch unsere häufig gestellten Fragen.", "", "", "About", "faq"); ?>
				
				<br/><br/><br/>NUTZUNGSANFRAGEN FILME

				<br/><br/>Anke Hahn
				<br />Tel.: +49-30-300 903-31
				<br /><a href="ahahn@deutsche-kinemathek.de">ahahn@deutsche-kinemathek.de</a>

				<br/><br/><br/>FOTO- UND FILMEINREICHUNGEN

				<br/><br/>Bitte senden Sie Ihre Fotos und/oder Ihr Filmmaterial an:

				<br/><br/>Deutsche Kinemathek – Museum für Film und Fernsehen
				<br/>Projekt "Wir waren so frei ... Momentaufnahmen 1989/1990"
				<br/>Potsdamer Straße 2
				<br/>10785 Berlin

				<br/><br/>Tel.: +49-30-300 903-0
				<br/>Fax: +49-30-300 903-13

				<br/><br/><br/>PRESSE

				<br/><br/>Presseanfragen richten Sie bitte an:

				<br/><br/>Heidi Berit Zapke
				<br />Tel.: +49-30-300 903-820
				<br /><a href="mailto:hbzapke@deutsche-kinemathek.de">hbzapke@deutsche-kinemathek.de</a>

<?php			
			}
?>
			</div><!-- end aboutContent -->
		</div><!-- end contentArea -->
