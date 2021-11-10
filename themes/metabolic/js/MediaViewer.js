/*jshint esversion: 6 */
import React, {useCallback} from 'react';
import ReactDOM from "react-dom";
import { MediaViewerList } from './MediaViewer/MediaViewerList';
import { VideoViewer } from './MediaViewer/VideoViewer';

import DocumentViewer from './MediaViewer/DocumentViewer';
import DocumentContextProvider from './MediaViewer/DocumentViewer/DocumentContext';

// import { DocumentViewer } from './MediaViewer/DocumentViewer';
import { ImageViewer } from './MediaViewer/ImageViewer';

// import MdExpand from 'react-ionicons/lib/MdExpand'
// import MdExit from 'react-ionicons/lib/MdExit'


const axios = require('axios');
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const selector = pawtucketUIApps.MediaViewer.selector;
const viewerOptions = pawtucketUIApps.MediaViewer.options;
if(!viewerOptions) { viewerOptions = {}; }

/**
 * Component context making Lightbox internals accessible to all subcomponents
 *
 * @type {React.Context}
 */
const MediaViewerContext = React.createContext();

/**
 *
 */
class MediaViewer extends React.Component{
	constructor(props) {
		super(props);
		
		this.viewerRef = React.createRef();
		
		let index = 0;
		for(let i in this.props.media) {
			if (this.props.media[i]['is_primary'] === '1') {
				index = i;
			}
		}
		
		this.state = {
			media: this.props.media,
			index: index,
			
			parent: document.getElementById(selector.substr(1)),
			
			width: this.props.width ? this.props.width : '500px',
			height: this.props.height ? this.props.height : '500px',
			controlHeight: this.props.controlHeight ? this.props.controlHeight : '72px',
			
			windowWidth: null,
			windowHeight: null,
			
			fullscreen: false
		};
		
		this.setIndex = this.setIndex.bind(this);
		this.toggleFullscreen = this.toggleFullscreen.bind(this);
	}

	setIndex(index) {
		if (this.state.media.length === 0) { return false; }
		if (index < 0) { return false; }
		if (index >= this.state.media.length) { return false; }
		
		this.setState({index: index});
		return true;
	}
	
	componentDidMount() {
		this.updateWindowDimensions();
		window.addEventListener('resize', this.updateWindowDimensions);
	}

	componentWillUnmount() {
		window.removeEventListener('resize', this.updateWindowDimensions);
	}

	updateWindowDimensions() {
		this.setState({ windowWidth: window.innerWidth, windowHeight: window.innerHeight });
	}
	
	toggleFullscreen(e) {
		this.setState({ fullscreen: !this.state.fullscreen });
		e.preventDefault();
	}
	
