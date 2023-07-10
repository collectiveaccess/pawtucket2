'use strict';
import React from 'react';
import ReactDOM from 'react-dom';

const selector = pawtucketUIApps.carousel.selector;
const appData = pawtucketUIApps.carousel.data;
const imageList = appData.images;
const width = appData.width;
const showThumbnails = appData.showThumbnails;
const centerMode = appData.centerMode;
const centerSlidePercentage = appData.centerSlidePercentage;
const infiniteLoop = appData.infiniteLoop;
const autoPlay = appData.autoPlay;

var Carousel = require('react-responsive-carousel').Carousel;
class MediaCarousel  extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			images: props.images
		}
	}
    render() {
        return (
            <Carousel autoPlay={autoPlay} stopOnHover={false} showThumbs={showThumbnails} thumbWidth={100} width={width} dynamicHeight={true} showArrows={true} centerMode={centerMode} centerSlidePercentage={centerSlidePercentage} infiniteLoop={infiniteLoop}>
			{this.state.images.map(function(image, i) { return <div key={i}>
				<div class="slideContainer"><img src={image.url} />
				<p className="legend" dangerouslySetInnerHTML={{ __html : image.caption }} />
				</div>
			</div>})}
            </Carousel>
        );
    }
};

ReactDOM.render(<MediaCarousel images={imageList}/>, document.querySelector(selector));


