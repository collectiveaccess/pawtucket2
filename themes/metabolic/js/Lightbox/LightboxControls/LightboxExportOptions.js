/**
 * Renders export options
 *
 * Props are:
 *    <NONE>
 *
 * Used by:
 *  	LightboxControls
 *
 * Uses context: LightboxContext
 */

import React, { useContext, useState, useEffect } from 'react'
import { LightboxContext } from '../LightboxContext'

const appData = pawtucketUIApps.Lightbox.data;
const exportFormats = appData.exportFormats;
const siteBaseUrl = appData.siteBaseUrl

const LightboxExportOptions = () => {

	const { id, setId, key, setKey, selectedItems, setSelectedItems, sortDirection, setSortDirection, sort, setSort } = useContext(LightboxContext)

	const [exportOptions, setExportOptions] = useState([])

	useEffect(() => {
		let tempExportOptions = [];

		for (let i in exportFormats) {
			let r = exportFormats[i];
			tempExportOptions.push(
				<a
					className="dropdown-item"
					href={siteBaseUrl + '/objects/getContent/getResult/1/download/1/view/' + r.type + '/export_format/' + r.code + '/key/' + key + '/facets/_search:ca_sets.set_id:' + id + '/record_ids/' + ((selectedItems.length > 0) ? selectedItems.join(';') : "")}
					key={i}
				>{r.name}</a>
			);
		}

		if (selectedItems.length == 0) {
			tempExportOptions.push(
				<a
					className="dropdown-item"
					href={siteBaseUrl + '/getSetMedia/set_id/' + id + '/key/' + key + '/sort/' + sort + '/sort_direction/' + sortDirection}
					key='dlMedia'
				>Download media</a>
			);
		} else {
			tempExportOptions.push(
				<a
					className="dropdown-item"
					href={siteBaseUrl + '/getSetMedia/set_id/' + id + '/record_ids/' + selectedItems.join(';')} key='dlMedia'
				>Download selected media</a>);
		}
		setExportOptions(tempExportOptions)
	}, [])

	return (
		<div id="bExportOptions">
			<div className="dropdown show">
				<a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<ion-icon name="download"></ion-icon>
				</a>
				<div className="dropdown-menu" aria-labelledby="dropdownMenuLink">
					{(selectedItems.length > 0) ? <><div className="dropdown-header">Export Selected Items As:</div><div className="dropdown-divider"></div></> : null}
					{exportOptions}
				</div>
			</div>
		</div>
	);
}

export default LightboxExportOptions


// import React from "react"
// import ReactDOM from "react-dom";
// import { LightboxContext } from '../../Lightbox'

// const appData = pawtucketUIApps.Lightbox.data;

// class LightboxExportOptions extends React.Component {
// 	constructor(props) {
// 		super(props);

//     LightboxExportOptions.contextType = LightboxContext;
// 	}

// 	render() {
// 		let exportOptions = [];
// 		let exportFormats = null;
// 		exportFormats = appData.exportFormats;

// 		if(exportFormats) {
// 			for (let i in exportFormats) {
// 				let r = exportFormats[i];
// 				exportOptions.push(
//           <a
//             className="dropdown-item"
//             href={appData.siteBaseUrl + '/objects/getContent/getResult/1/download/1/view/' + r.type + '/export_format/' + r.code + '/key/' + this.context.state.key + '/facets/_search:ca_sets.set_id:' + this.context.state.id + '/record_ids/' + ((this.context.state.selectedItems.length > 0) ? this.context.state.selectedItems.join(';') : "")}
//             key={i}>{r.name}</a>
//         );
// 			}
// 		}

// 		if(this.context.state.selectedItems.length == 0){
// 			exportOptions.push(
//         <a
//           className="dropdown-item"
//           href={appData.siteBaseUrl + '/getSetMedia/set_id/' + this.context.state.set_id + '/key/' + this.context.state.key + '/sort/' + this.context.state.sort + '/sort_direction/' + this.context.state.sortDirection}
//           key='dlMedia'>Download media</a>
//       );
// 		}else{
// 			exportOptions.push(
//         <a
//           className="dropdown-item"
//           href={appData.siteBaseUrl + '/getSetMedia/set_id/' + this.context.state.set_id + '/record_ids/' + this.context.state.selectedItems.join(';')} key='dlMedia'>Download selected media</a>);
// 		}

// 		return (
// 			<div id="bExportOptions">
// 				<div className="dropdown show">
// 					<a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
// 					<ion-icon name="download"></ion-icon>
// 				  </a>

// 				  <div className="dropdown-menu" aria-labelledby="dropdownMenuLink">
// 					{(this.context.state.selectedItems.length > 0) ? <><div className="dropdown-header">Export Selected Items As:</div><div className="dropdown-divider"></div></> : null}
// 					{exportOptions}
// 				  </div>
// 				</div>
// 			</div>
// 		);
// 	}

// }

// export default LightboxExportOptions;
