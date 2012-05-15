<?php
	$t_subject = $this->getVar('t_subject');
?>
<div style="width: 100%; height: 100%; border: 0px; background-color: #FFFFFF;" id="infovis"> </div>

<script type="text/javascript">
	var labelType, useGradients, nativeTextSupport, animate;
		var ht;
		
		(function() {
		  var ua = navigator.userAgent,
			  iStuff = ua.match(/iPhone/i) || ua.match(/iPad/i),
			  typeOfCanvas = typeof HTMLCanvasElement,
			  nativeCanvasSupport = (typeOfCanvas == 'object' || typeOfCanvas == 'function'),
			  textSupport = nativeCanvasSupport 
				&& (typeof document.createElement('canvas').getContext('2d').fillText == 'function');
		  //I'm setting this based on the fact that ExCanvas provides text support for IE
		  //and that as of today iPhone/iPad current text support is lame
		  labelType = (!nativeCanvasSupport || (textSupport && !iStuff))? 'Native' : 'HTML';
		  nativeTextSupport = labelType == 'Native';
		  useGradients = nativeCanvasSupport;
		  animate = !(iStuff || !nativeCanvasSupport);
		})();
		
		function init(json){
			//init data
			//end
			var infovis = document.getElementById('infovis');
			var w = infovis.offsetWidth - 50, h = infovis.offsetHeight - 50;
			
			//init Hypertree
			 ht = new $jit.Hypertree({
			  //id of the visualization container
			  injectInto: 'infovis',
			  //canvas width and height
			  width: w,
			  height: h,
			  duration: 700,
			  offset: 0.0,
			  
			  //Change node and edge styles such as
			  //color, width and dimensions.
			  Node: {
				  dim: 8,
				  color: "#882222"
			  },
			  Edge: {
				  lineWidth: 1,
				  color: "#828282"
			  },
			  onBeforeCompute: function(node){
				 // noop
			  },
			  //Attach event handlers and add text to the
			  //labels. This method is only triggered on label
			  //creation
			  onCreateLabel: function(domElement, node){
				  domElement.innerHTML = node.name;
				  $jit.util.addEvent(domElement, 'click', function () {
					  ht.onClick(node.id, {
						  onComplete: function() {
							  ht.controller.onComplete();
						  }
					  });
				  });
			  },
			  //Change node styles when labels are placed
			  //or moved.
			  onPlaceLabel: function(domElement, node){
				  var style = domElement.style;
				  style.display = '';
				  style.cursor = 'pointer';
				   if (node._depth == 0) {
					  domElement.setAttribute("class", "visLevel1");
		
				  }else if (node._depth == 1) {
					  domElement.setAttribute("class", "visLevel2");
		
				  } else if(node._depth == 2){
					  domElement.setAttribute("class", "visLevel3");
		
				  } else {
					  style.display = 'none';
				  }
		
				  var left = parseInt(style.left);
				  var w = domElement.offsetWidth;
				  style.left = (left - w / 2) + 'px';
			  },
			  
			  onComplete: function() {
					var node = ht.root;
					var x = node.split("_");
					jQuery.getJSON('<?php print caNavUrl($this->request, 'Detail', $this->request->getController(), 'getRelationshipsAsJSON');?>', { id: x[2], table:x[0]+"_"+x[1]}, function(data) {
						var new_id = data.id;
						//console.log(data);
						ht.op.sum(data, {  
						  type: 'fade:seq',  
						  duration: 300,  
						  hideLabels: false,  
						  fps: 24,
						  transition: $jit.Trans.Quart.easeOut,
						  onComplete: function() { 
							// noop
							ht.root = new_id;
						  },
						  id: new_id
						});
						
						
					});
				},
			  
				Events: {
					enable: true,
					  onClick: function(node, eventInfo, e) {
						if (node) {
							if (ht.root == node.id) {
								var u = '<?php print caNavUrl($this->request, 'Detail', '^detail', 'Index', array('^key' => ''));?>';
								u = u.replace('^detail', node.data.detail);
								u = u.replace('^key', node.data.key);
								u = u + node.data.id;
								window.location = u;
							} else {
								ht.root = node.id;
							}
						}
					  }
				}
			});
			//load JSON data.
			ht.loadJSON(json);
			//compute positions and plot.
			ht.refresh();
			//end
			ht.controller.onComplete();
		}
		
		jQuery(document).ready(function() {
			jQuery.getJSON('<?php print caNavUrl($this->request, 'Detail', $this->request->getController(), 'getRelationshipsAsJSON', array('table' => $t_subject->tableName(), 'id' => $t_subject->getPrimaryKey())); ?>', init); 
		});
</script>