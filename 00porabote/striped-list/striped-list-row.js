import React, { Component } from 'react'

class StripedListRow extends Component {


    render() {

        return(
            <div className="grid_list" {...this.props}>
                {this.props.children}
            </div>
        )
    }
}

export default StripedListRow