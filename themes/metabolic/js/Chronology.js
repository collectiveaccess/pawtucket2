import React, { useEffect, useState, useContext } from 'react'
import { ChronologyContext } from './Chronology/ChronologyContext';
import { addFilterValue } from './Chronology/ChronologyQueries';

import ChronologyContextProvider from './Chronology/ChronologyContext';
import ChronologyInfo from './Chronology/ChronologyInfo';
import ChronologyMedia from './Chronology/ChronologyMedia';
import '../css/main.scss';
import ChronologyYearBar from './Chronology/ChronologyYearBar';

import { ScrollSync, ScrollSyncNode } from "scroll-sync-react";

const selector = pawtucketUIApps.Chronology.selector;
const baseUrl = pawtucketUIApps.Chronology.baseUrl;

const Chronology = (props) => {

  const { browseType, setKey, setResultItems, setTotalResultItems, setYears } = useContext(ChronologyContext)

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

  // $(window).scroll(function () {
  //   var mediaCol = $('.info-block').height() - $(this).height();
  //   var infoCol = this.scrollY - $('.info-block').offset().top;

  //   $('.media-block').scrollTop(infoCol / mediaCol * ($('#media-div').height() - $(this).height()));
  // });

  return(
    <ScrollSync>
      <div className='container-fluid mt-4 mb-4 metabolic-chronology'>
        <div className='row justify-content-center' style={{ position: 'relative' }}>
          <ChronologyMedia/>
          <ChronologyInfo/>
          <ChronologyYearBar/>
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

{/* <div className='container-fluid mt-4'>
  <div className='row justify-content-center' style={{ 'position': 'relative' }}>
    <div className='col-4'>
      <div className='media-block' style={{ 'overflow': 'hidden', 'display': 'block', 'height': '100%', 'position': 'fixed', marginRight: '60px' }}>
        <ChronologyMedia />
      </div>
    </div>
    <div className='col-5' style={{ 'position': 'relative' }}>
      <div className='info-block' style={{ 'position': 'relative', marginRight: '10%' }}>
        <ChronologyInfo />
      </div>
    </div>
    <div className='col-1' style={{ 'position': 'relative', 'padding': '0' }}>
      <div className='year-block' >
        <ChronologyYearBar />
      </div>
    </div>
  </div>
</div> */}