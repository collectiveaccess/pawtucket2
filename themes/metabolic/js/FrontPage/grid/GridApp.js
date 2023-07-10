import React, { Component } from "react";
import GridList from "./GridList";

class GridApp extends Component {
  constructor(props) {
    super(props);
  }

  render() {
  	let data = this.props.data ? this.props.data : [];
    return (
      <React.StrictMode>
      <div className="App">
        <div className="container">
          <GridList data={data} />
        </div>
      </div>
      </React.StrictMode>
    );
  }
}

export default GridApp;
