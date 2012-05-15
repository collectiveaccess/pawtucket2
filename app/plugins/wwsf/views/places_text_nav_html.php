<?php
global $g_ui_locale;

			if ($g_ui_locale == 'en_US') {
?>
				Which places come to mind when you think of the time of the Fall of the Wall and German reunification? You can probably remember Berlin’s Brandenburg Gate and other border checkpoints, the best of you can maybe even recall the events in Hungary and Leipzig. But how did people in places such as Suhl, Gotha, Plauen or Mödlareuth experience the time?
				<br/><br/>
				More than 20 years on, only a few places represent an experience that extended throughout large parts of Europe. Our map however, is dotted with a multitude of flags, because the internet archive presents images from places that did not make it into the attention of the media, as well as new perspectives on well-known ones. Our photographs, films and memories give room to different possibilities for observation.

<?php
			}else{
?>
				Welche Orte fallen Ihnen ein, wenn Sie an die Umbruchszeit 1989/1990 denken? Berlin natürlich und dort vor allem das Brandenburger Tor und die Grenzübergange Bornholmer und Bernauer Straße, vielleicht erinnern Sie sich an Bilder aus Leipzig oder Ungarn. Wie aber haben Menschen in Suhl, Gotha, Plauen oder Mödlareuth die Zeit erlebt?
				<br/><br/>
				Mehr als 20 Jahre nach den Ereignissen stehen noch immer einige wenige Orte stellvertretend für eine Entwicklung, die große Teile Europas erfasste. Unsere Landkarte ist jedoch mit unzähligen Fähnchen übersäht. Denn im Internet-Archiv finden sich Eindrücke von Orten, die der medialen Aufmerksamkeit entgangen sind und neue Perspektiven auf wohlbekannte Plätze. Die Fotografien, Filme und Erinnerungen geben damit den vielfältigen Möglichkeiten der Wahrnehmung Raum.
<?php			
			}
?>		
		<div id="placesLinks">
<?php
			print "<div><img src='".$this->request->getThemeUrlPath()."/graphics/arrow_right_gray.gif' width='9' height='10' border='0'> ".caNavLink($this->request, _t("Rediscovered Places"), "", "wwsf", "Places", "Index")."</div>";
			print "<div><img src='".$this->request->getThemeUrlPath()."/graphics/arrow_right_gray.gif' width='9' height='10' border='0'> ".caNavLink($this->request, _t("Map"), "", "wwsf", "Places", "Map")."</div>";
?>
		</div><!-- end placeLinks -->