import React from 'react'
import Datas from '@porabote/datas'
import { TooltipForm } from '@porabote/tooltip'

class InputBare extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            type: this.props.type || 'text',
            className: this.props.className || 'input-mini',
            style: this.props.style || {},
            disabled: this.props.disabled || false,
            name: this.props.name,
            value: this.props.value || '',
            isTooltipDisplayed: 'none',
            tooltip: false
        }
    }

    render() {

        let value = this.state.value
        if (!this.props.value) {
            value = Datas.getValueByPath(this.props.name, this.props.formContext.values)
        }

        if (value === null) value = ''

        return(
            <span style={{position: 'relative'}}>
                {this.state.tooltip && <TooltipForm display={this.state.isTooltipDisplayed}></TooltipForm>}
                <input
                    disabled={this.state.disabled}
                    type={this.state.type}
                    value={value}
                    placeholder={this.state.placeholder}
                    name={this.state.name}
                    onChange={(e) => {
                        if (this.props.onchange === 'function') {
                            this.props.onChange(e, {
                                name: this.props.name,
                                value: e.target.value,
                                ...this.props.formContext
                            })
                        } else {
                            this.props.formContext.setFieldValue(this.props.name, e.target.value)
                        }
                    }}
                    onMouseEnter={() => {
                        this.setState({
                            isTooltipDisplayed: 'block'
                        })
                    }}
                    onMouseLeave={() => {
                        this.setState({
                            isTooltipDisplayed: 'none'
                        })
                    }}
                    className={this.state.className}
                    autoComplete='off'
                    style={this.state.style}
                />
            </span>
        )
    }

}

export default InputBare