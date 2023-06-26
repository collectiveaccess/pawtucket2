/**
* Renders buttons to switch views cofigured in browse.conf
*
* Props are:
* 		view : view format to use for display of results
*
* Used by:
*  	LightboxControls
*
* Uses context: LightboxContext
*/

import React from "react"
import ReactDOM from "react-dom";
import { LightboxContext } from '../../Lightbox'

class LightboxViewList extends React.Component {
  constructor(props) {
		super(props);
		LightboxViewList.contextType = LightboxContext
	}

	render() {
		let viewButtonOptions = ["images", "list"]; // make this come from browse.conf
		let viewButtonIcons = {
								"images" : "<ion-icon name='apps'></ion-icon>",
								"list" : "<ion-icon name='ios-list-box'></ion-icon>"
							}
		let viewButtonList = [];
		if(viewButtonIcons) {
			for (let i in viewButtonIcons) {
				let b = viewButtonIcons.i;
				viewButtonList.push(<a href='#' className='disabled' key={i} dangerouslySetInnerHTML={{__html: viewButtonIcons[i]}}></a>);
			}
		}

		return (
			<div id="bViewButtons">{viewButtonList}</div>
		);
	}
}

export default LightboxViewList;
