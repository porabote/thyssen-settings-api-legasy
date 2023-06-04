import React from 'react'
import CommentListItem from './comment-list-item'

class CommentList extends React.Component {

    render() {

        return(
            <div className="on_comments__items">
                <CommentListItem/>
            </div>
        )
    }
}

export default CommentList