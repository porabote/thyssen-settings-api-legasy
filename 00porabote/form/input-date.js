import React, { useState } from 'react'
import DatePicker from 'react-date-picker';

class InputDate extends React.Component {

    state = {
        startDate: new Date()
    }

    componentDidMount() {
        this.props.formContext.setFieldValue(this.props.name, this.convertDate(new Date()))
    }

    convertDate = (inputFormat) => {
        function pad(s) { return (s < 10) ? '0' + s : s; }
        var d = new Date(inputFormat)
        return [d.getFullYear(), pad(d.getMonth()+1), pad(d.getDate())].join('-')
    }

    render() {
        return(
            <div>

                <div className="form_item">
                    <label className="form_item__label">{this.props.label}</label>

                    <DatePicker
                        dateFormat="DD.MM/YYYY"
                        selected={this.state.startDate}
                        value={this.state.startDate}
                        onChange={(date) => {
                            let dateFormated = (date) ? this.convertDate(date) : null;
console.log(dateFormated)
                            this.props.formContext.setFieldValue(this.props.name, dateFormated)
                            this.setState({
                                startDate: date
                            })
                        }}
                        isClearable
                    />
                </div>

            </div>
        )
    }

}

export default InputDate