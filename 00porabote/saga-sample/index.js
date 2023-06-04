import createSagaMiddleware from 'redux-saga'
import { all } from 'redux-saga/effects'

//import { docsWatcher } from './docs-saga'

const sagaMiddleware = createSagaMiddleware()

export function* rootWatcher() {
    yield all([
        //docsWatcher()
    ])
}

export default sagaMiddleware