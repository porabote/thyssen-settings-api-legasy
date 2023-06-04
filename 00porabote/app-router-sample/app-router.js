import React from 'react';
import { Route, Switch, Redirect } from 'react-router-dom'
import ProtectedRoute from '../protectedRoute/protected.route.js'
import Auth from '../auth'

const AppRouter = () => {
    return (
        <div>
            <Switch>
                <ProtectedRoute path="/chat/:action" exact component={Chat} />
                <Route path="/auth/:action" exact component={Auth}></Route>
                <Redirect to="/auth/invitation"/>
            </Switch>
        </div>
    );
};

export default AppRouter;