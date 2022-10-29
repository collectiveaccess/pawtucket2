<?php
	$t_section = $this->getVar("section");
	$vs_title = $this->getVar("section_title");
	$vs_text = $this->getVar("section_text");
	
	if($t_section->get("ca_occurrences.idno") == "acknowledgments"){
?>
		<div class="text_content with_vertical_ornaments">
			<div class="vertical_ornaments">
				<div class="vertical_ornament_two"></div>
				<div class="vertical_ornament_two"></div>
				<div class="vertical_ornament_two"></div>
			</div>
			<div class="text acknowledgments">
				<p><?php print $vs_text; ?></p>    
			</div>
		</div>
<?php	
	}else{
?>
<div class="page_title">
    <h1><?php print $vs_title; ?></h1>
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

<div class="text_content with_vertical_ornaments">
<?php
	switch($t_section->get("ca_occurrences.idno")){
		case "foreword":
?>
    <div class="vertical_ornaments">
        <div class="vertical_ornament_one"></div>
    </div>
<?php		
		break;
		# -----------------------------------------
		default:
?>
    <div class="vertical_ornaments">
        <div class="vertical_ornament_one"></div>
    </div>
<?php		
		
		break;
		# -----------------------------------------
	}
?>
    <div class="text">
    	<p><?php print $vs_text; ?></p>
    
   <!-- <ol class="footnotes">
        <li id="footnote1">[Footnotes, D.W. Cruickshank, “On the Stage, on the Page: Some Developments in Spanish Drama, 1681—1833” in A Lifetime’s Reading: Hispanic Essays for Patrick Gallagher, ed. Don W. Cruickshank. Dublin, University College Dublin P, 1999, pp. 26-43 touches on several aspects of this subject. Lisa Surwillo “Paratextual Performances in the ‘Galerías dramáticas’”in The Stages of Property: Copyrighting Theatre in Spain. U of Toronto Press, 2007, pp 124-146 treats this subject in depth in post-1833 imprints. For a general discussion and historic overview of paratext in books, especially in Spain, see Antonio Castillo Gómez “”Véndese en la tienda de...”  Apuntes sobre la publicidad del libro en la España moderna” in La publicidad del libro en el mundo hispánico (Siglos XVII-XX): Los Catálogos de venta de libreros y editores. Ed. Pedro Rueda Ramírez Lluís Agustí. Barcelona: Calambur 2016, pp. 87-113.]</li>
        <li id="footnote2">[Footnote: Bergman, Hannah E. and Szilvia E. Szmuk. A Catalogue of Comedias sueltas in The New York Public Library. 2 vols. Research Bibliographies and Checklists 32. London: Grant and Cutler, 1980–81.]</li>
    </ol>-->
	</div>
</div>
<?php	
	}
?>