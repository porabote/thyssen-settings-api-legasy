import { LOGIN_ROUTE, CHAT_ROUTE } from './utils/consts'

export const publicRoutes = [
    {
        path: LOGIN_ROUTE,
        component: Auth
    }
]

export const privateRoutes = [
    {
        path: CHAT_ROUTE,
        component: Chat
    }
]