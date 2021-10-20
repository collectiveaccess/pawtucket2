import React, { useState, useContext } from 'react'
import { DocumentContext } from "../DocumentContext"

const ToolBarPaging = () => {

  const { numPages, setNumPages, page, setPage, enteredPage, setEnteredPage } = useContext(DocumentContext)

  const nextPage = () => {
		const p = page + 1;
		if (p <= numPages) {
			setPage(p)
			setEnteredPage(p + '')
		}
	}

	const previousPage = () => {
		const p = page - 1;
		if (p > 0) {
			setPage(p)
			setEnteredPage(p + '')
		}
	}

  const updatePage = (e) => {
		let p = parseInt(e.target.value);
		
		if ((p > 0) && (p <= numPages)) {
			setPage(p)
			setEnteredPage(e.target.value)
		} else {
			setEnteredPage(e.target.value);
		}
	}

  return (
    <>
      <button className="btn btn-sm" style={{backgroundColor: 'transparent'}} onClick={() => previousPage()}>
        <span className="material-icons">arrow_back</span>
      </button>

      {/* <a type="button" className="text-decoration-none" onClick={() => previousPage()} title='Previous page' >
        <span className="material-icons">arrow_back</span>
      </a> */}

      <input type='text' value={enteredPage} onChange={(e) => updatePage(e)} className="currentPage"/> of {numPages > 0 ? numPages : null}
      
      {/* <a type="button" className="text-decoration-none" onClick={() => nextPage()} title='Next page'>
        <span className="material-icons">arrow_forward</span>
      </a> */}

      <button className="btn btn-sm" style={{backgroundColor: 'transparent'}} onClick={() => nextPage()}>
        <span className="material-icons">arrow_forward</span>
      </button>
    </>
  )
}

export default ToolBarPaging
