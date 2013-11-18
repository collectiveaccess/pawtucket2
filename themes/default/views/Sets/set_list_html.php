<?php
	$t_set = new ca_sets();
	$va_write_sets = $this->getVar("write_sets");
	#$va_write_sets = array();
	$va_read_sets = $this->getVar("read_sets");
	#$va_read_sets = array();
	$va_access_values = $this->getVar("access_values");
#print_r($va_read_sets);	
?>
	<H1>Lightboxes</H1>
	<div class="row">
<?php
	$vn_col_span = 3;
	$vn_col_span_sm = 6;
	$vb_read_and_write = false;
	if((sizeof($va_write_sets)) && (sizeof($va_read_sets))){
		$vb_read_and_write = true;
		$vn_col_span = 6;
		$vn_col_span_sm = 12;
	}
	$vn_items_per_row = 12/$vn_col_span;
	if($vb_read_and_write){
		print "<div class='col-sm-5 col-md-5 col-lg-5'>\n";
	}else{
		print "<div class='col-sm-10 col-md-10 col-lg-10'>\n";
	}
	if(sizeof($va_write_sets)){
		print "<H3>Write access sets</H3>\n";
		$vn_i_set = 0;
		foreach($va_write_sets as $vn_set_id => $va_set_info){
			if($vn_i_set == 0){
				print "<div class='row'>\n";
			}
			$vn_i_set++;
			$t_set->load($vn_set_id);
			print "<div class='col-sm-".$vn_col_span_sm." col-md-".$vn_col_span."'>\n";
			print caLightboxSetListItem($this->request, $t_set, $va_access_values);
			print "\n</div><!-- end col -->\n";
			if($vn_i_set == $vn_items_per_row){
				print "</div><!-- end row -->\n";
				$vn_i_set = 0;
			}
		}
		if($vn_i_set && ($vn_i_set < $vn_items_per_row)){
			while($vn_i_set < $vn_items_per_row){
				print "<div class='col-sm-".$vn_col_span_sm." col-md-".$vn_col_span."'></div>\n";
				$vn_i_set++;
			}
			print "</div><!-- end row -->\n";
		}
	}
	if($vb_read_and_write){
		print "</div><!-- end col-5 --><div class='col-sm-5 col-md-5 col-lg-5'>\n";
	}
	
	if(sizeof($va_read_sets)){
		print "<H3>Read access sets</H3>\n";
		$vn_i_set = 0;
		foreach($va_read_sets as $vn_set_id => $va_set_info){
			if($vn_i_set == 0){
				print "<div class='row'>\n";
			}
			$vn_i_set++;
			$t_set->load($vn_set_id);
			print "<div class='col-sm-".$vn_col_span_sm." col-md-".$vn_col_span."'>\n";
			print caLightboxSetListItem($this->request, $t_set, $va_access_values);
			print "</div><!-- end col -->\n";
			if($vn_i_set == $vn_items_per_row){
				print "</div><!-- end row -->\n";
				$vn_i_set = 0;
			}
		}
		if($vn_i_set && ($vn_i_set < $vn_items_per_row)){
			while($vn_i_set < $vn_items_per_row){
				print "<div class='col-sm-".$vn_col_span_sm." col-md-".$vn_col_span."'></div>\n";
				$vn_i_set++;
			}
			print "</div><!-- end row -->\n";
		}
	}
?>
		</div><!-- end col-md-5 or 10 -->
		<div class="col-sm-2 col-md-2 col-lg-2">
			<h3>activity stream</h3>
		</div><!-- end col 2 -->
	</div><!-- end row -->