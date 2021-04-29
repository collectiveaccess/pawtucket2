import React, { useEffect, useState, useContext } from 'react'
import { ChronologyContext } from './ChronologyContext';
import { ScrollSyncNode } from "scroll-sync-react";

const ChronologyInfo = () => {

  const { resultItems } = useContext(ChronologyContext)

  if (resultItems) {
    let yearValues = [];
    return (
      <ScrollSyncNode group="a">
        <div className="col-5 disable-scrollbars" id='info-div'>
          <div style={{ height: '800px'}}>
            {resultItems.map((item, index) => {
              return (
                <div className="text-container mb-5" key={index}>
                  {(item.title !== null) ?
                    <a href={item.detailUrl}><h4 className="item-title" dangerouslySetInnerHTML={{ __html: item.title }} /></a>
                    : null}
                  {(item.data !== null) ?
                    item.data.map((dta, index) => {
                      if (dta.name == 'year' && dta.value !== "" && dta.value !== null){
                        if(!yearValues.includes(dta.value)){
                          yearValues.push(dta.value);
                          return(
                            <a href={`${dta.value}`} id={`${dta.value}`} key={index}></a>
                          )
                        }
                      }else{
                        return(
                          (dta.value !== "" && dta.value !== null) ?
                            <h6 key={index} className='data-name' dangerouslySetInnerHTML={{ __html: dta.value}} />
                          : null 
                        )
                      }
                    })
                  : null }
                </div>
              )
            })}
          </div>
        </div>
      </ScrollSyncNode>
    )
  } else {
    return null;
  }
}

export default ChronologyInfo
