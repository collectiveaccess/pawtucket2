/*jshint esversion: 6 */
import React from "react"
import ReactDOM from "react-dom";

import MdArrowDropleftCircle from 'react-ionicons/lib/MdArrowDropleftCircle'
import MdArrowDroprightCircle from 'react-ionicons/lib/MdArrowDroprightCircle'

import MdAddCircle from 'react-ionicons/lib/MdAddCircle'
import MdRemoveCircle from 'react-ionicons/lib/MdRemoveCircle'

import { pdfjs } from 'react-pdf';
const pdfjsWorker = require('pdfjs-dist/build/pdf.worker.entry');
pdfjs.GlobalWorkerOptions.workerSrc = pdfjsWorker;

import { Document, Page } from 'react-pdf';


/**
 *
 */
class PDFViewer extends React.Component{
	constructor(props) {
		super(props);
		
		this.state = {
			page: 1,
			numPages: 0,
			
			magnificationLevel: 100
		};
		
		this.onDocumentLoadSuccess = this.onDocumentLoadSuccess.bind(this);
		this.nextPage = this.nextPage.bind(this);
		this.previousPage = this.previousPage.bind(this);
		this.numPages = this.numPages.bind(this);
		this.magnificationLevel = this.magnificationLevel.bind(this);
		this.zoomIn = this.zoomIn.bind(this);
		this.zoomOut = this.zoomOut.bind(this);
	}
	
	onDocumentLoadSuccess({ numPages }) {
		//console.log('Loaded PDF ' + this.props.url, 'Number of pages: ' + numPages);
    	this.setState({numPages: numPages});
	}
	
	nextPage() {
		const p = this.state.page + 1;
		if (p <= this.numPages()) {
			this.setState({page: p});
		}
	}

	previousPage() {
		const p = this.state.page - 1;
		if (p > 0) {
			this.setState({page: p});
		}
	}
	
	numPages() {
		return this.state.numPages;
	}
	
	magnificationLevel(m=null) {
		if (m !== null) {
			m = parseInt(m);
			if ((m > 0) && (m <= 1000)) {
				this.setState({magnificationLevel: m});
			}
		}
		return this.state.magnificationLevel;
	}
	
	zoomIn() {
		this.magnificationLevel(this.magnificationLevel() + 10);
	}
	
	zoomOut() {
		this.magnificationLevel(this.magnificationLevel() - 10);
	}

	render() {
		const width = parseInt(this.props.width);
		const height = parseInt(this.props.height) - 40;	// 40px high tool bar
		
		if(!this.props.url) {
			return(
				<div>No media available</div>
			);
		} 
		
		let page = null;
		
		if (height <= width) {
			page = (<Page pageNumber={this.state.page} height={height} scale={this.magnificationLevel()/100}/>);
		} else {
			page = (<Page pageNumber={this.state.page} width={width} scale={this.magnificationLevel()/100}/>);
		}
		
		let pageCounter = null
		if (this.numPages() > 0) {
			pageCounter = this.state.page + '/' + this.numPages();
		}
		
		return(
			<div className='mediaViewerPDFContainer'>
				<div className='row'>
					<div className='col-md-3'>
						<button type="button" className="btn btn-secondary" onClick={this.previousPage} title='Previous page'><MdArrowDropleftCircle/></button>
					</div>
					<div className='col-md-3 text-center'>
						{pageCounter}
					</div>
					<div className='col-md-3 text-center'>
						<a href='#'  onClick={this.zoomOut}><MdRemoveCircle/></a>
						{this.magnificationLevel() + '%'}
						<a href='#'  onClick={this.zoomIn}><MdAddCircle/></a>
					</div>
					<div className='col-md-3 text-right'>
						<button type="button" className="btn btn-secondary" onClick={this.nextPage} title='Next page'><MdArrowDroprightCircle/></button>
					</div>
				</div>
				<div className='row'>
					<div className='col-md-12 text-center mediaViewerPDFViewer' style={{width: width, height: height}}>
						<Document
							file={this.props.url}
							onLoadSuccess={this.onDocumentLoadSuccess}
						>
							{page}
						</Document>
					</div>
				</div>
			</div>
		);
	}
}

export { PDFViewer };
