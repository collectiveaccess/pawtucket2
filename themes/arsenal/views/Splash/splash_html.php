<?php
		global $g_ui_locale;
		/* dirty hack to translate browse labels since I can't update po/mo files */
		$va_facet_code_to_label_map = array(
			'entity_facet' => array(
				"de_DE" => array("name_singular" => "Regie", "name_plural" => "Regie"),
				"en_US" => array("name_singular" => "Director", "name_plural" => "Directors"),
			),
			'country_facet' => array(
				"de_DE" => array("name_singular" => "Land", "name_plural" => "Länder"),
				"en_US" => array("name_singular" => "Country", "name_plural" => "Countries"),
			),
			'year_facet' => array(
				"de_DE" => array("name_singular" => "Jahr", "name_plural" => "Jahre"),
				"en_US" => array("name_singular" => "Year", "name_plural" => "Years"),
			),
			'forum_year_facet' => array(
				"de_DE" => array("name_singular" => "Forumsjahr", "name_plural" => "Forumsjahre"),
				"en_US" => array("name_singular" => "Forum year", "name_plural" => "Forum years"),
			),
			'format_facet' => array(
				"de_DE" => array("name_singular" => "Format", "name_plural" => "Formate"),
				"en_US" => array("name_singular" => "Format", "name_plural" => "Formats"),
			),
			'titleseries_facet' => array(
				"de_DE" => array("name_singular" => "Serientitel", "name_plural" => "Serientitel"),
				"en_US" => array("name_singular" => "Series title", "name_plural" => "Series titles"),
			),
		);
?>
		<div id="hpText">
<?php
		if($g_ui_locale=="de_DE"){
?>
Willkommen in der Datenbank des Arsenal – Institut für Film und Videokunst. Rund 6.000 Filme und Videos aus den Bereichen Kollektion und Distribution sind hier zu entdecken, die seit der Gründung der Institution im Jahre 1963 aus dem Programm des Berlinale Forum und durch die jahrzehntelange Arbeit des Kino Arsenal Eingang in die Sammlung gefunden haben. Filme aus aller Welt, in allen Längen und Genres sind hier aufgeführt.
Das Archiv des Arsenal – Institut für Film und Videokunst hatte niemals einen definierten Sammlungsauftrag. Unabhängig von klassischen Ordnungsprinzipien spiegelt es internationale Geschichte und Gegenwart aus der Sicht einer fast 50 Jahre alten Berliner Filminstitution. Aus der praktischen Arbeit heraus entstanden, kann das Archiv nur im Austausch mit der Gegenwart weiter leben. Deshalb freuen wir uns, endlich online und damit zugänglich zu sein.
<?php
		} else {
?>
Welcome to the Arsenal – Institute for Film and Video Art database. There are about 6.000 films and videos from both the Arsenal collection as well as the distribution arm to be discovered here, which, since the founding of the institution in 1963, have found their way into the database via the Forum programs shown at the Berlin Film Festival, and via the work of the Arsenal Cinema over the decades. Films are screened here from the world over, of all lengths and genres. The Arsenal – Institute for Film and Video Art archive has never had clearly defined parameters for how it collects films. Unhampered by classical organizational principles, it reflects international history and current trends from the viewpoint of an almost fifty-year-old Berlin film institution. Emerging from practical work, the archive can only continue to exist by engaging with the present. This is one reason why we are delighted to be finally online and accessible.
<?php
		}
?>
		</div>
		<div id="hpFeatured">
			<div class="title">&nbsp;<!--<?php print _t("Recommended"); ?>--></div>
			<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("user_favorites_medium"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("user_favorites_id"))); ?></td></tr></table>
		</div>
		
		<div id="quickLinkItems" >
			<div class="quickLinkItem" style="margin-top:0px;">
			<div class="title"><?php print ($g_ui_locale == de_DE ? "Experimentalfilm" : "Experimental Film"); ?></div>
				<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("featured_content_preview"), '', '', 'Favorites', 'index'); ?></td></tr></table>
			</div>
			<div class="quickLinkItem">
				<div class="title"><?php print ($g_ui_locale == de_DE ? "Meist gesehen" : "Most Viewed"); ?></div>
				<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("most_viewed_preview"), '', '', 'Favorites', 'index'); ?></td></tr></table>
			</div>
			<div class="quickLinkItem" style="margin-right:0px;">
				<div class="title"><?php print ($g_ui_locale == de_DE ? "Neuzugänge" : "Recently Added"); ?></div>
				<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("recently_added_preview"), '', '', 'Favorites', 'index'); ?></td></tr></table>
			</div>
			<div id="hpBrowse">
				<div><b><?php print ($g_ui_locale == "de_DE" ? "Suche nach" : "Browse Films by"); ?>:</b></div>
				<div style="margin-top:10px;">
<?php
					$va_facets = $this->getVar('available_facets');
					foreach($va_facets as $vs_facet_name => $va_facet_info) {
?>
						<a href="#" onclick='caUIBrowsePanel.showBrowsePanel("<?php print $vs_facet_name; ?>")'><?php print $va_facet_code_to_label_map[$vs_facet_name][$g_ui_locale]["name_singular"]; ?></a><br/>
<?php
					}
					print caNavLink($this->request, ($g_ui_locale == de_DE ? "Experimentalfilm" : "Experimental Film"), '', '', 'Search', 'Index', array('search' => ($g_ui_locale == de_DE ? "Experimentalfilm" : "Experimental Film")));
?>
				<br />
				</div>
			</div>

<div class="hpRss"><?php print caNavLink($this->request, '<img src="'.$this->request->getThemeUrlPath(true).'/graphics/feed.gif" border="0" alt="'._t('Get alerted to newly added items by RSS').'" width="14" height="14"/> '._t('Get alerted to newly added items by RSS'), 'caption', '', 'Feed', 'recentlyAdded'); ?></div>
		</div><!-- end quickLinkItems -->
<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
	<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browseSelectPanelButton">&nbsp;</a>
	<div id="splashBrowsePanelContent">

	</div>
</div>
<script type="text/javascript">
	var caUIBrowsePanel = caUI.initBrowsePanel({ facetUrl: '<?php print caNavUrl($this->request, '', 'Browse', 'getFacet'); ?>'});
</script>
			
		
