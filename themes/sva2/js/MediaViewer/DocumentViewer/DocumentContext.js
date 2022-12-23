import React, { createContext, useState } from 'react';
export const DocumentContext = createContext();

const DocumentContextProvider = (props) => {

  const [ page, setPage ] = useState(1)
  const [ enteredPage, setEnteredPage ] = useState(1)
  const [ numPages, setNumPages ] = useState(0)
  const [ magLevel, setMagLevel ] = useState(100)
  const [ rotationValue, setRotationValue ] = useState(0)
  const [ fullscreen, setFullscreen ] = useState(false)
  const [ twoPageSpread, setTwoPageSpread ] = useState(false)
  const [ toggleThumbnails, setToggleThumbnails ] = useState(true)

  const [ showThumbnails, setShowThumbnails ] = useState()
  const [ showToolBar, setShowToolBar ] = useState(false)
  const [ showSearch, setShowSearch ] = useState(false)
  const [ showZoom, setShowZoom ] = useState(false)
  const [ showPaging, setShowPaging ] = useState(false)
  const [ showRotate, setShowRotate ] = useState(false)
  const [ showTwoPageSpread, setShowTwoPageSpread ] = useState(false)
  const [ showFullScreen, setShowFullScreen ] = useState(false)

  return (
    <DocumentContext.Provider
      value={{
        page, setPage,
        enteredPage, setEnteredPage,
        numPages, setNumPages,
        magLevel, setMagLevel,
        showThumbnails, setShowThumbnails,
        rotationValue, setRotationValue,
        fullscreen, setFullscreen,
        twoPageSpread, setTwoPageSpread,
        toggleThumbnails, setToggleThumbnails,

        showToolBar, setShowToolBar,
        showSearch, setShowSearch,
        showZoom, setShowZoom,
        showPaging, setShowPaging,
        showRotate, setShowRotate,
        showTwoPageSpread, setShowTwoPageSpread,
        showFullScreen, setShowFullScreen

      }}>
      {props.children}
    </DocumentContext.Provider>
  )
}

export default DocumentContextProvider;
