import React, { useEffect, useState, useContext } from 'react'
import { ChronologyContext } from '../ChronologyContext';
import { ScrollSyncNode } from "scroll-sync-react";

const ChronologyInfo = () => {

  const { resultItems, currentActionItem, setCurrentActionItem } = useContext(ChronologyContext)

  const handleMouseOver = (id) => {
    setCurrentActionItem(id);
  }

  if (resultItems) {
    let yearValues = [];
    return (
      <ScrollSyncNode group="a">
        <div className="col col-md-5 disable-scrollbars portrait" id='info-div'>
          <div style={{ height: '1000px', paddingTop: "5%", paddingBottom: "5%" }}>
            {resultItems.map((item, index) => {
              return (
                // id = {(item.id == currentActionItem) ? 'curr-action' : ''} d-flex align-items-center
                <div className="text-container d-flex" id={(item.id == currentActionItem) ? 'curr-action' : 'action'} key={index} onMouseOver={() => handleMouseOver(item.id)}>

                  <div className="align-self-center">
                    {(item.title !== null) ?
                        <a href={item.detailUrl} ><h4 className="item-title" dangerouslySetInnerHTML={{ __html: item.title }} /></a>
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
