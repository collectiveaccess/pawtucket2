import React, { Component } from "react";
import SetItem from "./SetItem";

import "./InteractiveSets.css";

class Set extends Component {
  constructor(props) {
    super(props);
  }

  render() {
    return (
      <div>
        <div className="container-fluid">
          <div className="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 row-cols-xl-3">
            {this.props.currentSet.map((item) => {
              return <SetItem data={item} />;
            })}
          </div>
        </div>
      </div>
    );
  }
}

export default Set;
