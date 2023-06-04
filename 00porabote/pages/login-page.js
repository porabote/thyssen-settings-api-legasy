import React, { Component } from 'react'
import { NavLink, Redirect } from 'react-router-dom'
import { connect } from 'react-redux'
import { login, checkAuth } from '../auth/auth-actions'
import { Button, Input, InputHidden, Checkbox } from '../form'


class LoginPage extends Component {

    constructor(props) {
        super(props);
        props.checkAuth()
    }

    state = {
        account_alias: 'porabote',
        email: 'd.razumihin@porabote.ru',
        password: 'z7893727',
        formErrors: {email: '', password: ''},
        emailValid: false,
        passwordValid: false,
        formValid: true
    }

    loginHandler = (event) => {

        event.preventDefault()

        const { login } = this.props
        login(this.state.email, this.state.password)

    }

    handleUserInput = (e) => {
        const name = e.target.name;
        const value = e.target.value;
        this.setState({[name]: value},
            () => { this.validateField(name, value) });
    }

    validateField = () => {

    }

    render() {

        document.title = "Porabote - Авторизация";

        if(this.props.auth.isAuth) return <Redirect to="/reports/feed/"></Redirect>

        const authError = ''//(this.props.auth.authError) ? <Error error={this.props.auth.authError} /> : ''

        return (
            <div className="AuthFormContainer">
            <div className="box login">

                <h1 className="login__title">Вход в систему</h1>

                <div className="box-body">

                    <form placeholder="" id="loginForm" action="/users/login">

                        <InputHidden type="password" inputClass="hidden_input"/>

                        <InputHidden
                            value={this.state.account_alias}
                            label="Аккаунт"
                            name="account_alias"
                        />


                        <Input
                            label="E-mail"
                            name="username"
                            value={this.state.email}
                            onChange={this.handleUserInput}
                        />

                        <Input
                            placeholder="***"
                            label="Пароль"
                            name="password"
                            type="password"
                            id="password"
                            value={this.state.password}
                            onChange={this.handleUserInput}
                        />

                        {authError}

                        <div style={{padding: '10px 0'}}>
                            <Button
                                text="Войти"
                                onClick={this.loginHandler}
                                className="on-button grey-stroke_x_yellow-fill icon-login-auth__grey_x_white"
                                type="button" style={{width: '140px', marginTop: '20px'}}
                                disabled={!this.state.formValid}
                            />
                        </div>

                        <div style={{
                            padding: '15px 0',
                            display: 'flex',
                            justifyContent: 'space-between',
                            alignItems: 'flex-end'
                        }}>
                            <Checkbox name="remember_me" label="Запомнить меня" type="checkbox"
                                      inputClass="form-item__checkbox" id="remember_me"/>
                            <NavLink className="link_forgot-passw" to={"/auth/forgotPassword/"}>Забыли пароль?</NavLink>

                        </div>


                    </form>

                </div>

            </div>
            </div>
        )
    }

}



const mapStateToProps = store => ({
    auth: store.auth
})
const mapDispatchToProps = {
    login,
    checkAuth
}
//
// export default compose(
//     LoginPage,
//     connect(mapStateToProps, mapDispatchToProps)
// )()

export default connect(mapStateToProps, mapDispatchToProps)(LoginPage)