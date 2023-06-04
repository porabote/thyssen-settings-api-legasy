import React from 'react'

const InputHidden = props => {

    const inputType = props.type || 'text'
    const htmlFor = `${inputType}-${Math.random()}`

    return (
                <input
                    type="hidden"
                    placeholder={props.placeholder}
                    id={htmlFor}
                    name={props.name}
                    onChange={props.onChange}
                />
    )

}

export default InputHidden