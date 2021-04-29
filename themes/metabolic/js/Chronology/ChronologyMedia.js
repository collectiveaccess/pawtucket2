import React, { useEffect, useState, useContext } from 'react'
import { ChronologyContext } from './ChronologyContext';
import { ScrollSyncNode } from "scroll-sync-react";

const ChronologyMedia = () => {

  const { resultItems } = useContext(ChronologyContext)

  if(resultItems){
    return (
      <ScrollSyncNode group="a">
        <div className="col-5 disable-scrollbars" id='media-div'>
          <div style={{ height: '1200px' }}>
            {resultItems.map((image, index) => {
              return(
                <div className="image-container mb-5" key={index}>
                  {(image.media !== null) ? 
                    <a href={image.detailUrl}><img className="img-fluid" src={image.media[1].url} /></a>
                    : <img src="http://placehold.jp/24/cccccc/ffffff/150x150.png?text=No Image Available" /> }
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

export default ChronologyMedia
