import { LOGOUT, LOGIN_REQUEST, LOGIN_SUCCESS, LOGIN_FAILURE } from './auth-types';
import authService from './auth-service';
import { ROUTING } from '../router/router-types'

const checkAuth = () => {

    return dispatch => {

        dispatch(request(localStorage.getItem('access_token')))

        authService.check(localStorage.getItem('access_token'))
            .then(
              response => {
                if ( response.response.status === 200) {

                    if(response.data.token) {

                        const user = _parseJwt(response.data.token)

                        dispatch(success(user))
                    }

                } else {
                   dispatch(failure(response.statusText))
                }

            });
    }

    function request(token) { return { type: LOGIN_REQUEST, payload: token } }
    function success(user) { return { type: LOGIN_SUCCESS, payload: user } }
    function failure(error) {return { type: LOGIN_FAILURE, payload : error } }
}

const login = (username, password) => {
    return dispatch => {

        dispatch(request({ username }));

        authService.login(username, password)
            .then(
                 response => {

                     if (response.data.errors !== undefined) {

                        dispatch(failure(response.data.errors))

                     } else {

                        localStorage.setItem('access_token', response.data.access_token)
                        localStorage.setItem('refresh_token', null)

                        const user = _parseJwt(response.data.access_token);

                        dispatch(success(user));

                        dispatch({
                          type: ROUTING,
                          payload: {
                              method: 'push',
                              nextUrl: '/payments-set/feed/'
                          }
                        })

                     }

                }
            )
            .catch(
                error => console.log(error)
            );

    };

    function request(user) { return { type: LOGIN_REQUEST, payload: user } }
    function success(user) { return { type: LOGIN_SUCCESS, payload: user } }
    function failure(error) {return { type: LOGIN_FAILURE, payload : error } }
}

const logout = () => {
    return dispatch => {
        localStorage.removeItem('access_token')
        dispatch({ type: LOGOUT })
    }
}

const _parseJwt = token => {
    var base64Url = token.split('.')[1];

    if(base64Url === undefined) return null;

    var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));

    return JSON.parse(jsonPayload);
};

//const _setToken = (token) => {

//    setToken(token);
//    const expiration = new Date(new Date().getTime() + 1000 * 60  * 60);
//     setTokenExpirationDate(expiration);//set expiration time one hour from current time
//     localStorage.setItem(
//         "userData",
//         JSON.stringify({
//             token,
//             expirationTime: expiration.toISOString()
//         })
//     );
//
//     setTokenExpirationDate(expiration);
//     localStorage.setItem(
//         "userData",
//         JSON.stringify({
//             token,
//             expirationTime: expiration.toISOString()
//         })
//     );

//}


const refreshToken = () => {
    let currUser = JSON.parse(localStorage.getItem("userData"));
    let getUserFormData = new FormData();
    getUserFormData.append("grant_type", "refresh_token");
    getUserFormData.append("refresh_token", currUser.refresh_token);
    return new Promise((resolve, reject) => {
//         API
//             .post(`${URL}/token/url/`, getUserFormData, {
//                 headers: {
//                     Authorization: "Basic {secret_key}"
//                 }
//             })
//             .then(async response => {
//                 resolve(response);
//             })
//             .catch(error => {
//                 reject(error);
//             });
    });
};


export { login, logout, checkAuth, refreshToken }