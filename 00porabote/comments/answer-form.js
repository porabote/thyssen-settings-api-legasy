import React from 'react'

import CommentForm extends React.Component {

    render(

        return(
            <form method="post" encType="multipart/form-data" accept-charset="utf-8" id="subCommentForm"
                  data-rules="{}" className="on_comments__sub-form hide" action="/comments/add/">
                <div style="display:none;"><input type="hidden" name="_method" value="POST"></div>
                <input type="hidden" name="record_id" id="record-id" value="212"> <input type="hidden"
                                                                                         name="class_name"
                                                                                         id="class-name"
                                                                                         value="App.Payments">

                    <input type="hidden" name="parent_id" id="parentId" value="0">


                        <div className="on_comments__form__input-couple__wrap" id="coupleInputs">


                            <label className="on_comments__form__input-couple__item__label first"><input
                                type="hidden" name="name" value="Максимов  Денис" readOnly="" placeholder="Ваше имя"
                                className="on_comments__form__input-couple__item first answer" id="commentName">
                                <span className="on_comments__form__listener-fio" id="listenerFio"></span>
                            </label>


                            <label className=""><textarea name="msg" id="commentMsg"
                                                          placeholder="Напишите ваш комментарий"
                                                          className="on_comments__form__input-couple__item"></textarea></label>

                        </div>


                        <div className="on_comments__form__button-panel">

                            <div className="on_comments__form__button-panel__buttons">
                                <button type="button" disabled="disabled"
                                        className="on_comments__form__button-panel__button send"
                                        id="buttonSendSubComment">Отправить
                                </button>
                                <button type="button"
                                        className="on_comments__form__button-panel__button cancel">Отменить
                                </button>
                            </div>


                        </div>

            </form>
        )
    )
}