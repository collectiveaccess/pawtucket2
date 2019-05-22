'use strict';
import React from 'react';
import ReactDOM from 'react-dom';

const selector = pawtucketUIApps.carousel.selector;
const appData = pawtucketUIApps.carousel.data;
const imageList = appData.images;
const width = appData.width;

var Carousel = require('react-responsive-carousel').Carousel;
class DemoCarousel  extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			images: props.images
		}
	}
    render() {
        return (
            <Carousel autoPlay={true} stopOnHover={false} showThumbs={true} thumbWidth={100} width={width} dynamicHeight={true} showArrows={true}>
			{this.state.images.map(function(image, i) { return <div key={i}>
				<img src={image.url} />
				<p className="legend">{image.caption}</p>
			</div>})}
            </Carousel>
        );
    }
};

ReactDOM.render(<DemoCarousel images={imageList}/>, document.querySelector(selector));


