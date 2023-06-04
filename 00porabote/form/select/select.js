import React from 'react'
import Option from './option'
import SelectTags from './select-tags'
import Api from '@services/api-service'
import Datas from '@porabote/datas'
import './select.less'

export default class Select extends React.Component {

    constructor(props) {

        super(props);

        this.state = {
            options: [],
            empty: (props.empty === undefined) ? 'Не выбрано' : props.empty,
            seekValue: '',
            seekDelay: 300,
            seekMode: (typeof props.seekMode === "undefined") ? 'static' : props.seekMode,
            mode: (typeof props.mode === "undefined") ? 'default' : props.mode,
            inputValue: '',
            searchPhrase: '',
            url: (props.url) ? props.url : null,
            uri: (props.uri) ? this.objectToQuerystring(props.uri) : null,
            setOption: (typeof props.setOption === 'function') ? props.setOption : null

            // limit : (props.limit) ? props.limit : 50,
            // valueInit: null,
            // inputValue: '',
            // firstLoaded: null,
            // isAjaxCompleted: false,
            // isOpened: false,
            // isFirstLoad: true
        }

        this.textInput = React.createRef();
        this.dropPanel = React.createRef();
        this.toggleDropList = this.toggleDropList.bind(this);

    }

    componentDidMount() {
        this.setDropPanelWidth();
        this.setElementPositions();

        if (!this.state.url) {
            this.setOptions();
        } else {
            this.getOptionsByApi()
        }
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        if(prevProps.updated !== this.props.updated) {
            this.setOptions()
        }
    }


    getOptionsByApi()
    {
        // this.setState({
        //     isAjaxCompleted: false
        // })

        let url = (this.state.uri) ? `${this.state.url}?${this.state.uri}` : this.state.url
        Api.get(url)
            .then( resp => {
                if (resp.response.status === 200) {

                    const options = resp.data.map((item, index) => {
                        return this.state.setOption(item)
                    })
                    this.setOptions(options)
                }

            });
    }

    /**
     * Parsing Object to URI
     */
    objectToQuerystring(obj, prefix) {
        var str = [],
            p;
        for (p in obj) {
            if (obj.hasOwnProperty(p)) {
                var k = prefix ? prefix + "[" + p + "]" : p,
                    v = obj[p];
                str.push((v !== null && typeof v === "object") ?
                    this.objectToQuerystring(v, k) :
                    encodeURIComponent(k) + "=" + encodeURIComponent(v));
            }
        }
        return str.join("&");
    }

    /*
    * Set Options
    * */
    setOptions(OptionsApi = {}) {

        let Options = [];

        if (Object.keys(OptionsApi).length === 0) {
            //If only one Option, put to array
            Options = (Array.isArray(this.props.children)) ? [...this.props.children] : [this.props.children]
        } else {
            Options = OptionsApi
        }

        this.setEmptyOption(Options);

        let selectedOption = null;

        let currentValue = Datas.getValueByPath(this.props.name, this.props.formContext.values);

        let options = Options.map( child => {
            if (typeof child === 'undefined') return

            if (child.props.value === currentValue) {
                selectedOption = child
            }
            return child;
        });
        
        let inputValue = (selectedOption && this.state.mode !== 'tags')
            ? selectedOption.props.children : this.state.empty

        this.setState({
            options,
            inputValue
        })

    }

    /*
    * Set Default Option
    * */
    setEmptyOption = (options) => {
        if(this.state.empty) {
            options.unshift(<Option key={Math.random()} value=''>{this.state.empty}</Option>)
        }
        return options
    }

    clickByLinkOption = (e) => {

        this.setState({
            isOpened: false,
            value: e.target.getAttribute('value'),
            inputValue: e.target.innerText,
            seekValue: ''
        })

        this.props.formContext.setFieldValue(this.props.name, e.target.getAttribute('value'))

        if (typeof this.props.afterSelectCallback === 'function') this.props.afterSelectCallback(e, this.props.formContext)

        e.preventDefault();
    }

    clickByLinkOptionTagsMode = (e) => {

        if (e.target.getAttribute('value').length === 0) return

        let value = [...this.props.values[this.props.name], e.target.getAttribute('value')]

        value = value.filter((value, index, self) => {
            return self.indexOf(value) === index;
        })

        this.setState({
            value
        })

        this.props.setFieldValue(this.props.name, value)

    }

    setElementPositions() {
        this.dropPanel.current.style.top = "34px";
    }


    toggleDropList(el)
    {
        if(!this.state.isOpened) {

            this.textInput.current.focus();

            this.setState({
                isOpened: true
            })

        } else {

            this.setState({
                isOpened: false
            })
        }
    }

    showDropPanel = () => {
        this.dropPanel.current.style.zIndex = 1000
        this.setState({ isOpened: true })
    }

    hideDropPanel = () => {
        this.dropPanel.current.style.zIndex = 10
        this.setState({
            isOpened: false
        })
    }

