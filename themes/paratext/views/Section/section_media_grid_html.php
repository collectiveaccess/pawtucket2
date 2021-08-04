<?php
	# --- grid view doesn't show text for section
	$t_section = $this->getVar("section");
	$vs_title = $this->getVar("section_title");
	$vs_text = $this->getVar("section_text");
	$vs_current_section = $this->getVar("current_section");
	$r_illustrations = $this->getVar("illustrations_as_search_result");
	
	$vn_illustration_id = $this->request->getParameter("illustration", pInteger);
?>
<div class="page_title">
    <h1><?php print $vs_title; ?></h1>
    <ul class="exhibition-sub-menu">
<?php
	$va_paratext_exhibition_sections = $this->request->config->get("paratext_exhibition_sections");
	
	foreach($va_paratext_exhibition_sections as $vs_idno => $vs_section_title){
		if(strToLower($vs_idno) != $t_section->get("ca_occurrences.idno")){
			print "<li>".caNavLink($this->request, $vs_section_title, '', '', 'Section', $vs_idno)."</li>";
		}		
	}
?>
    </ul>
</div>

<div class="text_content grid_content">
        	<div class="image_nav">
<?php
			print caNavLink($this->request, '< Back', '', '', 'Section', $vs_current_section);
?>
            <br/><br/></div>

<?php
				if($r_illustrations->numHits()){
					$i = 0;
					while($r_illustrations->nextHit()){
						$vs_see_also = $r_illustrations->getWithTemplate("<ifcount code='ca_objects.related' restrictToTypes='book' min='1'><br/><br/>More Information: <unit relativeTo='ca_objects.related' restrictToTypes='book' delimiter='<br/>'><a href='http://www.comediassueltasusa.org/collection/Detail/objects/^ca_objects.object_id' target='_blank'>^ca_objects.CCSSUSA_Uniform <i class='fa fa-external-link' aria-hidden='true'></i></a></unit></ifcount>");
						$vs_thumb = $r_illustrations->get("ca_object_representations.media.large");							
						if($i == 0){
?>
							<div class="columns">
<?php
						}
						$i++;
?>
						<div class="grid_column">
							<?php print $vs_thumb; ?>
							<div class='caption'><?php print $r_illustrations->get("ca_objects.preferred_labels.name").$vs_see_also; ?></div>
						</div>
<?php
						if($i == 3){
							$i = 0;
?>
							</div>
<?php						
						}
					
					}
					if($i > 0){
?>
						</div>
<?php
					}
				}
?>

</div>