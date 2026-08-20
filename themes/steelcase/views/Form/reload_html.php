<?php
	$vs_message = $this->getVar("message");
	$pn_set_item_id = $this->request->getParameter('set_item_id', pInteger);
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
	// Kill "last checked" list used in search/browse results to select item for addition to lightbox
	var c = jQuery.cookieJar('lastChecked');
	c.remove();
	
<?php
	if($vs_message){
		if($pn_set_item_id){
?>
			setTimeout(function(){
				$('#caFormOverlay').fadeOut(300, function() {
					 var url = window.location.href;
					 offset = url.indexOf("/set_item_id");
					 if(offset > 0){
					 	url = url.substring(0, offset)
					 }
					 window.location.href = url + "<?php print "/set_item_id/".$pn_set_item_id; ?>";
				 });
			}, 1500);
<?php
		}else{
?>
			setTimeout(function(){
				$('#caFormOverlay').fadeOut(300, function() {
					 window.location.reload();
				 });
			}, 1500);
<?php
		}
	}else{
		if($pn_set_item_id){
?>
			var url = window.location.href;
			offset = url.indexOf("/set_item_id");
			if(offset > 0){
				url = url.substring(0, offset)
			}
			window.location.href = url + "<?php print "/set_item_id/".$pn_set_item_id; ?>";
<?php			
		}else{
?>
			window.location.reload();
<?php
		}
	}
?>
});
</script>