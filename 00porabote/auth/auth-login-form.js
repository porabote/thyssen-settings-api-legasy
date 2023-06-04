import React, { Component } from 'react'
import { NavLink } from 'react-router-dom'
import AuthService from '@porabote/services'
import { Form, Field, InputHidden, Input, Button, Checkbox, SubmitButton } from '@porabote/form'
import  './auth.less'
import AccountCircleOutlinedIcon from '@material-ui/icons/AccountCircleOutlined';
import AccountCircleRoundedIcon from '@material-ui/icons/AccountCircleRounded';

class LoginForm extends Component {

    state = {

        values: {
            account_alias: 'porabote',
            username: 'd.razumihin@porabote.ru',
            password: 'z7893727',
        },
        formErrors: {
            email: '',
            password: ''
        }
    }

    submitForm = (values) => {

        authService.login(values)
    }

    render() {


        return (
            <div className="box login">

                <h1 style={{marginLeft: '10px'}}>
                    <AccountCircleOutlinedIcon style={{fontSize: '34px', marginRight: '13px', color: '#DBDBDB'}}/>
                    Авторизация
                </h1>

                <div className="box-body">

                    <Form
                        submitForm={this.submitForm}
                        defaultValues={this.state.values}
                    >

                        <Field>
                            <InputHidden type="password" inputClass="hidden_input" />
                        </Field>

                        <Field>
                            <InputHidden
                                label="Аккаунт"
                                name="account_alias"
                            />
                        </Field>

                        <Field>
                            <Input
                                label="E-mail"
                                name="username"
                            />
                        </Field>

                        <Field>
                            <Input
                                placeholder="***"
                                label="Пароль"
                                name="password"
                                type="password"
                            />
                        </Field>

                        <div style={{padding: '10px 0'}}>
                            <SubmitButton>
                                <Button
                                    text="Войти"
                                    className="on-button grey-stroke_x_yellow-fill icon-login-auth__grey_x_white"
                                    type="button"
                                    style={{width: '140px', marginTop: '20px'}}
                                />
                            </SubmitButton>
                        </div>

                        <div style={{
                            padding: '15px 0',
                            display: 'flex',
                            justifyContent : 'flex-end',
                            alignItems: 'flex-end'
                        }}>

                            {/*
                                <Checkbox
                                name="remember_me"
                                label="Запомнить меня"
                                type="checkbox"
                                inputClass="form-item__checkbox"
                                id="remember_me" />
                            */}
                            <NavLink to={"/auth/forgotPassword/"}>Восстановить пароль</NavLink>

                        </div>


                    </Form>

                </div>

            </div>

        );
    }
}

export default LoginForm