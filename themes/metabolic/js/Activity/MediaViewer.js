/*jshint esversion: 6 */
import React, { useCallback } from 'react';
import ReactDOM from "react-dom";
import { MediaViewerList } from '../MediaViewer/MediaViewerList';
import { VideoViewer } from '../MediaViewer/VideoViewer';
import { DocumentViewer } from '../MediaViewer/DocumentViewer';
import { ImageViewer } from '../MediaViewer/ImageViewer';

const axios = require('axios');
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Component context making Lightbox internals accessible to all subcomponents
 * @type {React.Context}
 */
const MediaViewerContext = React.createContext();

/**/
class MediaViewer extends React.Component {
	constructor(props) {
		super(props);

		this.viewerRef = React.createRef();

		let index = 0;
		for (let i in this.props.media) {
			if (this.props.media[i]['is_primary'] === '1') {
				index = i;
			}
		}

		this.state = {
			media: this.props.media,
			index: index,

			// parent: document.getElementById(selector.substr(1)),

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

		this.setState({ index: index });
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
		if(window.innerWidth && window.innerHeight){
			this.setState({ windowWidth: window.innerWidth, windowHeight: window.innerHeight });
		}
	}

	toggleFullscreen(e) {
		this.setState({ fullscreen: !this.state.fullscreen });
		e.preventDefault();
	}

	render() {
		let viewer = null;

		let mediaInfo = this.props.media;	// SETH CHANGED: use prop, not state - state is not updated on click

		// if (!mediaInfo) { 
		// 	return null;
		// }

		let fullscreen = this.state.fullscreen ? true : false;

		let width = this.state.width;
		let height = this.state.height;
		let controlHeight = this.state.controlHeight;

		let nHeight = parseInt(height.replace(/[^\d]+/g, ''));
		let ncontrolHeight = parseInt(controlHeight.replace(/[^\d]+/g, ''));
		nHeight -= ncontrolHeight;
		let viewerHeight = nHeight + 'px';	// adjusted to provide space for controls

		if (fullscreen) {
			width = this.state.windowWidth + 'px';
			height = this.state.windowHeight + 'px';
			viewerHeight = (this.state.windowHeight - ncontrolHeight - 8) + 'px';
		}

		const viewerRef = this.viewerRef.current;

		let nWidth;
		if (width.match(/%/g)) {
			if (viewerRef) {
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

		if (typeof mediaInfo !== 'object') {
			// console.log("is string", this.props.class, mediaInfo);
			// mediaInfo = this.props.media;

			switch (this.props.class) {
				case 'image':
					viewer = (
						<div className={classes.join(' ')} style={{height: '100%'}}>
							<ImageViewer url={mediaInfo} {...standardProps} />
						</div>
					)
					break;
				case 'audio':
				case 'video':
					viewer = (
						<div className={classes.join(' ')}>
							<VideoViewer playlist={mediaInfo} {...standardProps} />
						</div>
					);
					break;
				case 'document':
					viewer = (
						<div className={classes.join(' ')}>
							<DocumentViewer url={mediaInfo} {...standardProps} />
						</div>
					);
					break;
				default:
					viewer = (
						<div className='mediaViewerContainer'>Unsupported media type {this.props.class}</div>
					);
					break;
			}
		} else {
			// console.log("is object", mediaInfo);
			mediaInfo = this.state.media[this.state.index];

			switch (mediaInfo.class) {
				case 'image':
					viewer = (
						<div className={classes.join(' ')}>
							<ImageViewer url={mediaInfo.url} {...standardProps} />
						</div>
					);
					break;
				case 'audio':
				case 'video':
					viewer = (
						<div className={classes.join(' ')}>
							<VideoViewer playlist={[mediaInfo.url]} {...standardProps} />
						</div>
					);
					break;
				case 'document':
					viewer = (
						<div className={classes.join(' ')}>
							<DocumentViewer url={mediaInfo.url} {...standardProps} />
						</div>
					);
					break;
				default:
					viewer = (
						<div className='mediaViewerContainer'>Unsupported media type {mediaInfo.class}</div>
					);
					break;
			}
		}

		// console.log(this.props.class);

		// switch (this.props.class) {
		// 	case "image":
		// 		viewer = (
		// 			<div className={classes.join(' ')}>
		// 				<ImageViewer url={this.props.media} {...standardProps} />
		// 			</div>
		// 		);
		// 		break;
		// 	case 'audio':
		// 	case 'video':
		// 		viewer = (
		// 			<div className={classes.join(' ')}>
		// 				<VideoViewer playlist={[mediaInfo.url]} {...standardProps} />
		// 			</div>
		// 		);
		// 		break;
		// 	case 'document':
		// 		viewer = (
		// 			<div className={classes.join(' ')}>
		// 				<DocumentViewer url={mediaInfo.url} {...standardProps} />
		// 			</div>
		// 		);
		// 		break;
		// 	default:
		// 		viewer = (
		// 			<div className='mediaViewerContainer'>Unsupported media type {this.props.class}</div>
		// 		);
		// 		break;
		// }

		const fs = document.getElementById('mediaDisplayFullscreen');

		if (!fullscreen) {
			fs.style.display = 'none';
			return (
				<div className='mediaViewer' style={{ width: width, height: height }} ref={this.viewerRef}>
					{viewer}
					{/* <MediaViewerList media={this.state.media} index={this.state.index} setMedia={this.setIndex} fullscreen={fullscreen}
						width={controlWidth} height={controlHeight} toggleFullscreen={this.toggleFullscreen} /> */}
				</div>
			);
		} else {
			fs.style.display = 'block';
			if (!fs) return null;
			return ReactDOM.createPortal(
				(<div className='mediaViewer' style={{ width: width, height: height }} ref={this.viewerRef}>
					<div style={{ height: viewerHeight }}>{viewer}</div>
					{/* <MediaViewerList media={this.state.media} index={this.state.index} setMedia={this.setIndex} fullscreen={fullscreen}
						width={controlWidth} height={controlHeight} toggleFullscreen={this.toggleFullscreen} /> */}
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
export default MediaViewer 

