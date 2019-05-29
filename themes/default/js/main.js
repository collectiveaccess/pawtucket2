'use strict';
import React from 'react';
import ReactDOM from 'react-dom';
import 'bootstrap';

const domContainer = document.querySelector("#pawtucketApp");


// Loop through configured page apps
Object.entries(pawtucketUIApps).forEach(([key, value]) => {
   try {
   	require("./" + key + ".js");
   } catch (e) {
   	console.log(`WARNING: No module defined for PawtucketApp ${key}`);
   }
});
