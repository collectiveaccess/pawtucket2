import React, { useEffect, useState, useContext } from 'react'

import { ChronologyContext } from './Chronology/ChronologyContext';
import ChronologyContextProvider from './Chronology/ChronologyContext';

import '../css/main.scss';
import ChronologyView from './Chronology/ChronologyView';
import ChronologyList from './Chronology/ChronologyList';

const selector = pawtucketUIApps.Chronology.selector;
const chronology = pawtucketUIApps.Chronology.chronology;
// const baseUrl = pawtucketUIApps.Chronology.baseUrl;

const Chronology = (props) => {

  const { currentAction, setCurrentAction } = useContext(ChronologyContext)

  useEffect(() => {
    if(chronology){
      setCurrentAction(chronology);
    }
  }, [])

  if(currentAction){
    return(
      <ChronologyView/>
    )
  }else {
    return(
      <ChronologyList />
    );
  }
}

/**
 * Initialize browse and render into DOM. This function is exported to allow the Pawtucket
 * app loaders to insert this application into the current view.
 */
export default function _init() {
	ReactDOM.render(<ChronologyContextProvider> <Chronology/> </ChronologyContextProvider> , document.querySelector(selector));
}