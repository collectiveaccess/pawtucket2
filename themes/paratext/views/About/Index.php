<div class="page_title">
    <h1>About</h1>
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
<?php
    	print caGetThemeGraphic($this->request, "img/Szilvia_about.jpg", array("class" => "centered big_margin_bottom", "alt" => "Szilvia Szmuk-Tanenbaum"));
?>
    <p>The concept of ‘paratext’ in the study of literature is relatively new. It looks not at the literary content of a work, but the way(s) it is presented to the world, the way(s) it manifests itself in the world in the materials that surround the text: table of contents, illustrations, lists of dramatis personae, etc. Gérard Genette’s groundbreaking work Paratexts: Thresholds of Interpretation, published in 1997, introduced and defined this idea. The most concise definition would have to include Add more from Genette</p>

    <div id="agradecimientos" class="team_photos big_margin_top">
        <div class="team_member">
            <div class="member_photo" style="background: url('<?php print caGetThemeGraphicUrl($this->request, "img/Szilvia_about.jpg"); ?>') no-repeat center; background-size: cover;"></div>
            <div class="member_name">Name Lastname</div>
        </div>
        <div class="team_member">
            <div class="member_photo" style="background: url('<?php print caGetThemeGraphicUrl($this->request, "img/Szilvia_about.jpg"); ?>') no-repeat center; background-size: cover;"></div>
            <div class="member_name">Name Lastname</div>
        </div>
        <div class="team_member">
            <div class="member_photo" style="background: url('<?php print caGetThemeGraphicUrl($this->request, "img/Szilvia_about.jpg"); ?>') no-repeat center; background-size: cover;"></div>
            <div class="member_name">Name Lastname</div>
        </div>
        <div class="team_member">
            <div class="member_photo" style="background: url('<?php print caGetThemeGraphicUrl($this->request, "img/Szilvia_about.jpg"); ?>') no-repeat center; background-size: cover;"></div>
            <div class="member_name">Name Lastname</div>
        </div>
    </div>

</div>