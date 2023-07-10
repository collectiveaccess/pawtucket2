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

import React from "react";
import ReactDOM from "react-dom";
import { LightboxContext } from '../Lightbox';

import EasyEdit from 'react-easy-edit';
import { editLightbox } from "../../../default/js/lightbox";

const appData = pawtucketUIApps.Lightbox.data;
const lightboxTerminology = appData.lightboxTerminology;

class LightboxIntro extends React.Component {
	constructor(props) {
		super(props);

    LightboxIntro.contextType = LightboxContext;

		this.saveLightboxEdit = this.saveLightboxEdit.bind(this);
	}

	saveLightboxEdit(name) {
		let that = this;
		editLightbox(that.context.props.baseUrl, that.context.state.tokens, that.context.state.id, name, function(data) {
			console.log("saveLightboxEdit ", data);
			// Update name in context state
			let lightboxList = that.context.state.lightboxList;
			lightboxList[that.context.state.id]['title'] == name;
			that.context.setState({lightboxlist: lightboxList});
		});
	}

	render() {

		return (
			<h1 className="lightbox-intro-title">{lightboxTerminology.section_heading}:&nbsp;
				<EasyEdit
					type="text"
					onSave={this.saveLightboxEdit}
					saveButtonLabel="Save"
					saveButtonStyle="btn btn-primary btn-sm"
					cancelButtonLabel="Cancel"
					cancelButtonStyle="btn btn-primary btn-sm"
					attributes={{name: "name", id: "lightbox_name" + this.context.state.id}}
					value={this.context.state.lightboxTitle}
				/>
			</h1>

		);
	}
}

export default LightboxIntro;
