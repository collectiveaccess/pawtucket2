<?php
	$va_analytics_facets = $this->getVar("analytics_facets");
	
	$vn_total_objects = $this->getVar("totalRecordsAvailable");
	$va_analytics_chart_facets = $this->getVar("analytics_chart_facets");
     // Define the custom sort function
     function custom_sort($a,$b) {
          return strtolower($a['label'])>strtolower($b['label']);
     }
?>
<div class="row">
	<div class="col-sm-10 col-md-10 col-sm-offset-1">
		<div class="pull-right detailTool generalToolSocial">
			<a href='https://twitter.com/home?status=http%3A//fabricofdigitallife.com<?php print caNavUrl($this->request, '', 'Analytics', 'Index'); ?>'><i class="fa fa-twitter-square" aria-hidden="true"></i></a>
			<a href='https://www.facebook.com/sharer/sharer.php?u=http%3A//fabricofdigitallife.com<?php print caNavUrl($this->request, '', 'Analytics', 'Index'); ?>'><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
			<a href='https://plus.google.com/share?url=http%3A//fabricofdigitallife.com<?php print caNavUrl($this->request, '', 'Analytics', 'Index'); ?>'><i class="fa fa-google-plus-square" aria-hidden="true"></i></a>
		</div><!-- end detailTool -->
		<H1><?php print _t("Analytics"); ?></H1>
	</div>
</div>
<div class="row">
	<div class="col-sm-10 col-md-6 col-sm-offset-1">
		<div class="analyticsBody">
<?php
			print caGetThemeGraphic($this->request, 'bodySm2.jpg');
			# not on the body
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 378), array('style' => 'left:38%; top:2%; width:20%;')); 
			# entire body
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 316), array('style' => 'left:38%; top:5.7%; width:20%;')); 
			# eye
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 287), array('style' => 'left:13%; top:10.3%; width:8%;')); 
			# ear
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 288), array('style' => 'left:25%; top:15.3%; width:8%;')); 
			# brain
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 357), array('style' => 'left:65%; top:12%; width:8%;')); 
			# head
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 200), array('style' => 'left:79%; top:9%; width:8%;')); 
			# jaw
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 284), array('style' => 'left:80%; top:11%; width:10%;')); 
			# nose
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 289), array('style' => 'left:80%; top:13%; width:10%;')); 
			# throat
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 293), array('style' => 'left:80%; top:15%; width:10%;')); 
			# cheek
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 285), array('style' => 'left:80%; top:17%; width:10%;')); 
			# forehead
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 283), array('style' => 'left:80%; top:19%; width:12%;')); 
			# face
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 360), array('style' => 'left:80%; top:21%; width:10%;')); 
			# chin
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 286), array('style' => 'left:80%; top:23%; width:10%;')); 
			# mouth
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 290), array('style' => 'left:13%; top:20.3%; width:10%;')); 
			# teeth
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 291), array('style' => 'left:13%; top:23%; width:10%;')); 
			# toungue
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 292), array('style' => 'left:13%; top:25%; width:10%;')); 
			# back
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 315), array('style' => 'left:13%; top:30.5%; width:10%;')); 
			# skin
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 358), array('style' => 'left:17%; top:35%; width:10%;')); 
			# neck
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 270), array('style' => 'left:55%; top:19%; width:10%;')); 
			# thorax
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 301), array('style' => 'left:55%; top:21%; width:10%;')); 
			# shoulder
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 294), array('style' => 'left:73%; top:29%; width:12%;')); 
			# heart
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 386), array('style' => 'left:66%; top:33%; width:10%;')); 
			# arm
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 202), array('style' => 'left:69%; top:39%; width:10%;')); 
			# elbow
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 295), array('style' => 'left:69%; top:41.5%; width:10%;')); 
			# abdomen
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 204), array('style' => 'left:73%; top:44.5%; width:12%;')); 
			# waist
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 303), array('style' => 'left:75%; top:47%; width:10%;')); 
			# stomach
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 390), array('style' => 'left:75%; top:49%; width:10%;')); 
			# digestive tract
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 391), array('style' => 'left:75%; top:51%; width:15%;')); 
			# wrist
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 296), array('style' => 'left:76%; top:54%; width:10%;')); 
			# hand
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 297), array('style' => 'left:71%; top:65.5%; width:10%;')); 
			# leg
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 306), array('style' => 'left:58%; top:60%; width:10%;')); 
			# hip
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 205), array('style' => 'left:58%; top:62.5%; width:10%;')); 
			# groin
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 304), array('style' => 'left:58%; top:64.5%; width:10%;')); 
			# thigh
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 307), array('style' => 'left:58%; top:66.5%; width:10%;')); 
			# calf
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 309), array('style' => 'left:58%; top:68.5%; width:10%;')); 
			# ankle
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 311), array('style' => 'left:63%; top:74%; width:10%;')); 
			# foot
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 312), array('style' => 'left:65%; top:84%; width:10%;')); 
			# toe
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 313), array('style' => 'left:45%; top:88.5%; width:10%;')); 
			# torso
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 203), array('style' => 'left:13%; top:40%; width:10%;')); 
			# breast
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 302), array('style' => 'left:13%; top:42%; width:10%;')); 
			# chest
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 300), array('style' => 'left:13%; top:44%; width:10%;')); 
			# lungs
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 387), array('style' => 'left:13%; top:46%; width:10%;')); 
			# thumb
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 299), array('style' => 'left:11%; top:53%; width:10%;')); 
			# finger
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 298), array('style' => 'left:10%; top:56%; width:10%;')); 
			# buttock
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 305), array('style' => 'left:13%; top:63%; width:10%;')); 
			# genitals
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 389), array('style' => 'left:13%; top:70%; width:10%;')); 
			# knee
			print caNavLink($this->request, '&nbsp;', '', '', 'Browse', 'objects', array('facet' => 'locationOnBody', 'id' => 308), array('style' => 'left:15%; top:78%; width:10%;')); 
			
