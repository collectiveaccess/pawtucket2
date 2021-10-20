import React, { useState, useContext } from 'react'
import { DocumentContext } from "./DocumentContext"
import { Document, Page } from 'react-pdf';

import TrackVisibility from "react-on-screen";

const DocumentThumbnail = (props) => {

  const { numPages, setNumPages, page, setPage, enteredPage, setEnteredPage } = useContext(DocumentContext)

  const changePage = (e, page) => {
    setPage(page);
    setEnteredPage(page);
    e.preventDefault();
  }
  
  return (
    // <TrackVisibility partialVisibility>
    //   {({ isVisible }) => isVisible ? 
      
        <div className="my-1" onClick={(e) => changePage(e, index + 1)} style={{ cursor: "pointer" }}>
          <Document file={props.file} loading={<div className="default-page" style={{ width: '100%', height: '200px', backgroundColor: '#fff' }}></div>}>
            <Page pageNumber={props.pageNumber} height={props.height} />
          </Document>
        </div>
      
    //   : <div className="default-page" style={{ width: '100%', height: '200px', backgroundColor: '#fff' }}></div> }
    // </TrackVisibility>   
  )
}

export default DocumentThumbnail
