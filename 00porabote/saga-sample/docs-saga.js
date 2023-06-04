import { takeEvery } from 'redux-saga/effects' //put, takeEvery, call
//import { setRecords } from '../components/docs/docs-actions'//fetchRecords
import { FETCH_RECORDS } from '../components/docs/docs-types' //SET_RECORDS
//import store from '../store'

// todo API Service instead
// const fetchListFromApi = () => {
//
//     // const pageId = store.getState().characters.currentPage;
//     // return fetch(`https://rickandmortyapi.com/api/character/?page=${pageId}`)
//
// }

function* fetchRecordsWorker() {
    
    // const data = yield call(fetchListFromApi)
    // console.log(data)
    // const json = yield call( () => new Promise( res => res(data.json()) ) );
    // yield put(setRecords(json))
    
}

function* docsWatcher() {
    
    yield takeEvery(FETCH_RECORDS, fetchRecordsWorker)
    
}

export {
    docsWatcher
}