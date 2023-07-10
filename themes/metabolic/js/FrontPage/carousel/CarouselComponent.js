import React, { Component } from "react";

import Slider from "react-slick";
import "slick-carousel/slick/slick.css";
import "slick-carousel/slick/slick-theme.css";

import "bootstrap/dist/css/bootstrap.css";
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";

import "./Carousel.css";

class CarouselComponent extends Component {
  constructor(props) {
    super(props);
  }

  render() {
    const settings = {
      arrows: true,
      className: "slides",
      dots: true,
      // fade: true,
      infinite: true,
      slidesToScroll: 1,
      slidesToShow: 3,
      speed: 500,
    };

   let data = this.props.data ? this.props.data : [];
    return (
      <Slider {...settings}>
        {data.map((item) => {
          return (
            <div className="container">
            <React.StrictMode>
              <Card>
                <div
                  className="image"
                  dangerouslySetInnerHTML={{
                    __html: item.media_tag,
                  }}
                />
                <Card.Body>
                  <Card.Text as="div">
                    <div
                      className="caption"
                      dangerouslySetInnerHTML={{
                        __html: item.caption,
                      }}
                    />
                  </Card.Text>
                  <Button variant="outline-primary" size="sm">
                    <a className="url" href={item.url} rel="noopener">
                      URL
                    </a>
                  </Button>
                </Card.Body>
              </Card>
              </React.StrictMode>
            </div>
          );
        })}
      </Slider>
    );
  }
}

export default CarouselComponent;
