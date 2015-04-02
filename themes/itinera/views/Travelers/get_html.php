<?php
	require_once(__CA_MODELS_DIR__.'/ca_entities.php');
	$vn_entity_id = $this->request->getParameter('id', pInteger);
	
	$t_entity = new ca_entities($vn_entity_id);
	//print "NAME=".$t_entity->get('ca_entities.preferred_labels.displayname');
	//print join("<br>\n", ($t_entity->get('ca_tour_stops.preferred_labels.name', ['returnAsArray' => true])));
?>

<div id="viz">

</div>

<script type="text/javascript">
	var mode = 'circular';
	var radius = 700 / 2;
	var current_id = <?php print (int)$vn_entity_id; ?>;

	var cluster = d3.layout.cluster()
		.size([360, radius - 120]);

	//var diagonal = d3.svg.diagonal.radial()
	var diagonal = (mode == 'circular') ?
		d3.svg.diagonal.radial().projection(function(d) { return [d.y, d.x / 180 * Math.PI]; })
		:
		d3.svg.diagonal().projection(function(d) { return [d.y, d.x]; });


	var svg = d3.select("#viz").append("svg")
		.attr("width", radius * 2)
		.attr("height", radius * 2)
	  .append("g")
		.attr("transform", "translate(" + radius + "," + radius + ")");

	var draw = function(error, root) {
	  var nodes = cluster.nodes(root);
	  
		var linkSel = svg.selectAll("path.link")
			.data(cluster.links(nodes));

		linkSel.exit().transition().style("opacity", 0).remove();
		
		var link = linkSel.enter().append("path")
			.attr("class", "link")
			.attr("d", diagonal);
			
		linkSel.transition()
			.attr("d", diagonal);

		var nodeSel = svg.selectAll("g.node")
		  .data(nodes, function(d) { return d.id; });
		  
		nodeSel.exit().transition().style("opacity", 0).remove();
		
		var node = nodeSel
			.enter().append("g")
			.attr("class", "node");

		if (mode == 'circular') {
			nodeSel.transition().attr("transform", function(d) { return "rotate(" + (d.x - 90) + ")translate(" + d.y + ")"; });
		} else {
			nodeSel.transition().attr("transform", function(d) { return "translate(" + d.y + " " + d.x +")"; });
		}
		
		nodeSel.selectAll("text").text(function(d) { return d.name; })
			.style("fill", function(d) { return (d.id == current_id) ? "#cc0000" : "#000"; })
			.style("font-weight", function(d) { return (d.id == current_id) ? "bold" : "normal"; });
		
		node.append("circle")
			.attr("r", 4.5).on('click', function(e) { 
				current_id = e.id;
				d3.json('<?php print caNavUrl($this->request, '*', '*', 'GetData', array('download' => 1)); ?>/id/' + current_id, draw);
				jQuery('#travelerCard').fadeOut(250).load('<?php print caNavUrl($this->request, '*', '*', 'GetCard', array('download' => 1)); ?>/id/' + current_id, function() {
					jQuery(this).fadeIn(250);
				});
			});

		node.append("text")
			.attr("dy", ".31em")
			.attr("text-anchor", function(d) { return (mode == 'circular') ? (d.x < 180 ? "start" : "end") : "start"; })
			.attr("transform", function(d) { return (mode == 'circular') ? (d.x < 180 ? "translate(8)" : "rotate(180)translate(-8)") : "translate(8)"; })
			.style("font-weight", function(d) { return (d.id == current_id) ? "bold" : "normal"; })
			.text(function(d) { return d.name; });
			
		  
	};
	d3.json('<?php print caNavUrl($this->request, '*', '*', 'GetData', array('id' => $vn_entity_id, 'download' => 1)); ?>', draw);
	jQuery('#travelerCard').load('<?php print caNavUrl($this->request, '*', '*', 'GetCard', array('id' => $vn_entity_id, 'download' => 1)); ?>');

	d3.select(self.frameElement).style("height", radius * 2 + "px");

</script>