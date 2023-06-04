import { OPEN_MODAL, CLOSE_MODAL, PUSH_MODAL_ITEM, REMOVE_MODAL_ITEM } from './modal-types'

const initialState = {
    isOpen: false,
    items : []
}

const modalReducer = (state = initialState, action) => {

    switch (action.type) {
        case PUSH_MODAL_ITEM:
            return {...state,
                isOpen: true,
                items: [
                    ...state.items,
                    {
                        title: action.payload.title,
                        content: action.payload.content,
                    }
                ]
            }
        case OPEN_MODAL:
            return {...state, isOpen: true}
        case CLOSE_MODAL:
            return {...state, isOpen: false}
        case REMOVE_MODAL_ITEM:
            return {
                ...state,
                items: [
                    ...state.items.slice(0, action.payload.tabKey),
                    ...state.items.slice(++action.payload.tabKey)
                ],
                isOpen: action.payload.isOpen
            }
        default: return state
    }

}

export default modalReducer