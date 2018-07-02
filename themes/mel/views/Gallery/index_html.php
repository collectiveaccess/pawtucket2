<div class="row"><div class="col-sm-8 col-sm-offset-2">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <H1><?php #print $this->getVar("section_name"); ?>Meet 25 Objects</H1>
                <p>The Mel Fisher Maritime Museum’s transatlantic slave trade artifact collection contains rare tangible evidence of a cruel period in history. These objects document an era that history books all too often ignore.</p>
                
                <p>More than thirty years of research, conservation, and exhibition have brought us to this online virtual exhibition.</p>
                
                <p>We have selected twenty-five objects to chronicle the history of the trade.</p>
            </div>
        </div>
    </div>
<?php
	$va_sets = $this->getVar("sets");
	$va_first_items_from_set = $this->getVar("first_items_from_sets");
	if(is_array($va_sets) && sizeof($va_sets)){
		# --- main area with info about selected set loaded via Ajax
?>
		<div class="container">
			<div class="row">
				<div class='col-sm-12'>
					<div id="gallerySetInfo" class="row">
					<hr/>
<?php
                    foreach($va_sets as $vn_set_id => $va_set){
                        $t_set = new ca_sets($va_set["set_id"]);
                        $va_first_item = array_shift($va_first_items_from_set[$vn_set_id]);
                        $t_first_rep = new ca_object_representations($va_first_item['representation_id']);
                        $vs_rep_iconlarge = $t_first_rep->get("ca_object_representations.media.iconlarge");
?>
                        <div class="col-sm-6 col-md-4">
                            <div class="set-feature-box">
<?php 
                                    if($vs_rep_iconlarge){
                                        print caNavLink($this->request, $vs_rep_iconlarge, "", "", "Gallery", $va_set["set_id"]); 
                                    } else {
                                        print caGetThemeGraphic($this->request, 'placeholder_front.jpg');
                                    }
?>
                                <div class="set-feature-title">
                                    <?php print "<H4>".caNavLink($this->request, $t_set->get("ca_sets.preferred_labels.name"), "", "", "Gallery", $va_set["set_id"])."</H4>"; ?>
                                </div>
                            </div>
                        </div>
                        
<?php
                    }
?>
					</div><!-- end gallerySetInfo -->
				</div><!-- end col -->
			</div><!-- end row -->
		</div><!-- end container -->
<?php
	}
?>
</div><!-- end col --></div><!-- end row -->