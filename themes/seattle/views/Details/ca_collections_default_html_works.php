<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
	
		<div class="container">

		
			
			<div class="row">
			
				<div class='col-md-12 col-lg-12'>
				{{{<ifdef code="ca_collections.idno"><span id="idno" style="display:none">^ca_collections.idno</span></ifdef>}}}
					<H4 style="font-size:200%;">{{{<ifdef code="ca_collections.record_group"><span id="idno" style="display:none">^ca_collections.idno</span>Series ^ca_collections.idno: </ifdef>}}}
					{{{<ifdef code="ca_collections.preferred_labels.name"><span id="collection_name">^ca_collections.preferred_labels.name</span></ifdef>}}}</H4>
					<br>
						{{{<ifdef code="ca_collections.record_group">
					<H4><span class="trimText">Record Group: ^ca_collections.record_group</span></H4><br>



				</ifdef>}}}
					{{{<ifcount code="ca_collections.related" restrictToTypes="record_group" min="1" max="1">
					
					<unit relativeTo="ca_collections"><H4>Record Group: ^ca_collections.related.preferred_labels.name</H6></unit></ifcount>}}}
				
				
				{{{<ifdef code="ca_object_lots">
					<H4><span class="trimText">Record Group: ^ca_object_lots.idno</span></H4><br>



				</ifdef>}}}
			
				
					{{{<ifdef code="ca_collections.date">
					<H4><span class="trimText">Dates: ^ca_collections.date.dates_value</span></H4><br>



				</ifdef>}}}
						{{{<ifdef code="ca_collections.extent">
					<H4><span class="trimText">Extent: ^ca_collections.extent</span></H4><br>



				</ifdef>}}}
					
						
					<H4><span id="full_description" style="display:none">{{{^ca_collections.description}}}</span></H4>
					<H4>
					<span id="short_description"><span id="just_des">{{{^ca_collections.description%length=1200}}}</span>
					
					<script>
					if (document.getElementById('just_des').innerHTML != document.getElementById('full_description').innerHTML){
					document.write("...<a href='#' onClick=\"getElementById('full_description').style.display='block';getElementById('short_description').style.display='none';\"><br>Read More</a> </span>");}
					</script>
					
					</H4>
					
					
					
					
					
					
					
					
	{{{<ifdef  code="ca_collections.external_link.url_line1" min="1"><br><H4>Finding Aids:</H4><span></ifdef >}}}


						<span id="ead" class="trimText">
						{{{<ifcount code="ca_collections.ead_link" min="1">
							<span id="eadlink" style="display:none" >^ca_collections.ead_link</span><span>
							<script>
							var link = document.getElementById('eadlink').innerHTML;
							
							
							ead_up = document.getElementById('ead');
							ead = document.createElement('a');
							ead.innerHTML = '<br> Go to full EAD Guide</a>';
							ead.href = link
							ead.style = "font-size:150%;"
							
							if (link.length >0){
							ead_up.appendChild(ead);}
							</script></span>
						</unit>		
	</ifcount>}}}</span>

	{{{<ifcount code="ca_collections.fold_link" min="1">	<br>			
							<span id="fold_link" class="trimText"><span id="link" style="display:none">^ca_collections.fold_link</span>
							<script>
							var link = document.getElementById('link').innerHTML;
						
							//document.write('<a href="'+link+'" style="font-size:150%;">'+ linkname +'</a>');
							ead_up = document.getElementById('fold_link');
							ead = document.createElement('a');
							ead.innerHTML = "Folders";
						
							ead.href = document.getElementById('link').innerHTML.replace(/&amp;/g, "&");
						
							ead.style = "font-size:150%;"
							ead_up.appendChild(ead);
							</script>
</span></ifcount>}}}
{{{<ifcount code="ca_collections.another" min="1"><span><br></ifcount>}}}<span id="external_link2">
							{{{<unit delimiter="<br/>"><span id="another" class="trimText"><a id="linkname2"  style = "font-size:150%;"href="^ca_collections.another.web_link"  >^ca_collections.another.web_name</a></unit>}}}<br></span>
							
						</span>	</H4>
					
					<br>
					
				</div><!-- end col -->
			</div><!-- end row -->
			<div>
				
				 {{{<ifdef code="ca_collections.notes"><H6>About</H6>^ca_collections.notes<br/></ifdef>}}}
				 {{{<ifcount code="ca_objects" min="1">
				<span style="font-size:200%;"><a  href="<?php echo __CA_URL_ROOT__?>/index.php/Search/advanced/objects" onClick="collectionSearch();">Search</a> or
				<a  href="<?php echo __CA_URL_ROOT__?>/index.php/Search/objects/search/collection%3A^ca_collections.idno" onClick="collectionSearch();">Browse</a>

				items available within this collection </span>
<script>
  function collectionSearch() { 

localStorage.clear();
  localStorage.setItem("collection_name", document.getElementById("idno").innerHTML);}
 

</script>	
<br><br>	
</ifcount>}}}


	
{{{<ifcount code="ca_collections.lcsh_terms" min="1"><H4>Library of Congress Terms:</H4></ifcount>}}}<br>
							{{{<unit delimiter="<br/>"><span class="trimText" id="loc" style="color:#262626;font-size:150%;">^ca_collections.lcsh_terms</span></unit>}}}
							
<script>
//var lsch = document.getElementById('loc').innerHTML.find('li').text();
//document.write(lsch[0]);
 

</script>								
</div>
			<div class="row">			
				
								
					
					<div class='col-md-6 col-lg-6'>
					{{{<ifdef code="ca_collections.notes"><H6>About</H6>^ca_collections.notes<br/></ifdef>}}}
					{{{<ifcount code="ca_objects" min="1" max="1"><H6>Related object</H6><unit relativeTo="ca_objects" delimiter=" "><l>^ca_object_representations.media.small</l><br/><l>^ca_objects.preferred_labels.name</l><br/></unit></ifcount>}}}
					<div id="detailTools">
						
					</div><!-- end detailTools -->
					
				</div><!-- end col -->
					
				
				<div class='col-md-6 col-lg-6'>
					
					
					
					{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}					
				</div><!-- end col -->
			</div><!-- end row -->


		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
