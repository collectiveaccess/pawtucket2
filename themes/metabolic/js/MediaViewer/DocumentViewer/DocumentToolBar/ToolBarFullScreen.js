import React, { useContext } from 'react'
import { DocumentContext } from "../DocumentContext"

const ToolBarFullScreen = () => {

  const { fullscreen, setFullscreen } = useContext(DocumentContext)

  const toggleFullScreen = (e) => {
		var elem = document.getElementById("pdf-viewer");
		if(fullscreen){
			document.exitFullscreen();
		}else{
			if (elem.requestFullscreen) {
				elem.requestFullscreen();
			}
		}
		e.preventDefault();
	}

	document.onfullscreenchange = function ( event ) {
		if (!fullscreen){
			setFullscreen(true)
		}else{
			setFullscreen(false)
		}
	};
  
  return (
    <button className="btn btn-outline-secondary btn-sm" onClick={(e) => toggleFullScreen(e)}>
      {fullscreen ? <span className="material-icons">fullscreen_exit</span> : <span className="material-icons">fullscreen</span>}
    </button>
  )
}

export default ToolBarFullScreen
