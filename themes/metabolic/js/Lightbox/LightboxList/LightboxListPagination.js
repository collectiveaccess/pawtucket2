/**
* Adds Pagination for the Lightbox List
*
* Props are:
*    lightboxesPerPage: used to set how many lightboxes to display per page
*    totalLightboxes: the total number of lightboxes
*    paginate: handler to change the page
*    prevPageHandler: handler to move to the previous page
*    nextPageHandler: handler to go to the next page
*    currentPage: tracks the current active page
*    numberOfPages: holds the total number of pages
*
* Sub-components are:
* 		<NONE>
*
* Used by:
*  	LightboxList
*/

import React from "react"
import ReactDOM from "react-dom";
import { LightboxContext } from '../../Lightbox'

class LightboxListPagination extends React.Component {
  constructor(props) {
    super(props);

    LightboxListPagination.contextType = LightboxContext
  }

  render() {
    return (
      <div className="text-center">
        <nav>
          <ul className="pagination">

          {this.props.totalLightboxes === 0 ? ' ' :
            <>
              <li className={parseFloat(this.props.currentPage) === 1 ? "page-item disabled " : "page-item"} id='first-page'>
                <a className="page-link" onClick={() => this.props.paginate(parseFloat(1))} href='#' style={{textDecoration: 'none'}}>
                  First
                </a>
              </li>

              <li className={parseFloat(this.props.currentPage) === 1 ? "page-item disabled " : "page-item"} id='previous' style={{marginRight: '5px'}}>
                <a className="page-link" aria-label="Previous" onClick={() => this.props.prevPageHandler(parseFloat(this.props.currentPage))} href='#' style={{textDecoration: 'none'}}>
                  <span aria-hidden="true">&laquo;</span>
                  <span className="sr-only">Previous</span>
                </a>
              </li>
            </>
          }

          <a style={{color: 'black', marginTop: '5px'}}>
            Page{' '}
              <input type='number' min={1} max={parseFloat(this.props.numberOfPages)} value={parseFloat(this.props.currentPage)} onChange={(e) => this.props.paginate(parseFloat(e.target.value))}/>
            {' '}of{' '}{this.props.numberOfPages}
          </a>

          {this.props.totalLightboxes === 0 ? ' ' :
            <>
              <li className={parseFloat(this.props.currentPage) === parseFloat(this.props.numberOfPages) ? "page-item disabled " : "page-item"} id='next' style={{marginLeft: '5px'}}>
                <a className="page-link" aria-label="Next" onClick={() => this.props.nextPageHandler(parseFloat(this.props.currentPage), parseFloat(this.props.numberOfPages))} href='#' style={{textDecoration: 'none'}}>
                  <span aria-hidden="true">&raquo;</span>
                  <span className="sr-only">Next</span>
                </a>
              </li>

              <li className={parseFloat(this.props.currentPage) === parseFloat(this.props.numberOfPages) ? "page-item disabled " : "page-item"} id='last-page'>
                <a className="page-link" onClick={() => this.props.paginate(parseFloat(this.props.numberOfPages))} href='#' style={{textDecoration: 'none'}}>
                  Last
                </a>
              </li>
            </>
          }

          </ul>
        </nav>
      </div>
    );
  }
}

export default LightboxListPagination;
