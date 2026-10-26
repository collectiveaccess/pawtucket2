<?php
	$va_paratext_exhibition_sections = $this->request->config->get("paratext_exhibition_sections");	
?>

<div class="page_title">
    <h1>Exhibition</h1>
    <div class="ornament">
<?php
        $ornaments = array(
            'head_ornament-10.svg',
            'head_ornament-11.svg',
            'head_ornament-12.svg',
        );
        $rand_ornament = array_rand($ornaments, 1);
		print caGetThemeGraphic($this->request, $ornaments[$rand_ornament], array("class" => "page_title_ornament", "alt" => "Header Ornament"));
?>
    </div>
</div>
<div class="text_content">
	<div class="text exhibition_landing">
<?php
		$c = 1;
		$col = 1;
		$t_nav_section = new ca_occurrences();
		foreach($va_paratext_exhibition_sections as $vs_idno){
			$t_nav_section->load(array("idno" => $vs_idno));
			print caNavLink($this->request, "<div class='case_buttons col".$col."'><div class='case_number'>Exhibit Case ".$c.":</div><div class='case_title'>".$t_nav_section->get("ca_occurrences.preferred_labels.name").(($c == 8) ? "<br/><br/>" : "")."</div></div>", "", '', "Section", $vs_idno);
			$c++;
			if($col == 1){
				$col = 2;
			}else{
				$col = 1;
			}
		}
?>
		<div style="clear:both;"></div>
	</div>
</div>
