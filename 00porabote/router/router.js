import React from 'react';
import { Route, Switch, Redirect } from 'react-router-dom'
import ProtectedRoute from './protected-route.js'
import { FeedPage, LoginPage } from '../pages'
// import Docs from '../../docs'
// import Dicts from '../../dicts'
// import Chat from '../../chat'
// import Reports from '../../reports'
// import ToDo from '../../todo'
// import Contractors from '../../contractors'
// import PaymentsSet from '../../payments-set'
// import Persons from '../../persons'
// import Users from '../../users'

const AppRouter = props => {

    return (
        <div>
            <Switch>
                <Route path="/auth" component={LoginPage}></Route>
                <ProtectedRoute path="/feed" component={FeedPage} />
                <Redirect to="/feed/feed/" />
            </Switch>
        </div>
    );
};

export default AppRouter;