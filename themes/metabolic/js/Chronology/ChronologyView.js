import React, { useContext } from 'react';
import { ChronologyContext } from './ChronologyContext';
import ChronologyInfo from './ChronologyView/ChronologyInfo';
import ChronologyMedia from './ChronologyView/ChronologyMedia';
import ChronologyYearBar from './ChronologyView/ChronologyYearBar';
import { ScrollSync } from "scroll-sync-react";

const ChronologyView = (props) => {
  const { resultItems, setCurrentAction , currentActionTitle } = useContext(ChronologyContext)

  const backToList = (e) => {
    e.preventDefault();
    setCurrentAction();
  }

  if(resultItems){
    return (
      <ScrollSync>
        <div className='container-fluid metabolic-chronology'>
          <div className='row chronology-title'>
            <div className="col-3 text-start">
              <button className='btn btn-secondary text-start' type="button" onClick={(e) => backToList(e)}>Back</button>
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
