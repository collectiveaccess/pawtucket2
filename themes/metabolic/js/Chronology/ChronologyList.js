import React, { useEffect, useState, useContext } from 'react';
import { ChronologyContext } from './ChronologyContext';
import roadrunner from './assets/roadrunner_gray.png';
import { getFacet, addFilterValue } from './ChronologyQueries';

const baseUrl = pawtucketUIApps.Chronology.baseUrl;

const ChronologyList = () => {

  const { browseType, setKey, setResultItems, setTotalResultItems, setYears, currentAction, setCurrentAction, currentActionTitle, setCurrentActionTitle } = useContext(ChronologyContext)

  const [ projects, setProjects ] = useState([]);

  useEffect(() => {
    getFacet(baseUrl, browseType, '', 'project', (data) => {
      console.log('getFacet: ', data);
      setProjects(data.values);
    })
  }, [browseType])

  const setAction = (e, act, title) => {
    setCurrentAction(act);
    setCurrentActionTitle(title)

    addFilterValue(baseUrl, browseType, '', 'project', act, 'ca_occurrences.date', function (data) {
      console.log('addFilterValue', data);
      setKey(data.key);
      setResultItems(data.items);
      setTotalResultItems(data.item_count);

      let tempYrs = []
      data.items.map((item) => {
        if (item.data[1].value !== null && item.data[1].value !== "") {
          tempYrs.push(item.data[1].value);
        }
      })
      let years_arr = Array.from(new Set(tempYrs))
      setYears(years_arr);
    })

    // window.history.pushState("", "", window.location.href + `/id/${act}`);

    e.preventDefault();
  }

  return (
    <div className='container-fluid chronology-list'>
      <div className="row justify-content-center">
        <div className='col-10'>
          <h1 className="my-5">Chronology</h1>
          <div className="row row-cols-1 row-cols-sm-1 row-cols-md-3">
            {(projects)?
              projects.map((project, index) => {
                return(
                  <div className='col' key={index}>
                    <div className="card mb-4 border-0" onClick={(e) => setAction(e, project.id, project.value)} style={{ cursor: 'pointer' }}>
                      {(project.displayData[0].value) ? 
                        <img className="list-img" src={project.displayData[0].value } alt="card image cap" />
                      : <img className="list-img-rr" src={roadrunner} alt="card image cap" /> }
                      <h5 className="card-title text-left mt-2">{project.value}</h5>
                    </div>
                  </div>
                )
              })
            : null}
          </div>
        </div>
      </div>
    </div>
  )
}

export default ChronologyList
