import { LOGIN_SUCCESS, LOGOUT, LOGIN_FAILURE } from './auth-types'

const initialState = {
    isAuth: false,
    token: null,
    exp : null,
    iat: null,
    user: {
        name: ''
    },
    account_alias: 'porabote'
}
//return {...state, list: state.list.concat(action.payload)}
const authReducer = (store = initialState, action) => {
    switch (action.type) {
        case LOGIN_SUCCESS:
            return {...store, isAuth: true, user: {...store.user, ...action.payload}}
        case LOGIN_FAILURE:
            return {...store, isAuth: false, authError: action.payload}
        case LOGOUT:
            return {...store, isAuth: false}
        default: return store
    }

}

export default authReducer