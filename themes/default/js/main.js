'use strict';
import React from 'react';
import ReactDOM from 'react-dom';
import 'bootstrap';

const domContainer = document.querySelector("#pawtucketApp");

export default function _initPawtucketApps() {
	// Loop through configured page apps
	Object.entries(pawtucketUIApps).forEach(([key, value]) => {
		try {
			let m = require("themeJS/" + key + ".js");
			m.default();
		} catch (e) {
			try {
				let m = require("defaultJS/" + key + ".js");
				m.default();
			} catch (e) {
				console.log(`WARNING: No module defined for PawtucketApp ${key}`, e);
			}
		}
	});
}

_initPawtucketApps();
