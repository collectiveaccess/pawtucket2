<?php
	$vs_message = $this->getVar("message");
	if($vs_message){
?>
	<div id="caFormOverlay"><div class='alert alert-info'>
<?php
		if($vs_message == "Thank you for registering!  Your account will be activated after review."){
			print $vs_message." Please allow up to 48 hours for review or contact us with questions.";
		}else{
			print $vs_message;
		}
?>
	</div><!-- end alert --></div><!-- end caFormOverlay -->
<?php
	}
?>
<script type="text/javascript">
$(document).ready(function() {
	// Kill "last checked" list used in search/browse results to select item for addition to lightbox
	var c = jQuery.cookieJar('lastChecked');
	c.remove();
	
<?php
	if($this->request->isAjax()){
		if($vs_message){
?>
			setTimeout(function(){
				$('#caFormOverlay').fadeOut(300, function() {
					window.location.href += "/contributed/1";
					window.location.reload();
				 });
			}, 3000);
<?php
		}else{
?>
			window.location.href += "/contributed/1";
			window.location.reload();
<?php
		}
	}
?>
});
</script>