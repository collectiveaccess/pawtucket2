<?php
$access_values = 	$this->getVar("access_values");
$t_object = $this->getVar("item");
$reps = $t_object->getRepresentations(['small', 'pdf', 'original'], null, array("checkAccess" => $access_values));
if(is_array($reps) && sizeof($reps)) {
?>
		<table class="record table table-striped table-responsive">
			<tbody>
				<tr><th colspan="<?= sizeof($reps) + 1; ?>"><H4>Documents</H4></th></tr>
				<tr>
					<td class="empty"></td>
					<td>
						<ul>
<?php
	foreach($reps as $rep_id => $rep) {
		$label = $type = "";
		if($rep["label"] && ($rep["label"] != "[BLANK]")){
			$label = ": ".$rep["label"];
		}
		switch($rep["typename"]){
			case "fiscal":
				$type = "Fiscal Note";
			break;
			# ---------------------------
			case "attach":
				$type = "Attachment";
			break;
			# ---------------------------
			case "pdf":
				$type = "PDF";
			break;
			# ---------------------------
			case "complete":
				$type = "Signed Copy";
			break;
			# ---------------------------
		}
?>
		<li><?= caNavLink($this->request, "<i class='bi bi-file-earmark-arrow-down-fill' aria-label='Download' title='Download'></i> {$type}{$label}", '*', '*', '*', 'DownloadRepresentation', [
			'context' => 'objects', 
			'version' => 'original', 
			'representation_id' => $rep_id
			]); ?></li>
<?php
	}
?>
					</td>
				</tr>
			</tbody>
		</table>
<?php
}
?>