/**
 * Implements a facet button. Clicking on the button triggers an action for the represented facet (Eg. open
 * a panel displaying all facet values)
 *
 * Props are:
 * 		name : Facet code; used when applying filter values from this facet.
 * 		text : Display name for facet; used as text of button
 * 		callback : Method to call when filter is clicked
 *
 * Sub-components are:
 * 		<NONE>
 *
 * Used by:
 *  	LightboxFacetList
 */

import React from "react";
import ReactDOM from "react-dom";
import { LightboxContext } from '../../../Lightbox';

class LightboxFacetButton extends React.Component {
  constructor(props) {
		super(props);
    
		LightboxFacetButton.contextType = LightboxContext;
	}

	render() {
		return(
			<label
        data-option={this.props.name}
        onClick={this.props.callback}
        role='button'
        aria-expanded='false'
        aria-controls='collapseFacet'>
          {this.props.text}
      </label>
		);
	}
}

export default LightboxFacetButton;
