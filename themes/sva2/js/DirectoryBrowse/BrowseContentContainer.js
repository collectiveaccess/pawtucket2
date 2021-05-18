import React from 'react'

const BrowseContentContainer = (props) => {
  if(props.data){
    return (
      <div className="row browse-content-container">
        <div className="column-container">
          {props.data.map((item, index) => { 
            return(
              <div className="browse-item" key={index} dangerouslySetInnerHTML={{__html: item }}></div>
          )})}
        </div>
      </div>
    )
  }else{
    return null;
  }
}

export default BrowseContentContainer
