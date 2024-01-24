'use strict';
import React from 'react';
import ReactDOM from 'react-dom';
import 'htmx.org';
import * as bootstrap from 'bootstrap';
require('bootstrap-icons/font/bootstrap-icons.css');

window.htmx = require('htmx.org');

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

function initPawtucketApps(app=null) {
	// Loop through configured page apps
	let themeErr = null;
	
	let apps = pawtucketUIApps;
	if(app) { apps = {}; apps[app.app] = app; }
	Object.entries(apps).forEach(([key, value]) => {
		try {
			let m = require('themeJS/' + key + ".js");
			m.default(value);
		} catch (e) {
			themeErr = e;
			try {
				let m = require('defaultJS/' + key + ".js");
				m.default(value);
			} catch (e) {
				console.log(`WARNING: No module defined in theme for PawtucketApp ${key}`, themeErr);
				console.log(`WARNING: No default module defined for PawtucketApp ${key}`, e);
			}
		}
	});
}
window.initApp = initPawtucketApps;

export default initPawtucketApps;
