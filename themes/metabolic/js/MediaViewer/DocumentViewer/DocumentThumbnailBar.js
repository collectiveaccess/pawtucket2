import React, { useState, useContext } from 'react'
import { DocumentContext } from "./DocumentContext"
import { Document, Page } from 'react-pdf';

// import DocumentThumbnail from './DocumentThumbnail';

import VisibilitySensor from "react-visibility-sensor";


const DocumentThumbnailBar = (props) => {

  const { numPages, setNumPages, page, setPage, enteredPage, setEnteredPage, magLevel, setMagLevel, showThumbnails, setShowThumbnails } = useContext(DocumentContext)

  let thumbnails = [];
	for (let i = 1; i <= numPages; i++) {
		thumbnails.push(
      <Document file={props.url} loading={<div div className="default-page" style={{ width: '100%', height: '200px', backgroundColor: '#fff' }}></div>}>
        <Page pageNumber={i} height={200} />
      </Document>
		)
	}
  
  const changePage = (e, page) => {
		setPage(page);
		setEnteredPage(page);
		e.preventDefault();
	}

  let defaultPage = (<div div className="default-page" style={{ width: '100%', height: '200px', backgroundColor: '#fff' }}></div>)

  if(showThumbnails){
    return (
      <div className="col-3 mr-1" style={{ height: props.height, overflow: "scroll" }}>	
        <div className='thumbnails-container' style={{ backgroundColor: "#F2F2F0", padding: "10px" }}>
          {thumbnails? 
            thumbnails.map((thumbnail, index) => {

              return (
                <div className={"text-center" + `${page == index+1 ? "border border-secondary" : "border border-light"}`} key={index}>
                  <div className="my-1" onClick={(e) => changePage(e, index + 1)} style={{ cursor: "pointer" }}>

                    <VisibilitySensor>
                      {({ isVisible }) =>
                        <div>{isVisible ? thumbnail : defaultPage }</div>
                      }
                    </VisibilitySensor>

                    {/* {thumbnail} */}
                  </div>
                  <p className="mb-1">Page {index+1}</p>
                </div>
              )
            })
          : null}
        </div>
      </div>
    )
  }else{
    return null
  }
}

export default DocumentThumbnailBar
