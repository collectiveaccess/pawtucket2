'use strict';
import React from 'react';
import ReactDOM from 'react-dom';

const domContainer = document.querySelector("#pawtucketApp");


// Loop through configured page apps
Object.entries(pawtucketUIApps).forEach(([key, value]) => {
   console.log(`key= ${key} value = ${value}`);
   
   try {
   	require("./" + key + ".js");
   } catch (e) {
   	console.log(`WARNING: No module defined for PawtucketApp ${key}`);
   }
});
