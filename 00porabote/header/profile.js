import React from 'react'
import {NavLink} from 'react-router-dom'
import { logout } from '../auth/auth-actions'
import {connect} from 'react-redux'
import PermIdentityIcon from '@material-ui/icons/PermIdentity';
import AccountCircleOutlinedIcon from '@material-ui/icons/AccountCircleOutlined';

function Profile(props)
{
    if(!props.auth.isAuth) {
        return (
            <div className="header__panel__auth">
                {/*<NavLink className="header__panel__auth__link" to={"/registration"}>*/}
                {/*    <AccountCircleOutlinedIcon style={{ fontSize: 22, color: "#737A80", marginRight: '4px' }} />*/}
                {/*    Иван*/}
                {/*</NavLink>*/}
            </div>
        )
    }

    return (

        <div className="header-panel__profile">

            <div className="header-panel__profile__data">

                <span className="header-panel__profile__data__rights" onClick={props.logout}>Выход | {props.auth.account_alias}</span>
            </div>

            <div className="header-panel__profile__photo"></div>
            {/*<i className="material-icons header-panel__profile__icon-menu">keyboard_arrow_down</i>*/}
            <i className="header-panel__profile__icon-menu lnr lnr-chevron-down"></i>

            {/*Скрытая часть  */}
            <div className="header-panel__profile__dropdown">
                <ul className="header-panel__profile__dropdown__list">
                    <li className="header-panel__profile__dropdown__list__item">
                        <NavLink to="/users/profile/" className="header-panel__profile__dropdown__item__link profil"> Профиль</NavLink>
                    </li>
                    <li className="header-panel__profile__dropdown__list__item">
                        <NavLink to="/settings/index/" className="header-panel__profile__dropdown__item__link settings">Настройки модулей</NavLink>
                    </li>

                    <div className="header-panel__profile__dropdown__list__line"> </div>
                    <li className="header-panel__profile__dropdown__list__item ">
                        <span onClick={logout} className="header-panel__profile__dropdown__item__link exit">Выход</span>
                    </li>
                </ul>
            </div>
            {/* ...Скрытая часть  */}

        </div>

    )
}

const mapDispatchToProps = {
    logout
}

export default connect(null, mapDispatchToProps)(Profile)
//<span className="header-panel__profile__data__fio">{props.auth.user.name}</span>