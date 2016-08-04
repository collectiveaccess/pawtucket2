<?php
	$t_list = new ca_lists();
?>




<div class='container'>
	<div class='row'>
		<div class='col-sm-12'>
			<h1>Featured Galleries</h1>
		</div>
	</div>
	<div class='row'>
		<div class='col-sm-4'>
<?php
			$vn_thematic_type_id = $t_list->getItemIDFromList("lightbox_cats", "thematic_guide");
			print "<div class='featuredGallery'>";
			print "<div class='featuredImage'>".caGetThemeGraphic($this->request, 'museum.jpg')."</div>";
			print "<div class='featuredTitle'>".caNavLink($this->request, 'Themes', '', '', 'Gallery', 'Index', array('theme' => $vn_thematic_type_id))."</div>";
			print "</div>";
?>		
		</div>
		<div class='col-sm-4'>
<?php
			$vn_timeline_type_id = $t_list->getItemIDFromList("lightbox_cats", "timeline");
			print "<div class='featuredGallery'>";
			print "<div class='featuredImage'>".caGetThemeGraphic($this->request, 'archives.jpg')."</div>";
			print "<div class='featuredTitle'>".caNavLink($this->request, 'Timelines', '', '', 'Gallery', 'Index', array('theme' => $vn_timeline_type_id))."</div>";
			print "</div>";
?>		
		</div>		
		<div class='col-sm-4'>
<?php
			$vn_in_focus_type_id = $t_list->getItemIDFromList("lightbox_cats", "in_focus");
			print "<div class='featuredGallery'>";
			print "<div class='featuredImage'>".caGetThemeGraphic($this->request, 'library.jpg')."</div>";
			print "<div class='featuredTitle'>".caNavLink($this->request, 'Digital Collections', '', '', 'Gallery', 'Index', array('theme' => $vn_in_focus_type_id))."</div>";
			print "</div>";
?>		
		</div>				
	</div>
</div>