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
				<h1><?php print _t("Imprint"); ?></h1>
<?php
			if ($g_ui_locale == 'en_US') {
?>
				<b>Publisher</b>
				
				<br/>Stiftung Deutsche Kinemathek
				<br/>Potsdamer Straße 2
				<br/>10785 Berlin
				
				<br/><br/>Tel.: +49-30-300 903-0
				<br/>Fax: +49-30-300 903-13
				<br/><a href="mailto:info@deutsche-kinemathek.de">info@deutsche-kinemathek.de</a>
				
				<br/><br/>Bundeszentrale für politische Bildung
				<br/>Thorsten Schilling
				<br/>Stresemannstr. 90
				<br/>10963 Berlin

				<br/><br/>Tel +49 (0)30 254504-420
				<br/>Fax +49 (0)30 254504-422

				<br/><br/><b>Idea and concept</b>
				<br/>Dr. Rainer Rother 

				<br/><br/><b>Concept development</b>
				<br/>Thorsten Schilling (bpb), Ronald Hirschfeld (bpb), Jürgen Keiper (SDK)

				<br/><br/><b>Project management</b>
				<br/>Ulrike Schmiegelt

				<br/><br/><b>Scientific research</b>
				<br/>Judith Lehniger, Ulrike Schmiegelt

				<br/><br/><b>Eyewitness interviews</b>
				<br/>Judith Lehniger, Ulrike Schmiegelt				
				
				<br/><br/>The internet presentation is an independent part of the overall project "Wir waren so frei... Momentaufnahmen 1989/1990" (Project management: Ulrike Schmiegelt). The web presentation refers to the documents acquired within the project and was developed in close cooperation with the bpb (The Federal Agency for Civic Education) and Whirl-i-Gig (New York). 

				<br/><br/><b>Internet archive (project management)</b>
				<br/>Jürgen Keiper

				<br/><br/><b>Cataloguing and Indexing (concept and coordination)</b>
				<br/>Christiane Grün 

				<br/><br/><b>Additional research</b>
				<br/>Madeleine Bernstorff, Karin Fritzsche 

				<br/><br/><b>Digitization</b>
				<br/>Eva Gabronova, Michael Spalek 

				<br/><br/><b>Cataloguing and indexing</b>
				<br/>Anne Breimaier, Asal Dardan, Christiane Grün, Tanja Horstmann, Peter Jammerthal, Annette Lingg, Elena Maria Serban, Michael Spalek, Marie Wilz

				<br/><br/><b>Assistant editor</b>
				<br/>Julia Pattis

				<br/><br/><b>Registrar</b>
				<br/>Peter Jammerthal

				<br/><br/><b>Vocabulary (concept and development)</b>
				<br/>Jutta Lindenthal 

				<br/><br/><b>Film preservation, Videocataloguing and -indexing, digital post</b>
				<br/>Volkmar Ernst, Oliver Hanley 

				<br/><br/><b>Videoencoding</b>
				<br/>Andreas Ehlert, Stefan Keidel 

				<br/><br/><b>Translations</b>
				<br/>Liz Goerl, Monica Koshka-Stein, Jane Palmer

				<br/><br/><b>IT-infrastructure</b>
				<br/>Andreas Ehlert, Bernhard Glomm, Florian Regel 

				<br/><br/><b>Database, Software Development and coding</b>
				<br/>Seth Kaufman, Stefan Keidel, Maria Passarotti (all Whirl-i-Gig)
				<br/>Detlev Balzer (vocabulary software) 

				<br/><br/><b>Software Development coordination</b>
				<br/>Catherine Lillie (Whirl-i-Gig) 

				<br/><br/><b>Website Design</b>
				<br/>Maria Passarotti (Whirl-i-Gig) 

				<br/><br/><b>About CollectiveAccess</b>
				<br/>The project "Wir waren so frei ... Momentaufnahmen 1989/1990" has been developed using <a href="http://www.collectiveaccess.org" target="_new">CollectiveAccess</a>, open source software for cataloguing and publishing of museum and archival collections. CollectiveAccess was created and is developed by Whirl-i-Gig, a New York-based firm specializing in development of applications for museums, archives and scientific research. 
				<br/><br/>CollectiveAccess is free software, licensed under the GNU Public License and make available without restriction. A community of partner institutions contribute funding, planning and software development resources. Many collaborators focus on areas of specific interest to them and it is through their efforts that CollectiveAccess has gained capabilities it would never have had otherwise. If CollectiveAccess lacks features that you require let Whirl-i-Gig know and, if possible, please consider joining the development effort! 

				<br/><br/><b>Responsible in accordance with German press laws/German interstate agreement on media services</b>
				<br/>Dr. Rainer Rother
				<br/>Deutsche Kinemathek – Museum für Film und Fernsehen
				<br/>Potsdamer Straße 2
				<br/>10785 Berlin
				<br/>Germany 
				<br/><br/>Tel.: +49-30-300 903-0
				<br/>Fax: +49-30-300 903-13
				<br/><a href="mailto:info@deutsche-kinemathek.de">info@deutsche-kinemathek.de</a> 

				<br/><br/><b>Copyrights</b>
				<br/>All contents, graphics and/or images are copyrighted and may be used only according to the associated license. Individual items may involve other copyright specifications which also have to be observed. 

				<br/><br/><b>Disclaimer</b>
				<br/>The Deutsche Kinemathek checks and updates the information on its web pages regularly. Despite all care, individual data may have changed. Hence we cannot guarantee or be held liable for the accuracy, completeness or up-to-dateness of any information provided here. The links to external sites have been compiled to the best of our knowledge and belief. We have taken great care to examine the seriousness of those providing these links. Yet since the content of Internet pages is dynamic and continually subject to change, it is impossible for us to constantly monitor the content of each link. Thus the Stiftung Deutsche Kinemathek assumes no responsibility for the content of the Internet pages of third parties linked to this site. 
<?php
			}else{
?>
				<b>Herausgeber</b>
				
				<br/>Stiftung Deutsche Kinemathek
				<br/>Potsdamer Straße 2
				<br/>10785 Berlin
				
				<br/><br/>Tel.: +49-30-300 903-0
				<br/>Fax: +49-30-300 903-13
				<br/><a href="mailto:info@deutsche-kinemathek.de">info@deutsche-kinemathek.de</a>
								
				<br/><br/>Bundeszentrale für politische Bildung
				<br/>Thorsten Schilling
				<br/>Stresemannstr. 90
				<br/>10963 Berlin

				<br/><br/>Tel +49 (0)30 254504-420
				<br/>Fax +49 (0)30 254504-422

				<br/><br/><b>Idee und Konzept</b>
				<br/>Dr. Rainer Rother 

				<br/><br/><b>Konzeptentwicklung</b>
				<br/>Thorsten Schilling (bpb), Ronald Hirschfeld (bpb), Jürgen Keiper (SDK)

				<br/><br/><b>Projektleitung</b>
				<br/>Ulrike Schmiegelt

				<br/><br/><b>Wissenschaftliche Recherche</b>
				<br/>Judith Lehniger, Ulrike Schmiegelt

				<br/><br/><b>Zeitzeugenarbeit</b>
				<br/>Judith Lehniger, Ulrike Schmiegelt
				
				<br/><br/>Das Internet-Archiv ist ein eigenständiger Bereich des Gesamtprojektes "Wir waren so frei ... Momentaufnahmen 1989/1990". Der Webauftritt versammelt fast alle Dokumente, die im Rahmen des Projektes zusammengetragen wurden, und wird permanent mit neuen Fotos und Filmen aktualisiert. Die Konzeption geschah in enger Zusammenarbeit mit der bpb (Bundeszentrale für politische Bildung) und Whirl-i-Gig (New York). 

				<br/><br/><b>Internet-Archiv (Projektmanagement)</b>
				<br/>Jürgen Keiper

				<br/><br/><b>Katalogisierung und Indexierung (Konzept und Koordination)</b>
				<br/>Christiane Grün 

				<br/><br/><b>Zusatzrecherche</b>
				<br/>Madeleine Bernstorff, Karin Fritzsche 

				<br/><br/><b>Digitalisierung</b>
				<br/>Eva Gabronova, Michael Spalek 

				<br/><br/><b>Katalogisierung und Indexierung</b>
				<br/>Anne Breimaier, Asal Dardan, Christiane Grün, Tanja Horstmann, Peter Jammerthal, Annette Lingg, Elena Maria Serban, Michael Spalek, Marie Wilz

				<br/><br/><b>Redaktionelle Mitarbeit</b>
				<br/>Julia Pattis

				<br/><br/><b>Registrar</b>
				<br/>Peter Jammerthal 

				<br/><br/><b>Vokabulare (Konzept und Entwicklung)</b>
				<br/>Jutta Lindenthal 

				<br/><br/><b>Konservatorische Aufarbeitung (Film/Video), Videokatalogisierung and -indexierung, digitale Nachbearbeitung</b>
				<br/>Volkmar Ernst, Oliver Hanley 

				<br/><br/><b>Videoencoding</b>
				<br/>Andreas Ehlert, Stefan Keidel 

				<br/><br/><b>Übersetzungen</b>
				<br/>Liz Goerl, Monica Koshka-Stein, Jane Palmer

				<br/><br/><b>IT-Infrastruktur</b>
				<br/>Andreas Ehlert, Bernhard Glomm, Florian Regel 

				<br/><br/><b>Datenbank- und Softwareentwicklung, Programmierung</b>
				<br/>Seth Kaufman, Stefan Keidel, Maria Passarotti (alle Whirl-i-Gig)
				<br/>Detlev Balzer (Software Vokabularentwicklung) 

				<br/><br/><b>Koordination Projektentwicklung</b>
				<br/>Catherine Lillie (Whirl-i-Gig) 

				<br/><br/><b>Grafik&Design</b>
				<br/>Maria Passarotti (Whirl-i-Gig) 

				<br/><br/><b>Über CollectiveAccess</b>
				<br/>Das Projekt "Wir waren so frei ... Momentaufnahmen 1989/1990" wurde mit <a href="http://www.collectiveaccess.org" target="_new">CollectiveAccess</a> realisiert, einer Open source Software zur Katalogisierung und Veröffentlichung von Museums- und Archivbeständen. CollectiveAccess wurde konzipiert und wird weiter entwickelt durch Whirl-i-Gig, einer New Yorker Firma, die sich auf die Entwicklung von Anwendungen für Museen, Archive und die wissenschaftliche Forschung spezialisiert hat. 
				<br/><br/>CollectiveAccess ist eine freie Software, die unter der GNU Public License steht und ohne Einschränkungen verfügbar. Aufbauend auf eine community von Partnerinstitutionen wird die Finanzierung, Planung und Weiterentwicklung umgesetzt. Da zahlreiche Beteiligte und Nutzer völlig unterschiedliche Interessen und Ausrichtungen besitzen, besitzt CollectiveAccess nun zahlreiche, besondere Fähigkeiten. Falls Sie besondere Anforderungen haben, teilen Sie diese bitte Whirl-i-Gig mit und - falls möglich - beteiligen Sie sich ander Entwicklung. 

				<br/><br/><b>Verantwortlich im Sinne des Presserechts/des Staatsvertrages über Mediendienste</b>
				<br/>Dr. Rainer Rother
				<br/>Deutsche Kinemathek – Museum für Film und Fernsehen
				<br/>Potsdamer Straße 2
				<br/>10785 Berlin
				<br/>Deutschland 
				<br/><br/>Tel.: +49-30-300 903-0
				<br/>Fax: +49-30-300 903-13
				<br/><a href="mailto:info@deutsche-kinemathek.de">info@deutsche-kinemathek.de</a> 

				<br/><br/><b>Copyright</b>
				<br/>Alle Inhalte und Grafiken sind urheberrechtlich geschützt und dürfen von Dritten nur entsprechend der jeweiligen Lizenzierung weiterverwendet werden. Einzelne Inhalte können spezielle Urheberrechtsvermerke enthalten, die zu beachten sind. 

				<br/><br/><b>Disclaimer</b>
				<br/>Die Deutsche Kinemathek – Museum für Film und Fernsehen prüft und aktualisiert die Informationen auf ihren Webseiten regelmäßig. Trotz aller Sorgfalt können sich die Daten inzwischen verändert haben. Eine Haftung oder Garantie für die Aktualität, Richtigkeit und Vollständigkeit der zur Verfügung gestellten Informationen kann daher nicht übernommen werden. Die auf diesen Seiten vorhandenen Links zu fremden Anbietern wurden nach bestem Wissen und Gewissen erstellt. Dabei wurde auf die Vertrauenswürdigkeit der jeweiligen Anbieter geachtet. Da jedoch der Inhalt von Internetseiten dynamisch ist und sich jederzeit ändern kann, ist eine ununterbrochene Überwachung der Inhalte, auf die ein Link erstellt wurde, nicht möglich. Die Deutsche Kinemathek – Museum für Film und Fernsehen macht sich deshalb den Inhalt von Internet-Seiten Dritter, die mit der eigenen Internetpräsenz verlinkt sind, insoweit nicht zu eigen.
<?php			
			}
?>
			</div><!-- end aboutContent -->
		</div><!-- end contentArea -->
