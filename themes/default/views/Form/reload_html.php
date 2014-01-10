<?php
	$vs_message = $this->getVar("message");
	if($vs_message){
?>
	<div id="caFormOverlay"><div class='alert alert-info'>
<?php
		print $vs_message;
?>
	</div><!-- end alert --></div><!-- end caFormOverlay -->
<?php
	}
?>
<script type="text/javascript">
$(document).ready(function() {
<?php
	if($vs_message){
?>
		setTimeout(function(){
			$('#caFormOverlay').fadeOut(300, function() {
				 window.location.reload();
			 });
		}, 1500);
<?php
	}else{
?>
		window.location.reload();
<?php
	}
?>
});
</script>