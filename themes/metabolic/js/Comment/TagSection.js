import React, { useState, useContext, useRef } from 'react'
import { getContent, suggestTags, addTag } from './CommentQueries';
import { CommentContext } from './CommentContext';
import { AsyncTypeahead, Typeahead } from 'react-bootstrap-typeahead';
import 'react-bootstrap-typeahead/css/Typeahead.css';

const baseUrl = pawtucketUIApps.Comment.baseUrl;
const searchUrl = pawtucketUIApps.Comment.searchUrl;

const TagSection = () => {

  const { tags, setTags, tablename, itemID, isLoggedIn } = useContext(CommentContext)

  const [ tagValue, setTagValue ] = useState("")
  const [ tagOptions, setTagOptions ] = useState([])
  const [ isLoading, setIsLoading ] = useState(false)

  const [ statusMessage, setStatusMessage ] = useState("")
  const [ statusMessageType, setStatusMessageType ] = useState("")

  const typeaheadRef = useRef(null)

  const handleChange = (value) => {
    
    if(value){
      suggestTags(baseUrl, tablename, itemID, value, (data) => {
        setTagOptions(data.tags)
      })
    }

    setTagValue(value)
  }

  const handleInputChange = (text, event) => {
    setTagValue(text)

    if(text){
      suggestTags(baseUrl, tablename, itemID, text, (data) => {
        setTagOptions(data.tags)
      })
    }
  }

  const submitForm = (e) => {

    if (tagValue.length < 1){
      setStatusMessage("There is no tag to submit")
      setStatusMessageType("error")

      setTimeout(function () {
        setStatusMessage('')
      }, 3000);
    }else{
      addTag(baseUrl, tablename, itemID, tagValue, function (data) {
      
        setTagValue() //Clear form elements
  
        getContent(baseUrl, tablename, itemID, function (data) {
          setTags(data.tags)
        })
  
        typeaheadRef.current.clear()
      })
    }

    e.preventDefault();
  }

  const onReturn = (e) => {
    if(e.key == "Enter" && tagValue == e.target.value){
      submitForm(e)
    }
  }

  if(tags){
    return( 
      <>
        {
        	((tags && (tags.length >= 1)) || isLoggedIn) ? 
        		<h2 className="mt-4"><b>Tags</b></h2>
        		:
        		""
        }
        <div className="tag-section" style={{width: "100%"}}>
          {tags ? 
            tags.map((tag, index) => {
              return(
                <a href={searchUrl + "tag: " + `${tag.tag}`} className="btn btn-outline-secondary btn-sm" key={index} style={{margin: "5px"}}>{tag.tag}</a>
              )
            })
          : null}

          {(statusMessage) ? <div className={`alert alert-${(statusMessageType == 'error') ? 'danger' : 'success'}`}>{statusMessage}</div> : null}

          {isLoggedIn ?
            <div className="d-inline-block">
              <div className="d-inline-block">
                <Typeahead
                  id="tag-typeahead-input"
                  onInputChange={(text, event) => handleInputChange(text, event)}
                  onChange={(value) => handleChange(value)}
                  options={tagOptions}
                  placeholder="Enter your tags"
                  ref={typeaheadRef}
                  onKeyDown={(e) => onReturn(e)}
                />
              </div>
              <div className="d-inline-block">
                <button type="button" className="btn btn-primary btn-sm" onClick={(e) => submitForm(e)} style={{borderRadius: "10px", marginLeft: "10px"}}><span className="material-icons">add</span></button>
              </div>
            </div>
          : null}
        </div>
      </>
    )
  }else{
    return null
  }

}

export default TagSection

{/* <input type="text" className='form-control' id='tag' name='tag' value={tagValue} onChange={(e) => handleForm(e)} placeholder="Add tag here" style={{marginLeft: "5px"}}/> */}

{/* <Typeahead
  id="tag-typeahead"
  onInputChange={(text, event) => handleInputChange(text, event)}
  onChange={(value) => handleChange(value)}
  options={tagOptions}
  placeholder="Add tag here"
/> */}

// const handleForm = (value) => {
//   // console.log("handleForm");
//   suggestTags(baseUrl, value, (data) => {
//     console.log("suggestTags", data);
//     setTagOptions(data.tags)
//   })
//   setTagValue([value])
// }

{/* <AsyncTypeahead
      id="tag-typeahead"
      placeholder="Enter your tags"
      isLoading={isLoading}
      onSearch={(query) => {
        // console.log("query: ", query);
        setIsLoading(true);
        fetchOptions(query);
      }}
      options={tagOptions}
      ref={typeaheadRef}
      onInputChange={(text, event) => handleInputChange(text, event)}
      onChange={(value) => handleChange(value)}
> */}