import React from 'react'
import Modal from '../modal'
import AppRouter from '@components/app-router'
import Header from '../header'
import { Sidebar } from '@porabote'

const Layout = () => {

    return(
        <div className="main">
            <div className="header">
                <Header/>
            </div>

            <section className="main-section">
                <AppRouter/>
            </section>

            <div className="sidebar-container">
                <Sidebar/>
            </div>
        </div>
    )

}

export default Layout