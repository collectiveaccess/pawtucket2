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
const siteBaseUrl = appData.siteBaseUrl;
const anonToken = appData.anonToken ? appData.anonToken : 0;
let downloadType = appData.downloadType;
if (!downloadType) { downloadType = 'download_original'; }

const LightboxExportOptions = () => {

	const { id, setId, key, setKey, selectedItems, setSelectedItems, sortDirection, setSortDirection, sort, setSort } = useContext(LightboxContext)

	const [exportOptions, setExportOptions] = useState([]);
	
	const token = 

	useEffect(() => {
		let tempExportOptions = [];

		for (let i in exportFormats) {
			let r = exportFormats[i];
			tempExportOptions.push(
				<a
					className="dropdown-item"
					href={siteBaseUrl + '/objects/getContent/getResult/1/download/1/view/' + r.type + '/export_format/' + r.code + '/token/' + anonToken + '/facets/_search:ca_sets.set_id:' + id + '/record_ids/' + ((selectedItems.length > 0) ? selectedItems.join(';') : "")}
					key={i}
				>{r.name}</a>
			);
		}

		if (selectedItems.length == 0) {
			tempExportOptions.push(
				<a
					className="dropdown-item"
					href={siteBaseUrl + '/getSetMedia/set_id/' + id + '/token/' + anonToken + '/sort/' + sort + '/sort_direction/' + sortDirection + '/download_type/' + downloadType}
					key='dlMedia'
				>Download media</a>
			);
		} else {
			tempExportOptions.push(
				<a
					className="dropdown-item"
					href={siteBaseUrl + '/getSetMedia/set_id/' + id + '/record_ids/' + selectedItems.join(';') + '/download_type/' + downloadType} key='dlMedia'
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

export default LightboxExportOptions;
