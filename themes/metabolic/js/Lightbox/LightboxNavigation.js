/**
 *
 * Sub-components are:
 *      <NONE>
 *
 * Props are:
 *      <NONE>
 *
 * Used by:
 *  	Lightbox
 *
 * Uses context: LightboxContext
 */

import React from "react"
import ReactDOM from "react-dom";
import { LightboxContext } from '../Lightbox'

class LightboxNavigation extends React.Component{
	constructor(props) {
		super(props);

		LightboxNavigation.contextType = LightboxContext

		this.backToList = this.backToList.bind(this);
	}

	backToList(e) {
		let state = this.context.state;

		state.id = null; // clear set
		state.filters = null; // clear filters
		state.lightboxTitle = null;

		this.context.setState(state);
	}
	render() {
		return(
			<a href='#' className='btn btn-secondary' onClick={this.backToList}>
				<ion-icon name='ios-arrow-back'></ion-icon>
			</a>
		);
	}
}
export default LightboxNavigation;
