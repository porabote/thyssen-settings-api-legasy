import { combineReducers } from 'redux'
import { authReducer } from '@porabote/auth'
import { modalReducer } from '@porabote/modal'

export const rootReducer = combineReducers({
    auth: authReducer,
    modal: modalReducer
})

export default rootReducer