
<div class="row">
	<div class="col-sm-12 " style='border-right:1px solid #ddd;'>
		<h1>About the Dutch Colonial Records Digitization Project</h1>

{{{form}}}

<div class='advancedContainer' style='padding-bottom:10px;'>
	<div class='row'>
		<div class="col-sm-6">
			<div class='menuLink first'><?php print caNavLink($this->request, 'Browse', '', '', 'Search', 'advanced/dutch'); ?></div> | 
			<div class='menuLink'><?php print 'About the Project'; ?></div> | 
			<div class='menuLink'><?php print caNavLink($this->request, 'Related Resources', '', '', 'Search', 'advanced/dutch_related'); ?></div>
		</div>
		<div class="advancedSearchField dutch col-sm-4">
			<span class='formLabel' data-toggle="popover" data-trigger="hover" data-content="Search across all fields in the database.">Search Dutch Colonial Records</span>
			{{{_fulltext%width=200px&height=1}}}<span class='btn btn-default' >{{{submit%label=Search}}}</span>
		</div>		
	</div>		
</div>	

{{{/form}}}

	</div>
</div><!-- end row -->

<div class="container">
	<div class="row">
		<div class="col-sm-12 bodytext">
			{{{dutchAbout}}}		
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->
<div class="container">
	<div class="row">
		<div class="col-sm-12 linktext">
			<h2>About Our Partners</h2>
			<table>
				<tr>
					<td><?php print caGetThemeGraphic($this->request, 'holland-dames-logo.jpg');?></td>
					<td style='width:200px;'><a href='#' type="button" data-toggle="modal" data-target="#linkModal" data-whatever="<a href='http://www.hollanddames.org/' target='_blank'>http://www.hollanddames.org/</a>">The Society of Daughters of Holland Dames <i class='fa fa-external-link'></i></a></td>
					<td>The Society of Daughters of Holland Dames was founded in 1895 by women who were descendants of the seventeenth-century Dutch of New Netherland. Since its establishment, the Society has worked to promote a broad understanding of the history, virtues and achievements of those ancestors and settlers. The Holland Dames does this in a variety of ways, including collecting and preserving genealogical and historical documents relating to the Dutch in America, establishing commemorative memorials in lasting tribute to the early Dutch and encouraging excellence in historical research relating to the Dutch in America.</td>
				</tr>
				<tr>
					<td><?php print caGetThemeGraphic($this->request, 'logo-rijksoverheid-en.jpg');?></td>
					<td style='width:200px;'><a href='#' type="button" data-toggle="modal" data-target="#linkModal" data-whatever="<a href='http://en.nationaalarchief.nl/' target='_blank'>http://en.nationaalarchief.nl/</a>">National Archives of the Netherlands <i class='fa fa-external-link'></i></a></td>
					<td>The Nationaal Archief (Dutch National Archives) is the ‘national memory’ of the Netherlands. The Archives holds 125 kilometres of documents, photos and maps both from the central government, as well as from organizations and persons of national importance (past and present).</td>
				</tr>
				<tr>
					<td><?php print caGetThemeGraphic($this->request, 'NNI-Logo.jpg');?></td>
					<td style='width:200px;'><a href='#' type="button" data-toggle="modal" data-target="#linkModal" data-whatever="<a href='https://www.newnetherlandinstitute.org/' target='_blank'>https://www.newnetherlandinstitute.org/</a>">New Netherland Institute <i class='fa fa-external-link'></i></a></td>
					<td>The New Netherland Institute (NNI) is an independent 501c(3) non-profit, non-State organization dedicated to fund raising for and supporting the efforts of the New York State Library’s New Netherland Research Center (formerly the New Netherland Project). Created in 1986 as the Friends of the New Netherland Project, the NNI has supported the transcription, translation, and publication of the 17th-century Dutch colonial records held by the New York State Library and State Archives.</td>
				</tr>							
			</table>
		</div><!-- end col -->
	</div><!-- end row -->
</div><!-- end container -->

<div class="modal fade" id="linkModal" tabindex="-1" role="dialog" aria-labelledby="linkModalLabel">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="linkModalLabel">You are exiting the New York State Education Department's (NYSED) web site.</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            The site you are about to visit (<span id='site'></span>) is not under the jurisdiction of the NYSED, and the NYSED is not responsible for its content.
          </div>
        </form>
      </div>
      <div class="modal-footer">
      	Click the link above to continue or
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<script>
	$('#linkModal').on('show.bs.modal', function (event) {
	  var href = $(event.relatedTarget) // Button that triggered the modal
	  var linkData = href.data('whatever') // Extract info from data-* attributes
	  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
	  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
	  var modal = $(this)
	  modal.find('.modal-body #site').html(linkData)
	})
</script>
