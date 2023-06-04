import React, { Component } from 'react'

class Tabs extends Component {

    static defaultProps = {
        defaultFocus: false,
        forceRenderTabPanel: false,
        selectedIndex: null,
        defaultIndex: null,
        environment: null
    };

    state = {
        selectedIndex: 0
    }

    setSelectedIndex = (key) => {
        this.setState({
            selectedIndex: key
        })
    }


    render() {

        const { children } = this.props;//, ...props

        return(
            <div className="tabs js-tabs">
                {
                    React.Children.map(children, (child, id) => {
                        return React.cloneElement(child, { tabs: this, tabKey: --id });
                    })
                }
            </div>
        )
    }
}

export default Tabs