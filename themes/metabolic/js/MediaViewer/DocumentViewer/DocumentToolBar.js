import React, { useState, useContext } from 'react'
import { DocumentContext } from "./DocumentContext"
import ToolBarFullScreen from './DocumentToolBar/ToolBarFullScreen'
import ToolBarPaging from './DocumentToolBar/ToolBarPaging'
import ToolBarZoom from './DocumentToolBar/ToolBarZoom'

const DocumentToolBar = () => {

	const { numPages, setNumPages, page, setPage, enteredPage, setEnteredPage, magLevel, setMagLevel, showThumbnails, setShowThumbnails, rotationValue, setRotationValue, fullscreen, setFullscreen, twoPageSpread, setTwoPageSpread, showToolBar, setShowToolBar, 
		showSearch, setShowSearch,
		showZoom, setShowZoom,
		showPaging, setShowPaging,
		showRotate, setShowRotate,
		showTwoPageSpread, setShowTwoPageSpread,
		showFullScreen, setShowFullScreen,
		toggleThumbnails, setToggleThumbnails
 } = useContext(DocumentContext)

  const [ searchValue, setSearchValue ] = useState("")

  const handleForm = (e) => {
    console.log('e: ', e.target.value);
    setSearchValue(e.target.value)
  }
	
	const toggleToolBar = (e) => {
		if(showToolBar){
			setShowToolBar(false);
		}else{
			setShowToolBar(true);
		}
		e.preventDefault();
	}

	const toggleThumbnailBar = (e) => {
		// if(showThumbnails){
		// 	setShowThumbnails(false);
		// }else{
		// 	setShowThumbnails(true);
		// }
		if(toggleThumbnails){
			setToggleThumbnails(false);
		}else{
			setToggleThumbnails(true);
		}
		e.preventDefault();
	}

	const rotatePDF = (e) => {
		if(rotationValue >= 0 && rotationValue < 270){
			setRotationValue(rotationValue + 90)
		}else{
			setRotationValue(0)
		}
		e.preventDefault();
	}

	const twoPage = (e) => {
		if(twoPageSpread){
			setTwoPageSpread(false)
		}else{
			setTwoPageSpread(true)
		}
		e.preventDefault();
	}


	if(showToolBar){
		return (
			<div className="document-toolbar-container container mb-3">
				<div className='row justify-content-center' style={{ backgroundColor: "#F2F2F0", padding: "10px" }}>

					{showToolBar? 
						<div className="col-1">
							<button className="btn btn-outline-secondary btn-sm" onClick={(e) => toggleToolBar(e)}>
								<span className="material-icons">expand_less</span>
							</button>
						</div>
					: null}
	
					{!fullscreen && showThumbnails? 
						<div className="col-1">
							<button className="btn btn-outline-secondary btn-sm" onClick={(e) => toggleThumbnailBar(e)}>
								<span className="material-icons">view_sidebar</span>
							</button>
						</div>
					: null}
	
					{showZoom? 
						<div className="col-1">
							<ToolBarZoom />
						</div>
					: null}
	
					{showSearch? 
						<div className="col-2">
							<input type="text" className='doc-search-input' value={searchValue} onChange={(e) => handleForm(e)} placeholder="Search" style={{ width: '140px' }}/>
						</div>
					: null}
	
					{showPaging? 
						<div className={'col-3' + `${showSearch? 'text-right' : 'text-center'}`}>
							<ToolBarPaging />
						</div>
					: null}
	
					{showRotate? 
						<div className="col-1">
							<button className="btn btn-outline-secondary btn-sm" onClick={(e) => rotatePDF(e)}>
								<span className="material-icons">rotate_right</span>
							</button>
						</div>
					: null}
	
					{showTwoPageSpread?	
						<div className="col-1">
							<button className="btn btn-outline-secondary btn-sm" onClick={(e) => twoPage(e)}>
								<span className="material-icons">auto_stories</span>
							</button>
						</div>
					: null}
	
					{showFullScreen? 
						<div className="col-1">
							<ToolBarFullScreen />
						</div>
					: null}
	
				</div>
			</div>
		)
	}else{
		return(
			<span className="material-icons" onClick={(e) => toggleToolBar(e)} style={{cursor: 'pointer'}}>expand_more</span>
		)
	}

}

export default DocumentToolBar
