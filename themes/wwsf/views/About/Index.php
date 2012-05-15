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
				<h1><?php print _t("Project Description"); ?></h1>
<?php
			if ($g_ui_locale == 'en_US') {
?>
				Pictures make history, but seldom are the same pictures so often attributed to a story as they are to the political upheaval of 1989/90 in Germany. The atmosphere preceding the Fall of the Wall, daily life during changing times, and the parallelism of euphoria and uncertainty form the core of significant experiences that seldom found their way into the flood of pictures. This motivated the Deutsche Kinemathek to give these images from private collections their own space in which they might be reflected upon anew.
				<br/><br/>Central to the project are the photographic stories told by all who used a camera to document the moods and experiences of 1989/90. Family pictures, travels, protests, the Fall of the Wall and the speedy transformation of all types of structures – be they political, social or architectural – these are the dominant themes in the pictures.
				
				<h2>Internet Archive</h2>
				We began research for photos and films in Summer of 2008, and have now collected thousands of your pictures for the project. All of these photos, as well as the films in their full length, are available for viewing and comment in our Internet Archive. In order to make the project accessible in an appropriate format, the open-source collections management system <a href="http://www.collectiveaccess.org/index.php" target="_new">CollectiveAccess</a> was further developed and expanded, in close cooperation with the bpb (Federal Center for Political Education) and the New York software development firm Whirl-i-Gig.
				
				<br/><br/>Our goal was to make a Website by users, for users. As a registered user, you can rate or comment on photos and films, as well as create your own albums. In addition, most of the objects are under a <a href="http://creativecommons.org/about/what-is-cc" target="_blank">Creative Commons license</a>, making the images more easily accessible for research by schools and universities.

				<br/><br/>This collection is just a starting point. The project will be continued beyond 2009. Send us your photos and tell us your stories!

				<h2>Exhibit</h2>
				The Internet archive has its origins in the 2009 exhibition "Moments in Time 1989/1990", at the Museum for Film and Television in Berlin. A selection curated from the submitted photographs and films formed the centre of the exhibition. This was juxtaposed with images from international television broadcasts and German documentary films. You can find the six exhibition chapters with some 300 private records on the page <?php print caNavLink($this->request, "THEMES", "", "wwsf", "Themes", "Index"); ?>.
<?php
			}else{
?>
				Bilder schreiben Geschichte, doch selten sind der Geschichte so oft die gleichen Bilder verschrieben worden wie 1989/90 in Deutschland. Die Atmosphäre vor dem Mauerfall, der Alltag entlang des "Zeitenwechsels", aber auch die Parallelität von Euphorie und Verunsicherung bilden den Kern von bedeutsamen Erfahrungen, die in der Bilderflut selten durchschienen. Dies war der Anlass, noch einmal neu über die Bilder dieser Umbruchszeit nachzudenken und den privaten Bildern Raum zu geben.

				<br/><br/>Im Mittelpunkt stehen die Bildgeschichten aller, die einen Fotoapparat oder eine Filmkamera nutzten, um diese Stimmungen und Erfahrungen zu dokumentieren. Familienbilder, Reisen, Demonstrationen, Mauerfall und die schnelle Veränderung jeglicher Strukturen - sei es politisch, sozial oder architektonisch - sind die großen Themen der Bilder.


				<h2>Internet-Archiv</h2>

				Im Sommer 2008 begannen wir mit der Recherche nach Fotos und Filmen. Mittlerweile sind mehrere tausend Bilder von Ihnen für das Projekt zur Verfügung gestellt worden. Alle diese Fotos und die Filme (in ganzer Länge) können Sie in unserem Internet-Archiv ansehen und kommentieren. Um dies in geeigneter Form zu ermöglichen, wurde das Open Source Sammlungsmanagement-System <a href="http://www.collectiveaccess.org" target="_new">CollectiveAccess</a> in enger Zusammenarbeit mit der bpb (Bundeszentrale für politische Bildung) sowie Whirl-i-Gig (New York) weiterentwickelt und um neue Funktionen ergänzt.

				<br/><br/>Es war unser Anliegen, eine Webseite von Nutzern für Nutzer zu machen. Als angemeldeter Nutzer haben Sie die Möglichkeit, Fotos und Filme zu kommentieren und zu bewerten und Sie können eigene Alben erstellen. Zudem stehen die meisten Fotos und Filme unter einer <a href="http://de.creativecommons.org/was-ist-cc/" target="_blank">Creative Commons-Lizenz</a>, um die Dokumente auch Schulen und Universitäten im Rahmen von Forschung und Vermittlung zur nicht kommerziellen Nutzung bereitzustellen.

				<br/><br/>Diese Sammlung ist nur ein erster Ausgangspunkt. Das Projekt wird über kontinuierlich fortgeführt. <?php print caNavLink($this->request, "Bitte senden Sie uns Ihre Bilder und erzählen Sie Ihre Geschichte!", "", "", "About", "participate"); ?>
				
				<h2>Ausstellung</h2>
				Das Internet-Archiv ist entstanden mit der Ausstellung "Wir waren so frei … Momentaufnahmen 1989/1990", die zwischen 1. Mai bis 9. November 2009 im Museum für Film und Fernsehen in Berlin stattfand. Im Zentrum der Ausstellung stand eine kuratierte Auswahl der eingereichten Fotografien und Filme. Diesen wurden Aufnahmen der internationalen TV-Berichterstattung und Bilder deutscher Dokumentarfilmer gegenübergestellt. Die sechs Ausstellungskapitel mit rund 300 Privataufnahmen finden Sie auf der Seite <?php print caNavLink($this->request, "THEMEN", "", "wwsf", "Themes", "Index"); ?>.
<?php			
			}
?>
			</div><!-- end aboutContent -->
		</div><!-- end contentArea -->
