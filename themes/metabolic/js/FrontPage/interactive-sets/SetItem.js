import React, { Component } from "react";

import "bootstrap/dist/css/bootstrap.css";
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";

import "./InteractiveSets.css";

class SetItem extends Component {
  constructor(props) {
    super(props);
  }

  render() {
    return (
      <div className="col mb-4">
        <div className="card-container">
          <Card>
            <div
              className="img"
              dangerouslySetInnerHTML={{ __html: this.props.data.media_tag }}
            />
            <Card.Body>
              <Card.Text>
                <div
                  className="caption"
                  dangerouslySetInnerHTML={{ __html: this.props.data.caption }}
                />
              </Card.Text>
              <Button variant="outline-primary" size="sm">
                <a className="url" href={this.props.data.url} rel="noopener">
                  URL
                </a>
              </Button>
            </Card.Body>
          </Card>
        </div>
      </div>
    );
  }
}

export default SetItem;
