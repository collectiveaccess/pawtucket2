import React, { useContext } from 'react'
import { ActivityContext } from './Activity/ActivityContext';
import ActivityContextProvider from './Activity/ActivityContext';
import ActivityList from './Activity/ActivityList';
import ActivityView from './Activity/ActivityView';

import '../css/main.scss';

const selector = pawtucketUIApps.Activity.selector;

const Activity = () => {

  const { facetValue } = useContext(ActivityContext)

  if (facetValue){
    return (
      <ActivityView />
    )
  }else{
    return(
      <ActivityList />
    )
  }
}

export default function _init() {
  ReactDOM.render(<ActivityContextProvider> <Activity /> </ActivityContextProvider>, document.querySelector(selector));
}