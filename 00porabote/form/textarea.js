import React from 'react'

const Textarea = props => {

    const inputClass = props.class || 'form_item_textarea'
    const label = (typeof props.label != 'undefined' && props.label) ?
        <label className="form_item__label">{props.label}</label> : ''

    return (
        <div className="form-item grid">
            {label}
            <div className="form_item_textarea_wrap">
                <textarea
                    type="text"
                    placeholder={props.placeholder}
                    name={props.name}
                    className={inputClass}
                    value={props.formContext.values[props.name]}
                    onChange={(e) => {
                        props.formContext.setFieldValue(props.name, e.target.value)
                    }}
                    onKeyUp={(e) => {
                        if(typeof props.onKeyUp === 'function') {
                            props.onKeyUp(e)
                        }
                    }}
                >
                </textarea>
            </div>
        </div>
    )

}

export default Textarea