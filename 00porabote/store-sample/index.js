import { compose, applyMiddleware, createStore } from 'redux'
//import sagaMiddleware, { rootWatcher } from '../saga'
import thunkMiddleware from 'redux-thunk'
import rootReducer from './root-reducer'

const store = createStore(rootReducer,
    compose(
        applyMiddleware(
            thunkMiddleware,
            //sagaMiddleware
        )
    ));

//sagaMiddleware.run(rootWatcher)

export default store;