import React from 'react'

class SelectTags extends React.Component {

    removeItem = (e) => {
        let deleteKey = e.target.getAttribute('item');
        let values = this.props.value.filter((item, index) => index != deleteKey)
        this.props.formContext.setFieldValue(this.props.name, values, 'replace')
    }

    render() {

        return(
            <React.Fragment>
                <div></div>
                <div className={this.props.value.length > 0 ? 'select-tags active' : 'select-tags'}>
                    {
                        this.props.value.map((val, index) => {
                            return (
                                <div key={index} className='select-tag'>
                                    <span
                                        item={index}
                                        className='select-tag-close'
                                        onClick={this.removeItem}
                                    >
                                        x
                                    </span>
                                    {val}
                                </div>
                            )
                        })
                    }
                </div>
            </React.Fragment>
        )
    }

}

export default SelectTags