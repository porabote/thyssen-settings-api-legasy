import React from 'react'


const Checkbox = props => {

    const inputClass = props.class || 'form-item__checkbox'
    const htmlFor = `checkbox-${Math.random()}`

    return (
        <div className="form-item__checkbox-wrap">
            <input type="checkbox" id={htmlFor} className={inputClass} />
            <label htmlFor={htmlFor}>{props.label}</label>
        </div>
    )

}

export default Checkbox