	render() {
		let viewer = null;
		let mediaInfo = this.state.media[this.state.index];
		if (!mediaInfo) { return null; }
		let fullscreen = this.state.fullscreen ? true : false;
		
		let width = this.state.width;
		let height = this.state.height;
		let controlHeight = this.state.controlHeight;
		
		let nHeight = parseInt(height.replace(/[^\d]+/g, ''));
		let ncontrolHeight = parseInt(controlHeight.replace(/[^\d]+/g, ''));
		if(this.props.media.length > 1) {
			nHeight -= ncontrolHeight;
		}
		let viewerHeight = nHeight + 'px';	// adjusted to provide space for controls
		
		if (fullscreen) {
			width =  this.state.windowWidth + 'px';
			height =  this.state.windowHeight + 'px';
			viewerHeight =  (this.state.media > 1) ? (this.state.windowHeight - ncontrolHeight - 8) + 'px' : (this.state.windowHeight - 32) + 'px';
		}
		
		const viewerRef = this.viewerRef.current;
		
		let nWidth;
		if(width.match(/%/g)) {
			if(viewerRef) {
				nWidth = viewerRef.clientWidth;
			} else {
				nWidth = 500;
			}
		} else {
			nWidth = parseInt(width.replace(/[^\d]+/g, ''));
		}
		let controlWidth = (nWidth - 26) + 'px';
		
		let standardProps = {
			width: width, 
			height: viewerHeight, 
			fullscreen: fullscreen
		};

		let classes = ['mediaViewerContainer'];
		// console.log("media info: ", mediaInfo);
		switch(mediaInfo.class) {
			case 'image':
				viewer = (
					<div className={classes.join(' ')}>
						<ImageViewer url={mediaInfo.url} {...standardProps}/>
					</div>
				);
				break;
			case 'audio':
			case 'video':
				viewer = (
					<div className={classes.join(' ')}>
						<VideoViewer playlist={[mediaInfo.url]} {...standardProps}/>
					</div>
				);
				break;
			case 'document':
				viewer =  (
					<div className={classes.join(' ')}>
						<DocumentContextProvider> <DocumentViewer url={mediaInfo.url} {...standardProps} pages={mediaInfo.pages} options={viewerOptions.pdfViewer}/> </DocumentContextProvider>
					</div>
				);
				break;
			default:
				viewer = (
					<div className='mediaViewerContainer'>Unsupported media type {mediaInfo.class}</div>
				);
				break;
		}
		
		const fs = document.getElementById('mediaDisplayFullscreen');
	
		// const icon = this.props.fullscreen === false ? (<MdExpand fontSize='24px'/>) : (<MdExit fontSize='24px'/>);

		// const iconTitle = this.props.fullscreen === false ? 'Expand fullscreen' : 'Exit';

		// let viewerMediaList = (this.state.media.length > 1) ? <MediaViewerList media={this.state.media} index={this.state.index} setMedia={this.setIndex} fullscreen={fullscreen} width={controlWidth} height={controlHeight} toggleFullscreen={this.toggleFullscreen} /> 
		// 	: <div className='float-right'><a href='#' onClick={this.toggleFullscreen} title={iconTitle}>{icon}</a></div>;

		let viewerMediaList = (this.state.media.length > 1) ? <MediaViewerList media={this.state.media} index={this.state.index} setMedia={this.setIndex} fullscreen={fullscreen} width={controlWidth} height={controlHeight} toggleFullscreen={this.toggleFullscreen} /> 
			: null;
				
		let mediaViewer = null
		if(mediaInfo.class == "document"){
			mediaViewer = (
				<div className='mediaViewer' style={{ width: width, height: height }} ref={this.viewerRef}>		
					{viewer}
					{viewerMediaList}
				</div>
			)
		}else{
			mediaViewer = (
				<div className='mediaViewer' style={{ width: width, height: height }} ref={this.viewerRef}>		
					{viewer}
					{viewerMediaList}
				</div>
			)
		}

		if (!fullscreen) {
			fs.style.display = 'none';
			return (
				<div>
					{mediaViewer}
				</div>
				// <div className='mediaViewer' style={{ width: width, height: height }} ref={this.viewerRef}>		
				// 	{viewer}
				// 	{viewerMediaList}
				// </div>
			);
		} else {
			fs.style.display = 'block';
			if (!fs) return null;
			return ReactDOM.createPortal(
				(<div className='mediaViewer' style={{ width: width, height: height }} ref={this.viewerRef}>
					<div style={{ height: viewerHeight }}>{viewer}</div>
					{viewerMediaList}
				</div>),
				fs
			);
		}
	
	} //render
}


/**
 * Initialize browse and render into DOM. This function is exported to allow the Pawtucket
 * app loaders to insert this application into the current view.
 */
export default function _init() {
	ReactDOM.render(
		<MediaViewer media={pawtucketUIApps.MediaViewer.media} 
			width={pawtucketUIApps.MediaViewer.width}
			height={pawtucketUIApps.MediaViewer.height}
			controlHeight={pawtucketUIApps.MediaViewer.controlHeight}/>, document.querySelector(selector));
}
