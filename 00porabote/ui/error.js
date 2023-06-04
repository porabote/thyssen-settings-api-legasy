import React from 'react'

const Error = (props) => {
    return (
        <div className="form-error-notice">
            {props.error}
        </div>
    )
}

export default Error