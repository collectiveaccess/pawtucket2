<form class="g-3 mt-3" action="<?= caNavUrl($this->request, 'search', '', 'objects'); ?>" id="advSearch" method="post" enctype="multipart/form-data">
	<input type="hidden" name="_advanced" value="1">
	<div class="row mb-3 justify-content-center">
		<div class="col-auto me-2 mb-2">
			{{{ca_objects.preferred_labels.name%id=title&placeholder=Title&class=browseMoreSearchOptsField%20form-control}}}
		</div>
		<div class="col-auto me-2 mb-2">
			{{{ca_objects.idno%id=identifier&placeholder=Identifier&class=browseMoreSearchOptsField%20form-control}}}
		</div>
		<div class="col-auto mb-2">
			{{{ca_occurrences.cfaDateProduced%width=200px&useDatePicker=0&placeholder=Date%20of%20Production&class=browseMoreSearchOptsField%20form-control}}}
		</div>
	</div>
	<div class="row mb-3 justify-content-end">
		<div class="col-auto">
			<button type="submit" class="btn mb-3" style="color: #fff; background-color: #E26C2F; border-radius: 20px; padding: 5px 40px;">
				<span style="color: #FFF; font-family: Helvetica Neue; font-size: 14px; line-height: 24px; letter-spacing: 1.4px;">SEARCH</span>  
				<svg xmlns="http://www.w3.org/2000/svg" width="10" height="12" viewBox="0 0 10 12" fill="none">
					<g clip-path="url(#clip0_854_21104)">
						<path d="M3.62982 6.00002L0.4375 0.666687L10.0007 6.00002L0.4375 11.3334L3.62982 6.00002Z" fill="white"/>
					</g>
					<defs>
						<clipPath id="clip0_854_21104">
							<rect width="9.56322" height="10.6667" fill="white" transform="translate(0.4375 0.666687)"/>
						</clipPath>
					</defs>
				</svg>
			</button>
		</div>
	</div>
{{{/form}}}