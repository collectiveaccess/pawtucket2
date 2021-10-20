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

	const { numPages, setNumPages, page, setPage, enteredPage, setEnteredPage, magLevel, setMagLevel, showThumbnails, setShowThumbnails, rotationValue, setRotationValue, fullscreen, setFullscreen, twoPageSpread, setTwoPageSpread, showToolBar, setShowToolBar } = useContext(DocumentContext)

	useEffect(() => {
		setNumPages(props.pages)
		setShowToolBar(props.options.showToolBar)
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

	let defaultPage = (<div className="default-page" style={{margin:'auto', width: "355px", height: `${ fullscreen? "1000px": `${height}px` }`, backgroundColor: '#fff' }}></div>)
	
	let pdfPages = [];
	for (let i = 1; i <= numPages; i++) {
		pdfPages.push(
			{
				"page_num": i,
				"doc": (
					<Document file={props.url} rotate={rotationValue} loading={defaultPage} onLoadSuccess={ i == 1 ? (e) => onDocumentLoadSuccess(e) : null}>
						<Page pageNumber={i} height={fullscreen? 1000 : height } scale={magLevel / 100} />
					</Document>)
			}
		)
	}

	let pdfPagesTwoSpread = [];
	for (let i = 2; i <= numPages; i++) {
		pdfPagesTwoSpread.push(
			[
				{
					"page_num": i, 
					"doc": (<Document file={props.url} rotate={rotationValue} loading={defaultPage}>
						<Page pageNumber={i} height={fullscreen ? 1000 : height} scale={magLevel / 100} />
					</Document>)
				},
				{
					"page_num": i+1 ,
					"doc": (<Document file={props.url} rotate={rotationValue} loading={defaultPage}>
						<Page pageNumber={i+1} height={fullscreen ? 1000 : height} scale={magLevel / 100} />
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

	// console.log("page: ", page);
	// console.log("pdfPagesTwoSpread: ", pdfPagesTwoSpread);
	// console.log("defaultPage: ", defaultPage);

	if(props.url) {
		return(
			<div className='mediaViewerPDFContainer' style={{border: '1px solid darkgrey', marginBottom: "20px"}}>

				<div id="pdf-viewer">
					{fullscreen?
						<DocumentFullscreenViewer url={props.url} pdfPages={pdfPages} pdfPagesTwoSpread={pdfPagesTwoSpread} visibilityChange={visibilityChange} defaultPage={defaultPage} onDocumentLoadSuccess={onDocumentLoadSuccess}/>
					: 
						<>
							<DocumentToolBar />
							<div className='row justify-content-center'>
								<DocumentThumbnailBar url={props.url} height={"450px"} />

								<div className={"text-center mediaViewerPDFViewer " + `${showThumbnails ? 'col-8' : 'col-12'}`} style={{ width: width, height: height, overflow: "scroll", backgroundColor: '#F2F2F0', padding: "5px"}}>

									{pdfPages && twoPageSpread? 
										<>
											<div className="text-center">
												<div id={'page-' + `${1}`} className="m-1">
													<VisibilitySensor partialVisibility={true} onChange={(isVisible) => visibilityChange(isVisible, 1)}>
														{({ isVisible }) => <div>{isVisible ? 
															<Document file={props.url} rotate={rotationValue} loading={defaultPage} onLoadSuccess={(e) => onDocumentLoadSuccess(e)}>
																<Page pageNumber={1} height={fullscreen ? 1000 : height} scale={magLevel / 100} />
															</Document>
														: defaultPage}</div>}
													</VisibilitySensor>
												</div>
											</div>
											{pdfPagesTwoSpread.map((spread, index) => {
												// console.log(spread);
												return(
													<div className="d-flex" key={index}>
														<div className="d-inline">
															<div id={'page-' + `${spread[0].page_num}`} className="m-1">
																<VisibilitySensor partialVisibility={true} onChange={(isVisible) => visibilityChange(isVisible, spread[0].page_num)}>
																	{({ isVisible }) =>	<div>{isVisible ? spread[0].doc : defaultPage}</div>}
																	{/* {spread[0].doc} */}
																</VisibilitySensor>
															</div>
														</div>
														<div className="d-inline">
															<div id={'page-' + `${spread[1].page_num}`} className="m-1">
																<VisibilitySensor partialVisibility={true} onChange={(isVisible) => visibilityChange(isVisible, spread[1].page_num)}>
																	{({ isVisible }) => <div>{isVisible ? spread[1].doc : defaultPage}</div>}
																	{/* {spread[1].doc} */}
																</VisibilitySensor>
															</div>
														</div>
													</div>
												)
											})}
										</>
									: null}

									{pdfPages && !twoPageSpread? 
										pdfPages.map((pfd_page, index) => {
											return(
												<div key={index} id={'page-' + `${pfd_page.page_num}`} className="m-1">
													<VisibilitySensor partialVisibility={true} offset={{ bottom: 20 }} key={index} onChange={(isVisible) => visibilityChange(isVisible, pfd_page.page_num)}>
														{({ isVisible }) => <div>{isVisible ? pfd_page.doc: defaultPage}</div>}
														{/* {pfd_page.doc} */}
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

// let pageComponent = null;

// if (height <= width) {
// 	pageComponent = (<Page pageNumber={page} height={height} scale={magLevel/100}/>);
// } else {
// 	pageComponent = (<Page pageNumber={page} width={width} scale={magLevel/100}/>);
// }

{/* <VisibilitySensor onChange={(isVisible) => changePage(isVisible, 1)}>
			<div style={{ backgroundColor: '#F2F2F0', padding: "5px"}}>
				<Document file={props.url} onLoadSuccess={(e) => onDocumentLoadSuccess(e)} rotate={rotationValue} loading={defaultPage}>
					<Page pageNumber={1} height={height} scale={magLevel / 100} />
				</Document>
			</div>
		</VisibilitySensor> */}

// <VisibilitySensor>
// 	{({ isVisible }) =>
// 		<div>{isVisible ? <div key={index}>{page}</div> : defaultPage}</div>
// 	}
// </VisibilitySensor>


// import React from "react"
// import ReactDOM from "react-dom";

// import MdArrowDropleftCircle from 'react-ionicons/lib/MdArrowDropleftCircle'
// import MdArrowDroprightCircle from 'react-ionicons/lib/MdArrowDroprightCircle'

// import MdAddCircle from 'react-ionicons/lib/MdAddCircle'
// import MdRemoveCircle from 'react-ionicons/lib/MdRemoveCircle'

// import { pdfjs } from 'react-pdf';
// const pdfjsWorker = require('pdfjs-dist/build/pdf.worker.entry');
// pdfjs.GlobalWorkerOptions.workerSrc = pdfjsWorker;

// import { Document, Page } from 'react-pdf';
// import DocumentToolBar from "./DocumentViewer/DocumentToolBar";

// import DocumentContextProvider from './DocumentViewer/DocumentContext';

// /**
//  *
//  */
// class DocumentViewer extends React.Component{
	
// 	constructor(props) {
// 		super(props);
		
// 		this.state = {
// 			page: 1,
// 			enteredPage: 1,
// 			numPages: 0,
			
// 			magnificationLevel: 100
// 		};
		
// 		this.onDocumentLoadSuccess = this.onDocumentLoadSuccess.bind(this);
// 		this.nextPage = this.nextPage.bind(this);
// 		this.previousPage = this.previousPage.bind(this);
// 		this.numPages = this.numPages.bind(this);
// 		this.magnificationLevel = this.magnificationLevel.bind(this);
// 		this.zoomIn = this.zoomIn.bind(this);
// 		this.zoomOut = this.zoomOut.bind(this);
// 		this.updatePage = this.updatePage.bind(this);
// 	}
	
// 	onDocumentLoadSuccess({ numPages }) {
// 		//console.log('Loaded PDF ' + this.props.url, 'Number of pages: ' + numPages);
//     this.setState({numPages: numPages});
// 	}
	
// 	nextPage() {
// 		const p = this.state.page + 1;
// 		if (p <= this.numPages()) {
// 			this.setState({page: p, enteredPage: p + ''});
// 		}
// 	}

// 	previousPage() {
// 		const p = this.state.page - 1;
// 		if (p > 0) {
// 			this.setState({page: p, enteredPage: p + ''});
// 		}
// 	}
	
// 	numPages() {
// 		return this.state.numPages;
// 	}
	
// 	magnificationLevel(m=null) {
// 		if (m !== null) {
// 			m = parseInt(m);
// 			if ((m > 0) && (m <= 1000)) {
// 				this.setState({magnificationLevel: m});
// 			}
// 		}
// 		return this.state.magnificationLevel;
// 	}
	
// 	zoomIn() {
// 		this.magnificationLevel(this.magnificationLevel() + 10);
// 	}
	
// 	zoomOut() {
// 		this.magnificationLevel(this.magnificationLevel() - 10);
// 	}
	
// 	updatePage(e) {
// 		let p = parseInt(e.target.value);
		
// 		if ((p > 0) && (p <= this.state.numPages)) {
// 			this.setState({page: p, enteredPage: e.target.value });
// 		} else {
// 			this.setState({enteredPage: e.target.value });
// 		}
// 	}

// 	render() {
// 		const width = parseInt(this.props.width);
// 		const height = parseInt(this.props.height) - 40;	// 40px high tool bar
		
// 		if(!this.props.url) {
// 			return(
// 				<div>No media available</div>
// 			);
// 		} 
		
// 		let page = null;
		
// 		if (height <= width) {
// 			page = (<Page pageNumber={this.state.page} height={height} scale={this.magnificationLevel()/100}/>);
// 		} else {
// 			page = (<Page pageNumber={this.state.page} width={width} scale={this.magnificationLevel()/100}/>);
// 		}
		
// 		let pageCounter = null
// 		if (this.numPages() > 0) {
// 			pageCounter = this.numPages();
// 		}
		
// 		return(
// 			<div className='mediaViewerPDFContainer'>'
// 				<div className='row'>
// 					<div className='col-md-12 text-center mediaViewerPDFViewer' style={{width: width, height: height}}>
// 						<Document
// 							file={this.props.url}
// 							onLoadSuccess={this.onDocumentLoadSuccess}
// 						>
// 							{page}
// 						</Document>
// 					</div>
// 				</div>

// 			</div>
// 		);
// 	}
// }

// <div className='fullscreen-container container' style={{width: "1600px"}}>
// 	<div className="row justify-content-center mb-3 sticky-top">
// 		<div className="col-8">
// 			<DocumentToolBar />
// 		</div>
// 	</div>

// 	<div className='row justify-content-center'>
// 		<div className="text-center mediaViewerPDFViewer">

// 			{pdfPages && twoPageSpread ?
// 				<>
// 					<div className="text-center">
// 						<VisibilitySensor onChange={(isVisible) => visibilityChange(isVisible, 1)}>
// 							<div id={'page-' + `${1}`} style={{ backgroundColor: '#F2F2F0', padding: "5px" }}>
// 								<Document file={props.url} rotate={rotationValue} loading={defaultPage} onLoadSuccess={(e) => onDocumentLoadSuccess(e)}>
// 									<Page pageNumber={1} height={fullscreen ? 1000 : height} scale={magLevel / 100} />
// 								</Document>
// 							</div>
// 						</VisibilitySensor>
// 					</div>
// 					{pdfPagesTwoSpread.map((spread, index) => {
// 						// console.log(spread);
// 						return (
// 							<div className="d-flex" key={index}>
// 								<div className="d-inline">
// 									<VisibilitySensor onChange={(isVisible) => visibilityChange(isVisible, spread[0].page_num)}>
// 										<div id={'page-' + `${spread[0].page_num}`} style={{ backgroundColor: '#F2F2F0', padding: "5px" }}>{spread[0].doc}</div>
// 									</VisibilitySensor>
// 								</div>
// 								<div className="d-inline">
// 									<VisibilitySensor onChange={(isVisible) => visibilityChange(isVisible, spread[1].page_num)}>
// 										<div id={'page-' + `${spread[1].page_num}`} style={{ backgroundColor: '#F2F2F0', padding: "5px" }}>{spread[1].doc}</div>
// 									</VisibilitySensor>
// 								</div>
// 							</div>
// 						)
// 					})}
// 				</>
// 			: null}

// 			{pdfPages && !twoPageSpread ?
// 				pdfPages.map((page, index) => {
// 					return (
// 						<VisibilitySensor key={index} onChange={(isVisible) => visibilityChange(isVisible, page.page_num)}>
// 							<div id={'page-' + `${page.page_num}`} style={{ backgroundColor: '#F2F2F0', padding: "5px" }}>{page.doc}</div>
// 						</VisibilitySensor>
// 					)
// 				})
// 			: null}

// 		</div>
// 	</div>
// </div>