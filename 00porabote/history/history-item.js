import React from 'react'

class HistoryItem extends React.Component {

    render() {

        return(
            <div className="on_comments__item on">
                <div className="on_comments__item-avatar">
                    <div className="on_comments__item-avatar-img">

                    </div>
                </div>
                <div className="on_comments__item-fio">
                    <span className="on_comments__item-fio__sender">{this.props.user}</span>
                    <span className="on_comments__listener-fio hide"></span>
                </div>
                <div className="on_comments__item-date">
                    <time>
                        {this.props.datetime}
                    </time>
                </div>
                <div className="on_comments__item-title">{this.props.msg}</div>

                <div href="#" className="on_comments__item-response">
                    <div href="#" className="on_comments__item-response-link"></div>
                    <div href="#" className="on_comments__item-response-form"></div>
                </div>

            </div>
        )
    }
}

export default HistoryItem