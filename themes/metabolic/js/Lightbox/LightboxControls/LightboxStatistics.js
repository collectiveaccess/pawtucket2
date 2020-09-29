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
		if (this.context.state.resultSize === 0) {
			return(<h2 className="my-2">No Items</h2>);
		}else{
			return(
				<h2 className="my-2">{(this.context.state.resultSize !== null) ? ((this.context.state.resultSize== 1) ?
					"1 Item" : this.context.state.resultSize + " Items") : <div className="text-center">Loading...</div>}</h2>
			);
		}
	}
}

export default LightboxStatistics;
