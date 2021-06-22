import React, { createContext, useState } from 'react';
export const ActivityContext = createContext();

const ActivityContextProvider = (props) => {

  const [ currProject, setCurrProject ] = useState(); 
 
  return (
    <ActivityContext.Provider
      value={{
        currProject, setCurrProject
       }}>
      {props.children}
    </ActivityContext.Provider>
  )
}

export default ActivityContextProvider;