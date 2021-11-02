/**
* Archive browse collection information panel
*
* Props are:
* 		headline : browse inteface headline (Ex. "Photography Collection")
* 		description : descriptive text for the browse (Eg. text about the collection)
*
* Sub-components are:
* 		<NONE>
*
* Used by:
*  	Lightbox
*
* Uses context: LightboxContext
*/

import React, { useContext } from 'react'
import { LightboxContext } from './LightboxContext'

import EasyEdit from 'react-easy-edit';
import { editLightbox } from "../../../default/js/lightbox";

const appData = pawtucketUIApps.Lightbox.data;
// const lightboxTerminology = appData.lightboxTerminology;
const baseUrl = appData.baseUrl;

const LightboxIntro = (props) => {
	
	const { id, setId, tokens, setTokens, lightboxTitle, setLightboxTitle, lightboxList, setLightboxList } = useContext(LightboxContext)

	const saveLightboxEdit = (name) => {
		editLightbox(baseUrl, tokens, id, name, (data) => {
			console.log("editLightbox", data);
			// Update name is context state
			let tempLightboxList = {...lightboxList}
			tempLightboxList[id]['title'] == name;
			setLightboxList(tempLightboxList)
			setLightboxTitle(name)
		});
	}

	return (
		<h1>
			<EasyEdit
				type="text"
				onSave={saveLightboxEdit}
				saveButtonLabel="Save"
				saveButtonStyle="btn btn-primary btn-sm"
				cancelButtonLabel="Cancel"
				cancelButtonStyle="btn btn-primary btn-sm"
				attributes={{name: "name", id: "lightbox_name" + id}}
				value={lightboxTitle}
			/>
		</h1>
	);
}

export default LightboxIntro;

	// <h1>{lightboxTerminology.section_heading}:&nbsp;

	// saveLightboxEdit(name) {
	// 	let that = this;
	// 	editLightbox(that.context.props.baseUrl, that.context.state.tokens, that.context.state.id, name, function(data) {
	// 		console.log("saveLightboxEdit ", data);
	// 		// Update name in context state
	// 		let lightboxList = that.context.state.lightboxList;
	// 		lightboxList[that.context.state.id]['title'] == name;
	// 		that.context.setState({lightboxlist: lightboxList});
	// 	});
	// }