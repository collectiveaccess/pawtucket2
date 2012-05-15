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
				<h1><?php print _t("Partners"); ?></h1>
<?php
			if ($g_ui_locale == 'en_US') {
?>
				<div style="float:left; margin: 10px 20px 10px 0px;"><a href="http://www.deutsche-kinemathek.de" target="_blank"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/deutsche_kinemathek_white.gif" width="95" height="132" border="0"></a></div>
				<h2><a href="http://www.deutsche-kinemathek.de" target="_blank">Deutsche Kinemathek – Museum für Film und Fernsehen, Berlin</a></h2>

				Over one million photos, 20,000 posters, 15,000 drawings and 13,000 film prints are preserved in the archives of the Stiftung Deutsche Kinemathek (SDK). Only a small but impressive number of these objects has been presented since 2000 in the Filmhaus at Potsdamer Platz, Berlin’s new center. In this striking building with its glass façade, national and international cineastes can enjoy the fascination of a century of German film history. In 2006, the Kinemathek opened the Permanent Exhibition on Television - as counterpart to the Permanent Exhibition on Film. In an entertaining fashion, it documents five decades of German television history in East and West, and is currently the only venue in Europe to combine these two media under one roof.
				<br/><a href='#' id='showDKButton' onclick='$("#DKText").slideDown(250); $("#showDKButton").slideUp(1); return false;' class='hide' style='margin-top:5px;'><?php print _t("More"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"></a>
				<div id="DKText" style="display:none;">
					<br/>The body responsible for the Museum für Film und Fernsehen is the Stiftung Deutsche Kinemathek (SDK). Founded in 1963 as an association, it took on its present legal form as a foundation in 1971. For more than 40 years, the SDK has collected, indexed and restored everything related to German film and television history – both for the general public and experts. Hence the Filmhaus in the Sony Center is more than a museum: in addition to its two Permanent Exhibitions, it has an extensive film archive as well as a number of collections based on personal estates of stars, including Marlene Dietrich. In addition to all the objects and excerpts from films displayed on four floors, its archives contain countless costumes, technical equipment, and historical documents. What’s more, the SDK has Germany’s most significant collection of screenplays by famous filmmakers, e.g., by Fritz Lang and Rainer Werner Fassbinder. Some of these items have already been or will in the future be made accessible to museum visitors in monothematic special exhibitions intended to augment what is currently on display in the Permanent Exhibitions. Moreover, a number of internet-based projects have publicized specific parts of the collection (<a href="http://www.kameradatenbank.de" target="_blank">www.kameradatenbank.de</a>, <a href="https://www.lost-films.eu" target="blank">www.lost-films.eu</a>).

					<br/><br/>Films may be taken out on loan from the Deutsche Kinemathek’s archives for non-commercial purposes. The SDK has also made a name for itself with its many publications on film and its history, e.g., with its “Film und Schrift” series. Over the years, a number of titles have also become standard literature for the field. Moreover, since 1977 the activities of the Kinemathek have included retrospectives and homages on topics related to film history during the Berlin International Film Festival. Other events are also held at the Filmhaus, for instance, conferences, lectures, panel discussions and symposia on film, television and media policies. In addition, visitors to the museum may do research in one of Europe’s largest specialized libraries.

					<br/><br/>Since 2006, the Deutsche Kinemathek – Museum für Film und Fernsehen has had dual leadership: Dr. Rainer Rother is artistic director; and Dr. Paul Klimpel, administrative director. They replaced Hans Helmut Prinzler, former head of the Kinemathek und long-standing director of the museum.
					<a href='#' id='hideDKButton' onclick=' $("#showDKButton").slideDown(1); $("#DKText").slideUp(250); return false;' class='hide' style='margin-top:5px;'><?php print _t("Hide"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"></a>
				</div><!-- end DKText-->
				<br/><br/>
				
				<div style="float:left; margin: 10px 20px 10px 0px;"><a href="http://www.bpb.de" target="_blank"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/bpb.png' width='180' height='56' border='0'></a></div>
				<h2><a href="http://www.bpb.de" target="_blank">The Federal Agency for Civic Education</a></h2>

				The work done by the Federal Agency for Civic Education (Bundeszentrale für politische Bildung/bpb) centres on promoting awareness for democracy and participation in politics. It takes up topical and historical subjects by issuing publications, by organising seminars, events, study trips, exhibitions and competitions, by providing extension training for journalists and by offering films and on-line products. The broad range of educational activities provided by the bpb is designed to motivate people and enable them to give critical thought to political and social issues and play an active part in political life. Considering Germany's experience with various forms of dictatorial rule down through its history, the Federal Republic of Germany bears a unique responsibility for firmly anchoring values such as democracy, pluralism and tolerance in people's minds.

				<a href='#' id='showDPBButton' onclick='$("#DPBText").slideDown(250); $("#showDPBButton").slideUp(1); return false;'  class='hide' style='margin-top:5px;'><?php print _t("More"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"></a>
				<div id="DPBText" style="display:none;">
					<br/>The bpb celebrated its 50th anniversary in 2002. 50 years of bpb stand for 50 years of work in education aimed at strengthening and improving civil society. The various educational activities the bpb has to offer provide insights into how political, cultural, social and economic processes fit together in history and society. It bears the socio-political, educational and journalistic responsibility for the way in which it goes about its work. Being an institution entrusted with providing the kind of civic education specified in the German constitution, it also supports events organised by more than 300 approved educational establishments, foundations and non-governmental organisations involved in civic education in the Federal Republic of Germany.

					<br/><br/>The bpb has a wide range of services on offer to teachers and anyone involved in education and youth work. It addresses young people directly by dealing with topics and using media that suit their age. It develops special media packages and advanced training activities for young people in sports clubs, in the Bundeswehr or in the police. Now, in the age of the media society, the bpb applies modern methods of communication and makes cross-use of the media. It is facing up to the demands for rapid and well-founded information: It takes up topical social and political events and debates in the educational activities and special online products it offers. This ensures that anyone interested can acquire full information.
					<a href='#' id='hideDPBButton' onclick=' $("#showDPBButton").slideDown(1); $("#DPBText").slideUp(250); return false;' class='hide' style='margin-top:5px;'><?php print _t("Hide"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"></a>
					</div><!-- end DKText-->
				<br/><br/>
				
<?php
			}else{
?>
				<div style="float:left; margin: 10px 20px 10px 0px;"><a href="http://www.deutsche-kinemathek.de" target="_blank"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/deutsche_kinemathek_white.gif" width="95" height="132" border="0"></a></div>
				<h2><a href="http://www.deutsche-kinemathek.de" target="_blank">Deutsche Kinemathek – Museum für Film und Fernsehen</a>, Berlin</h2>

				Mehr als eine Million Fotos, 20.000 Plakate, 15.000 Skizzen und 13.000 Filmkopien werden in den Archiven der Stiftung Deutsche Kinemathek (SDK) aufbewahrt. Nur ein kleiner, aber dennoch imposanter Teil dessen ist seit dem Jahr 2000 in Berlins Neuer Mitte, im Filmhaus am Potsdamer Platz, zu sehen. Nationale und internationale Filmlieber können in dem architektonisch markanten Gebäude mit der gläsernen Fassade die Faszination eines Jahrhunderts deutscher Filmgeschichte erleben. 2006 eröffnete neben der Ständigen Ausstellung Film auch ein Pendant zum Thema Fernsehen, das auf unterhaltsame Weise fünf Jahrzehnte deutscher Fernsehgeschichte in Ost und West dokumentiert – eine in Europa bislang einzigartige Kombination beider Medien unter einem Dach.

				<a href='#' id='showDKButton' onclick='$("#DKText").slideDown(250); $("#showDKButton").slideUp(1); return false;' class='hide' style='margin-top:5px;'><?php print _t("More"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"></a>
				<div id="DKText" style="display:none;">
					<br/>Trägerin des Museums für Film und Fernsehen ist die Stiftung Deutsche Kinemathek (SDK), die 1963 zunächst als Verein gegründet und 1971 in ihre heutige Rechtsform umgewandelt wurde. Seit mehr als 40 Jahren sammelt, archiviert und restauriert sie alles, was zur deutschen Film- und Fernsehgeschichte gehört - sowohl für die Öffentlichkeit als auch für die Fachwelt. Das Filmhaus im Sony Center ist also mehr als ein Museum: Es umfasst neben den beiden Ständigen Ausstellungen auch ein umfangreiches Filmarchiv sowie zahlreiche Sammlungen aus Nachlässen von Stars wie Marlene Dietrich. Neben den auf vier Etagen ausgestellten Exponaten und den dort ausgestrahlten Filmausschnitten kommen so unzählige Kostüme, technische Geräte und historische Dokumente, aber auch Deutschlands bedeutendste Sammlung an Drehbüchern von so bekannten Filmschaffenden wie Fritz Lang und Rainer Werner Fassbinder zusammen. Einiges davon wird den Museumsbesuchern in monothematischen Sonderausstellungen, die das Angebot der Ständigen Ausstellungen ergänzen, zugänglich gemacht. Darüberhinaus wurden einige Sammlungsbestände im Rahmen von Projekten im Internet publiziert (<a href="http://www.kameradatenbank.de" target="blank">www.kameradatenbank.de</a>, <a href="https://www.lost-films.eu" target="_blank">www.lost-films.eu</a>). 
	
					<br/><br/>Filme aus den Beständen der Deutschen Kinemathek werden außerdem für nichtgewerbliche Zwecke verliehen. Einen Namen machte sich die Stiftung auch mit ihren zahlreichen Publikationen zu Film und Filmgeschichte, zum Beispiel mit der Reihe „Film und Schrift“. Einige Titel avancierten zu Standardwerken der Fachliteratur. Zu den weiteren Tätigkeiten der Kinemathek zählen die filmhistorische Retrospektive und Hommage der Internationalen Filmfestspiele Berlin, die sie seit 1977 verantwortet. Im Filmhaus finden Tagungen, Vorträge, Podiumsdiskussionen und Symposien zu film-, fernseh- und medienpolitischen Themen statt. Darüber hinaus steht den Besuchern des Museums eine der größten Fachbibliotheken Europas zu Recherchezwecken offen.
	
					<br/><br/>Seit 2006 hat die Deutsche Kinemathek – Museum für Film und Fernsehen eine neue Leitung: Der Künstlerische Direktor Dr. Rainer Rother und der Verwaltungsdirektor Dr. Paul Klimpel bilden eine Doppelspitze. Sie lösten den Vorstand der Kinemathek und langjährigen Direktor des Museums, Hans Helmut Prinzler, ab.
					<a href='#' id='hideDKButton' onclick=' $("#showDKButton").slideDown(1); $("#DKText").slideUp(250); return false;' class='hide' style='margin-top:5px;'><?php print _t("Hide"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"></a>
				</div><!-- end DKText-->
				<br/><br/>
				
				<div style="float:left; margin: 10px 20px 10px 0px;"><a href="http://www.bpb.de" target="_blank"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/bpb.png' width='180' height='56' border='0'></a></div>
				<h2><a href="http://www.bpb.de" target="_blank">Die Bundeszentrale für politische Bildung</a></h2>

				Im Zentrum der Arbeit der Bundeszentrale für politische Bildung steht die Förderung des Bewusstseins für Demokratie und politische Partizipation. Aktuelle und historische Themen greift sie mit Veranstaltungen, Printprodukten, audiovisuellen und Online-Produkten auf. Veranstaltungsformate der bpb sind Tagungen, Kongresse, Festivals, Messen, Ausstellungen, Studienreisen, Wettbewerbe, Kinoseminare und Kulturveranstaltungen sowie Events und Journalistenweiterbildungen. Das breit gefächerte Bildungsangebot der bpb soll Bürgerinnen und Bürger motivieren und befähigen, sich kritisch mit politischen und gesellschaftlichen Fragen auseinander zu setzen und aktiv am politischen Leben teilzunehmen. Aus den Erfahrungen mit diktatorischen Herrschaftsformen in der deutschen Geschichte erwächst für die Bundesrepublik Deutschland die besondere Verantwortung, Werte wie Demokratie, Pluralismus und Toleranz im Bewusstsein der Bevölkerung zu festigen.

				<a href='#' id='showDPBButton' onclick='$("#DPBText").slideDown(250); $("#showDPBButton").slideUp(1); return false;' class='hide' style='margin-top:5px;'><?php print _t("More"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"></a>
				<div id="DPBText" style="display:none;">
					<br/>Im Jahr 2002 feiert die bpb ihr 50-jähriges Bestehen. Die unterschiedlichen Bildungsangebote der bpb vermitteln Einblicke in die historischen und gesellschaftlichen Zusammenhänge politischer, kultureller, sozialer sowie wirtschaftlicher Prozesse. Ihre Aufgabe erfüllt sie in eigener gesellschaftspolitischer, pädagogischer und publizistischer Verantwortung. Sie ist überparteilich und wissenschaftlich ausgewogen. Als eine Institution der staatlich verfassten politischen Bildung fördert sie zudem Veranstaltungen von mehr als 300 anerkannten Bildungseinrichtungen, Stiftungen und regierungsunabhängigen Organisationen, die in der Bundesrepublik Deutschland in der politischen Bildung tätig sind.

					<br/><br/>Die bpb hält besondere Angebote für Lehrerinnen, Lehrer und Personen in der Bildungs- und Jugendarbeit bereit. Jugendliche und junge Erwachsene spricht sie mit altersgemäßen Themen und Medien direkt an. Sie erarbeitet spezielle Medienpakete und Fortbildungen für junge Erwachsene in Sportvereinen, bei Bundeswehr oder Polizei. Im Zeitalter der Mediengesellschaft macht sich die bpb moderne Kommunikationsmethoden zu eigen und verfolgt einen crossmedialen Ansatz. Sie stellt sich den Anforderungen nach schneller und fundierter Information: Mit ihren Bildungsangeboten und speziellen Online-Produkten greift sie aktuelle gesellschaftliche sowie politische Ereignisse und Debatten auf. Interessierte Bürgerinnen und Bürger können sich bei der bpb also umfassend informieren.
					<a href='#' id='hideDPBButton' onclick=' $("#showDPBButton").slideDown(1); $("#DPBText").slideUp(250); return false;' class='hide' style='margin-top:5px;'><?php print _t("Hide"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="9" height="10" border="0"></a>
				</div><!-- end DKText-->
				<br/><br/>
				
<?php			
			}
?>
			</div><!-- end aboutContent -->
		</div><!-- end contentArea -->
