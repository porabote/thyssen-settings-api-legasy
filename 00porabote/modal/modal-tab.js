import React, { Component } from 'react'
import { connect } from 'react-redux'

class ModalTab extends Component {

    render() {

        return(
            <div className="modal-tabs-item active">
                <span className="modal-tabs-item__link">{this.props.data.title}</span>
                <span
                    className="modal-tabs-item__close modal-close"
                    item-key={this.props.itemkey}
                    onClick={() => {
                        this.props.removeModalItem(this.props.itemkey)
                    }}
                ></span>
            </div>
        )
    }
}

const mapDispatchToProps = (dispatch) => {
    return {
        removeModalItem: (tabKey) => dispatch({
            type: 'REMOVE_MODAL_ITEM',
            payload: {
                tabKey
            }
        }),
    }
}
export default connect(null, mapDispatchToProps)(ModalTab)