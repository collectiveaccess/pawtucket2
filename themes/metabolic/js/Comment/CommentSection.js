import React, { useState, useContext } from 'react';
import { addComment, getContent } from './CommentQueries';
import { CommentContext } from './CommentContext';

const baseUrl = pawtucketUIApps.Comment.baseUrl;

const CommentSection = (props) => {

  const { comments, setComments, tablename, itemID, isLoggedIn } = useContext(CommentContext)

  const [ statusMessage, setStatusMessage ] = useState("")
  const [ statusMessageType, setStatusMessageType ] = useState("")
  const [ commentValue, setCommentValue ] = useState("")

  const handleForm = (e) => {
    setCommentValue(e.target.value)
  }

  const submitForm = (e) => {

    if (commentValue.length < 1){
      setStatusMessage("There is no comment to submit")
      setStatusMessageType("error")
      
      setTimeout(function () {
        setStatusMessage('')
      }, 3000);
    }else{
      setStatusMessage("Submitting comment ...")
      setStatusMessageType("success")
  
      addComment(baseUrl, tablename, itemID, commentValue, function (data) {
        console.log('addComment', data);
        setStatusMessage(data.message)
        if(data.error){
          setStatusMessage(data.error)
          setStatusMessageType("error")
        }else{
          setStatusMessageType('success')
          setCommentValue("") //Clear form elements
    
          setTimeout(function () {
            setStatusMessage('')
          }, 3000);
    
          getContent(baseUrl, tablename, itemID, function (data) {
            // console.log('getContent', data);
            setComments(data.comments);
          })
        }
      })
    }

    e.preventDefault();
  }

  return (
    <>
      {comments?
        <>
          {comments.length >= 1 ?
            <h2 className="mb-3"><b>{comments.length} {comments.length > 1 ? "Comments" : "Comment"}</b></h2>
          : (isLoggedIn ? <h2 className="mb-3"><b>Comments</b></h2> : '')}
        </>

      :  null}

      {isLoggedIn ?

        <div className="comment-form">
          {(statusMessage) ? <div className={`alert alert-${(statusMessageType == 'error') ? 'danger' : 'success'}`}>{statusMessage}</div> : null}
          <form className='ca-form mb-3'>
            <div className="row">
                <div className="col-9">
                  <textarea className='form-control' id='comment' name='comment' value={commentValue} onChange={(e) => handleForm(e)} placeholder='Enter your comment' />
                  <input type='submit' className='btn-sm btn-primary' style={{ borderRadius: "10px", marginTop: "10px" }} value={props.commentButtonText} onClick={(e) => submitForm(e)} />
                </div>
                {/* <div className="col-3 d-flex align-items-center">
                  <input type='submit' className='btn btn-primary' style={{borderRadius: "10px"}} value={props.commentButtonText} onClick={(e) => submitForm(e)} />
                </div> */}
            </div>
          </form>
        </div>

      : null}

      <div className="comment-section mb-4" style={{width: "100%", maxHeight: "300px", overflow: "auto"}}>

        {comments ? 
          comments.map((comment, index) => {
            return(
              <div key={index}>
                <div className="d-flex"> <strong>{comment.author}</strong> <p style={{marginLeft: "20px"}}>{comment.date}</p> </div>
                <div className="mb-2"> {comment.comment} </div>
                <div className="line-border border-bottom mb-2"></div>
              </div>
            )
          })
        : null}

      </div>
    </>
  );
}

export default CommentSection ;