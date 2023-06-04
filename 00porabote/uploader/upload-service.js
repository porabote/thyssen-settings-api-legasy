//import axios from 'axios'

class uploadService {

    constructor() {

        this._apiUrl = 'https://api.porabote.ru';
        this.access_token = localStorage.getItem('access_token');

        // this.connect = axios.create({
        //     baseURL: this._apiUrl,
        //     timeout: 10000,
        //     headers: {
        //         'Access-Control-Allow-Credentials': true,
        //         'Authorization': 'JWT ' + this.access_token,
        //         'Accept': 'application/json',
        //         'Content-Type': 'multipart/form-data'
        //     }
        // })

    }

    upload = (el, extraInfo) => {

        if(!el.target.files.length) {
            alert('Файлы не выбраны')
            return
        }

        var formData = new FormData();
        formData.append("files[0][file]", el.target.files[0]);
        for(const fieldName in extraInfo) {
            formData.append('files[0][' + fieldName + ']', extraInfo[fieldName]);
        }


        this.connect.post("/files/upload/", formData, {

            onUploadProgress: (p) => {
                console.log(p);
                //this.setState({
                //fileprogress: p.loaded / p.total
                //})
            }
        }).then (data => {
            console.log(data)
            //this.setState({
            //fileprogress: 1.0,
            //})
        }).then (resp => {
            console.log(resp)
        })
       // return this.connect.post(`/files/upload/`, data)
    }

}

export default new uploadService()