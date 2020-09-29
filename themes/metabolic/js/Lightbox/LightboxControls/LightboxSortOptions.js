/**
 * Renders sort options
 *
 * Props are:
 * 		<NONE>
 *
 * Used by:
 *  	LightboxControls
 *
 * Uses context: LightboxContext
 */

import React from "react";
import ReactDOM from "react-dom";
import { LightboxContext } from '../../Lightbox';

const appData = pawtucketUIApps.Lightbox.data;

class LightboxSortOptions extends React.Component {
	constructor(props) {
		super(props);
    	LightboxSortOptions.contextType = LightboxContext;
		this.handleSort = this.handleSort.bind(this);
	}

	handleSort(e){
		let sort = e.target.attributes.getNamedItem('data-sort').value;
		let direction = e.target.attributes.getNamedItem('data-direction').value;
		this.context.sortResults(sort, direction);
    this.context.setState({userSort: false, showSaveButton: true})
    window.scrollTo(0, 0);
		e.preventDefault();
    console.log("sort: ", this.context.state.sort);
	}

	render() {
		let sortOptions = [];
		let sortConfig = [];
		//let sortDirection = [];
		sortConfig = appData.browseConfig.sortBy;
		//sortDirection = browseConfig.sortDirection;
		if(sortConfig) {
			for (let i in sortConfig) {
				let r = sortConfig[i];
				let sortLinkText = "";
				let sortLinkActive = "";

				sortLinkText = ((this.context.state.sort == i) && (this.context.state.sortDirection == "asc")) ?
        <b>{i}  <ion-icon name="arrow-up"></ion-icon></b>
        :
        <>{i} <ion-icon name='arrow-up'></ion-icon></>;

				sortLinkActive = ((this.context.state.sort == i) && (this.context.state.sortDirection == "asc")) ? "active" : null;

				sortOptions.push(<a className={((this.context.state.sort == i) && (this.context.state.sortDirection == "asc")) ?
        "dropdown-item active"
        :
        "dropdown-item"} href="#" onClick={this.handleSort} data-sort={i} data-direction="asc" key={r + "asc"}>{sortLinkText}</a>);

				sortLinkText = ((this.context.state.sort == i) && (this.context.state.sortDirection == "desc")) ?
        <b>{i} <ion-icon name='arrow-down'></ion-icon></b>
        :
        <>{i} <ion-icon name='arrow-down'></ion-icon></>;

				sortOptions.push(<a className={((this.context.state.sort == i) && (this.context.state.sortDirection == "desc")) ?
        "dropdown-item active" :
         "dropdown-item"} href="#" onClick={this.handleSort} data-sort={i} data-direction="desc" key={r + "desc"}>{sortLinkText}</a>);

			}
		}
		return (
			<div id="bSortOptions">
				<div className="dropdown show">
					<a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<ion-icon name="funnel"></ion-icon>
				  </a>

				  <div className="dropdown-menu" aria-labelledby="dropdownMenuLink">
					{sortOptions}
				  </div>
				</div>
			</div>
		);
	}
}

export default LightboxSortOptions;
