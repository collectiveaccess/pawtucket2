'use strict';
import React from 'react';
import ReactDOM from 'react-dom';

const selector = pawtucketUIApps.gallery.selector;
const appData = pawtucketUIApps.gallery.data;
const sectionName = appData.sectionName;

	class GalleryInfo extends React.Component {
		render() {
			return (
			    <div>
                    <h1>Section Name: Set Title</h1>
                    <p>Description</p>
				</div>
			);
		}
	}
	class GalleryPrevious extends React.Component {
		render() {
			return (
				<button className='btn btn-secondary'><ion-icon name='ios-arrow-back'></ion-icon></button>
			);
		}
	}
	class GalleryNext extends React.Component {
		render() {
			return (
				<button className='btn btn-secondary'><ion-icon name='ios-arrow-forward'></ion-icon></button>
			);
		}
	}
	class GalleryItem extends React.Component {
		render() {
			return (
						<div className='row'>
							<div className='col-12 col-sm-8'>
								<GalleryItemMedia />
							</div>
							<div className='col-12 col-sm-4' id='galleryDetailObjectInfo'>
								<GalleryItemInfo />
							</div>
						</div>	
				
			);
		}
	}
	class GalleryItemMedia extends React.Component {
		render() {
			return (
				<div className='galleryPrimaryMedia'>Image here</div>
			);
		}
	}
	class GalleryItemInfo extends React.Component {
		render() {
			return (
			    <div>
                    <div className='mb-3'>
                        <small>1/20</small>
                    </div>
                    <h2>Item Title</h2>
                    <div className='mb-3'>
                        <div className='label'>Title</div>
                        Title here
                    </div>
                    <div className='mb-3'>
                        <div className='label'>Date</div>
                        Date
                    </div>
                    <div className='py-3'>
                        <a href='#' className='btn btn-primary'>View <ion-icon name='ios-arrow-forward'></ion-icon></a>
                    </div>
                </div>
			);
		}
	}
	class GalleryDetail extends React.Component {
		constructor(props) {
			super(props);
			this.state = {
				settings: {
					sectionName: sectionName,
					...props
				}
			}
		}
		render() {
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
                                <GalleryPrevious />
                            </div>
                        </div>
                        <div className='col-8 col-sm-10'>
                            <GalleryItem />
                        </div>
                        <div className='col-2 col-sm-1 text-right'>
                            <div className='galleryDetailNav'>
                                <GalleryNext />
                            </div>
                        </div>
                    </div>
                </div>
			);
		}
	}
    

ReactDOM.render(<GalleryDetail />, document.querySelector(selector));


