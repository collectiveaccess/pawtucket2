<?php require(__CA_THEME_DIR__."/views/mailTemplates/settings.php"); ?>

<p style="font-family: <?= $font; ?>; color: <?= $font_color; ?>; font-size: 18px; font-weight: bold; padding-top: 30px;">Lightbox <em>"{{{lightboxName}}}"</em> has been shared with you by {{{sharer}}} at the <a href="<?= $home_url; ?>" style="color: <?= $font_color; ?>">Metabolic Studio</a></p>

{{{<ifdef code='message'><p style="font-family: helvetica; font-size: 15px; color: <?= $font_color; ?>; "><strong>Sharing note:</strong> ^message</p></ifdef>}}}

<p style="width: 275px; height: 35px; margin: 26px auto 10px auto; background-color: <?= $font_color; ?>; font-family: <?= $font; ?>; font-size: 22px; font-weight: bold; text-align: center; border-radius: 10px; padding-top: 12px;">
	<a href="{{{lightboxUrl}}}" style="color: #fff; text-decoration: none; margin-top: 15px;">View lightbox</a>
</p>

