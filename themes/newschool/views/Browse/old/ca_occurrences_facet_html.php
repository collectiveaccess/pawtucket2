<?php
	$va_facet_content = $this->getVar('facet_content');
	$vs_facet_name = $this->getVar('facet_name');
	$vs_view = $this->getVar('view');
	$vs_key = $this->getVar('key');
?>
<div style="margin:10% 10% 10% 10%; width: 80%; height: 80%; padding: 10px; background-color: #fff; opacity: 0.8; -webkit-column-fill: auto; column-count: 3; -moz-column-count: 3; -webkit-column-count: 3; overflow: auto;">
<?php
	foreach($va_facet_content as $vn_id => $va_item) {
		print caNavLink($this->request, $va_item['label'], '', '*', '*', '*', array('facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => $vs_view, 'key' => $vs_key))."<br/>\n";
	}
?>
</div>