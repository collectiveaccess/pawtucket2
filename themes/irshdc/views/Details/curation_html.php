				{{{<ifdef code="ca_objects.description.curatorial_desc_value">
					<div class='unit'><h6>Description</h6>
					<div class="unit" data-toggle="popover" data-placement="left" data-trigger="hover" title="Source" data-content="^ca_objects.curatorial_description.curatorial_desc_source"><h6>Description</h6>
						<span class="trimText">^ca_objects.description.curatorial_desc_value</span>
					</div>
				</ifdef>}}}
				{{{<ifcount code="ca_entities.related" restrictToTypes="school" restrictToRelationshipTypes="related" min="1"><HR/><H6>Related school(s)</H6><unit relativeTo="ca_objects_x_entities" restrictToTypes="school" restrictToRelationshipTypes="related" delimiter=", "><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels.displayname</l></unit> (^relationship_typename)</unit></ifcount>}}}
		{{{<ifdef code="ca_objects.narrative_thread|ca_objects.theme|ca_objects.genre|ca_objects.keywords"><HR/></ifdef>}}}
				{{{<ifdef code="ca_objects.narrative_thread"><div class='unit'><h6>Narrative thread(s)</h6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.narrative_thread</unit></div></ifdef>}}}
				{{{<ifdef code="ca_objects.genre"><div class='unit'><h6>Genre(s)</h6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.genre</unit></div></ifdef>}}}
				{{{<ifdef code="ca_objects.keywords"><div class='unit'><h6>Keywords</h6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.keywords</unit></div></ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.historical_note|ca_objects.curators_comments.comments|ca_objects.community_input_objects.comments_objects"><HR/></ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.historical_note.historical_note_value">
					<div class="unit" data-toggle="popover" data-placement="left" data-trigger="hover" title="Source" data-content="^ca_objects.historical_note.historical_note_source"><h6>Contextual note</h6>
						<span class="trimText">^ca_objects.historical_note.historical_note_value</span>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.curators_comments.comments">
					<div class="unit" data-toggle="popover" data-placement="left" data-trigger="hover" title="Source" data-content="^ca_objects.curators_comments.comment_reference"><h6>Curatorial comment</h6>
						<span class="trimText">^ca_objects.curators_comments.comments</span>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_objects.community_input_objects.comments_objects">
					<div class='unit' data-toggle="popover" data-placement="left" data-trigger="hover" title="Source" data-content="^ca_objects.community_input_objects.comment_reference_objects"><h6>Community input</h6>
						<span class="trimText">^ca_objects.community_input_objects.comments_objects</span>
					</div>
				</ifdef>}}}