<?php
	$t_subject = $this->getVar('t_subject');
	
?>

<div class="container">
	<div class="row collection">
		<div class="col-sm-6">	
			<div class="contributeForm">
				<h1>Search Collection</h1>
				{{{form}}}

					<div class="contributeField">
						Title:<br/>
						{{{ca_objects.preferred_labels.name%width=220px}}}
					</div>
					<div class="contributeField">
						Accession number:<br/>
						{{{ca_objects.idno%width=200px}}}
					</div>
					<div class="contributeField">
						Artist:<br/>
						{{{ca_entities.preferred_labels.displayname%width=220px&height=40px}}}
					</div>
					<div class="contributeField">
						Date:<br/>
						{{{ca_objects.date%width=220px}}} 
					</div>

					<br style="clear: both;"/>

					<div style="float: right; margin-left: 20px;">{{{reset%label=Reset}}}</div>
					<div style="float: right;">{{{submit%label=Save}}}</div>
				{{{/form}}}
				<div class='clearfix'></div>
			</div>
		</div>
	</div>
</div>