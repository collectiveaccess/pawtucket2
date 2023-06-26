'use strict';
import React from 'react';
import ReactDOM from 'react-dom';

const e = React.createElement;

let selector = pawtucketUIApps.expandandscroll.selector;

class ExpandAndScroll extends React.Component {
  constructor(props) {
    super(props);
    this.state = { hide: true };
  }

  render() {
    return (<a href="#">{this.props.text}</a>)
  }
}

// Find all DOM containers, and render into them.
document.querySelectorAll(selector)
  .forEach(domContainer => {
    // Read data from a data-* attributes
    let target = domContainer.dataset.target;
    let text = domContainer.dataset.text;
    ReactDOM.render(
      e(ExpandAndScroll, { 'text': text, 'target': target }),
      domContainer
    );
  });