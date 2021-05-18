import React, { Component } from "react";
import "./Carousel.css";
import CarouselComponent from "./CarouselComponent";

class CarouselApp extends Component {
  constructor(props) {
    super(props);
  }

  render() {
    return (
      <div className="App">
        <CarouselComponent data={this.props.data} />
      </div>
    );
  }
}

export default CarouselApp;
