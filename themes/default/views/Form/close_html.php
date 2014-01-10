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
			caMediaPanel.hidePanel();
		}, 2000);
<?php
	}else{
?>
		caMediaPanel.hidePanel();
<?php
	}
?>
});
</script>