import React, { useState, useContext } from 'react'
import { DocumentContext } from "./DocumentContext"
import { Document, Page } from 'react-pdf';

import VisibilitySensor from "react-visibility-sensor";

const DocumentThumbnailBar = (props) => {

  const { numPages, setNumPages, page, setPage, enteredPage, setEnteredPage, magLevel, setMagLevel, showThumbnails, setShowThumbnails, toggleThumbnails, setToggleThumbnails  } = useContext(DocumentContext)

  let defaultPage = (<div div className="default-page" style={{ width: '100%', height: '200px', backgroundColor: '#fff' }}></div>)

  let thumbnails = [];
	for (let i = 1; i <= numPages; i++) {
		thumbnails.push(
      {
        "page_num": i,
        "doc": (
          <Document file={props.url} loading={defaultPage}>
            <Page pageNumber={i} height={200} />
          </Document>
        )
      }
		)
	}

  const scrollToPage = (page_num) => {
    const element = document.getElementById("page-" + `${page_num}`);
    element.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
  }

  const changePage = (e, page) => {
		setPage(page);
		setEnteredPage(page);
    scrollToPage(page)
		e.preventDefault();
	}

  if(showThumbnails && toggleThumbnails){
    return (
      <div className="col-3 m-0" style={{ height: props.height, overflow: "scroll" }}>	
        <div className='thumbnails-container' style={{ backgroundColor: "#F2F2F0", padding: "10px" }}>
          {thumbnails? 
            thumbnails.map((thumbnail, index) => {
              return (
                <div id={'thumbnail-' + `${thumbnail.page_num}`} className="my-1" key={index} >
                  <div className={"text-center " + `${page == thumbnail.page_num ? "border border-secondary" : "border border-light"}`} onClick={(e) => changePage(e, thumbnail.page_num)} style={{ cursor: "pointer" }}>
                    <VisibilitySensor>
                      {({ isVisible }) =>
                        <div>{isVisible ? thumbnail.doc : defaultPage }</div>
                      }
                    </VisibilitySensor>
                  </div>
                  <p className="mb-1">Page {thumbnail.page_num}</p>
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
