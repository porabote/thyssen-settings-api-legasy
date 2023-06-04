import React, { Component } from 'react'

class History extends Component {


    render() {

        const count = Object.keys(this.props.children).length;

        return(
            <div className="on_comments">
                <div className="on_comments__title sidebar-box-up"><span>История ({count})</span></div>
                {this.props.children}
            </div>
        )
    }

}

export default History