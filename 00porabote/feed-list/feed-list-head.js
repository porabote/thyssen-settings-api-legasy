
import React from 'react'

const FeedListHead = (props) => {

    let checkbar = (props.ckeckbar) ? props.ckeckbar : ''

    return(
        <div className="feed-list head" style={{gridTemplateColumns: props.flexWidths}}>
            {props.schema.map((item, index) => {
                    return (
                    <span key={index} className="feed-list__head">{item.name}</span>
                    )
                })
            }
        </div>
    )
}

export default FeedListHead