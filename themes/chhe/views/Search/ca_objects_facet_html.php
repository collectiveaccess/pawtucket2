<?php
	$va_facet_content = $this->getVar('facet_content');
	$vs_facet_name = $this->getVar('facet_name');
	$vs_view = $this->getVar('view');
	$vs_key = $this->getVar('key');
	
	$vb_is_nav = (bool)$this->getVar('isNav');
	
	$vn_cols = 4;
?>
<table class="table <?php print $vb_is_nav ? "browseNavTable" : "table-bordered"; ?>">
	<tbody>
<?php
	$vn_i = 0;
	foreach($va_facet_content as $vn_id => $va_item) {
		if (!$vn_i) { print "<tr>"; }
		print "<td>".caNavLink($this->request, $va_item['label'], '', '*', '*', '*', array('facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => $vs_view, 'key' => $vs_key))."</td>";
		
		$vn_i++;
		if ($vn_i >= $vn_cols) { print "</tr>\n"; $vn_i = 0; }
	}
	if (($vn_i > 0) && ($vn_i < $vn_cols)) { print "</tr>\n"; }
	
?>
	</tbody>
</table>