import React, { useEffect, useContext } from "react"
import { Document, Page } from 'react-pdf';
import VisibilitySensor from "react-visibility-sensor";

import { DocumentContext } from "./DocumentContext"
import DocumentToolBar from "./DocumentToolBar";

const DocumentFullscreenViewer = ({ url, pdfPages, pdfPagesTwoSpread, visibilityChange, onDocumentLoadSuccess }) => {
  const { numPages, magLevel, rotationValue, fullscreen, twoPageSpread } = useContext(DocumentContext)

  let defaultPage = (<div className="default-page" style={{ margin: 'auto', width: `${772}px`, height: `${fullscreen ? "1000px" : `${currentPageHeight}px`}`, backgroundColor: '#fff' }}></div>)

  return (
    <div className='fullscreen-container container' style={{ width: "1600px" }}>
      <div className="row justify-content-center mb-3 sticky-top">
        <div className="col-8">
          <DocumentToolBar />
        </div>
      </div>

      <div className='row justify-content-center'>
        <div className="text-center mediaViewerPDFViewer" style={{ backgroundColor: '#F2F2F0', padding: "5px" }}>

          {pdfPages && twoPageSpread ?
            <>
              <div className="text-center">
                <VisibilitySensor
                  partialVisibility={true}
                  onChange={(isVisible) => visibilityChange(isVisible, 1)}
                >
                  {({ isVisible }) =>
                    <div id={'page-' + `${1}`}> {isVisible ?
                    <Document file={url} rotate={rotationValue} loading={defaultPage} onLoadSuccess={(e) => onDocumentLoadSuccess(e)}>
                      <Page pageNumber={1} height={fullscreen ? 1000 : height} scale={magLevel / 100} />
                    </Document>
                  : defaultPage}</div>}
                </VisibilitySensor>
              </div>

              {pdfPagesTwoSpread.map((spread, index) => {
                return (
                  <div className="d-flex" key={index}>
                    <div className="d-inline">
                      <VisibilitySensor
                        partialVisibility={true}
                        offset={{ top: 260, bottom: 260 }}
                        onChange={(isVisible) => visibilityChange(isVisible, spread[0].page_num)}
                      >
                        {({ isVisible }) =>
                          <div id={'page-' + `${spread[0].page_num}`}>{isVisible ? spread[0].doc : defaultPage}</div>}
                      </VisibilitySensor>
                    </div>

                    {spread[1].page_num > numPages ? <div></div> :
                      <div className="d-inline">
                        <VisibilitySensor
                          partialVisibility={true}
                          offset={{ top: 260, bottom: 260 }}
                          onChange={(isVisible) => visibilityChange(isVisible, spread[1].page_num)}
                        >
                          {({ isVisible }) => <div id={'page-' + `${spread[1].page_num}`} className="m-1">{isVisible ? spread[1].doc : defaultPage}</div>}
                        </VisibilitySensor>
                      </div>
                    }
                  </div>
                )
              })}
            </>
            : null}

          {pdfPages && !twoPageSpread ?
            pdfPages.map((page, index) => {
              return (
                <VisibilitySensor key={index}
                  partialVisibility={true}
                  offset={{ top: 260, bottom: 260 }}
                  onChange={(isVisible) => visibilityChange(isVisible, page.page_num)}
                >
                  {({ isVisible }) => <div id={'page-' + `${page.page_num}`}>{isVisible ? page.doc : defaultPage}</div>}
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
