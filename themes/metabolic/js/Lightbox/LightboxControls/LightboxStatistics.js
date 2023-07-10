/**
 * Browse result statistics display. Stats include a # results found indicator. May embed other
 * stats such as a list of currently applied browse filters (via LightboxCurrentFilterList)
 *
 * Props are:
 * 		<NONE>
 *
 * Sub-components are:
 * 		<NONE>
 *
 * Uses context: LightboxContext
 */

import React from "react";
import ReactDOM from "react-dom";
import { LightboxContext } from '../../Lightbox';

class LightboxStatistics extends React.Component {
	constructor(props) {
		super(props);
    	LightboxStatistics.contextType = LightboxContext;
	}

	render() {
		let resultSize = this.context.state.totalSize ? this.context.state.totalSize : 0;
		if (resultSize === 0) {
			return(<h2 className="lb-stats my-2 mx-2">No Items</h2>);
		}else{
			return(
				<h2 className="lb-stats my-2 mx-2">{(resultSize !== null) ? ((resultSize == 1) ?
					"1 Item" : resultSize + " Items") : <div className="text-center">Loading...</div>}</h2>
			);
		}
	}
}

export default LightboxStatistics;
