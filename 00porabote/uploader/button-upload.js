import React from 'react'
import uploadService from './upload-service'

const ButtonUpload = (props) => {


    const uploadStart = (el) => {
        uploadService.upload(el, props)
    }

    return(
        <label className="uploader__label-default">
            <div className="input file">
                <input
                    onChange={uploadStart}
                    multiple="multiple"
                    className="dropArea__input"
                    type="file"
                    {...props}
                />
            </div>
            Загрузить файл
        </label>
    )

}

export default ButtonUpload