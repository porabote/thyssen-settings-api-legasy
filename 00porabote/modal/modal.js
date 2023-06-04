import React, { Component } from 'react'
import { connect } from 'react-redux'
import ModalTab from './modal-tab'
import ModalItem from './modal-item'
import './modal.less'

class Modal extends React.Component {

    render() {

        const items = (typeof this.props.modal.items != "undefined") ? this.props.modal.items : []

        return(
            <div className={this.props.modal.isOpen ? "modal active" : "modal"}  onClick={this.props.closeModal}>
                <div
                    className={this.props.modal.isOpen ? "modal-box-wrap active" : "modal-box-wrap"}
                    onClick={e => {e.stopPropagation()}}
                >
                    <div id="modal-tabs">
                        {items.map((data, index) => {
                            return <ModalTab data={data} itemkey={index} key={index}/>
                        })}
                    </div>

                    {items.map((data, index) => {
                        return <ModalItem data={data} itemkey={index} key={index}/>
                    })}
                    
                </div>
            </div>
        )
    }

}

const mapStateToProps = (state) => {
    return({
        modal: state.modal
    })
}
export default connect(mapStateToProps)(Modal)