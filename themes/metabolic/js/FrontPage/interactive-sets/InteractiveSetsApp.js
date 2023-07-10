import React, { Component } from "react";
import Set from "./Set";
import DummyFrontPage from "./DummyFrontPage";

import "bootstrap/dist/css/bootstrap.css";
import Button from "react-bootstrap/Button";

import "./InteractiveSets.css";

class InteractiveSetsApp extends Component {
  constructor(props) {
    super(props);
    this.state = {
      setData: this.props.data,
      showSetList: false,
      currentSet: this.props.data[0].items,
      currentSetName: this.props.data[0].set,
      mode: this.props.mode,
    };
  }

  showSetListHandler = () => {
    const doesShow = this.state.showSetList;
    this.setState({ showSetList: !doesShow });
  };

  setCurrentSet = (clickedSet) => {
    const { set, items } = clickedSet;
    this.setState({
      currentSet: items,
      currentSetName: set,
    });
  };

  render() {
    let setList = null;
    if (this.state.showSetList) {
      setList = (
        <div>
          {this.state.setData.map((set) => {
            return (
              <div style={{ padding: "10px" }} key={set.key}>
                <Button
                  onClick={() => this.setCurrentSet(set)}
                  variant="secondary"
                  size="lg"
                  block
                >
                  {set.set}
                </Button>
              </div>
            );
          })}
        </div>
      );
    }

    return (
      <React.StrictMode>
      <div className="App">
        <div className="container">
          <div className="row">
            <div className="col-sm-2">
              <div>
                <Button onClick={this.showSetListHandler} size="sm">
                  Show Set List
                </Button>
                {setList}
              </div>
            </div>

            <div className="col-sm-10">
              {this.state.showSetList === false ? (
                <div>
                  <DummyFrontPage />
                </div>
              ) : (
                <div>
                  <h3>{this.state.currentSetName}</h3>
                  <Set currentSet={this.state.currentSet} />
                </div>
              )}
            </div>
          </div>
        </div>
        {/* container end */}
      </div>
      </React.StrictMode>

    );
  }
}

export default InteractiveSetsApp;