?>
		</div>
	</div>
	<div class="col-sm-10 col-md-4">
		<div class="analyticsChartCol">
<?php
	$vn_c = 1;
	if(is_array($va_analytics_chart_facets) && sizeof($va_analytics_chart_facets)){
		foreach($va_analytics_chart_facets as $va_analytics_chart_facet){
			print "<H2>".$va_analytics_chart_facet["label_singular"]."</H2>";
			print "<div class='ct-chart".$vn_c."'></div>";
			# --- prepare data for chart - labels and counts
			$va_chart_data = array("labels" => array(), "series" => array());
			foreach($va_analytics_chart_facet["content"] as $va_content){
				$va_chart_data["labels"][] = "'".$va_content["label"]."'";
				if($va_content["children"]){
					$vn_child_count_rel_objects = 0;
					foreach($va_content["children"] as $vn_child_term_id => $va_child_facet){
						$vn_child_count_rel_objects += $va_child_facet["content_count"];
					}
					$va_chart_data["series"][] = $vn_child_count_rel_objects;
				}else{
					$va_chart_data["series"][] = $va_content["content_count"];
				}
				
			}
			
?>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					new Chartist.Bar('.ct-chart<?php print $vn_c; ?>', {
					  labels: [<?php print join(", ", $va_chart_data["labels"]); ?>],
					  series: [<?php print join(", ", $va_chart_data["series"]); ?>]
					}, {
					  distributeSeries: true
					});
				});
			</script>
<?php
			$vn_c++;
		}
	}
?>
		
<!--		<div class="ct-chart">
		
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				new Chartist.Bar('.ct-chart', {
				  labels: ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'],
				  series: [20, 60, 120, 200, 180, 20, 10]
				}, {
				  distributeSeries: true
				});
			});
		</script>
		<div class="ct-chart-pie">
		
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				var data = {
				  labels: ['5', '3', '4'],
				  series: [5, 3, 4]
				};

				var sum = function(a, b) { return a + b };

				new Chartist.Pie('.ct-chart-pie', data, {
				  labelInterpolationFnc: function(value) {
					return Math.round(value / data.series.reduce(sum) * 100) + '%';
				  }
				});
			});
		</script>
-->		
		</div><!-- end analyticsChartCol -->
	</div>
</div>
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
<?php
		if(is_array($va_analytics_facets["use"]) && sizeof($va_analytics_facets["use"])){
			$vs_facet_name = "use";
			print "<H2>".$va_analytics_facets["use"]["label_singular"]."</H2>";
			print "<div class='row'>";
			foreach($va_analytics_facets["use"]["content"] as $vn_index => $va_facet){
				print "<div class='col-md-2 col-sm-12'>".caNavLink($this->request, $va_facet["label"].(($va_facet["content_count"]) ? " (".$va_facet["content_count"].")" : ""), 'platformLink', '', 'Browse', 'objects', array('facet' => $vs_facet_name, 'id' => $va_facet["id"]))."</div>";
			}
			print "</div>";
		}
?>
	</div>
</div>
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="row">
<?php
		if(is_array($va_analytics_facets) && sizeof($va_analytics_facets)){
			$vn_c = 0;
			foreach($va_analytics_facets as $vs_facet_name => $va_facet_content){
				if($vs_facet_name == "use"){
					continue;
				}
				if($vn_c == 0){
					print "<div class='col-md-3 col-xs-12'>";
				}
				print "<H2>".$va_facet_content["label_singular"]."</H2>";
				print "<div class='analyticsFacetBlock'>";
				usort($va_facet_content["content"], "custom_sort");
				foreach($va_facet_content["content"] as $vn_index => $va_facet){
					print "<div>".caNavLink($this->request, ucfirst($va_facet["label"]).(($va_facet["content_count"]) ? " (".$va_facet["content_count"].")" : ""), '', '', 'Browse', 'objects', array('facet' => $vs_facet_name, 'id' => $va_facet["id"]))."</div>";
					if(in_array($vs_facet_name, array("analytics_has_related_objects_facet", "analytics_has_related_entities_facet"))){
						break;
					}
					if($va_facet["children"]){
						foreach($va_facet["children"] as $vn_child_term_id => $va_child_facet){
							print "<div class='analyticsHierChild'>".caNavLink($this->request, ucfirst($va_child_facet["label"]).(($va_child_facet["content_count"]) ? " (".$va_child_facet["content_count"].")" : ""), '', '', 'Browse', 'objects', array('facet' => $vs_facet_name, 'id' => $vn_child_term_id))."</div>";
						}
					}
				}
				print "</div><!-- end analyticsFacetBlock-->";
				$vn_c++;
				if($vn_c == 3){
					print "</div>";
					$vn_c = 0;
				}
			}
			# --- catch trailing col divs
			if($vn_c > 0){
				print "</div>";
			}
		}
?>
			<br/><br/>
		</div>
	</div>
</div>