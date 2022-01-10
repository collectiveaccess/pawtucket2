/*
* Container for display and editing of applied browse filters. This component provides
* markup wrapping both browse statistics (# of results found) (component <LightboxStatistics>
* as well as the list of available browse facets (component <LightboxFacetList>).
*
* Props are:
* 		facetLoadUrl : URL to use to load facet content
*
* Sub-components are:
* 		LightboxStatistics
* 		LightboxDragAndDrop
* 		LightboxSelection
* 		LightboxSortOptions
* 		LightboxExportOptions
*
* Used by:
*  	Lightbox
*
* Uses context: LightboxContext
*/

import React, { useContext } from 'react'
import { LightboxContext } from './LightboxContext'

import LightboxExportOptions from './LightboxControls/LightboxExportOptions';
import LightboxSortOptions from './LightboxControls/LightboxSortOptions';
import LightboxStatistics from './LightboxControls/LightboxStatistics';
import LightboxDragAndDrop from './LightboxControls/LightboxDragAndDrop';
import LightboxSelection from './LightboxControls/LightboxSelection';

const LightboxControls = () => {
	
	const { userAccess, setUserAccess, shareAccess, setShareAccess } = useContext(LightboxContext)

	return (
		<div className="row mb-3">
			<div className="col-4 ">
				<LightboxStatistics />
			</div>

			<div className="col-8 ">
				<div className='row d-flex align-items-center justify-content-end'>
					{shareAccess == "edit" && userAccess == 2? 
						<>
							<LightboxDragAndDrop />
							<LightboxSelection />
						</>
					: null}
					<LightboxSortOptions />
					<LightboxExportOptions />
				</div>
			</div>
		</div>
	)
}

export default LightboxControls