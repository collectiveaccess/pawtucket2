/*jshint esversion: 6 */
import React from 'react';
import ReactDOM from 'react-dom';
import Slider from 'react-slick';

// import MdExpand from 'react-ionicons/lib/MdExpand'
// import MdExit from 'react-ionicons/lib/MdExit'

/**
 *
 */
class MediaViewerList extends React.Component{
	constructor(props) {
		super(props);
		this.state = {
			media: this.props.media,
			index: parseInt(this.props.index)
		};
		
		this.loadMedia = this.loadMedia.bind(this);
	}
	
	loadMedia(e) {
		const index = parseInt(e.target.dataset.index);
		
		this.setState({ index: index });
		if(this.props.setMedia) {
			this.props.setMedia(index);
		}
		e.preventDefault();
	}
	
	render() {
		const nWidth = parseInt(this.props.width.replace(/[^\d]+/g, ''));
		const nHeight = parseInt(this.props.height.replace(/[^\d]+/g, ''));
		if(!nHeight) { nHeight = 72; }
		const maxThumbnails = Math.floor(nWidth / nHeight);
		let n = this.state.media.length;
		let hasArrows = false;
		if (n > maxThumbnails) { 
			n = maxThumbnails; 
			hasArrows = true;
		}
		
		const offset = hasArrows ? 24 : 0; // left arrow extends 24 pixels past left side
		let adjustedWidth = (nWidth - offset) + 'px';
		let adjustedHeight = nHeight + 'px';
		
		
		let settings = {
		  dots: false,
		  arrows: true,
		  accessibility: true,
		  infinite: false,
		  speed: 500,
		  slidesToShow: n,
		  slidesToScroll: n-1,
		  adaptiveHeight: true,
		  variableWidth: true
		};
		let mediaList = this.state.media.map((v, i) => {
			const selected = (this.state.index === i) ? 'slick-selected' : '';
			return (<a href='#' onClick={this.loadMedia} className={selected} key={i}><img data-index={i} src={v.urls.icon} style={{border: '3px transparent solid'}}/></a>);
		});
		
		// const icon = this.props.fullscreen === false ? (<MdExpand fontSize='24px'/>) : (<MdExit fontSize='24px'/>);
		// const iconTitle = this.props.fullscreen === false ? 'Expand fullscreen' : 'Exit';
				
		return(
			<div className='mediaViewerControls'>
				<div className='float-right'>
					{/* <a href='#' onClick={this.props.toggleFullscreen} title={iconTitle}>{icon}</a> */}
				</div>
				<div style={{width: adjustedWidth, height: adjustedHeight, marginLeft: offset + 'px'}}>
					<Slider {...settings} className='mediaViewerList'>{mediaList}</Slider>	
				</div>
			</div>
		);
	}
}

export { MediaViewerList };

