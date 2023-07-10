import React, { useState, useContext, useEffect } from 'react'
import { DocumentContext } from "../DocumentContext"

const ToolBarPaging = () => {

  const { numPages, setNumPages, page, setPage, enteredPage, setEnteredPage } = useContext(DocumentContext)

	const scrollToPage = (page_num) => {
		const element = document.getElementById("page-" + `${page_num}`);
		element.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
	}

  const nextPage = () => {
		const p = page + 1;
		if (p <= numPages) {
			setPage(p)
			setEnteredPage(p + '')
			scrollToPage(p)
		}
	}

	const previousPage = () => {
		const p = page - 1;
		if (p > 0) {
			setPage(p)
			setEnteredPage(p + '')
			scrollToPage(p)
		}
	}

  const updatePage = (e) => {
		console.log("update page: ", e.target.value);
		let p = parseInt(e.target.value);
		
		if ((p > 0) && (p <= numPages)) {
			setPage(p)
			setEnteredPage(p + '')
			setTimeout(() => {
				scrollToPage(p)
			}, 100);
		} 
		else {
			setEnteredPage(e.target.value);
		}
	}

  return (
    <>
      <button className="btn btn-sm p-0" style={{backgroundColor: 'transparent'}} onClick={() => previousPage()}>
        <span className="material-icons">arrow_back</span>
      </button>

      <input type='text' value={enteredPage} onChange={(e) => updatePage(e)} className="currentPage"/> of {numPages > 0 ? numPages : null}
    
      <button className="btn btn-sm p-0" style={{backgroundColor: 'transparent'}} onClick={() => nextPage()}>
        <span className="material-icons">arrow_forward</span>
      </button>
    </>
  )
}

export default ToolBarPaging
