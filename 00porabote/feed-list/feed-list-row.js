import React, { Component } from 'react'
import { Link } from 'react-router-dom'
import FeedListCell from './feed-list-cell'
import Moment from 'moment';

class FeedListBodyRow extends Component {

    constructor(props) {
        super(props);

        this.state = {
            schema: props.schema

        }
    }


    setValue(value, schema)
    {
        if(schema.dateFormat !== undefined) value = Moment(value).format("DD/ MM /YYYY")
        return value
    }

    render() {

        return(
            <Link
                to={this.props.to}
                className="feed-list"
                key={this.props.data.id}
                style={{gridTemplateColumns: this.props.flexWidths}}
            >
                {this.state.schema.map((schema, index) => {

                    let value = this.setValue(this.props.data[schema.field], schema)

                    return (
                        <FeedListCell element={schema.element} key={index}>{value}</FeedListCell>
                    )
                })}

            </Link>
        )
    }

}

export default FeedListBodyRow