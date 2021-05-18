import React, { useEffect, useState, useContext } from 'react'
import { ChronologyContext } from '../ChronologyContext';
import { ScrollSyncNode } from "scroll-sync-react";
import roadrunner from '../assets/roadrunner_gray.png';

const ChronologyMedia = () => {

  const { resultItems, currentActionItem, setCurrentActionItem } = useContext(ChronologyContext)

  const handleMouseOver = (id) => {
    setCurrentActionItem(id)
  }

  if(resultItems){
    return (
      <ScrollSyncNode group="a">
        <div className="col-4 disable-scrollbars" id='media-div'>
          <div className='media-bg justify-self-center' style={{ height: '800px', padding: 0 }}>
            {resultItems.map((image, index) => {
              return(
                <div className="image-container mr-5 ml-5 mb-2 p-2" key={index} onMouseOver={() => handleMouseOver(image.id)}>
                  {(image.media !== null) ? 
                    // id = {(image.id == currentActionItem) ? 'curr-action' : ''}
                    // "http://placehold.jp/24/cccccc/ffffff/150x150.png?text=No Image Available" 
                    <a href={image.detailUrl}><img id={(image.id == currentActionItem) ? 'curr-action' : 'action'} src={image.media[1].url} /></a>
                    : <img id={(image.id == currentActionItem) ? 'curr-action' : 'action'} src={roadrunner} alt='roadrunner'/> }
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
