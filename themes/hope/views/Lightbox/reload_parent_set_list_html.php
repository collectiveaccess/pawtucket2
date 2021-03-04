<?php
	$vs_message = $this->getVar("notification");
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
				$('#caFormOverlay').fadeOut(200, function() {

					window.location.href = "<?php print caNavUrl($this->request, '', 'Lightbox', 'parent_list', null); ?>";

				 });
			}, 1500);
<?php
		}else{
?>
				window.location.href = "<?php print caNavUrl($this->request, '', 'Lightbox', 'parent_list', null); ?>";
<?php
		}
?>
});
</script>