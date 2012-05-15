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
				<h1><?php print _t("How To Participate"); ?></h1>
<?php
			if ($g_ui_locale == 'en_US') {
?>
				The "Moments in Time 1989/1990" is an attempt to make the most important chapter in German post-war history visible to users, by users. This means we need your help!
				
				<br/><br/>Do you own films, videos and photographs that show the historical events and their effects on individual daily lives in the East and West? Please contribute to our collection with your material, stories and commentary. <a href='#sendPics' id='showSendPicsButton' onclick='$("#sendPics").slideDown(250);' >Send us your photos!</a>

				<br/><br/>Even if you don't own any photos or films, you can support our project by leaving comments that help describe photos more precisely or comprehensively. As a registered user, you have the opportunity to add notes and remarks to photos and films. You can attribute your own tags to images, thereby facilitating searches. Share your discoveries with other users by creating albums on specific themes. <?php print caNavLink($this->request, "Would you like to register?", "", "", "LoginReg", "form", array("site_last_page" => "default")); ?>

				<br/><br/>Join us in creating a personal image memorial to the changing times of 1989/1990!
				
				<div style="display:none;" id="sendPics">
					<a name="#sendPics"></a>
					<h2>Send us your photos!</h2>
					
					You can send us photos in any currently common photo, film or video format. Please fill out a questionnaire (<a href="<?php print $this->request->getThemeUrlPath(); ?>/graphics/pdf/foto_ia.pdf">photo</a> or <a href="<?php print $this->request->getThemeUrlPath(); ?>/graphics/pdf/film_ia.pdf">film/video</a>) for each item, and please don't forget to sign the <a href="<?php print $this->request->getThemeUrlPath(); ?>/graphics/pdf/Teilnahmeformular_ia.pdf">participant form</a>.
					
					<br/><br/>Please submit your photos via e-mail (20 MB max.) to <a href="mailto:info@wir-waren-so-frei.de">info@wir-waren-so-frei.de</a> or by post to the following address:
					
					<br/><br/>Deutsche Kinemathek – Museum für Film und Fernsehen 
					<br/>Projekt "Wir waren so frei" 
					<br/>Potsdamer Straße 2 
					<br/>10785 Berlin 
					<br/><br/>Telephone: 
					<br/>Tel.: +49-30-300 903-0 
					<br/>FAX: +49-30-300 903-13

					<br/><br/>We would love to answer your questions! <?php print caNavLink($this->request, "Get in touch with us", "", "", "About", "contact");?>.
					<a href='#' id='hideSendPicsButton' onclick='$("#sendPics").slideUp(250); return false;' class='hide' style='margin-top:5px;'><?php print _t("Hide"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"></a>
				</div>
<?php
			}else{
?>
				Das Internet-Archiv "Wir waren so frei ... Momentaufnahmen 1989/1990" ist der Versuch, den wichtigsten Abschnitt der deutschen Nachkriegsgeschichte von Nutzern für Nutzer sichtbar zu machen. Dabei sind wir auf Ihre Hilfe angewiesen!


				<br/><br/>Besitzen Sie private Filme, Videos und Fotografien, die die historischen Ereignisse mit ihren Auswirkungen auf den Alltag des Einzelnen in Ost und West zeigen? Bitte ergänzen Sie unsere Sammlung durch Ihr Bildmaterial und Ihre Erinnerungen. <a href='#sendPics' id='showSendPicsButton' onclick='$("#sendPics").slideDown(250);' >Schicken Sie uns Ihre Bilder!</a>


				<br/><br/>Auch wenn Sie keine eigenen Fotos und Filme besitzen, können Sie unser Projekt unterstützen! Helfen Sie uns durch Ihre Kommentare, Bilder präziser und umfassender zu beschreiben. Als angemeldeter Benutzer haben Sie die Möglichkeit, Anmerkungen und Hinweise zu Fotos und Filmen hinzuzufügen. Sie können Bildern eigene Schlagwörter zuordnen und dadurch die Suche vereinfachen. Lassen Sie andere Nutzer an Ihren Entdeckungen teilhaben, indem Sie Alben zu bestimmten Themen erstellen. <?php print caNavLink($this->request, "Jetzt anmelden?", "", "", "LoginReg", "form", array("site_last_page" => "default")); ?>


				<br/><br/>Gestalten Sie gemeinsam mit uns ein persönliches Bildgedächtnis der Zeitenwende von 1989/1990!


				<div style="display:none;" id="sendPics">
					<a name="#sendPics"></a>
					<h2>Schicken Sie uns Ihre Bilder!</h2>

					Sie können uns Ihre Bilder in jedem gängigen Foto-, Film- und Videoformat zuschicken. Bitte füllen Sie zu jedem Film, Video oder Foto unseren Fragebogen <a href="<?php print $this->request->getThemeUrlPath(); ?>/graphics/pdf/foto_ia.pdf">Foto</a> oder <a href="<?php print $this->request->getThemeUrlPath(); ?>/graphics/pdf/film_ia.pdf">Film/Video</a> aus. Bitte vergessen Sie nicht, das <a href="<?php print $this->request->getThemeUrlPath(); ?>/graphics/pdf/Teilnahmeformular_ia.pdf">Teilnahmeformular</a> zu unterschreiben.
	
	
					<br/><br/>Bitte senden Sie uns Ihre Bilder per E-Mail (max. 20 MB) an <a href="mailto:info@wir-waren-so-frei.de">info@wir-waren-so-frei.de</a> oder per Post an folgende Adresse:
	
					<br/>Deutsche Kinemathek – Museum für Film und Fernsehen
					<br/>Projekt "Wir waren so frei"
					<br/>Potsdamer Straße 2
					<br/>10785 Berlin
	
					<br/><br/>Telefon:
					<br/>Tel.: +49-30-300 903-0
					<br/>Fax: +49-30-300 903-13
	
	
					<br/><br/>Wir freuen uns über Ihre Fragen! Nehmen Sie einfach kurz <?php print caNavLink($this->request, "Kontakt", "", "", "About", "contact");?> mit uns auf.
					<a href='#' id='hideSendPicsButton' onclick='$("#sendPics").slideUp(250); return false;' class='hide' style='margin-top:5px;'><?php print _t("Hide"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"></a>
				</div>
<?php			
			}
?>
			</div><!-- end aboutContent -->
		</div><!-- end contentArea -->