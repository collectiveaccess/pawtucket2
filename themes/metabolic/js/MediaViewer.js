/*jshint esversion: 6 */
import React, {useCallback} from 'react';
import ReactDOM from "react-dom";
import { MediaViewerList } from './MediaViewer/MediaViewerList';
import { VideoViewer } from './MediaViewer/VideoViewer';
import { PDFViewer } from './MediaViewer/PDFViewer';
import { ImageViewer } from './MediaViewer/ImageViewer';

const axios = require('axios');
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const selector = pawtucketUIApps.MediaViewer.selector;
const appData = pawtucketUIApps.MediaViewer.data;

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
		
		this.state = {
			media: this.props.media,
			index: 0,
			
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
		nHeight -= ncontrolHeight;
		let viewerHeight = nHeight + 'px';	// adjusted to provide space for controls
		
		if (fullscreen) {
			width =  this.state.windowWidth + 'px';
			height =  this.state.windowHeight + 'px';
			viewerHeight =  (this.state.windowHeight - ncontrolHeight - 8) + 'px';
		}
		
		let nWidth = parseInt(width.replace(/[^\d]+/g, ''));
		let controlWidth = (nWidth - 26) + 'px';
		
		
		let standardProps = {
			width: width, 
			height: viewerHeight, 
			fullscreen: fullscreen
		};
		let classes = ['mediaViewerContainer'];
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
						<PDFViewer url={mediaInfo.url} {...standardProps}/>
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
		if(!fullscreen) {
			fs.style.display = 'none';
			return(
				<div className='mediaViewer' style={{width: width, height: height}}>
					{viewer}
					<MediaViewerList media={this.state.media} index={this.state.index} setMedia={this.setIndex} fullscreen={fullscreen}
						width={controlWidth} height={controlHeight} toggleFullscreen={this.toggleFullscreen}/>
				</div>
			);
		} else {
			fs.style.display = 'block';
			if (!fs) return null;
			return ReactDOM.createPortal(
				(<div className='mediaViewer' style={{width: width, height: height}}>
					<div style={{height: viewerHeight}}>{viewer}</div>
					<MediaViewerList media={this.state.media} index={this.state.index} setMedia={this.setIndex} fullscreen={fullscreen}
						width={controlWidth} height={controlHeight} toggleFullscreen={this.toggleFullscreen}/>
				</div>),
				fs
			);
		}
	}
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
