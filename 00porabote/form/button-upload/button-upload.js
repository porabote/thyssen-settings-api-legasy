import React from 'react'
import ProgressBar from './progress-bar'
import Api from '@services/api-service'
import './button-upload.less'

class ButtonUpload extends React.Component {

    constructor(props) {
        super(props)

        this.state = {
            files: []
        }

        this.fileInput = React.createRef();
    }

    upload = (File) => {

        const formData = new FormData();

        if (typeof this.props.data !== "undefined") {
            for (let field in this.props.data) {
                formData.append(field, this.props.data[field])
            }
        }

        formData.append('file', File)

        Api.post(this.props.uri, {
            body: formData,
        }).then(response => {
            if (typeof this.props.afterUpload === "function") {
                this.props.afterUpload(response);
            }
        })
    }

    render() {

        return(
            <div>

                <label className='uploader__label-default' style={this.props.style || {}}>
                    <div className="input_file">
                        <input
                            ref={this.fileInput}
                            multiple="multiple"
                            className="dropArea__input"
                            type="file"
                            onChange={(e) => {

                                {Object.keys(e.target.files).map((key, index) => {
                                    this.upload(e.target.files[key])
                                })}

                                this.setState({
                                    files: e.target.files
                                })

                                if (typeof this.props.onChange == "function") {
                                    this.props.onChange(e)
                                }
                            }}
                        />
                        {this.props.children}
                    </div>
                </label>

                {this.props.progressBar &&
                <ProgressBar files={this.state.files}></ProgressBar>
                }

            </div>
        )
    }
}

export default ButtonUpload