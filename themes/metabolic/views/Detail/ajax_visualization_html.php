<?php
	$t_subject = $this->getVar('t_subject');
?>
<div style="width: 100%; height: 100%; border: 0px; background-color: #FFFFFF;" id="infovis"> </div>

<script type="text/javascript">
	function init() {
		var w = jQuery('#infovis').width();
		var h = jQuery('#infovis').height();
		
		var margin = {top: 20, right: 120, bottom: 20, left: 120},
		width = w - margin.right - margin.left,
		height = h - margin.top - margin.bottom,
		i = 0,
		duration = 500,
		root;
		
		var openNodes = {};
	
		var tree = d3.layout.tree()
			.size([height, width]);
		
		var diagonal = d3.svg.diagonal()
			.projection(function(d) { return [d.y, d.x]; });
		
		var vis = d3.select("#infovis").append("svg")
			.attr("width", width + margin.right + margin.left)
			.attr("height", height + margin.top + margin.bottom)
		  .append("g")
			.attr("transform", "translate(" + margin.left + "," + margin.top + ")");
		
		d3.json("<?php print caNavUrl($this->request, 'Detail', $this->request->getController(), 'getRelationshipsAsJSON', array('table' => $t_subject->tableName(), 'id' => $t_subject->getPrimaryKey(), 'download' => 1)); ?>", function(json) {
		
		  root = json;
		  root.x0 = height / 2;
		  root.y0 = 0;
		
		  function collapse(d) {
			if (d.children) {
			  d._children = d.children;
			  d._children.forEach(collapse);
			  d.children = null;
			}
		  }
		
		  root.children.forEach(collapse);
		  update(root);
		});
		
		function update(source) {
		
		  // Compute the new tree layout.
		  var nodes = tree.nodes(root).reverse();
		
		  // Normalize for fixed-depth.
		  nodes.forEach(function(d) { d.y = d.depth * 240; });
		
		  // Update the nodes…
		  var node = vis.selectAll("g.node")
			  .data(nodes, function(d) { return d.id || (d.id = ++i); });
		
		  // Enter any new nodes at the parent's previous position.
		  var nodeEnter = node.enter().append("g")
			  .attr("class", "node")
			  .attr("transform", function(d) { return "translate(" + source.y0 + "," + source.x0 + ")"; })
			  .on("click", click)
			  .on("dblclick", dblclick);
		
		  nodeEnter.append("circle")
			  .attr("r", 1e-6)
			  .style("fill", function(d) { return d._children ? "lightsteelblue" : "#fff"; });
		
		  nodeEnter.append("text")
			  .attr("x", function(d) { return d.children || d._children ? -10 : 10; })
			  .attr("dy", ".35em")
			  .attr("text-anchor", function(d) { return d.children || d._children ? "end" : "start"; })
			  .text(function(d) { return d.name; })
			  .style("fill-opacity", 1e-6);
		
		  // Transition nodes to their new position.
		  var nodeUpdate = node.transition()
			  .duration(duration)
			  .attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; });
		
		  nodeUpdate.select("circle")
			  .attr("r", 4.5)
			  .style("fill", function(d) { return d._children ? "lightsteelblue" : "#fff"; });
		
		  nodeUpdate.select("text")
			  .style("fill-opacity", 1);
		
		  // Transition exiting nodes to the parent's new position.
		  var nodeExit = node.exit().transition()
			  .duration(duration)
			  .attr("transform", function(d) { return "translate(" + source.y + "," + source.x + ")"; })
			  .remove();
		
		  nodeExit.select("circle")
			  .attr("r", 1e-6);
		
		  nodeExit.select("text")
			  .style("fill-opacity", 1e-6);
		
		  // Update the links…
		  var link = vis.selectAll("path.link")
			  .data(tree.links(nodes), function(d) { return d.target.id; });
		
		  // Enter any new links at the parent's previous position.
		  link.enter().insert("path", "g")
			  .attr("class", "link")
			  .attr("d", function(d) {
				var o = {x: source.x0, y: source.y0};
				return diagonal({source: o, target: o});
			  });
		
		  // Transition links to their new position.
		  link.transition()
			  .duration(duration)
			  .attr("d", diagonal);
		
		  // Transition exiting nodes to the parent's new position.
		  link.exit().transition()
			  .duration(duration)
			  .attr("d", function(d) {
				var o = {x: source.x, y: source.y};
				return diagonal({source: o, target: o});
			  })
			  .remove();
		
		  // Stash the old positions for transition.
		  nodes.forEach(function(d) {
			d.x0 = d.x;
			d.y0 = d.y;
		  });
		}
		
		// Toggle children on click.
		function click(d) {
		  if (d.children) {
		  	openNodes[d.id] = undefined;
			d._children = d.children;
			d.children = null;
		  } else {
		  	if (!d._children) {
		  		var tmp = d.id.split('_');
		  		console.log("Load via json children for " + tmp[0] + '_' + tmp[1] + '/' + tmp[2]); 
		  		jQuery.getJSON('<?php print caNavUrl($this->request, 'Detail', $this->request->getController(), 'getRelationshipsAsJSON'); ?>/table/' + tmp[0] + '_' + tmp[1] + '/id/' + tmp[2] + '/download/1', function(json) {
		  			d.children = json.children;
		  			openNodes[d.id] = d;
		  			update(d);
		  		}); 
		  		return;
		  	}
			d.children = d._children;
			d._children = null;
			openNodes[d.id] = d;
		  }
		  update(d);
		}
		
		function dblclick(d) {
			var u = '<?php print caNavUrl($this->request, 'Detail', '^detail', 'Index', array('^key' => ''));?>';
			u = u.replace('^detail', d.data.detail);
			u = u.replace('^key', d.data.key);
			u = u + d.data.id;
			window.location = u;
		}

	}	
	jQuery(document).ready(function() {
		init();
		//jQuery.getJSON('<?php print caNavUrl($this->request, 'Detail', $this->request->getController(), 'getRelationshipsAsJSON', array('table' => $t_subject->tableName(), 'id' => $t_subject->getPrimaryKey())); ?>', init); 
	});
</script>