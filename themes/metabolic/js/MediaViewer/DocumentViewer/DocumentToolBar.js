import React, { useState, useContext } from 'react'
import { DocumentContext } from "./DocumentContext"
import ToolBarFullScreen from './DocumentToolBar/ToolBarFullScreen'
import ToolBarPaging from './DocumentToolBar/ToolBarPaging'
import ToolBarZoom from './DocumentToolBar/ToolBarZoom'

const DocumentToolBar = () => {

  const { numPages, setNumPages, page, setPage, enteredPage, setEnteredPage, magLevel, setMagLevel, showThumbnails, setShowThumbnails,
		rotationValue, setRotationValue, fullscreen, setFullscreen } = useContext(DocumentContext)

  const [ searchValue, setSearchValue ] = useState("")

  const handleForm = (e) => {
    console.log('e: ', e.target.value);
    setSearchValue(e.target.value)
  }
	
	const toggleThumnails = (e) => {
		if(showThumbnails){
			setShowThumbnails(false);
		}else{
			setShowThumbnails(true);
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

  return (
    <div className="document-toolbar-container container my-3">
      <div className='row justify-content-center'>

				{!fullscreen? 
					<div className="col-1">
						<button className="btn btn-outline-secondary btn-sm" onClick={(e) => toggleThumnails(e)}>
							<span className="material-icons">view_sidebar</span>
						</button>
					</div>
				: null}

				<div className="col-1">
					<ToolBarZoom />
				</div>

        <div className="col-3">
          <input type="text" className='doc-search-input' value={searchValue} onChange={(e) => handleForm(e)} placeholder="Search"/>
        </div>

        <div className='col-3'>
					<ToolBarPaging />
        </div>

				<div className="col-1">
					<button className="btn btn-outline-secondary btn-sm" onClick={(e) => rotatePDF(e)}>
						<span className="material-icons">rotate_right</span>
					</button>
				</div>

				<div className="col-1">
					<ToolBarFullScreen />
				</div>

      </div>
    </div>
  )
}

export default DocumentToolBar
