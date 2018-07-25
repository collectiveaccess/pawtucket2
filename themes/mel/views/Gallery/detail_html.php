<?php
	$pa_set_items = $this->getVar("set_items");
	$pn_set_id = $this->getVar("set_id");
	$t_set = $this->getVar("set");
	$ps_label = $this->getVar("label");
	$ps_description = $this->getVar("description");
	$pn_set_item_id = $this->getVar("set_item_id");
?>
    
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <H1><?php print $this->getVar("label")."</H1>"; ?>
            <hr/>
        </div>
    </div>
	<div id="galleryDetailArea" class="row">
	    <div class="col-sm-5 col-sm-offset-1">
	        <div id="galleryDetailImageArea">
<?php
            $vs_scan_html = '';
            $va_exhibit_media = [];
            $va_3d_scans = [];
            foreach($pa_set_items as $pa_set_item){
                if($pa_set_item["row_id"]){
                    $t_object = new ca_objects($pa_set_item["row_id"]);
                    $va_reps = $t_object->getRepresentations(['icon', 'iconlarge', 'large']);
                    foreach($va_reps as $vn_rep_id => $va_rep){
                    	array_push($va_exhibit_media, ['id' => $t_object->get("ca_objects.object_id"), 'label' => $t_object->get("ca_objects.preferred_labels"), 'large' => [$va_rep['tags']['large'], $va_rep['urls']['large']], 'icon' => [$va_rep['tags']['iconlarge'], $va_rep['urls']['iconlarge']]]);
                    }
                    if($vs_3d_url = $t_object->get("ca_objects.3D_Scan_URL")){
                    	array_push($va_3d_scans, [$vs_3d_url, $t_object->get("ca_objects.preferred_labels")]);
                    }
                }
            }
            if(sizeof($va_exhibit_media) < 2){
            	foreach($va_exhibit_media as $va_media){
					print $va_media['large'][0];
					print "<p id='media-detail-link'><small>".caNavLink($this->request, "View full record for ".$va_media['label'], "", "Detail", "objects", $va_media['id'])."</small></p>";
				}
			} else {
				$va_first_rep = reset($va_exhibit_media);
				print '<div id="set-item-rep-wrap"><div id="set-item-rep-display"><img src="'.$va_first_rep['large'][1].'"/></div>';
				print "</div><p id='media-detail-link'><small>".caNavLink($this->request, "View full record for ".$va_first_rep['label'], "media-detail-link", "Detail", "objects", $va_first_rep['id'])."</small></p>";
				print '<hr/>';
				print '<div class="row">';
				foreach($va_exhibit_media as $va_media){
					print "<div class='col-xs-4 col-sm-3'><div class='set-thumb'><a href='#' onclick='jQuery(\"#set-item-rep-display img\").attr(\"src\", \"".$va_media['large'][1]."\"); jQuery(\".media-detail-link\").attr(\"href\", \"/index.php/Detail/objects/".$va_media['id']."\"); jQuery(\".media-detail-link\").text(\"View full record for ".$va_media['label']."\");	 return false'>".$va_media['icon'][0].'</a></div></div>';
				}
				print '</div>';
			}
			
			foreach($va_3d_scans as $va_3d){
				$vs_scan_html .= '<div class="sketchfab-embed-wrapper"><iframe width="100%" height="360" src=" '.$va_3d[0].'/embed" frameborder="0" allow="autoplay; fullscreen; vr" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe> <p style="font-size: 13px; font-weight: normal; margin: 5px; color: #4A4A4A;"> <a href="'.$va_3d[0].'?utm_medium=embed&utm_source=website&utm_campain=share-popup" target="_blank" style="font-weight: bold; color: #1CAAD9;">'.$va_3d[1].'</a> by <a href="https://sketchfab.com/mfmaritimemuseum?utm_medium=embed&utm_source=website&utm_campain=share-popup" target="_blank" style="font-weight: bold; color: #1CAAD9;">The Mel Fisher Maritime Museum</a> on <a href="https://sketchfab.com?utm_medium=embed&utm_source=website&utm_campain=share-popup" target="_blank" style="font-weight: bold; color: #1CAAD9;">Sketchfab</a> </p> </div>';
            }
            print $vs_scan_html;
?>
	        </div><!-- end galleryDetailImageArea -->
	    </div>
		<div id="set-description-text" class="col-sm-5">
			<?php print $ps_description; ?>
		</div>
	</div>