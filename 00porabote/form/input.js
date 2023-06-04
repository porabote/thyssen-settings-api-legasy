import React from 'react'

const Input = props => {

    const inputType = props.type || 'text'
    const inputClass = props.class || 'form_item__text'

    const htmlFor = `${inputType}-${Math.random()}`

    let defaultValue = '';

    if(props.defaultValue !== undefined) {
        defaultValue = props.defaultValue
    } else {
        if(typeof props.formContext.values[props.name] != "undefined") {
            defaultValue = props.formContext.values[props.name]
        }
    }

    if(!defaultValue) defaultValue = '';

    return (
        <div className="form_item">
            <label htmlFor={htmlFor} className="form_item__label">{props.label}</label>
            <div className="form_item__input_wrap">
                <input
                    type={inputType}
                    defaultValue={defaultValue}
                    placeholder={props.placeholder}
                    id={htmlFor}
                    name={props.name}
                    onChange={ e => {
                         props.formContext.setFieldValue(props.name, e.target.value);
                    }}
                    className={inputClass}
                    autoComplete="off"
                />
            </div>
        </div>
    )

}

export default Input