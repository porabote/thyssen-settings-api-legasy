import React from 'react'
import Header from './header'

class HeaderContainer extends React.Component {

    // componentDidMount() {
    //     axios.get('https://porabote.ru/users/auth/', {})
    //         .then(response => {
    //             //debugger;
    //             //console.log(response);
    //         })
    // }

    render() {
        return (

            <Header {...this.props} />
        )
    }
}

export default HeaderContainer