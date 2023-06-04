import React from 'react'

import { login } from './auth-actions'

import { Button, Input, InputHidden } from '../UI'

export default function RegistrationForm(props) {

    const state = {
            account_alias: '',
            email: '',
            password: '',
            formErrors: {email: '', password: ''},
            emailValid: false,
            passwordValid: false,
            formValid: true
        }


    //const setState = () => {}

    // const login = (props) => {
    //     //contextType.login(props);
    // }

    const handleUserInput = (e) => {
       // const name = e.target.name;
       // const value = e.target.value;
        // this.setState({[name]: value},
        //     () => { this.validateField(name, value) });
    }
    //
    // const loginHandler = () => {
    //
    //     // API.post('/auth/login', this.state, { validateStatus: false })
    //     //     .then(res => {
    //     //         login(res.data);
    //     //     });
    //
    // }

    document.title ="Porabote - Регистрация";

    return (
        <div className="box login">

            <h1 className="login__title">Регистрация</h1>

            <div className="box-body">

                <form placeholder="" id="loginForm" action="/users/login">

                    <InputHidden type="password" inputClass="hidden_input" />

                    <InputHidden
                        value={state.account_alias}
                        label="Аккаунт"
                        name="account_alias"
                    />


                    <Input
                        label="E-mail"
                        name="username"
                        value={state.email}
                        onChange={handleUserInput}
                    />

                    <Input
                        placeholder="***"
                        label="Пароль"
                        name="password"
                        type="password"
                        id="password"
                        value={state.password}
                        onChange={handleUserInput}
                    />

                    <div style={{padding: '10px 0'}}>
                        <Button
                            text="Отправить запрос"
                            onClick={dispatch => (login)}
                            className="on-button grey-stroke_x_yellow-fill icon-login-auth__grey_x_white"
                            type="button" style={{width: '200px', marginTop: '20px'}}
                            disabled={!state.formValid}
                        />
                    </div>

                </form>

            </div>

        </div>
    )

}