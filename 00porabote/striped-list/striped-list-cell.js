import React from 'react'

const StripedListCell = (props) => {

    return(
        <span className="grid_list__item" {...props}>{props.children}</span>
    )
}

export default StripedListCell