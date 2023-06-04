import React, { Component } from 'react'
import { FeedListHead } from './'
import './feed-list.less'

export default class FeedList extends Component {

    setWidths = () => {

        let widths = '';

        this.props.schema.map((row, index) => {
            widths += `${row.width} `
        })

        return widths
    }

    state = {
        flexWidths: this.setWidths()
    }

    render() {

        return(
            <div className="feed-list">
                <div className="feed-list-hover">

                    <FeedListHead flexWidths={this.state.flexWidths} key="feed-list-head" schema={this.props.schema} />

                    {React.Children.map(this.props.children, (row, index) => {
                        return React.cloneElement(row, {flexWidths: this.state.flexWidths})
                    })}

                </div>
            </div>
        )
    }

}