<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");	
	$va_access_values = caGetUserAccessValues($this->request);	
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
			<div class="row">
				<div class='col-sm-12 col-md-12 col-lg-10 col-lg-offset-1 text-center'>
					<H1>{{{^ca_occurrences.preferred_labels.name}}} &mdash; {{{^ca_occurrences.alutiiq_word}}}{{{<ifdef code="ca_occurrences.pronunciation_audio_clip"> <i id="playPronunciation" class="fa fa-volume-up" aria-hidden="true"></i></ifdef>}}}</H1>

					<HR>
					{{{<ifdef code="ca_occurrences.sentence"><h2>^ca_occurrences.sentence</h2></ifdef>}}}
					<HR>
<?php
					if($va_audio_podcast = $t_item->representationsWithMimeType(array('audio/mpeg', 'audio/x-aiff', 'audio/x-wav, audio/mp4'), array('versions' => array('original'), 'return_with_access' => $va_access_values))){
						foreach($va_audio_podcast as $vn_rep_id => $va_audio_info){
							print "<div class='unit'>".$va_audio_info["tags"]["original"]."</div>";
						}
					}
					
?>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
<?php
					if($va_images = $t_item->representationsWithMimeType(array('image/jpeg', 'image/tiff', 'image/png', 'image/x-dcraw', 'image/x-psd', 'image/x-dpx', 'image/jp2', 'image/x-adobe-dng', 'image/bmp', 'image/x-bmp'), array('versions' => array('large'), 'return_with_access' => $va_access_values))){
						foreach($va_images as $vn_rep_id => $va_image_info){
							$t_rep = new ca_object_representations($va_image_info["representation_id"]);
							print "<div class='unit fullWidthImg'>".$va_image_info["tags"]["large"];
							print $t_rep->getWithTemplate("<if rule='^ca_object_representations.preferred_labels.name !~ /BLANK/'><div class='small text-left'>^ca_object_representations.preferred_labels.name</div></if>");
							print "</div>";
						}
					}					
?>
					<div class="row">
						<div class="col-md-6">
							<!-- AddToAny BEGIN -->
							<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
							<a class="a2a_dd" href="https://www.addtoany.com/share"></a>
							<a class="a2a_button_facebook"></a>
							<a class="a2a_button_twitter"></a>
							<a class="a2a_button_linkedin"></a>
							<a class="a2a_button_email"></a>
							</div>
							<script async src="https://static.addtoany.com/menu/page.js"></script>
							<!-- AddToAny END -->
						</div>
						<div class="col-md-6">
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_occurrences",  $t_item->get("ca_occurrences.occurrence_id"), array('view' => 'pdf', 'export_format' => '_pdf_ca_occurrences_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				
?>
						</div>
					</div>
				</div><!-- end col -->
				<div class='col-md-6 col-lg-5 text-left'>
					{{{<ifdef code="ca_occurrences.description"><div class="unit">^ca_occurrences.description</div></ifdef>}}}
					
				</div><!-- end col -->
			</div><!-- end row -->
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
{{{<ifdef code="ca_occurrences.pronunciation_audio_clip">	
	$(document).ready(function() {
    var audioElement = document.createElement('audio');
    audioElement.setAttribute('src', '^ca_occurrences.pronunciation_audio_clip.original.url');
    
    
    
    $('#playPronunciation').click(function() {
        return audioElement.paused ? audioElement.play() : audioElement.pause();
    });
});
</ifdef>}}}
</script>