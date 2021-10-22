/*jshint esversion: 6 */
import React, { useEffect, useContext } from "react"

import { pdfjs } from 'react-pdf';
const pdfjsWorker = require('pdfjs-dist/build/pdf.worker.entry');
pdfjs.GlobalWorkerOptions.workerSrc = pdfjsWorker;
import { Document, Page } from 'react-pdf';

import VisibilitySensor from "react-visibility-sensor";

import { DocumentContext } from "./DocumentViewer/DocumentContext"
import DocumentFullscreenViewer from "./DocumentViewer/DocumentFullscreenViewer";
import DocumentThumbnailBar from "./DocumentViewer/DocumentThumbnailBar";
import DocumentToolBar from "./DocumentViewer/DocumentToolBar";

const DocumentViewer = (props) => {

	const { numPages, setNumPages, page, setPage, enteredPage, setEnteredPage, magLevel, setMagLevel, showThumbnails, setShowThumbnails, rotationValue, setRotationValue, fullscreen, setFullscreen, twoPageSpread, setTwoPageSpread, showToolBar, setShowToolBar, 
		showSearch, setShowSearch,
		showZoom, setShowZoom,
		showPaging, setShowPaging,
		showRotate, setShowRotate,
		showTwoPageSpread, setShowTwoPageSpread,
		showFullScreen, setShowFullScreen
 } = useContext(DocumentContext)

	useEffect(() => {
		setNumPages(props.pages)
		
		setShowToolBar(props.options.showToolBar)
		setShowThumbnails(props.options.showThumbnails)
		setShowSearch(props.options.showSearch)
		setShowZoom(props.options.showZoom)
		setShowPaging(props.options.showPaging)
		setShowRotate(props.options.showRotate)
		setShowTwoPageSpread(props.options.showTwoPageSpread)
		setShowFullScreen(props.options.showFullScreen)
	}, [])

	let state_num = numPages;
	const onDocumentLoadSuccess = ( {numPages} ) => {
		let doc_num = numPages
		if(doc_num !== state_num ){
			setNumPages(doc_num)
		}
	}
	
	const width = parseInt(props.width);
	const height = parseInt(props.height) - 40;	// 40px high tool bar

	const currentPageWidth = 355 * (magLevel/100)
	const currentPageHeight = height * (magLevel/100)
	
	let defaultPage = (<div className="default-page" style={{ margin: 'auto', width: `${currentPageWidth}px`, height: `${ fullscreen? "1000px": `${currentPageHeight}px` }`, backgroundColor: '#fff' }}></div>)

	let pdfPages = [];
	for (let i = 1; i <= numPages; i++) {
		pdfPages.push(
			{
				"page_num": i,
				"doc": (
					<Document file={props.url} rotate={rotationValue} loading={defaultPage} onLoadSuccess={i == 1 ? (e) => onDocumentLoadSuccess(e) : null} className="mb-1">
						<Page pageNumber={i} height={fullscreen? 1000 : height } scale={magLevel / 100} />
					</Document>
				)
			}
		)
	}

	let pdfPagesTwoSpread = [];
	for (let i = 2; i <= numPages; i++) {
		console.log("i", i);
		pdfPagesTwoSpread.push(
			[
				{
					"page_num": i, 
					"doc": (<Document file={props.url} rotate={rotationValue} loading={defaultPage}>
						<Page pageNumber={i} height={fullscreen ? 1000 : height} scale={magLevel / 100} />
					</Document>)
				},
				{
					"page_num": i+1,
					"doc": (<Document file={props.url} rotate={rotationValue} loading={defaultPage}>
						<Page pageNumber={i + 1} height={fullscreen ? 1000 : height} scale={magLevel / 100} error={defaultPage} />
					</Document>)
				}
			]
		)
		i++;
	}

	const visibilityChange = (isVisible, page_num) => {
		if(isVisible){
			setPage(page_num)
			setEnteredPage(page_num)
		}
	}

	if(props.url) {
		return(
			<div className='mediaViewerPDFContainer' style={{border: '1px solid darkgrey', marginBottom: "20px"}}>

				<div id="pdf-viewer">
					{fullscreen?
						<DocumentFullscreenViewer url={props.url} pdfPages={pdfPages} pdfPagesTwoSpread={pdfPagesTwoSpread} visibilityChange={visibilityChange} onDocumentLoadSuccess={onDocumentLoadSuccess}/>
					: 
						<>
							<DocumentToolBar />
							<div className='row justify-content-center'>
								<DocumentThumbnailBar url={props.url} height={"450px"} />

								<div id="doc-scroll-container m-0" className={"text-center mediaViewerPDFViewer " + `${showThumbnails ? 'col-8' : 'col-11'}`} style={{ width: '100%', height: height, overflow: "scroll", backgroundColor: '#F2F2F0'}}>

									{pdfPages && twoPageSpread? 
										<>
											<div className="text-center">
												<div>
													<VisibilitySensor 
														partialVisibility={true} 
														onChange={(isVisible) => visibilityChange(isVisible, 1)}
													>
														{({ isVisible }) => 
															<div id={'page-' + `${1}`} className="mb-1">{isVisible ?
																<Document file={props.url} rotate={rotationValue} loading={defaultPage} onLoadSuccess={(e) => onDocumentLoadSuccess(e)}>
																	<Page pageNumber={1} height={fullscreen ? 1000 : height} scale={magLevel/100} />
																</Document>
														: defaultPage}</div>}
													</VisibilitySensor>
												</div>
											</div>

											{pdfPagesTwoSpread.map((spread, index) => {
												return(
													<div className="d-flex" key={index}>
														<div className="d-inline">
															<VisibilitySensor 
																partialVisibility={true} 
																onChange={(isVisible) => visibilityChange(isVisible, spread[0].page_num)}
																offset={{ top: 260, bottom: 260 }}
															>
																{({ isVisible }) => <div id={'page-' + `${spread[0].page_num}`} className="m-1">{isVisible ? spread[0].doc : defaultPage}</div>}
															</VisibilitySensor>
														</div>
														{spread[1].page_num > numPages? <div></div> :
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

									{pdfPages && !twoPageSpread? 
										pdfPages.map((pfd_page, index) => {
											return(
												<div>
													<VisibilitySensor
														partialVisibility={true} 
														offset={{top: 260, bottom: 260}} 
														onChange={(isVisible) => visibilityChange(isVisible, pfd_page.page_num)}
													>
														{({ isVisible }) => <div key={index} id={'page-' + `${pfd_page.page_num}`} className="my-1">{ isVisible ?
																pfd_page.doc
															: defaultPage }</div>}
													</VisibilitySensor>
												</div>
											)
										}) 
									: null}

								</div>
							</div>
						</>
					}
				</div>

			</div>
		);
	}else{
		return(
			<div>No media available</div>
		);
	}
}

export default DocumentViewer;
		
// 		if (height <= width) {
// 			page = (<Page pageNumber={this.state.page} height={height} scale={this.magnificationLevel()/100}/>);
// 		} else {
// 			page = (<Page pageNumber={this.state.page} width={width} scale={this.magnificationLevel()/100}/>);
// 		}