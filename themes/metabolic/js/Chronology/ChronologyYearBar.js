import React, { useEffect, useState, useContext } from 'react'
import { ChronologyContext } from './ChronologyContext';

import { Link } from 'react-scroll'

const ChronologyYearBar = (props) => {
  const { years } = useContext(ChronologyContext)

  if(years){
    return (
      <div className="container-fluid justify-content-center" id='year-bar'>
        <div className="year-bar-cont">
          <ul>
            {years.map((year, index) => {
              return <li key={index}><Link to={`${year}`} containerId="info-div" spy={true} smooth={true}>{year}</Link></li>
            })} 
          </ul>
        </div>
      </div>
    )
  }else{
    return null
  }
}

export default ChronologyYearBar