    /* Если селект был инициализирован в display:none, обновляем ширину */
    setDropPanelWidth()
    {
        if(this.refs.wrap.offsetWidth !== this.dropPanel.current.offsetWidth) {
            this.dropPanel.current.style.width = this.refs.wrap.offsetWidth + 'px';
        }
    }

    buildOptions = () => {

        return this.state.options.map((option, index) => {

            if (typeof option === 'undefined' || typeof option.props === 'undefined') return

            let isMatch = (
                option.props.children
                && option.props.children.length > 0
                && !option.props.children.toLowerCase().includes(this.state.seekValue)
            ) ? false : true

            if (!isMatch) return

            let afterSelectCallback = this.clickByLinkOption

            if (this.state.mode === 'tags') afterSelectCallback = this.clickByLinkOptionTagsMode

            return React.cloneElement(option, {...option.props, afterSelectCallback})

        })

    }

    render() {

        let dropStyle = { visibility: "hidden" }

        if(this.state.isOpened) {
            dropStyle = { visibility: "visible" }
        }

        const options = this.buildOptions()

        const tags = (this.state.mode === 'tags') ?
            <SelectTags
                name={this.props.name}
                modalContext={this.props.modalContext}
            /> : '';

        let disabled = (typeof this.props.desabled !== 'undefined' && this.props.disabled) ? true : false

        return(
            <div className="form-item flex no_padding">
                <label className="form-item__label">{this.props.label}</label>
                <div className="form-item__select-wrap" ref="wrap">
                    <span className="form-item__select-custom">

                        <input
                            disabled={disabled}
                            ref={this.textInput}
                            className="form-item__select-custom__input"
                            type="text"
                            onChange={(e) => {
                                this.setState({
                                    inputValue: e.target.value,
                                    seekValue: e.target.value.toLowerCase()
                                })
                            }}
                            onClick={(e) => {
                                e.target.select();
                            }}
                            onFocus={this.showDropPanel}
                            onBlur={ e => {
                                this.hideDropPanel();
                            }}
                            value={(this.state.inputValue) ? this.state.inputValue : ''}
                        />

                        <span
                            ref="toggle"
                            className="form-item__select-custom__toggle"
                            onMouseDown={(e) => {
                                if (disabled) return;
                                e.preventDefault();
                                this.toggleDropList()
                            }}
                        >
                            <span className="form-item__select-custom__icon"></span>
                        </span>

                        <div
                            style={dropStyle}
                            ref={this.dropPanel}
                            className="form-item__select__drop-blok"
                        >
                            <span>
                                {options}
                            </span>

                        </div>
                    </span>
                </div>
                {tags}
            </div>
        )
    }

}


// _setUri()
// {
//     let encodedUri = '';
//
//     if(this.state.defaultValue && this.state.limit) {
//
//         let defaultUri = this.state.uri;
//         if(typeof defaultUri.where['AND'] == "undefined") defaultUri.where['AND'] = {};
//
//         let uri = {where : {AND : {id : this.state.defaultValue} }}
//         if(typeof this.state.pattern != "undefined") uri.state = this.state.pattern;
//         encodedUri = this.state.form.objectToQuerystring(uri);
//         if(!encodedUri) return null;
//         //encodedUri = encodedUri.replace(/7B\%7Bvalue\%7D\%7D/g, this.searchPhrase);
//
//         this.setState({'value': this.state.defaultValue, 'defaultValue': null})
//
//     } else if (typeof this.state.uriDefault != 'undefined') {
//
//         encodedUri = this.state.form.objectToQuerystring(typeof this.state.uriDefault);
//         //encodedUri = encodedUri.replace(/7B\%7Bvalue\%7D\%7D/g, this.state.searchPhrase);
//
//         delete this.state.uriDefault;
//
//     } else {
//
//         if(this.state.defaultValue) {
//             this.setState({'value': this.state.defaultValue})
//             delete this.state.defaultValue;
//         }
//
//         encodedUri = (typeof this.state.uri != 'undefined') ? this.state.form.objectToQuerystring(this.state.uri) : null;
//
//         if(!encodedUri) return null;
//         //encodedUri = encodedUri.replace(/7B\%7Bvalue\%7D\%7D/g, this.searchPhrase);
//     }
//
//     return encodedUri;
//
// }

// setSelected()
// {
//     //Опредляем дефолтное значение селекта, устанавливаем и обнуляем
//     if(this.state.value) {
//         this.refs.select.value = this.state.value;
//     }
//
//     var selectedOption = this.refs.select.options[this.refs.select.selectedIndex];
//
//     if(typeof selectedOption === "undefined") {
//         this.refs.textInput.value = 'Не выбрано';
//         this.refs.select.value = null;
//     } else {
//         this.textInput.current.value = selectedOption.innerHTML;
//         this.refs.select.value = selectedOption.getAttribute('value');
//     }
// }

// setOptionsApi(data) {
//
//     let options = [];
//     for (const [key, option] of Object.entries(data)) {
//         options.push(<Option key={key} value={option.id}>{option.name}</Option>)
//     }
//
//     this.setOptions(options)
// }
