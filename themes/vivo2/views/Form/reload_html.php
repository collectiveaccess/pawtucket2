<?php
	$vs_message = $this->getVar("message");
	$vn_row_id = $this->getVar("row_id");
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
	if($this->request->isAjax()){
		if($vs_message){
?>
			setTimeout(function(){
				$('#caFormOverlay').fadeOut(300, function() {
<?php
					# --- don't add row id if this is coming from the home page
					if($vn_row_id){
?>
						var url = window.location.href;
						var n = url.indexOf("row_id")
						if(n > 0){
							var n = url.indexOf("/row_id");
							if(n > 0){
								url = url.substring(0, n);
							}
							var n = url.indexOf("?");
							if(n > 0){
								window.location.href = url + "&row_id=<?php print $vn_row_id; ?>";
							}else{
								window.location.href = url + "/row_id/<?php print $vn_row_id; ?>";
							}
						}else{
							window.location.reload();
						}
<?php
					}else{
?>
					 window.location.reload();
<?php
					}
?>
				 });
			}, 1500);
<?php
		}else{

			if($vn_row_id){
?>
				var url = window.location.href;
				var n = url.indexOf("row_id")
				if(n > 0){
					var n = url.indexOf("/row_id");
					if(n > 0){
						url = url.substring(0, n);
					}
					var n = url.indexOf("?");
					if(n > 0){
						window.location.href = url + "&row_id=<?php print $vn_row_id; ?>";
					}else{
						window.location.href = url + "/row_id/<?php print $vn_row_id; ?>";
					}
				}else{
					window.location.reload();
				}
<?php
			}else{
?>
			 window.location.reload();
<?php
			}

		}
	}
?>
});
</script>