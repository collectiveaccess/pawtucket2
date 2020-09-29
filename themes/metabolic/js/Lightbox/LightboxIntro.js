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
		editLightbox(this.context.props.baseUrl, {'name': name, set_id: this.context.state.set_id }, function(resp) {
			// TODO: display potential errors

			// Update name is context state
			let that = this;
			let state = that.context.state;
			state.lightboxList.sets[state.set_id]['label'] = name;
			state.headline = name;
			that.context.setState(state);
		});
	}

	render() {
		if (!this.props.headline || (this.props.headline.length === 0)) {
			return (<section></section>);
		}else{
			this.context.state.headline = this.props.headline;
			this.context.state.description = this.props.description;
		}
		return (
			<h1>{lightboxTerminology.section_heading}:&nbsp;
				<EasyEdit
					type="text"
					onSave={this.saveLightboxEdit}
					saveButtonLabel="Save"
					saveButtonStyle="btn btn-primary btn-sm"
					cancelButtonLabel="Cancel"
					cancelButtonStyle="btn btn-primary btn-sm"
					attributes={{name: "name", id: "lightbox_name" + this.context.state.set_id}}
					value={this.context.state.headline}
				/>
			</h1>

		);
	}
}

export default LightboxIntro;
