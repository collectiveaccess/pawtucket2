		<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
			<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browseSelectPanelButton"></a>
			<div id="splashBrowsePanelContent">
			
			</div>
		</div>
		<script type="text/javascript">
			var caUIBrowsePanel = caUI.initBrowsePanel({ facetUrl: '<?php print caNavUrl($this->request, '', 'Browse', 'getFacet'); ?>'});
		</script>
		
		<div id="hpText">
<?php
		print $this->render('Splash/splash_intro_text_html.php');
?> 
			
		</div>

		<div id="moreAbout">
			<?php print caNavLink($this->request, '<img src="'.$this->request->getThemeUrlPath().'/graphics/Uknown04_fg.jpg" border="0">', '', '', 'About', 'index'); ?>
			More about DHCC
		</div>
		<div id="splashText">
			Housed in the <a href="http://www.drexel.edu/academics/comad/">Antoinette Westphal College of  Media Arts &amp; Design,</a> Drexel University, Philadelphia, PA, the Drexel  Historic Costume Collection (DHCC) had its beginning in the 1890s when members of the  Drexel family began assembling a collection of notable garments, accessories  and textiles. The DHCC represents over 200 years of historic fashion and  textile design. Shoes, millinery, lingerie, and other accessories represent an opportunity to study an entire period ensemble. The  Collection is estimated to contain more than 10,000 items. Most significant  fashion designers of the 20th century are represented. Click on &quot;More about the DHCC&quot; to learn about this world class collection.
		</div>
		<div id="quickLinkItems">
			<div class="quickLinkItem">
				<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("featured_content_preview160"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("featured_content_id"))); ?></td></tr></table>
				<div class="title"><?php print _t("Featured Object"); ?></div>
			</div>
			<div class="quickLinkItem">
				<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("most_viewed_preview160"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("most_viewed_id"))); ?></td></tr></table>
				<div class="title"><?php print _t("Featured Designer"); ?></div>
			</div>
			<div class="quickLinkItem" style="margin-right:0px;">
				<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/Lanvin02_fg.gif' border='0'>", '', '', 'About', 'conservation');?></td></tr></table>
				<div class="title"><?php print _t("Conservation"); ?></div>
			</div>
			<div id="copytext">
			This site functions best using Internet Explorer 6 or higher. © All images on this website are protected by copyright. <a href="mailto:martink@drexel.edu">contact</a> us for right of release for educational purposes.	
			</div>		
		</div><!-- end quickLinkItems -->
			
		<div class="hpRss"><?php print caNavLink($this->request, '<img src="'.$this->request->getThemeUrlPath(true).'/graphics/feed.gif" border="0" alt="'._t('Get alerted to newly added items by RSS').'" width="14" height="14"/> '._t('Get alerted to newly added items by RSS'), 'caption', '', 'Feed', 'recentlyAdded'); ?></div>