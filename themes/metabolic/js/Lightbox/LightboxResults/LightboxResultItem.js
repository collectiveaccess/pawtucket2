/**
 * Formats each item in the browse result using data passed in the "data" prop.
 *
 * Props are:
 * 		data : object containing data to display for result item
 * 		view : view format to use for display of results
 *
 * Sub-components are:
 * 		<NONE>
 *
 * Used by:
 *  	LightboxResults
 */

import React from "react";
import ReactDOM from "react-dom";
import { LightboxContext } from '../../Lightbox';
import { removeItemFromLightbox } from "../../../../default/js/lightbox";

const appData = pawtucketUIApps.Lightbox.data;
const lightboxTerminology = appData.lightboxTerminology;

class LightboxResultItem extends React.Component {
	constructor(props) {
		super(props);

    LightboxResultItem.contextType = LightboxContext;

		this.selectLightboxItem = this.selectLightboxItem.bind(this);

	}

	selectLightboxItem(e) {

		let state = this.context.state;
		let item_id = parseInt(e.target.attributes.getNamedItem('data-item_id').value);
		if(!item_id) { return; }
		let i = null;
		i = state.selectedItems.indexOf(item_id);
		if(i > -1){
			state.selectedItems.splice(i, 1);
		}else{
			state.selectedItems.push(item_id);
		}
		this.context.setState(state);
		// console.log("selectedItems: " + item_id + " : " + this.context.state.selectedItems.indexOf(item_id), this.context.state.selectedItems);
	}

	render() {
		let data = this.props.data;

		switch(this.props.view) {
			default:
				return(
          <div className={'card mb-4 bResultImage' + ((this.context.state.selectedItems.includes(data.id)) ? ' selected' : '')} ref={this.props.scrollToRef}>

            <div className='card-body mb-2'>
              <a href={data.detailUrl}><div dangerouslySetInnerHTML={{__html: data.representation}}/></a>

              {(this.context.state.showSelectButtons) ?
                <div className='float-left'>
                  <a onClick={this.selectLightboxItem} data-item_id={data.id} className={'selectItem' + ((this.context.state.selectedItems.includes(data.id)) ? ' selected' : '')} role='button' aria-expanded='false' aria-controls='Select item'><ion-icon name='checkmark-circle' data-item_id={data.id}></ion-icon></a>
                </div>
               : null}

              {(this.context.state.userAccess == 2) ?
                <div className='float-right'>
                  <a data-toggle='collapse' href={`#deleteConfirm${data.id}`} className='removeItemInitial' role='button' aria-expanded='false' aria-controls='collapseExample'><ion-icon name='close-circle'></ion-icon></a>
                </div>
               : null}

              <a href={data.detailUrl} dangerouslySetInnerHTML={{__html: data.caption}}></a>
            </div>

            <div className='card-footer collapse text-center' id={`deleteConfirm${data.id}`}>
              <a data-item_id={data.id} onClick={this.context.removeItemFromLightbox}>Remove Item From {lightboxTerminology.singular}</a>
            </div>

          </div>
					);
				break;
		}
	}
}

export default LightboxResultItem;
