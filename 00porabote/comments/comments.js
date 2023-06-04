import React, { Component } from 'react'
import CommentForm from './comment-form'
import CommentList from './comment-list'
import './comments.less'

class Comments extends Component {


    render() {
        
        return(

            <div>
                <CommentForm/>
                <CommentList/>
            </div>
        )
    }

}

export default Comments