/*jshint esversion: 6 */
import React, { useContext } from "react"

import { pdfjs } from 'react-pdf';
const pdfjsWorker = require('pdfjs-dist/build/pdf.worker.entry');
pdfjs.GlobalWorkerOptions.workerSrc = pdfjsWorker;
import { Document, Page } from 'react-pdf';

import { TransformWrapper, TransformComponent } from "react-zoom-pan-pinch";

import { DocumentContext } from "./DocumentViewer/DocumentContext"
import DocumentThumbnailBar from "./DocumentViewer/DocumentThumbnailBar";
import DocumentToolBar from "./DocumentViewer/DocumentToolBar";

const DocumentViewer = (props) => {

	const { numPages, setNumPages, page, setPage, enteredPage, setEnteredPage, magLevel, setMagLevel, showThumbnails, setShowThumbnails, rotationValue, setRotationValue, fullscreen, setFullscreen } = useContext(DocumentContext)
	
	const onDocumentLoadSuccess = ( {numPages} ) => {
		setNumPages(numPages)
	}
	
	const width = parseInt(props.width);
	const height = parseInt(props.height) - 40;	// 40px high tool bar
	
	let pageComponent = null;
		
	if (height <= width) {
		pageComponent = (<Page pageNumber={page} height={height} scale={magLevel/100}/>);
	} else {
		pageComponent = (<Page pageNumber={page} width={width} scale={magLevel/100}/>);
	}
	
	if(props.url) {
		return(
			<div className='mediaViewerPDFContainer' style={{border: '1px solid darkgrey', marginBottom: "20px"}}>
				<div  id="pdf-viewer">
					{fullscreen?
					
						<div className='fullscreen-container container' style={{width: "1600px"}}>
							<div className="row justify-content-center mb-3">
								<div className="col-8" style={{backgroundColor: '#fff'}}>
									<DocumentToolBar />
								</div>
							</div>
					
							<div className='row justify-content-center'>
								{/* <DocumentThumbnailBar url={props.url} height={"800px"} /> */}
								<div className="text-center mediaViewerPDFViewer ">
									<Document file={props.url} onLoadSuccess={(e) => onDocumentLoadSuccess(e)} rotate={rotationValue}>
										<Page pageNumber={page} height={1000} scale={magLevel/100}/>
									</Document>
								</div>
							</div>
						</div>
					: 
						<>
							<DocumentToolBar />
							<div className='row justify-content-center'>
								<DocumentThumbnailBar url={props.url} height={"450px"} />
								<div className={"text-center mediaViewerPDFViewer " + `${ showThumbnails? 'col-8' : 'col-12' }`} style={{width: width, height: height}}>
									<Document file={props.url} onLoadSuccess={(e) => onDocumentLoadSuccess(e)} rotate={rotationValue}>
										{pageComponent}
									</Document>
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

// 				{/* <DocumentToolBar page={this.state.page} numPages={this.state.numPages} enteredPage={this.state.enteredPage} magLevel={this.state.magnificationLevel} /> */}
			
// 				<div className='row'>
// 					<div className='col-md-3'>
// 						<button type="button" className="btn btn-secondary" onClick={this.previousPage} title='Previous page'><MdArrowDropleftCircle/></button>
// 					</div>
// 					<div className='col-md-3 text-center'>
// 						<input type='text' value={this.state.enteredPage} onChange={this.updatePage} class="currentPage"/> of {pageCounter}
// 					</div>
// 					<div className='col-md-3 text-center'>
// 						<a href='#'  onClick={this.zoomOut}><MdRemoveCircle/></a>
// 						{this.magnificationLevel() + '%'}
// 						<a href='#'  onClick={this.zoomIn}><MdAddCircle/></a>
// 					</div>
// 					<div className='col-md-3 text-right'>
// 						<button type="button" className="btn btn-secondary" onClick={this.nextPage} title='Next page'><MdArrowDroprightCircle/></button>
// 					</div>
// 				</div>

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

{/* <div className='row'>

		<div className='col-md-3'>
			<button type="button" className="btn btn-secondary" onClick={() => previousPage()} title='Previous page'>
				<span className="material-icons">arrow_back_ios</span>
			</button>
		</div>

		<div className='col-md-3 text-center'>
			<input type='text' value={enteredPage} onChange={(e) => updatePage(e)} className="currentPage"/> of {pageCounter}
		</div>

		<div className='col-md-3 text-center'>
			<a href='#'  onClick={() => zoomOut()}><MdRemoveCircle/></a>
			{magLevel + '%'}
			<a href='#'  onClick={() => zoomIn()}><MdAddCircle/></a>
		</div>

		<div className='col-md-3 text-right'>
			<button type="button" className="btn btn-secondary" onClick={() => nextPage()} title='Next page'>
				<span className="material-icons">arrow_forward_ios</span>
			</button>
		</div>

	</div> */}

// const nextPage = () => {
	// 	const p = page + 1;
	// 	if (p <= numPages) {
	// 		setPage(p)
	// 		setEnteredPage(p + '')
	// 	}
	// }

	// const previousPage = () => {
	// 	const p = page - 1;
	// 	if (p > 0) {
	// 		setPage(p)
	// 		setEnteredPage(p + '')
	// 	}
	// }
		
	// const magnificationLevel = (m=null) => {
	// 	if (m !== null) {
	// 		m = parseInt(m);
	// 		if ((m > 0) && (m <= 1000)) {
	// 			setMagLevel(m)
	// 		}
	// 	}
	// 	return magLevel;
	// }
	
	// const zoomIn = () => {
	// 	magnificationLevel(magLevel + 10);
	// }
	
	// const zoomOut = () => {
	// 	magnificationLevel(magLevel - 10);
	// }
	
	// const updatePage = (e) => {
	// 	let p = parseInt(e.target.value);
		
	// 	if ((p > 0) && (p <= numPages)) {
	// 		setPage(p)
	// 		setEnteredPage(e.target.value)
	// 	} else {
	// 		setEnteredPage(e.target.value);
	// 	}
	// }

	// let pageCounter = null
	// if (numPages > 0) {
	// 	pageCounter = numPages;
	// }

	// let thumbnails = [];
	// for (let i = 1; i <= numPages; i++) {
	// 	// console.log("i: ", i);
	// 	thumbnails.push(
	// 		<Document file={props.url}>
	// 			<Page pageNumber={i} height={200}/>
	// 		</Document>
	// 	)
	// }

	// const changePage = (e, page) => {
	// 	setPage(page);
	// 	setEnteredPage(page);
	// 	e.preventDefault();
	// }