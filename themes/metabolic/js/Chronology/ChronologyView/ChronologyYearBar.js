import React, { useEffect, useState, useContext } from 'react'
import { ChronologyContext } from '../ChronologyContext';
import Scrollspy from 'react-scrollspy';
import { Link } from 'react-scroll'

const ChronologyYearBar = (props) => {
  const { years, currYear, setCurrYear } = useContext(ChronologyContext)

  const setCurrentYearSection = (e) => {
    if(e !== undefined){
      setCurrYear(String(e.id))
    }
  }

  if (years){
    return (
      <div className="container-fluid justify-content-center" id='year-bar'>
        <div className="year-bar-cont">
          <Scrollspy items={[...years]} currentClassName="active" scrolledPastClassName="prev" rootEl="#info-div" onUpdate={e => setCurrentYearSection(e)}>
              {years.map((year, index) => {
                if (year.includes("–")){
                  return (null)   
                } else {
                  return(
                    <li key={index} className={(currYear == year) ? 'curr-year' : ''}>
                      <a href={`#${year}`}></a>
                      <Link to={`${year}`} containerId="info-div" spy={true} smooth={true}>
                        <p>
                          {year}
                        </p>
                      </Link>
                    </li>
                  )
                }
              })} 
          </Scrollspy>
        </div>
      </div>
    )
  }else{
    return null
  }
}

export default ChronologyYearBar