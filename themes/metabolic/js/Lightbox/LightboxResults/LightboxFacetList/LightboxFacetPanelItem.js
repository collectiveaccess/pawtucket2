/**
 * Renders an individual item
 *
 * Props are:
 * 		id : item id; used as CSS id
 * 		data : object containing data for item; must include values for "id" (used as item value), "label" (display label) and "content_count" (number of results returned by this item)
 * 	  selected : render item as selected?
 * 	  callback : function to check when item is selected or unselected
 *
 * Sub-components are:
 * 		<NONE>
 *
 * Used by:
 *  	LightboxFacetPanel
 *
 * Uses context: LightboxContext
 */

import React from "react";
import ReactDOM from "react-dom";
import { LightboxContext } from '../../../Lightbox';

class LightboxFacetPanelItem extends React.Component {
	constructor(props) {
		super(props);

   	LightboxFacetPanelItem.contextType = LightboxContext;
	}

	render() {
		let { id, data } = this.props;
		let count = (data.content_count > 0) ? '(' + data.content_count + ')' : '';
		return(<>
			<input id={id} value={data.id} data-label={data.label} type="checkbox" name="facets[]" checked={this.props.selected} onChange={this.props.callback}/>
			<label htmlFor={id}>
				{data.label} &nbsp;
				<span className="number">{count}</span>
			</label>
		</>);
	}
}

export default LightboxFacetPanelItem;
