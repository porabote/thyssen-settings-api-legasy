import React from 'react'

const FeedListCell = (props) => {

    if(typeof props.element === 'function') {
        return(
            <span className="feed-list__item">
                {props.element(props.children)}
            </span>
        )
    }

    return (
        <span className="feed-list__item">
            {props.children}
        </span>
    )
}

export default FeedListCell