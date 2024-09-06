import React, { Component } from 'react';

export default class WrappedWidget extends Component {

  constructor(props) {
    super(props);

    this.element = React.createRef();
  }

  renderWidget(props) {
    const widgetEl = this.props.widget({
      annotation: props.annotation,
      readOnly: props.readOnly,
      ...props.config,
      onAppendBody: (body, saveImmediately) => props.onAppendBody(body, saveImmediately),
      onUpdateBody: (previous, updated, saveImmediately) => props.onUpdateBody(previous, updated, saveImmediately),
      onUpsertBody: (previous, updated, saveImmediately) => props.onUpsertBody(previous, updated, saveImmediately),
      onRemoveBody: (body, saveImmediately) => props.onRemoveBody(body, saveImmediately),
      onBatchModify: (diffs, saveImmediately)  => props.onBatchModify(diffs, saveImmediately),
      onSetProperty: (property, value) =>  props.onSetProperty(property, value),
      onAddContext: uri => props.onAddContext(uri),
      onSaveAndClose: () => props.onSaveAndClose()
    });

    // Delete previous rendered state
    while (this.element.current.firstChild)
      this.element.current.removeChild(this.element.current.lastChild);

    this.element.current.appendChild(widgetEl);
  }

  componentDidMount() {
    this.renderWidget(this.props);
  }

  componentWillReceiveProps(next) {
    if (this.element.current) {
      if (this.props.annotation !== next.annotation) {
        this.renderWidget(next);
      }
    }
  }

  render() {
    return (
      <div ref={this.element} className="widget"></div>
    )
  }

}
