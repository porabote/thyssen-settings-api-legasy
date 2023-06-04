class ApiService {

    // constructor() {
    //     console.log(process.env)
    // }

    #apiUrl = '';//process.env.apiURL;
    #access_token = '';// process.env.apiToken;

    post = async (url, data, params) => {

        const response = await fetch(this.getUrl(url), {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            credentials: 'omit',
            headers: {
                'Access-Control-Allow-Credentials': false,
                'Authorization': 'JWT ' + this.getToken(),
                'Accept': 'application/json',
                'Content-Type': 'application/json;charset=UTF-8',
                'Api-Version': 2
            },
            redirect: 'follow',
            referrerPolicy: 'no-referrer',
            body: JSON.stringify(data)
        });

        let responseJSON = await response.json();
        return {...responseJSON, ...{response: {status: response.status}}};

    }

    get = async (url, data, params) => {

        const response = await fetch(this.getUrl(url), {
            method: 'GET',
            mode: 'cors',
            cache: 'no-cache',
            credentials: 'omit',
            headers: {
                'Access-Control-Allow-Credentials': false,
                'Authorization': 'JWT ' + this.getToken(),
                'Accept': 'application/json',
                'Content-Type': 'application/json;charset=UTF-8',
                'Api-Version': 2
            },
            redirect: 'follow',
            referrerPolicy: 'no-referrer'
        });

        let responseJSON = await response.json();
        return {...responseJSON, ...{response: {status: response.status}}};

    }

    getUrl = (uri) => {
        return `${this.#apiUrl}${uri}`
    }

    getToken = () => {
        return localStorage.getItem('access_token');
    }

}

export default new ApiService()