import { get, post } from '@services/api-service'

class authService {

    check = () => {
        return post(`/api/users/check/`)
    }

    login = ({username, password, account_alias = 'porabote'} = {}) => {

        const authData = {
            body: {
                username: username,
                password: password,
                account_alias: account_alias
            }
        };

        return post(`/api/users/login`, authData);

    }

}

export default new authService()