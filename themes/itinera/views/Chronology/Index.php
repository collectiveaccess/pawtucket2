<div id='travelerList' class='clearfix'>
	
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="page-header">
				<h1 id="timeline">Chronology</h1>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="page-header" id="chronoline">
				<!--<label>Zoom Factor <input id="zoom-factor" type="text" value="2"></label><input id="zoom" type="button" value="Zoom" />-->
				<div id="travelerTimeline" class="timeline-tgt">
      				
      			</div>
			</div>
		</div>		
    </div>
</div>
<div class="container timelineContainer"><div class="moreArrowRight">Scroll for more <i class='glyphicon glyphicon-chevron-right'></i></div>
    <div class="row" id="travelerContentTimelineColumns">
<?php
	# load traveler cols here
?>    	   
    </div><!-- end row -->
</div>
<script type="text/javascript">
	jQuery(document).ready(function() {
		
		// Load traveler index via ajax
		jQuery("#travelerList").load('<?php print caNavUrl($this->request, '*', '*', 'TravelerIndex'); ?>');
		
		// Load traveler columns
		jQuery("#travelerContentTimelineColumns").load('<?php print caNavUrl($this->request, '*', '*', 'Get'); ?>');
		
		
	});
</script>



   
	<script type="text/javascript">
      
     	function renderTimeline(events, start, end, yearSpan){
     		if(!yearSpan){
     			yearSpan = 10;
     		}
      		jQuery("#travelerTimeline").html("");
      		var label = "year";
      		if(yearSpan > 50){
      			label = "decade";
      		}
      		if(yearSpan > 700){
      			label = "century";
      		}
      		var timeline = new Chronoline(document.getElementById("travelerTimeline"), events,
				{
					visibleSpan: DAY_IN_MILLISECONDS * 365 * yearSpan,
					animated: true,
					tooltips: true,
					defaultStartDate: start,
					startDate: start,
					endDate: end,
					sectionLabelAttrs: {'fill': '#997e3d', 'font-weight': 'bold'},
					labelInterval: isHalfMonth,
					hashInterval: isHalfMonth,
					scrollLeft: prevQuarter,
					scrollRight: nextQuarter,
					markToday: 'labelBox',
					draggable: true,
					subLabel: null,
					subSubLabel: label,
					scrollable: false,
					topMargin:1
				}
			);
	  
			$('#zoom').click(function() {
				timeline.zoom(parseFloat($('#zoom-factor').val()));
			});
      }
</script>