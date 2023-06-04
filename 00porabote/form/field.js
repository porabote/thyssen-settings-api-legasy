import React, { Component } from 'react'
import { FormConsumer} from './form-context'

export default class Field extends Component {


    render(){

        return(
            <FormConsumer>
                { (formContext) => React.cloneElement(this.props.children, { formContext }) }
            </FormConsumer>
        )
    }
}