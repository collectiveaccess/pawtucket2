import React, { useEffect, useContext } from "react"
import { Document, Page } from 'react-pdf';
import VisibilitySensor from "react-visibility-sensor";

import { DocumentContext } from "./DocumentContext"
import DocumentToolBar from "./DocumentToolBar";

const DocumentFullscreenViewer = ({ url, pdfPages, pdfPagesTwoSpread, visibilityChange, defaultPage, onDocumentLoadSuccess }) => {
  const { numPages, setNumPages, page, setPage, enteredPage, setEnteredPage, magLevel, setMagLevel, showThumbnails, setShowThumbnails, rotationValue, setRotationValue, fullscreen, setFullscreen, twoPageSpread, setTwoPageSpread } = useContext(DocumentContext)

  return (
    <div className='fullscreen-container container' style={{ width: "1600px" }}>
      <div className="row justify-content-center mb-3 sticky-top">
        <div className="col-8">
          <DocumentToolBar />
        </div>
      </div>

      <div className='row justify-content-center'>
        <div className="text-center mediaViewerPDFViewer">

          {pdfPages && twoPageSpread ?
            <>
              <div className="text-center">
                <VisibilitySensor onChange={(isVisible) => visibilityChange(isVisible, 1)}>
                  <div id={'page-' + `${1}`} style={{ backgroundColor: '#F2F2F0', padding: "5px" }}>
                    <Document file={url} rotate={rotationValue} loading={defaultPage} onLoadSuccess={(e) => onDocumentLoadSuccess(e)}>
                      <Page pageNumber={1} height={fullscreen ? 1000 : height} scale={magLevel / 100} />
                    </Document>
                  </div>
                </VisibilitySensor>
              </div>
              {pdfPagesTwoSpread.map((spread, index) => {
                // console.log(spread);
                return (
                  <div className="d-flex" key={index}>
                    <div className="d-inline">
                      <VisibilitySensor onChange={(isVisible) => visibilityChange(isVisible, spread[0].page_num)}>
                        <div id={'page-' + `${spread[0].page_num}`} style={{ backgroundColor: '#F2F2F0', padding: "5px" }}>{spread[0].doc}</div>
                      </VisibilitySensor>
                    </div>
                    <div className="d-inline">
                      <VisibilitySensor onChange={(isVisible) => visibilityChange(isVisible, spread[1].page_num)}>
                        <div id={'page-' + `${spread[1].page_num}`} style={{ backgroundColor: '#F2F2F0', padding: "5px" }}>{spread[1].doc}</div>
                      </VisibilitySensor>
                    </div>
                  </div>
                )
              })}
            </>
            : null}

          {pdfPages && !twoPageSpread ?
            pdfPages.map((page, index) => {
              return (
                <VisibilitySensor key={index} onChange={(isVisible) => visibilityChange(isVisible, page.page_num)}>
                  <div id={'page-' + `${page.page_num}`} style={{ backgroundColor: '#F2F2F0', padding: "5px" }}>{page.doc}</div>
                </VisibilitySensor>
              )
            })
            : null}

        </div>
      </div>
    </div>
  )
}

export default DocumentFullscreenViewer
