'use strict';
import React, {useState} from 'react'
import Slider from "react-slick";

const Carousel = ({data}) => {
  const [ imgCount, setImgCount ] = useState(data.length)

  const settings = {
    showThumbnails: false,
    infiniteLoop: true,

    dots: true,
    infinite: true,
    speed: 500,
    slidesToShow: 1,
    slidesToScroll: 1,
    variableWidth: true,

    returnImgAsLink: 1,
    accessibility: true,

    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          infinite: true,
          infiniteLoop: true,
          dots: true,
          variableWidth: true,
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          infinite: true,
          infiniteLoop: true,
          dots: true,
          variableWidth: true,
        }
      },
      {
        breakpoint: 300,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          dots: true,
          infinite: true,
          infiniteLoop: true,
          variableWidth: true,
        }
      }
    ]
  };

  return (
    <Slider {...settings}>
      {data.map((image) => {
        return (
          <div className='img-container' key={image.key} dangerouslySetInnerHTML={{ __html: image.media_tag_large_link }}/>
        );
      })}
    </Slider>
  );
}

export default Carousel;