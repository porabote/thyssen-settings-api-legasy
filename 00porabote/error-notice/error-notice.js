import React from 'react'

const ErrorNotice = (props) => {

    const { message } = props

    return (
        <div>
            <p>{message}</p>
        </div>
    )
}

export default ErrorNotice