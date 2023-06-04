import React from 'react'
import { Link } from 'react-router-dom'
import { useSelector } from 'react-redux'

var TopIcons = props =>
{

    if(!props.auth.state.isAuth) {
        return (
            <div className="header-panel__icons-set">

                </div>
        )
    }

    return (
        <div className="header-panel__icons-set">

            {/*<Link to="/chat" className="header-panel__icons-set__item__link" id="link-box-alert">*/}
            {/*    <span className="header-panel__icons-set__item__link_text chat">Чат</span>*/}
            {/*</Link>*/}
            {/*<Link to="/toDo" className="header-panel__icons-set__item__link">*/}
            {/*    <span className="header-panel__icons-set__item__link_text alarm_clock">задачи</span>*/}
            {/*</Link>*/}

        </div>
    )
}
export default TopIcons