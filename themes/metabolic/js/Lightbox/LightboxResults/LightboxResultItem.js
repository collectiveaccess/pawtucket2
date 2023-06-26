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

const appData = pawtucketUIApps.Lightbox.data;
const lightboxTerminology = appData.lightboxTerminology;

class LightboxResultItem extends React.Component {
	constructor(props) {
		super(props);

    	LightboxResultItem.contextType = LightboxContext;
		this.selectLightboxItem = this.selectLightboxItem.bind(this);
		this.handleImageClick = this.handleImageClick.bind(this);
	}

	selectLightboxItem(e) {
		let state = this.context.state;
		
		let item_id = this.props.data.id;
		if(!item_id) { return; }
		let i = null;
		i = state.selectedItems.indexOf(item_id);
		if(i > -1){
			state.selectedItems.splice(i, 1);
		}else{
			state.selectedItems.push(item_id);
		}
		this.context.setState(state);
		e.preventDefault();
	}

	handleImageClick(e) {
		if (this.context.state.showSelectButtons) {
			this.selectLightboxItem(e);
			e.preventDefault();
		}
	}

	render() {
		let data = this.props.data;
		let mediaTag = (data && data.media && data.media[0]) ? data.media[0].tag : '';

		switch(this.props.view) {
			default:
				return(
          <div className={'card mb-4 bResultImage' + ((this.context.state.selectedItems.includes(data.id)) ? ' selected' : '')} ref={this.props.scrollToRef}>

            <div className='card-body mb-2'>

              <a href={data.detailPageUrl}>
                <div dangerouslySetInnerHTML={{__html: mediaTag}} onClick={this.handleImageClick} />
              </a>

              {(this.context.state.showSelectButtons) ?
                <div className='float-left'>
                  <a onClick={this.selectLightboxItem} data-item_id={data.id} className={'selectItem' + ((this.context.state.selectedItems.includes(data.id)) ? ' selected' : '')} role='button' aria-expanded='false' aria-controls='Select item'>
                    <ion-icon name='checkmark-circle' data-item_id={data.id} style={{cursor: 'pointer'}}></ion-icon>
                  </a>
                </div>
              : null}

              <a href={data.detailPageUrl} dangerouslySetInnerHTML={{__html: data.title}} onClick={this.handleImageClick}></a>
            </div>

          </div>
				);
			break;
		}
	}
}

export default LightboxResultItem;
