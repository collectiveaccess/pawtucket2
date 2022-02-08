<?php
	$font = "Georgia, 'Times New Roman', Times, serif";
	$font_color = "#76766B";
	$home_url = "https://aliceb.metabolicstudio.org";
?>
<div style="background-color: <?= $font_color; ?>; padding: 10px; border-radius: 10px; height: 100px;">
	<a href="<?= $home_url; ?>"><?= caGetThemeGraphic('metabolic/metabolicStudioLogo.png', ['alt' => 'Metabolic Studio Logo', 'width' => '600px', 'height' => '90px'], ['absolute' => true]); ?></a>
</div>