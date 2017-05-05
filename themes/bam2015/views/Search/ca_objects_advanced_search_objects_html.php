<div class="row">
		<div class="col-xs-12 col-sm-8 col-md-7">
			<h2>Advanced Search</h2>

		

{{{form}}}
	
		<div class="form-group">
			Title:<br/>
			{{{ca_objects.preferred_labels.name%height=35px&width=100%&class=form-control}}}
		</div>
		<div class="form-group">
			Keyword<br/>
			{{{_fulltext%width=100%&height=35px&class=form-control}}}
		</div>		
		<div class="form-group">
			Object Identifier:<br/>
			{{{ca_objects.idno%width=100%&height=35px&class=form-control}}}
		</div>
		<div class="form-group">
			Type:<br/>
			{{{ca_objects.type_id%height=35px&class=form-control}}}
		</div>
		<div class="form-group">
			Date range <i>(e.g. 1970-1979)</i><br/>
			{{{ca_objects.sourceDate%height=35px&width=100%&useDatePicker=0&class=form-control}}}
		</div>
	
	<br style="clear: both;"/>
	<div class='searchSubmitButtons text-center'>
		{{{reset%label=Reset}}}&nbsp;&nbsp;&nbsp;&nbsp;{{{submit%label=Search}}}
	</div>
{{{/form}}}

		</div>
		<div class="col-xs-12 col-sm-4 col-md-5">
			<h2>For Researchers</h2>
			
				<p>
					Researchers can access: All known performances dating from the institution's founding in 1861 and all existing playbills, which provide detailed information about individual performances.
				</p>
				<p>
					For a list of all collections, see <?php print caNavLink($this->request, 'Browse Archival Collections', '', '', 'Collections', 'Index'); ?>.
				</p>
			
			</div><!-- end col -->
	</div><!-- end row -->