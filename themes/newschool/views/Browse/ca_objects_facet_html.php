<?php
	$va_facet_content = $this->getVar('facet_content');
	$vs_facet_name = $this->getVar('facet_name');
	$vs_view = $this->getVar('view');
	$vs_key = $this->getVar('key');
	
	$vb_is_nav = (bool)$this->getVar('isNav');
	
	$vn_cols = 4;
?>

<?php
	$vn_i = 0;
	foreach($va_facet_content as $vn_id => $va_item) {
		print "<div class='browseFacetItem'>".caNavLink($this->request, $va_item['label'], '', '*', '*', '*', array('facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => $vs_view, 'key' => $vs_key))."</div>";
		
		$vn_i++;
	}
	
?>
	</tbody>
</table>