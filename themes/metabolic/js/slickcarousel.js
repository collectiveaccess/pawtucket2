'use strict';
import React from 'react';
import ReactDOM from 'react-dom';
import Slider from "react-slick";

const selector = pawtucketUIApps.slickcarousel.selector;
const appData = pawtucketUIApps.slickcarousel.data;
const imageList = appData.images;

const variableWidth = appData.variableWidth;
const slidesToScroll = appData.slidesToScroll;
const slidesToShow = appData.slidesToShow;
const speed = appData.speed;
const infinite = appData.infinite;
const dots = appData.dots;
const className = appData.className;
const autoplay = appData.autoplay;
const returnImgAsLink = appData.returnImgAsLink;

class SlickCarousel  extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			images: props.images,
			settings: {
				className: className,
				dots: dots,
				infinite: infinite,
				speed: speed,
				slidesToShow: slidesToShow,
				slidesToScroll: slidesToScroll,
				variableWidth: variableWidth,
				autoplay: autoplay,
				returnImgAsLink: returnImgAsLink,
			  ...props
      }
		}
	}
    render() {
			return (
				<Slider {...this.state.settings}>
					{this.state.images.map(function(image, i) { 
						var imageTag;
						if (returnImgAsLink) {
							imageTag = image.media_tag_link;
						} else {
							imageTag = image.media_tag;
						}
						return <div key={i}>
						<div dangerouslySetInnerHTML={{ __html : imageTag }} />
						<p className="legend" dangerouslySetInnerHTML={{ __html : image.caption }} />
					</div>})}
				</Slider>
			);
    }
};

ReactDOM.render(<SlickCarousel images={imageList} />, document.querySelector(selector));


