import React, { createContext, useState } from 'react';
export const CommentContext = createContext();

const CommentContextProvider = (props) => {

  const [ tablename, setTablename ] = useState();
  const [ itemID, setItemID ] = useState();
  const [ comments, setComments ] = useState();
  const [ tags, setTags ] = useState();
  const [ isLoggedIn, setIsLoggedIn ] = useState();

  return (
    <CommentContext.Provider
      value={{
        tablename, setTablename,
        itemID, setItemID,
        comments, setComments,
        tags, setTags,
        isLoggedIn, setIsLoggedIn,
      }}>
      {props.children}
    </CommentContext.Provider>
  )
}

export default CommentContextProvider;