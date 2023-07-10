<?php
global $request, $cur_entity_id;
$request = $this->request;

$t_entity = $this->getVar("item");
$cur_entity_id = $t_entity->getPrimaryKey();

AssetLoadManager::register('visnetwork');


if(!function_exists('_getRelsForEntity')) {
	function _getRelsForEntity($t_entity, $entity_nodes, $entity_edges, $level) {
		global $request, $cur_entity_id;
	
		if($level > 2) {
			return ['nodes' => $entity_nodes, 'edges' => $entity_edges];
		}
	
		$rel_entities = $t_entity->getRelatedItems('ca_entities');
		if(sizeof($rel_entities)  == 0) { 
			return; 
		}
	
		$entity_id = $t_entity->getPrimaryKey();
	
		if(is_array($rel_entities)) {
			foreach($rel_entities as $e) {
				if(!isset($entity_nodes[$e['entity_id']])) {
					$entity_nodes[$e['entity_id']] = [
						'shape' => 'box',
						'physics' => true,
						'margin' => 15,
						'color' => [
							'border' => ((int)$cur_entity_id == (int)$e['entity_id']) ? "#DF7137" : '#000',
							'background' => ((int)$cur_entity_id == (int)$e['entity_id']) ? "#DF7137" : '#ccc',
							'highlight' => '#999'
						],
						'id' => $e['entity_id'],
						'label' => $e['label'], 
						'url' => caDetailUrl($request, 'ca_entities', $e['entity_id'])	// URL of detail for entity represented by node
					];
				}
				$is_dupe = false;
				foreach($entity_edges as $rel) {
					if(
						(($rel['from'] == $entity_id) && ($rel['to'] == $e['entity_id']))
						||
						(($rel['to'] == $entity_id) && ($rel['from'] == $e['entity_id']))
					) {
						$is_dupe = true;
						break;
					}
				}
				
				if(!$is_dupe) {
					$entity_edges[] = [
						'from' => $entity_id,
						'to' => $e['entity_id']
					];
				}
			
				$t_rel_entity = new ca_entities($e['entity_id']);
				$x= _getRelsForEntity($t_rel_entity, $entity_nodes, $entity_edges, $level + 1);
			
				$entity_nodes = $x['nodes'];
				$entity_edges = $x['edges'];
			}
		}
	
		return ['nodes' => $entity_nodes, 'edges' => $entity_edges];
	}
}

$data = _getRelsForEntity($t_entity, [], [], 0);

if(is_array($data) && is_array($data['nodes']) && (sizeof($data['nodes']) > 1)) { 
?>
<div id="entityRelationshipViz"></div>
<?= "<div class='text-right'>".caDetailLink($this->request, '<span class="glyphicon glyphicon-zoom-in" role="button" aria-label="Zoom"></span>', "vizZoom", "ca_entities", $cur_entity_id, array("mode" => "visualization"))."</div>"; ?>
					
<script>
	// create an array with nodes
	var nodes = new vis.DataSet(<?= json_encode(array_values($data['nodes'])); ?>);

	// create an array with edges
	var edges = new vis.DataSet(<?= json_encode(array_values($data['edges'])); ?>);

	// create a network
	var container = document.getElementById("entityRelationshipViz");
	var data = {
	  nodes: nodes,
	  edges: edges,
	};
	var options = {
		layout: {
			randomSeed: 100
		}
	};
	var network = new vis.Network(container, data, options);
	
	// Navigate to detail of related entity which node is double-clicked
	network.on("doubleClick", function (params) {
		if (params.nodes.length === 1) {
			var node = nodes.get(params.nodes[0]);
			if(node.url != null) {
				window.open(node.url);
			}
		}
 	});
</script>
<?php
}