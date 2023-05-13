'use strict';
import React from 'react';
import ReactDOM from 'react-dom';
const axios = require('axios');

const selector = pawtucketUIApps.gallery.selector;
const appData = pawtucketUIApps.gallery.data;
const sectionName = appData.sectionName;
/*const state = {
				numSetItems: appData.setContents.length,
				itemList: appData.setContents,
				key: 0,
				item: appData.setContents[0],
				loadingMore: false
			}
*/
/**
 * Initial state
 */
//function initialState() {
//	return {
//		numSetItems: appData.setContents.length,
//		itemList: appData.setContents,
//		key: 0,
//		loadingMore: false
//	};
//}
//function fetchSetContents(url, callback, useDefaultKey=true) {
	// Fetch set information and items
// 	axios.get(url + "/Gallery/getSetContentAsJSON/set_id/" + appData.set_id + "/ajax/1")
// 		.then(function (resp) {
// 			let data = resp.data;
// 			let state = initialState();
// 
// 			state.numSetItems = 123;
// 			state.itemList = null;
// 			state.key = null;
// 			state.setTitle = 0;
// 			state.setDescription = 0;
// 			state.loadingMore = false;	
// 		
// 			callback(state);
// 		})
// 		.catch(function (error) {
// 			console.log("Error while loading set information: ", error);
// 		});
// }
	class GalleryInfo extends React.Component {
		render() {
			return (
			    <div>
                    <h1>{appData.sectionName} {appData.setLabel}</h1>
                    <p>{appData.setDescription}</p>
				</div>
			);
		}
	}
	class GalleryPrevious extends React.Component {
		render() {
			let classname = "btn btn-secondary";
			if(this.props.itemKey == 0){
				classname += " disabled";
			}
			return (
				<button className={classname} onClick={this.props.onPrevious}><ion-icon name='ios-arrow-back'></ion-icon></button>
			);
		}
	}
	class GalleryNext extends React.Component {
		render() {
			let classname = "btn btn-secondary";
			if(this.props.itemKey >= (this.props.numSetItems - 1)){
				classname += " disabled";
			}
			return (
				<button className={classname} onClick={this.props.onNext}><ion-icon name='ios-arrow-forward'></ion-icon></button>
			);
		}
	}
	class GalleryItem extends React.Component {
		render() {
			return (
						<div className='row'>
							<div className='col-12 col-sm-8'>
								<div className='galleryPrimaryMedia align-middle' dangerouslySetInnerHTML={{__html: this.props.itemMedia}}></div>
							</div>
							<div className='col-12 col-sm-4' id='galleryDetailObjectInfo'>
								<GalleryItemInfo itemKey={this.props.itemKey} numSetItems={this.props.numSetItems} itemDescription={this.props.itemDescription}/>
							</div>
						</div>	
				
			);
		}
	}
	class GalleryItemInfo extends React.Component {
		render() {
			return (
			    <div>
                    <div className='mb-3'>
                       <small>{this.props.itemKey + 1}/{this.props.numSetItems}</small>
                    </div>
                    <div dangerouslySetInnerHTML={{__html: this.props.itemDescription}}></div>
                </div>
			);
		}
	}
	class GalleryDetailBottom extends React.Component {
		render() {
			let thumbnailList = [];
			if(this.props.itemList && (this.props.itemList.length > 0)) {
				for (let i in this.props.itemList) {
					let r = this.props.itemList[i];
					let classname = "card";
					if(this.props.itemKey == i){
						classname += " active";
					}
					thumbnailList.push(<div className='colNarrowPadding col-6 col-sm-4 col-md-2 col-lg-2 col-xl-1 mb-3'><div className={classname} onClick={() => this.props.loadItem(i)} dangerouslySetInnerHTML={{__html: r.media_tag_iconlarge}}></div></div>);
				}
			}
			
			
			return (
				<div className='row galleryDetailBottom mt-5 pt-5'>
					<div className='col-sm-12'>
						<div className='row rowNarrowPadding'>
							{thumbnailList}
						</div>
					</div>
				</div>
			);
		}
	}

	class GalleryDetail extends React.Component {
		constructor(props) {
			super(props);
			//fetchSetContents("http://metabolic2.whirl-i-gig.com:8084/index.php", function(newState) {
			//	callback(newState);
			//}, null)
			this.state = {
				numSetItems: appData.setContents.length,
				itemList: appData.setContents,
				key: 0,
				item: appData.setContents[0],
				loadingMore: false
			}
			this.onNext = this.onNext.bind(this);
			this.onPrevious = this.onPrevious.bind(this);
			this.loadItem = this.loadItem.bind(this);
		}
		onNext(){
			if(this.state.key < (this.state.numSetItems - 1)){
				this.setState({key: this.state.key + 1});
			}
		}
		onPrevious(){
			if(this.state.key > 0){
				this.setState({key: this.state.key - 1});
			}
		}
		loadItem(k){
			k = Number(k);
			if(!k){
				k = 0;
			}
			if(k < this.state.numSetItems){
				this.setState({key: k});
			}
		}

		render() {
			let state = this.state;
			var setItem = state.itemList[state.key];
			return (
			    <div>
                    <div className='row'>
                        <div className='col-sm-12 pb-5'>
                            <GalleryInfo />
                        </div>
                    </div>
                    <div className='row'>
                        <div className='col-2 col-sm-1 text-left'>
                            <div className='galleryDetailNav'>
                                <GalleryPrevious onPrevious={this.onPrevious} itemKey={state.key} />
                            </div>
                        </div>
                        <div className='col-8 col-sm-10'>
                            <GalleryItem itemMedia={setItem.media_tag_large_link} itemKey={state.key} numSetItems={state.numSetItems} itemDescription={setItem.itemDescription} />
                        </div>
                        <div className='col-2 col-sm-1 text-right'>
                            <div className='galleryDetailNav'>
                                <GalleryNext onNext={this.onNext} itemKey={state.key} numSetItems={state.numSetItems} />
                            </div>
                        </div>
                    </div>
                    <GalleryDetailBottom itemKey={state.key} itemList={state.itemList} loadItem={this.loadItem} />
                </div>
			);
		}
	}
    

ReactDOM.render(<GalleryDetail />, document.querySelector(selector));


