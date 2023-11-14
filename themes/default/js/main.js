'use strict';
import React from 'react';
import ReactDOM from 'react-dom';

const domContainer = document.querySelector("#pawtucketApp");
if (!Object.entries)
  Object.entries = function( obj ){
    var ownProps = Object.keys( obj ),
        i = ownProps.length,
        resArray = new Array(i); // preallocate the Array
    while (i--)
      resArray[i] = [ownProps[i], obj[ownProps[i]]];

    return resArray;
};

export default function _initPawtucketApps() {
	// Loop through configured page apps
	let themeErr = null;
	Object.entries(pawtucketUIApps).forEach(([key, value]) => {
		try {
			let m = require('themeJS/' + key + ".js");
			m.default();
		} catch (e) {
			themeErr = e;
			try {
				let m = require('defaultJS/' + key + ".js");
				m.default();
			} catch (e) {
				console.log(`WARNING: No module defined in theme for PawtucketApp ${key}`, themeErr);
				console.log(`WARNING: No default module defined for PawtucketApp ${key}`, e);
			}
		}
	});
}

_initPawtucketApps();
