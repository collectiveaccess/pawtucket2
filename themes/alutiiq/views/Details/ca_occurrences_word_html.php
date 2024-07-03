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
				<div class='col-sm-12 text-center'>
					<H2 class="uk-h1">{{{^ca_occurrences.preferred_labels.name}}} &mdash; {{{^ca_occurrences.alutiiq_word}}}{{{<ifdef code="ca_occurrences.pronunciation_audio_clip"> <span id='playPronunciation'><span class='uk-link el-image uk-icon' uk-icon='icon: microphone;'><svg width='20' height='20' viewBox='0 0 20 20'><line fill='none' stroke='#000' x1='10' x2='10' y1='16.44' y2='18.5'></line><line fill='none' stroke='#000' x1='7' x2='13' y1='18.5' y2='18.5'></line><path fill='none' stroke='#000' stroke-width='1.1' d='M13.5 4.89v5.87a3.5 3.5 0 0 1-7 0V4.89a3.5 3.5 0 0 1 7 0z'></path><path fill='none' stroke='#000' stroke-width='1.1' d='M15.5 10.36V11a5.5 5.5 0 0 1-11 0v-.6'></path></svg></span></span></ifdef>}}}</H2>
						
					<HR>
					{{{<ifdef code="ca_occurrences.sentence"><div class="sentence">^ca_occurrences.sentence</div></ifdef>}}}
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
				<div class='col-sm-6 col-md-6'>
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
						<div class="col-sm-12">
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
				<div class='col-md-6'>
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