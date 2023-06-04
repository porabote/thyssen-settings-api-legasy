import React from 'react'
import { NavLink } from 'react-router-dom'
import { useSelector } from 'react-redux'
import './header.less'
import '@porabote/form/form.less'
import '@porabote/form/input.less'
import '@porabote/form/button.less'

import Profile from './profile'
import TopMenu from './top-menu'
import TopIcons from './top-icons'
import { AuthConsumer } from '@porabote/auth'

var Header = props =>
{

    return (
        <AuthConsumer>
            {
                authState => {

                    const bgColor = (authState.state.isAuth) ? '#fff' : ''

                    return(
                        <header style={{'background' : bgColor}}>
                            <div className="header-panel">

                                <NavLink className="header-panel__logo" to={"/feed"}></NavLink>
                                <TopMenu auth={authState} auth={authState} />
                                <TopIcons auth={authState} />
                                <Profile auth={authState} />

                            </div>
                        </header>
                    )
                }
            }
        </AuthConsumer>
    )
}
export default Header