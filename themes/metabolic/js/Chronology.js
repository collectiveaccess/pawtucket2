import React, { useEffect, useState, useContext } from 'react'

import { ChronologyContext } from './Chronology/ChronologyContext';
import { addFilterValue } from './Chronology/ChronologyQueries';
import ChronologyContextProvider from './Chronology/ChronologyContext';
import ChronologyInfo from './Chronology/ChronologyInfo';
import ChronologyMedia from './Chronology/ChronologyMedia';
import ChronologyYearBar from './Chronology/ChronologyYearBar';

import '../css/main.scss';
import { ScrollSync, ScrollSyncNode } from "scroll-sync-react";

const selector = pawtucketUIApps.Chronology.selector;
const baseUrl = pawtucketUIApps.Chronology.baseUrl;

const Chronology = (props) => {

  const { browseType, setKey, setResultItems, setTotalResultItems, setYears, currentAction } = useContext(ChronologyContext)

  useEffect(() => {
    addFilterValue(baseUrl, browseType, '', '_search', 'agh2o', 'ca_occurrences.date', function (data) {
      console.log('addFilterValue', data);
      setKey(data.key);
      setResultItems(data.items);
      setTotalResultItems(data.item_count);

      let tempYrs = []
      data.items.map((item) => {
        if (item.data[1].value !== null && item.data[1].value !== ""){
          tempYrs.push(item.data[1].value);
        }
      })
      let years_arr = Array.from(new Set(tempYrs))
      setYears(years_arr);
    })
  }, [])

  return(
    <ScrollSync>
      <div className='container-fluid mt-4 mb-4 metabolic-chronology'>
        <div className='row justify-content-center' style={{ position: 'relative' }}>
          <ChronologyMedia />
          <ChronologyInfo />
          <ChronologyYearBar />
        </div>
      </div>
    </ScrollSync>
  );
}

/**
 * Initialize browse and render into DOM. This function is exported to allow the Pawtucket
 * app loaders to insert this application into the current view.
 */
export default function _init() {
	ReactDOM.render(<ChronologyContextProvider> <Chronology/> </ChronologyContextProvider> , document.querySelector(selector));
}