/**
* Formats each item in the browse result using data passed in the "data" prop.
*
* Props are: 
* 		<NONE>
*
* Sub-components are:
* 		LightboxListItem
*			LightboxListPagination
*			LightboxListSort
*
* Used by:
*  	Lightbox
*
* Uses context: LightboxContext
*/

import React, { useState, useContext, useEffect, useRef } from 'react'
import { LightboxContext } from './LightboxContext';

import LightboxListItem from './LightboxList/LightboxListItem';
import LightboxListPagination from './LightboxList/LightboxListPagination';
import LightboxListSort from './LightboxList/LightboxListSort';

const appData = pawtucketUIApps.Lightbox.data;
const lightboxTerminology = appData.lightboxTerminology;
const baseUrl = appData.baseUrl;

const LightboxList = (props) => {

	const { id, setId, tokens, setTokens, userAccess, setUserAccess,  lightboxList, setLightboxList, lightboxListPageNum, setLightboxListPageNum, lightboxSearchValue, setLightboxSearchValue, lightboxes, setLightboxes } = useContext(LightboxContext)

	const [ lightboxesPerPage, setLightboxesPerPage ] = useState(12)
	const [ paginatedLightboxes, setPaginatedLightboxes ] = useState([])
	// const [ filteredLightboxes, setFilteredLightboxes ] = useState([])
	const [ numberOfPages, setNumberOfPages ] = useState()
	
	// const newLightboxRef = useRef(null)

	useEffect(() => {
		// if (newLightboxRef && newLightboxRef.current) {
		// 	newLightboxRef.current.onClick();
		// }
		// newLightboxRef = { newLightboxRef }

		let tempLightboxes = []
		for (let k in lightboxList) {
			let l = lightboxList[k];
			tempLightboxes.unshift(<LightboxListItem key={k} data={l} count={l.count} baseUrl={baseUrl} tokens={tokens} />);
		}
		if(tempLightboxes){
			setLightboxes(tempLightboxes)
		}else{
			setLightboxes(<li className="list-group-item">
				<div className="row my-4">
					<div className="col-sm-12 label">Use the link above to create a {lightboxTerminology.section_heading}.</div>
				</div>
			</li>)
		}
		
	}, [lightboxList])

	useEffect(() => {
		if (lightboxes && lightboxes.length > 0) {
			setNumberOfPages(Math.ceil(lightboxes.length / lightboxesPerPage))
			let indexOfLastLightbox = lightboxListPageNum * lightboxesPerPage;
			let indexOfFirstLightbox = indexOfLastLightbox - lightboxesPerPage;
			setPaginatedLightboxes(lightboxes.slice(indexOfFirstLightbox, indexOfLastLightbox))
			
			if (lightboxSearchValue && lightboxSearchValue.length > 0) {
				// setFilteredLightboxes(lightboxes.filter(lightbox => (lightbox.props.data.title).toLowerCase().includes(lightboxSearchValue.toLowerCase())))
				setPaginatedLightboxes(lightboxes.filter(lightbox => (lightbox.props.data.title).toLowerCase().includes(lightboxSearchValue.toLowerCase())).slice(indexOfFirstLightbox, indexOfLastLightbox))
				setNumberOfPages(Math.ceil(lightboxes.filter(lightbox => (lightbox.props.data.title).toLowerCase().includes(lightboxSearchValue.toLowerCase())).length / lightboxesPerPage))
			}
		}
		if (lightboxListPageNum > numberOfPages) {
			setLightboxListPageNum(1)
		}
	}, [lightboxes, lightboxListPageNum, lightboxSearchValue, numberOfPages])

	//function paginates to the 1st page then calls function to create new lightbox
	const createNewLightbox = () => {
		setLightboxListPageNum(1)

		let tempLightboxList = { ...lightboxList }
		tempLightboxList[-1] = { "id": -1, "label": "" }
		setLightboxList(tempLightboxList)

		// callback(); // calls newLightbox function located in the context
	};

	const handleLightboxSearch = (e) => {
		setLightboxSearchValue(e.target.value)
	}

	// console.log("number of pages: ", numberOfPages);
	// console.log("lightboxListPageNum: ", lightboxListPageNum);
	// console.log('Lightboxes: ', lightboxes);
	// console.log('Paginated lightboxes: ', paginatedLightboxes);
	// console.log('Filtered lightboxes: ', filteredLightboxes);

	return (
		<div className='row'>
			<div className='col-sm-12 mt-3 mb-2'>

				<div className='row justify-content-center' style={{ marginBottom: "15px" }}>
					<div className="col-sm-8 col-lg-6 d-flex">
						<div className=''>
							<h1>My {lightboxTerminology.plural}</h1>
						</div> 
						<div className='ml-auto'>
							<a href='#' className='btn btn-primary' onClick={createNewLightbox}>New +</a>
						</div>
					</div>
				</div>

				<div className='row mb-2 justify-content-center'>
					<div className='col-sm-8 col-lg-6 d-flex'>
						<LightboxListSort />

						<div className="ml-3">
							<input type="text" defaultValue={lightboxSearchValue} onChange={(e) => handleLightboxSearch(e)} placeholder="Search Lightboxes" style={{ width: '150px' }} />
						</div>

					</div>
				</div>

				<div className="row justify-content-center">
					<div className='col-6'>
						{paginatedLightboxes && paginatedLightboxes.length >= 1 ?
							<LightboxListPagination lightboxesPerPage={lightboxesPerPage} numberOfPages={numberOfPages}/>
						: <div className="text-center"></div>}
					</div>
				</div>

				<div className='row justify-content-center my-1'>
					<div className='col-sm-8 col-lg-6'>
						<ul className="list-group list-group-flush">
							{paginatedLightboxes}
						</ul>
					</div>
				</div>

				<div className="row justify-content-center">
					<div className='col-6'>
						{paginatedLightboxes && paginatedLightboxes.length >= 1?
							<LightboxListPagination lightboxesPerPage={lightboxesPerPage}	numberOfPages={numberOfPages}/>
							: null}
					</div>
				</div>

			</div>
		</div>
	)
}

export default LightboxList