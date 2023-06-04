import React from 'react'
import {Route, Redirect} from 'react-router-dom'
import {useSelector} from 'react-redux'

export const ProtectedRoute = ({component: Component, ...rest}) => {

    const auth = useSelector(state => state.auth)

    return (
        <Route
            {...rest}
            render = { props => {

                    if (auth.isAuth) {
                        return <Component {...props} />;
                    } else {
                        return <Redirect to={
                            {
                                pathname: "/auth",
                                state: {
                                    from: props.location
                                }
                            }
                        }/>
                    }
            }
        }/>
    );
};

export default ProtectedRoute;