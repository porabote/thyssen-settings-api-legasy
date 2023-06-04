import React from 'react'
//import { createBrowserHistory } from "history";

export default class Form extends React.Component {

    constructor(props) {

        super(props);

        this.renderChildren = this.renderChildren.bind(this)

        //const history = createBrowserHistory();

        this.state = {
            searchUriStorage: this.queryStringToObject(window.location.search),// Params for URI
            cells: {},
            elementsStorage: [],
            Filter: null,// App.initClass('Filter', this)
            Table: null, //App.initClass('Table', this),
            Calendar: null,// App.initClass('Calendar')
            Pagination: null,// App.initClass('Pagination', this)
            action : null,
            filterContainer : null,
            contentContainer : null,
            autosubmit : true,
            modelName : null,
            isFilter : false,
            content : {
                list : [],
                classOfPrimaryKey : null,
                redirectLink : '',
                callbacks : {
                    afterLoad : null
                }
            },
            callbacks: {
                beforeSendData : null,
                afterRenderContent : null
            },
            selects : {
                count : 0,
                cursor : 0,
                loaded : []
            },
            elements: [],
            loadedContentNode: null,
            checkMain: null, // Params for Loaded HTML
        };
        //console.log(this.props.children);


    }

    renderChildren() {
        return React.Children.map(this.props.children, child => {
            return React.cloneElement(child, {
                form: this
            })
        })
    }

    //document.body
    mousedownHandler = (e) => {
        if(!e.target.closest('.form-item__select-wrap')) {
            Form.closeAllDropPanels();
        }
    }
    mousedownFilter = (btn) => {
        Form.removeHistoryParam('page');
        Form.submit();
    }


    render() {
        return(
            <form className="on-form">
                {this.renderChildren()}
            </form>
        )
    }



    /**
     * Parsing URI to Object
     */
    queryStringToObject(uri)
    {
        let uriArray = uri.replace(/^\?*/, '');
        if(uriArray.length === 0) return {};

        uriArray = uriArray.split("&");

        let uriObj = {};
        for(var i = 0; i < uriArray.length; i++) {
            let chainArray = uriArray[i].split('=');
            uriObj[chainArray[0]] = chainArray[1];
        }

        return uriObj;
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

}