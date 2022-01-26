/**
* Formats each item in the browse result using data passed in the "data" prop.
*
* Props are:
* 		data : object containing data to display for result item
* 		view : view format to use for display of results
*
* Sub-components are:
* 		<NONE>
*
* Used by:
*  	Lightbox
*
* Uses context: LightboxContext
*/

import React, {useState, useContext, useEffect} from 'react'
import { LightboxContext } from '../LightboxContext';

import EasyEdit from 'react-easy-edit';
import { confirmAlert } from 'react-confirm-alert';
import 'react-confirm-alert/src/react-confirm-alert.css';
import { editLightbox, deleteLightbox, createLightbox, getLightboxAccessForCurrentUser, loadLightbox } from "../../../../default/js/lightbox";

const LightboxListItem = (props) => {

	const [ deleting, setDeleting ] = useState(false);
	const [ countText, setCountText ] = useState((props.count == 1) ? props.count + " " + props.data.content_type_singular : props.count + " " + props.data.content_type_plural)

	const { id, setId, tokens, setTokens, userAccess, setUserAccess, lightboxTitle, setLightboxTitle, totalSize, setTotalSize, sortOptions, setSortOptions, comments, setComments, itemsPerPage, setItemsPerPage, lightboxList, setLightboxList, lightboxListPageNum, setLightboxListPageNum, lightboxSearchValue, setLightboxSearchValue, resultList, setResultList, selectedItems, setSelectedItems, showSelectButtons, setShowSelectButtons, anonymousAccessUrl, setAnonymousAccessUrl} = useContext(LightboxContext)

	useEffect(() => {
		if (!userAccess) {
			setUserAccess(props.data.access)
		}
	}, [])	
		
	const openLightbox = (e) => {
		setResultList(null);
		let id = e.target.attributes.getNamedItem('data-id').value;

		setSelectedItems([]);
		setShowSelectButtons(false)

		// setLightboxListPageNum(props.currentPage)
		// setLightboxSearchValue(props.searchValue)

		loadLightbox(props.baseUrl, tokens, id, (data) => {
			console.log('Load Lightbox: ', data);
			setId(id)
			setLightboxTitle(data.title)
			setResultList(data.items)
			setTotalSize(data.item_count)
			setSortOptions(data.sortOptions)
			setComments(data.comments)
			setAnonymousAccessUrl(data.anonymousAccessUrl)
			setUserAccess(data.access)
		}, { start: 0, limit: itemsPerPage });

		// getLightboxAccessForCurrentUser(props.baseUrl, id, tokens, (data) => {
		// 	console.log('getLightboxAccessForCurrentUser', data);

		// 	if (data && (data['access'] !== undefined)) {
		// 		if (data['access']) {
		// 			setUserAccess(data['access'])
		// 		}
		// 	}
		// });
	}

	const saveNewLightbox = (name) =>{
		createLightbox(props.baseUrl, tokens, name, (data) => {
			console.log("createLightbox", data);
			let tempLightboxList = {...lightboxList}
			delete (tempLightboxList[-1]);
			tempLightboxList[data.id] = {
				id: data.id, title: data.name, count: 0
			};
			setLightboxList(tempLightboxList)
		});
	}

	const saveLightboxEdit = (name) => {
		editLightbox(props.baseUrl, tokens, props.data.id, name, (data) => {
			console.log("editLightbox", data);
			// Update name is context state
			let tempLightboxList = {...lightboxList}
			tempLightboxList[props.data.id]['title'] == name;
			setLightboxList(tempLightboxList)
		});
	}

	const deleteLightboxConfirm = (e) => {
		confirmAlert({
			customUI: ({ onClose }) => {
				return (
					<div className='col info text-gray'>
						<p>Really delete <em>{props.data.title}</em>?</p>
						<div className='button' onClick={() => {
							// props.deleteCallback(props.data);
							deleteLightbox(props.baseUrl, tokens, props.data.id, (data) => {
								console.log("deleteLightbox ", data);
								let tempLightboxList = {...lightboxList}
								delete (tempLightboxList[props.data.id]);
								setLightboxList(tempLightboxList)
							});
							onClose();
						}}> Yes </div>
						&nbsp;
						<div className='button' onClick={onClose}>No</div>
					</div>
				);
			}
		});
	}

	const cancelNewLightbox = () => {
		let tempLightboxList = {...lightboxList}
		delete (tempLightboxList[-1]);
		setLightboxList(tempLightboxList)
	}

	if (deleting) {
		return (
			<div className="row my-1">
				<div className="col-sm-4">
					<EasyEdit
						type="text"
						onSave={saveLightboxEdit}
						saveButtonLabel="Save"
						saveButtonStyle="btn btn-primary btn-sm"
						cancelButtonLabel="Cancel"
						cancelButtonStyle="btn btn-primary btn-sm"
						attributes={{ name: "name", id: "lightbox_name" + props.data.id }}
						value={props.data.title}
					/>
				</div>
				<div className="col-sm-4">{countText}</div>
				<div className="col-sm-4 info">
					<div className="spinner">
						<div className="bounce1"></div>
						<div className="bounce2"></div>
						<div className="bounce3"></div>
					</div>
				</div>
			</div>
		);
	} else if(props.data.id > 0) {

		// if(!userAccess){
		// 	getLightboxAccessForCurrentUser(props.baseUrl, props.data.id, tokens, (resp) => {
		// 		if(resp && (resp['access'] !== undefined)) {
		// 			setUserAccess(resp['access'])
		// 		}
		// 	});
		// }

		return(
		<li className="list-group-item">
			<div className="row my-2">

				<div className="col-sm-12 col-md-6 label">
					{(userAccess == 2) ?
						<EasyEdit
							type="text"
							onSave={saveLightboxEdit}
							saveButtonLabel="Save"
							saveButtonStyle="btn btn-primary btn-sm"
							cancelButtonLabel="Cancel"
							cancelButtonStyle="btn btn-primary btn-sm"
							attributes={{ name: "name", id: "lightbox_name" + props.data.id }}
							value={props.data.title}
						/>
						: props.data.title}
				</div>

				<div className="col-sm-6 col-md-2 infoNarrow">{countText}</div>

				<div className="col-sm-6 col-md-4 info text-right">
					<a href='#' data-id={props.data.id} className='btn btn-secondary btn-sm' onClick={openLightbox}>View</a>
					&nbsp;
					{(userAccess == 2) ?
						<a href='#' data-id={props.data.id} className='btn btn-secondary btn-sm' onClick={deleteLightboxConfirm}>Delete</a>
						: null}
				</div>

			</div> {/* row-end */}
		</li>
		);
	}else{
		return(
		<li className="list-group-item">
			<div className="row my-2">
				<div className="col-sm-12 col-md-8 label">
					<EasyEdit
						ref={props.newLightboxRef}
						type="text"
						onSave={saveNewLightbox}
						onCancel={cancelNewLightbox}
						saveButtonLabel="Save"
						saveButtonStyle="btn btn-primary btn-sm"
						cancelButtonLabel="Cancel"
						cancelButtonStyle="btn btn-primary btn-sm"
						placeholder="Enter name"
						attributes={{ name: "name", id: "lightbox_name" + props.data.id }}
						value={props.data.title}
					/>
					{/* <div>{newLightboxError}</div> */}
				</div>
				<div className="col-sm-4 infoNarrow"></div>
				<div className="col-sm-4 info"></div>
			</div>
		</li>);
	}
}

export default LightboxListItem