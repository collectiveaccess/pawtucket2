import React, { useEffect, useState, useContext } from 'react';

import { ChronologyContext } from './ChronologyContext';
import ChronologyInfo from './ChronologyView/ChronologyInfo';
import ChronologyMedia from './ChronologyView/ChronologyMedia';
import ChronologyYearBar from './ChronologyView/ChronologyYearBar';

import { ScrollSync } from "scroll-sync-react";

const ChronologyView = (props) => {
  const { browseType, setKey, resultItems, setResultItems, setTotalResultItems, setYears, currentAction, setCurrentAction , currentActionTitle } = useContext(ChronologyContext)

  const backToList = (e) => {
    setCurrentAction();
    e.preventDefault();
  }

  if(resultItems){
    return (
      <ScrollSync>
        <div className='container-fluid metabolic-chronology'>
          <div className='row chronology-title'>
            <div className="col-3 text-left">
              <button className='text-left' type="button" className="btn btn-secondary" onClick={(e) => backToList(e)}>Back</button>
            </div>
            <div className="col-6">
              <h1 className='text-center'>{currentActionTitle}</h1></div>
            </div>
          <div className='row justify-content-center' style={{ position: 'relative' }}>
            <ChronologyMedia />
            <ChronologyInfo />
            <ChronologyYearBar />
          </div>
        </div>
      </ScrollSync>
    );
  }else{return null}
}

export default ChronologyView;
