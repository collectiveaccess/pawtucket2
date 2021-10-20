import React, { useContext } from 'react'
import { DocumentContext } from "../DocumentContext"

const ToolBarZoom = () => {

  const { magLevel, setMagLevel } = useContext(DocumentContext)

  const handleZoom = (e) => {
		setMagLevel(parseInt(e.target.value));
		e.preventDefault();
	}

	const zoomIn = () => {
		setMagLevel(parseInt(magLevel) + 10);
	}
	
	const zoomOut = () => {
		setMagLevel(parseInt(magLevel) - 10);
	}

  let zoomSelectOptions = [ 50, 75, 100, 125, 150, 200, 300, 400 ]

	let nonOption = null

	if(zoomSelectOptions.indexOf(magLevel) !== -1 ){
		nonOption =  null 
	}else{
		nonOption = <option value={magLevel}>{magLevel}%</option>
	}

  return (
    <div className="dropdown show">
      <button className="btn btn-outline-secondary btn-sm" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span className="material-icons">zoom_in</span>
      </button>

      <div className="dropdown-menu border border-dark" aria-labelledby="dropdownMenuLink">
        <div className='container'>
          <form className='form-inline'>
            <select value={magLevel} onChange={(e) => handleZoom(e)}>
              {nonOption}
              {zoomSelectOptions.map((option, index) => {
                return <option key={index} value={option}>{option}%</option>
              })}
            </select>
            <a href='#' onClick={() => zoomOut()} style={{textDecoration: "none", marginLeft: '5px'}}><span className="material-icons">zoom_out</span></a>
            <a href='#' onClick={() => zoomIn()} style={{textDecoration: "none", marginLeft: '5px'}}><span className="material-icons">zoom_in</span></a>
          </form>
        </div>
      </div>
    </div>
  )
}

export default ToolBarZoom
