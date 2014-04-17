<?php
	$vs_message = $this->getVar("message");
	if($vs_message){
		if($this->request->getParameter("overlay", pInteger)){
			print '<div id="caFormOverlay">';
		}
?>
	<div class='alert alert-info'>
<?php
		print $vs_message;
?>
	</div><!-- end alert -->
<?php
	}
if($this->request->getParameter("overlay", pInteger)){
?>
	</div><!-- end caFormOverlay -->
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
<?php
}
?>