'use strict';
import React from 'react';
import ReactDOM from 'react-dom';
import 'bootstrap';

const domContainer = document.querySelector("#pawtucketApp");

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
