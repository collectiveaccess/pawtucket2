	<div class="well">

		<h4>Basic Search</h4><br>

		<div class="basic-search">
			<div class="input-group">
				<label for="s1" class="col-sm-3 control-label">Terms Anywhere:</label>
				<div class="col-sm-9">
					<!--<input name="s1" id="s1" type="text" class="form-control">-->
					<?= $this->formElement('_fulltext', ['size' => 60, 'label' => '', 'description' => _t("All fields; includes full text where available")]); ?>
			
					<!--<p class="form-text"><em>All fields; includes full text where available.</em></p>-->
				</div>
			</div>

			<div class="input-group">
				<label for="s9" class="col-sm-3 control-label">Terms in Title:</label>
				<div class="col-sm-9" style="padding-bottom: 10px;">
					<input name="s9" id="s9" type="text" class="form-control">
				</div>
			</div>
		</div>

		<hr class="advanced-separator">

		<h4>Advanced Search</h4><br>

		<div class="advanced-search">

			<h4 class="expandable-controls">
				<a h data-bs-toggle="collapse" href="#filterfield" role="button" aria-expanded="false" aria-controls="filterfield">Filter by Field</a>
				<i class="bi bi-caret-right-fill"></i>
			</h4>

			<div class="collapse mb-3" id="filterfield">

				<p>Use as many fields as needed. Each text field can contain either one or multiple terms. Months are optional in date fields.</p><br>

				<div id="field-item" class="input-group advanced-fields mb-1 align-items-center">

					<label for="s7target" class="col-sm-3 control-label">Search by Field:</label>

					<div class="col-sm-3 me-1">
						<select class="form-control s7target" aria-label="select">
							<option value="">Select a Field</option>
							<option value="TI" data-type="text">Title</option>
							<option value="TX" data-type="text">Text</option>
							<option value="SPON" data-type="text">Sponsor</option>
							<option value="COMM" data-type="text">Committee</option>
							<option value="INDX" data-type="text">Index Terms</option>
							<option value="DTIR" data-type="date">Introduced</option>
							<option value="DTSI" data-type="date">Passed by Council</option>
							<option value="DTA" data-type="date">Signed by Mayor</option>
							<option value="DTF" data-type="date">Filed with Clerk</option>
							<option value="SCAN" data-type="boolean">Scan Available</option>
						</select>
					</div>

					<div class="col-sm-3 me-3 s7choices s7text">
						<input type="text" class="form-control s7terms" placeholder="Terms">
					</div>

					<div class="col-sm-2 d-flex align-items-center" id="addBtnCol">
						<a role="button" onclick="cloneElement();" title="Add Row" id="addBtn"><i class="bi bi-plus-lg"></i></a>
					</div>

				</div>

			</div>

		</div>


		<script>
			function cloneElement() {
					// Get the element to be cloned
					var original = document.getElementById('field-item');

					// Clone the element
					var clone = original.cloneNode(true);

					// Create a remove button
					var removeBtn = document.createElement('a');

					// Create icon
					var removeIcon = document.createElement('i');
					removeIcon.classList.add("bi");
					removeIcon.classList.add("bi-dash-lg");

					// Append the remove icon to the remove button
					removeBtn.appendChild(removeIcon);

					// Function to remove entire elment on click
					removeBtn.onclick = function() {
							this.parentNode.parentNode.remove();
					};

					// Remove exisiting add button in clone
					var subParent = clone.querySelector('#addBtnCol');
					var addBtn = subParent.querySelector('#addBtn');
					if (addBtn) {
						subParent.removeChild(addBtn);
					}

					// Append the remove button to the subparent
					subParent.appendChild(removeBtn);

					// Append the clone to the container
					document.getElementById('filterfield').appendChild(clone);
			}
		</script>

		<div class="advanced-search">

			<h4 class="expandable-controls">
				<a h data-bs-toggle="collapse" href="#filterdate" role="button" aria-expanded="false" aria-controls="filterdate">Filter by Date</a>
				<i class="bi bi-caret-right-fill"></i>
			</h4>

			<div class="collapse mb-3" id="filterdate">
				<p>A date range can be combined with other search terms, or submitted independently. Months are optional.</p><br>

				<div class="input-group ">
					<label for="s6range" class="col-sm-3 control-label">By Decade:</label>
					<div class="col-sm-9">
						<select id="s6range" class="form-control" aria-label="select">
							<option value="" selected="">No date limit, or custom range below</option>
						<option value="2020-">2020 to Present</option><option value="2010-2019">2010-2019</option>
						<option value="2000-2009">2000-2009</option><option value="1990-1999">1990-1999</option>
						<option value="1980-1989">1980-1989</option><option value="1970-1979">1970-1979</option>
						<option value="1960-1969">1960-1969</option><option value="1950-1959">1950-1959</option>
						<option value="1940-1949">1940-1949</option><option value="1930-1939">1930-1939</option>
						<option value="1920-1929">1920-1929</option><option value="1910-1919">1910-1919</option>
						<option value="1900-1909">1900-1909</option><option value="1890-1899">1890-1899</option>
						<option value="1880-1889">1880-1889</option><option value="1870-1879">1870-1879</option>
						<option value="-1869">Before 1870</option></select>
						<p><em>Date range refers to date of filing or legislative action, depending on the type of record.</em></p>
					</div>
				</div>

				<div class="input-group" style="padding: 0 0 0.25em;">
					<div class="col-sm-4 control-label"></div>
					<p style="text-align: center; margin-right: 4px; font-weight: bold;">OR</p>
				</div>

				<div class="input-group" id="s6cust">
					<label for="s6year1" class="col-sm-3 control-label">Custom Range:</label>
					<div class="col-sm-9">

						<div class="row row-cols-lg-auto">

							<select id="s6month1" class="form-control w-auto" aria-label="select">
								<option value="00" selected="">Month</option>
								<option value="01">Jan</option>
								<option value="02">Feb</option>
								<option value="03">Mar</option>
								<option value="04">Apr</option>
								<option value="05">May</option>
								<option value="06">Jun</option>
								<option value="07">Jul</option>
								<option value="08">Aug</option>
								<option value="09">Sep</option>
								<option value="10">Oct</option>
								<option value="11">Nov</option>
								<option value="12">Dec</option>
							</select>

							<input id="s6year1" type="number" step="1" maxlength="4" class="form-control w-auto" placeholder="Year" max="2024" min="1869">

							<span class="w-auto px-1 d-flex align-items-center"> � </span>

							<select id="s6month2" class="form-control w-auto" aria-label="select">
								<option value="00" selected="">Month</option>
								<option value="01">Jan</option>
								<option value="02">Feb</option>
								<option value="03">Mar</option>
								<option value="04">Apr</option>
								<option value="05">May</option>
								<option value="06">Jun</option>
								<option value="07">Jul</option>
								<option value="08">Aug</option>
								<option value="09">Sep</option>
								<option value="10">Oct</option>
								<option value="11">Nov</option>
								<option value="12">Dec</option>
							</select>

							<input id="s6year2" type="number" step="1" maxlength="4" class="form-control w-auto" placeholder="Year" max="2024" min="1869">

							<p><em>To browse a single year, enter it in both fields above.</em></p>

						</div>

					</div>
				</div>

			</div>
		</div>

		<div class="advanced-search">
			<h4 class="expandable-controls">
				<a h data-bs-toggle="collapse" href="#includeexclude" role="button" aria-expanded="false" aria-controls="includeexclude">Include and Exclude</a>
				<i class="bi bi-caret-right-fill"></i>
			</h4>

			<div class="collapse mb-3" id="includeexclude">
				<p>Enter terms in this section to either broaden or narrow your search.</p><br>

				<div class="input-group">
					<label for="s2" class="col-sm-3 control-label">Index Terms:</label>
					<div class="col-sm-9">
						<input name="s2" id="s2" type="text" class="form-control">
						<p><em>From <a href="/search/thesaurus/">City Clerk's Thesaurus</a>.</em></p>
					</div>
				</div>

				<div class="input-group">
					<label for="s8exclude" class="col-sm-3 control-label">Exclude Terms:</label>
					<div class="col-sm-9">
						<input id="s8exclude" type="text" class="form-control">
						<p><em>All fields; includes full text where available.</em></p>
					</div>
				</div>
			</div>

		</div>

		<div class="advanced-search">
			<h4 class="expandable-controls">
				<a h data-bs-toggle="collapse" href="#settings" role="button" aria-expanded="false" aria-controls="settings">Settings</a>
				<i class="bi bi-caret-right-fill"></i>
			</h4>

			<div class="collapse mb-3" id="settings">

				<p>These optional settings apply to all combinations of fields above. Adjacency only applies to multiple terms within the same field.</p><br>

				<div class="input-group">
					<label for="Sect4" class="col-sm-3 control-label">Default Operator:</label>
					<div class="col-sm-9">
						<select name="Sect4" class="form-control" aria-label="select">
							<option value="OR">Or</option>
							<option value="AND" selected="">And</option>
							<option value="ADJ">Adjacent</option>
						</select>
					</div>
				</div>

				<div class="input-group">
					<label for="l" class="col-sm-3 control-label">Results Per Page:</label>
					<div class="col-sm-9">
						<select name="l" class="form-control" aria-label="select">
							<option value="5">5</option>
							<option value="10">10</option>
							<option value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="0" selected="">200</option>
							<option value="500">500</option>
							<option value="1000">1000</option>
							<option value="2500">2500</option>
						</select>
					</div>
				</div>

				<div class="input-group radio-group">
					<label for="Sect2" class="col-sm-3 control-label">Thesaurus:</label>
					<div class="col-sm-9">
						<label><input type="radio" name="Sect2" value="THESON" checked=""> On</label>
						&nbsp;
						<label><input type="radio" name="Sect2" value="THESOFF"> Off</label>
					</div>
				</div>

				<div class="input-group radio-group">
					<label for="Sect3" class="col-sm-3 control-label">Plurals:</label>
					<div class="col-sm-9">
						<label><input type="radio" name="Sect3" value="PLURON" checked=""> On</label>
						&nbsp;
						<label><input type="radio" name="Sect3" value="PLUROFF"> Off</label>
					</div>
				</div>

			</div>
		</div>

		<div class="form-group" style="margin-top: 5px;">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<input type="submit" value="Search" class="btn btn-primary">
				<input type="reset" value="Reset" class="btn btn-sm btn-default" style="margin-left: 10px;" onclick="resetAdvForm();">
			</div>
		</div>

	</div>