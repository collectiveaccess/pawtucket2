import React, { createContext, useState } from 'react';
export const DocumentContext = createContext();

const DocumentContextProvider = (props) => {

  const [ page, setPage ] = useState(1)
  const [ enteredPage, setEnteredPage ] = useState(1)
  const [ numPages, setNumPages ] = useState(0)
  const [ magLevel, setMagLevel ] = useState(100)
  const [ showThumbnails, setShowThumbnails ] = useState(true)
  const [ rotationValue, setRotationValue ] = useState(0)
  const [ fullscreen, setFullscreen ] = useState(false)

  return (
    <DocumentContext.Provider
      value={{
        page, setPage,
        enteredPage, setEnteredPage,
        numPages, setNumPages,
        magLevel, setMagLevel,
        showThumbnails, setShowThumbnails,
        rotationValue, setRotationValue,
        fullscreen, setFullscreen
      }}>
      {props.children}
    </DocumentContext.Provider>
  )
}

export default DocumentContextProvider;
