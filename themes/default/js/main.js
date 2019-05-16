'use strict';
import React from 'react';
import ReactDOM from 'react-dom';
React.PropTypes=require('prop-types');
React.createClass=require('create-react-class');


const e = React.createElement;

class LikeButton extends React.Component {
  constructor(props) {
    super(props);
    this.state = { liked: false };
  }

  render() {
    if (this.state.liked) {
      return 'You liked this.';
    }

    return e(
      'button',
      { onClick: () => this.setState({ liked: true }) },
      'Like'
    );
  }
}

const domContainer = document.querySelector(myApp.selector);
ReactDOM.render(e(LikeButton), domContainer);

require("./carousel.js");
