import React from 'react';

import OnForm from '../UI/form'
import Input from '../UI/input'
import Select from '../UI/select'
import Button from '../UI/button'


export function InvitationForm() {  //{ onSubmit, onChange, value }: Props

    document.title ="Porabote - Приглашение";

    const selects = {
        "people_id" : {
            "url" : "/peoples/getAjaxList/",
            "uri" : {
                "where" : {
                    'OR' : {
                        "name LIKE" : "%{{value}}%",
                        "last_name LIKE" : "%{{value}}%",
                        "middle_name LIKE" : "%{{value}}%"
                    }
                },
                "pattern" : '{{last_name}} {{name}}',
                "limit" : 10
            },
            "tags_board" : "#forPeople",
            "tags_single" : true,
            "listeners" : { "#postId":"people_id" },

            "afterSelect":"Peoples|selectInInvitation",
            "formId" : "#nomenclaturesListContainer"
        },
        'post_id' : {
            "model":"Posts",
            "url" : "/posts/getAjaxList/",
            "uri" : {
                "where" : {
                    'OR' : {
                        "name LIKE" : "%{{value}}%",
                        "fio LIKE" : "%{{value}}%"
                    }
                },
                "pattern" : '{{fio}} {{name}}',
                "limit" : 10
            },
            "afterSelect": () => {
                //let usernameField = document.getElementById('username').dispatchEvent(new Event('keyup'));
                console.log(99);
            },
            "tags_board" : "#forPosts",
            "tags_single" : true
        },
        'pattern_id' : {
            "model":"Acl.Patterns",
            "url" : "/acl/patterns/getAjaxList/",
            "uri" : {
                "where" : {
                    "title LIKE" : "%{{value}}%"
                }
            },
            "limit" : 30,
            "tags_board" : "#forPattern",
            "tags_single" : true
        }
    }
    //onApp.autoloadAll();
    //onApp.sidebar.close({element : document.getElementById('makeInvitationBtn')});

    const submitForm = () => {

    }


    return (
        <div>
            <h1>Приглашение</h1>
            <OnForm
                afterResponse = {(response) => { }}
                selects = {selects}
            >

                <Select
                    id = "peopleInvitationId"
                    name = 'people_id'
                    tags_count = {1}
                    label = "Физическое лицо:"
                    class = "on-select__finder"
                    escape = {false}
                    empty = 'Не выбрано'
                    url = "/persons/get/"
                    uri = ""
                    options = {[
                        {id: 5, name: "Андреев Николай"},
                        {id: 6, name: "Максимов Денис"},
                        {id: 8, name: "Литвинович Станислав"}
                    ]}
                    buttons = {[
                        {
                            url : '/peoples/add/',
                            title : 'Добавить физическое лицо',
                            class : 'form-item__icon-plus tooltip js-open-modal'
                        }
                        ]}
                    />

                <Input name="email" label="E-mail"/>
                <Input name="post" label="Должность"/>


                <Select
                    name = 'role_id'
                    label = "Права:"
                    class = "on-select__finder"
                    url = "/persons/get/"
                    uri = ""
                    options = {[
                        {id: 1, name: "Администратор"},
                        {id: 2, name: "Пользователь"}
                    ]}
                />

                <div style={{padding: '10px 0'}}>
                    <Button
                        text="Отправить приглашение"
                        onClick={submitForm}
                        className="on-button grey-stroke_x_yellow-fill icon-login-auth__grey_x_white"
                        type="button" style={{width: '280px', marginTop: '20px'}}
                    />
                </div>

            </OnForm>
        </div>
    )

}
export default InvitationForm