import React, { Component } from 'react'
import { FormProvider } from './form-context'
import Api from '@services/api-service'

class Form extends Component {

    constructor(props) {
        super(props);

        this.state = {
            values: props.values,
            errors: []
        }
    }

    /*
    * Convert string path like 'one.1.two' to Object like {"one": {"1": {"two": 'testValue'}}}
    *
    *
    * */
    buildPathBranch = (path, value) => {
        let splits = path.split('.');
        splits.reverse()

        let target = {};

        splits.map((key, index) => {
            if (index == 0) {
                target[key] = value
            } else {
                let arr = isNaN(parseInt(key)) ? {} : []
                arr[key] = target
                target = arr
            }
        })

        return target
    }

    _setFieldValue = (name, value, mode = 'merge') => {

        const valueBranch = this.buildPathBranch(name, value)

        switch (mode) {
            case 'merge': //if value is string or object
                var values = this.mergeValues(this.state.values, valueBranch);
                break;
            case 'replace': // if value is array - target array will be replaced to source array
                var values = this.replaceValues(this.state.values, valueBranch);
                break;
            case 'push': // if value is array - source array will be added to target array
                var values = this.pushValue(this.state.values, name, value);
                break;
            case 'spliceByKey': // if value is array - source array will be removed from target array
                var values = this._spliceByKey(this.state.values, name, value)
        }

        this.setState({
            values
        })
    }

    isObject = (item) => {
        return (item && typeof  item === 'object' && !Array.isArray(item))
    }

    isArray = (item) => {
        return (item && Array.isArray(item))
    }

    _spliceByKey = (target, name, index) => {
        let splits = name.split('.');

        let cursor = target;
        for (const key in splits) {
            cursor = cursor[splits[key]]
        }
        cursor.splice(index, 1)

        return target
    }

    _pushValue = (target, name, value) => {
        let splits = name.split('.');

        let cursor = target;
        for (const key in splits) {
            cursor = cursor[splits[key]]
        }
        cursor.push(value)

        return target
    }

    replaceValue = (target, source) => {

        for (const key in source) {
            if (this.isObject(source[key])) {
                if (!target[key]) Object.assign(target, {[key]: {}})
                this.replaceValue(target[key], source[key])
            } else if (this.isArray(source[key])) {
                target[key] = source[key]
            } else {
                Object.assign(target, {[key]: source[key]})
            }
        }

        return target
    }

    mergeValues = (target, source) => {

        for (const key in source) {
            if (this.isObject(source[key])) {
                if (!target[key]) Object.assign(target, {[key]: {}})
                this.mergeValues(target[key], source[key])
            } else if (this.isArray(source[key])) {
                if (!target[key]) Object.assign(target, {[key]: []})
                this.mergeValues(target[key], source[key])
            } else {
                Object.assign(target, {[key]: source[key]})
            }
        }

        return target
    }

    _submitForm = (e) => {

        let values = { ...this.state.values }

        if(typeof this.props.submitForm === "function") {
            return this.props.submitForm(values);
        }
      
        if(typeof this.props.beforeSave === "function") {
            values =  this.props.beforeSave(values);
        }

        Api.post(this.props.action, {
            body: values
        })
        .then( response => {

            if(typeof this.props.afterSave == "function") {

                if( response.errors ) {
                    this.setState({
                        errors: response.errors
                    })
                }

                this.props.afterSave(response)
            }

        })


    }

    render() {
        return(
            <FormProvider value={{
                values: this.props.values,
                errors: this.state.errors,
                setFieldValue: this._setFieldValue.bind(this),
                submitForm: this._submitForm.bind(this)
            }}>
                <form>
                    {this.props.children}
                </form>
            </FormProvider>
        )
    }
}

export default Form