import React from "react";
export default function ErrorList(props) {
  var errors = props.errors;
  return React.createElement("div", {
    className: "panel panel-danger errors"
  }, React.createElement("div", {
    className: "panel-heading"
  }, React.createElement("h3", {
    className: "panel-title"
  }, "Errors")), React.createElement("ul", {
    className: "list-group"
  }, errors.map(function (error, i) {
    return React.createElement("li", {
      key: i,
      className: "list-group-item text-danger"
    }, error.stack);
  })));
}