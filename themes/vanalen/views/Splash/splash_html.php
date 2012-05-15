		<div id="hpTopBox">
			<div id="hpFeatured"><?php print caNavLink($this->request, $this->getVar("featured_content_medium"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("featured_content_id"))); ?></div><!-- end hpFeatured -->
			<div id="hpText">
				<div class="title">Welcome to Van Alen Institute's Design Archive</div>
				The Design Archive Project is a multi-year initiative to provide public, web-based access to the Institute's collections of historical design materials, including institutional records, photographs, and architectural drawings. Dating from its founding in 1894 through the present, these materials document the Institute's legacy as a bridge between architectural education and practice and the significant influence of VAI's programs on the development of early 20th century American architectural education.
				<div id="featuredCaption">Left: <i><?php print caNavLink($this->request, $this->getVar("featured_content_label"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("featured_content_id"))); ?></i></div><!-- end featuredCaption -->
			</div><!-- end hpText -->
			<div style="clear:both;"><!-- empty --></div>
		</div><!-- end hpTopBox -->
