import React from 'react'

class CommentForm extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            comment: '',
            isSubmitReady: false,
            txtHeight: '50'
        }

    }

    texareaChangeHandle = (e) => {

        let value = e.target.value;
        let isSubmitReady = (value.replace(/\s/g,'').length == 0) ? false : true

        // Если форма прошла валидацию, слушаем не был ли нажат ENTER
        // if(isSubmitReady) {
        //
        //     var value = currentValue.replace(/\s/g,'');
        //     if(value.length == 0) return false;
        //
        //     // Если это не Shift и  клавиша Enter и длина 0
        //     if (!e.nativeEvent.shiftKey && e.nativeEvent.which === 13 && value.length == 0) {
        //
        //         e.target.setAttribute('value', '')
        //         return false;
        //     }
        //     //Если это пробел в начале то отменяем его
        //     if (!e.shiftKey && e.which === 32 && value.length == 0) {
        //
        //         e.target.setAttribute('value', '')
        //         return false;
        //     }
        //     // Если это кнопка энтер то отправляем сообщение
        //     if(!e.shiftKey && e.which === 13 && value.length != 0) {
        //         //form.find('button.send').trigger('click');
        //     }
        //     if(!e.shiftKey && e.which === 13 && value.length == 0) {
        //         e.target.setAttribute('value', '')
        //         return false;
        //     }
        //
        //     this.setState({
        //         txtHeight: e.target.scrollHeight + e.target.offsetHeight - e.target.clientHeight,
        //         isSubmitReady
        //     })
        //     e.preventDefault();
        //
        // }
        this.setState({
            comment: value,
            txtHeight: e.target.scrollHeight + e.target.offsetHeight - e.target.clientHeight,
            isSubmitReady
        })
        e.preventDefault();

    }



    // Вставка комментария в DOM исходя из ответа сервера
    appendItem(button, record_data)
    {
        // Скрываем форму

        if(button.closest('form').getAttribute('id') == 'subCommentForm') {
            button.closest('form').classList.add('hide');
        }

        // Клонируем item по образцу и заполнем его
        var commentBlank = button.closest('.on_comments').querySelector('#commentBlank').cloneNode(true);

        commentBlank.querySelector('.on_comments__item-fio').querySelector('.on_comments__item-fio__sender').innerHTML = record_data.name;
        commentBlank.setAttribute('modules-id', record_data.id);

        //commentBlank.find('.on_comments__item-date').text(record_data.name);
        commentBlank.querySelector('.on_comments__item-title').innerHTML = record_data.msg;
        commentBlank.classList.remove('hide');
        commentBlank.setAttribute('id', 'item' + record_data.id);
        //commentBlank.querySelector('time').data('params')['datetime'] = this.getDateNow();
        commentBlank.querySelector('time').innerHTML = this.getDateNow();


        //var container = button.closest('.container.main');console.log(container);
        //var container_sub = container.querySelector('.container.sub');
        //var last_item = container_sub.find('.on_comments__item.on').last();

        var parentId = (button.closest('.on_comments__item')) ? button.closest('.on_comments__item').getAttribute('modules-id') : null;

        // Если это основной комментарий
        if(!parentId) {
            button.closest('.on_comments').querySelector('.on_comments__items').prepend(commentBlank);
        } else {
            button.closest('.on_comments').querySelector('.on_comments__item__childs-container[parent-id="'+parentId+'"]').prepend(commentBlank);
        }

        let containerForChilds = document.createElement('DIV');
        containerForChilds.classList.add('on_comments__item__sub-items', 'container', 'sub', 'on_comments__item__childs-container');
        containerForChilds.setAttribute('parent-id', record_data.id);
        commentBlank.append(containerForChilds);

        // Если комментарий был добавлен из основной формы
        if(!commentBlank.closest('.container.main')) {
            commentBlank.classList.add('container');
            commentBlank.classList.add('main');

        } else {
            // Добавлеяем фио, кому отвечаем

            //var main_comment = commentBlank.closest('.container.main');
            //commentBlank.prepend('<div class="on_comments__item__sub-items container sub on_comments__item__childs-container" parent-id="' + record_data.id + '"></div>');


            var listenerFIO = button.closest('form').querySelector('.on_comments__form__listener-fio').innerHTML;
            commentBlank.querySelector('.on_comments__listener-fio').classList.remove('hide');
            commentBlank.querySelector('.on_comments__listener-fio').innerHTML = listenerFIO;
        }

        //$.fn.core('timeDeclension', '#item' + record_data.id);

        $('html, body').animate({
            scrollTop : parseInt(commentBlank.offsetTop)
        }, 500);

    }

    beforeSend(form)
    {
        if(form.querySelector('#commentName').value.length == 0) {
            alert('Пожалуйста, укажите ваше имя');
            return false;
        }
        if(form.querySelector('#commentMsg').value.length == 0) {
            alert('Пожалуйста, напишите сообщение');
            return false;
        }
        return true;

    }

    clearForm(form)
    {
        form.querySelector('[name="msg"]').value = '';
    }

    showNext(button)
    {
        var itemsOff = button.closest('.on_comments').find('.on_comments__item.off');

        itemsOff.slice(0,10).removeClass('off').addClass('on');
        if (itemsOff.length < 11) { button.remove(); }

    }

    getDateNow()
    {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today =  yyyy + '-' + mm + '-' + dd + ' ' + today.getHours() + ':' + today.getMinutes() + ':00';//'2019-07-10 01:10:00'
        return today;
    }






    // bindingEvents()
    // {
    //     var comments = this;
    //
    //     this.setValidation(this.form);
    //     this.setEvents(this.form);
    //
    //     // Кнопка ответить
    //     $('body').delegate('.on_comments__item-response-link', 'click', function(event){
    //
    //         $(this).closest('.on_comments__item__sub-items').find('.on_comments__sub-form').each(function(){
    //             $(this).addClass('hide');
    //         });
    //
    //         // Если формы нет
    //         if($(this).closest('.on_comments__item').find('.on_comments__item-response-form').html().length == 0) {
    //
    //             if(!event.target.getAttribute('token')) {
    //                 var subForm = document.getElementById('subCommentForm').cloneNode(true);
    //             } else {
    //                 var subForm = document.getElementById('subCommentForm' + event.target.getAttribute('token')).cloneNode(true);
    //             }
    //
    //             let formId = Math.random().toString(36).substring(7);
    //
    //             subForm.setAttribute('id', formId);
    //             subForm.classList.remove('hide');
    //
    //             subForm.querySelector('[name="parent_id"]').value = event.target.closest('.on_comments__item').getAttribute('modules-id');
    //             subForm.querySelector('[name="msg"]').value = '';
    //             subForm.querySelector('#listenerFio').innerHTML =
    //                 event.target.closest('.on_comments__item').querySelector('.on_comments__item-fio__sender').innerHTML;
    //
    //
    //             // Инициализируем капчу в склонированной форме
    //             if(subForm.querySelector('.g-recaptcha') && subForm.querySelector('.g-recaptcha').length > 0) {
    //
    //                 /*
    //                                     sub_form.find('.g-recaptcha').attr('id', Math.random().toString(36).substring(7));
    //                                     sub_form.find('.g-recaptcha').html('');
    //                                     grecaptcha.render(sub_form.find('.g-recaptcha')[0], {
    //                                         'sitekey' : sitekey
    //                                     });
    //                 */
    //             }
    //
    //
    //             event.target.closest('.on_comments__item').querySelector('.on_comments__item-response-form').appendChild(subForm);
    //             comments.setValidation(document.getElementById(formId));
    //
    //             // Если форма есть но она скрыта
    //         } else if (
    //             event.target.closest('.on_comments__item').querySelector('.on_comments__item-response-form').innerHTML.length > 0 &&
    //             event.target.closest('.on_comments__item').querySelector('.on_comments__sub-form').classList.contains('hide')
    //         ) {
    //             event.target.closest('.on_comments__item').querySelector('.on_comments__item-response-form').querySelector('[name="msg"]').value = '';
    //             event.target.closest('.on_comments__item').querySelector('.on_comments__sub-form').classList.remove('hide');
    //
    //             // Ставим фокус на инпут (если фио заполнено ставим на сообщение)
    //             var subForm = event.target.closest('.on_comments__item').querySelector('.on_comments__sub-form');
    //         }
    //
    //         // Ставим фокус на инпут (если фио заполнено ставим на сообщение)
    //         if(subForm.querySelector('[name="name"]').value.length > 0) {
    //             subForm.querySelector('[name="msg"]').focus();
    //         } else {
    //             subForm.querySelector('[name="name"]').focus();
    //         }
    //
    //
    //         // Кнопка отправить
    //         let button = subForm.querySelector('#buttonSendSubComment');
    //         button.addEventListener('click', function(e){
    //             event.target.setAttribute('disabled', 'disabled');
    //             comments.sendComment(button);
    //             e.preventDefault();
    //         });
    //
    //         // Слушаем ENTER
    //         subForm.addEventListener('submit', function(e){
    //             //comments.sendComment(subForm.querySelector('.send'));
    //             e.preventDefault();
    //         });
    //
    //         return false;
    //
    //     });
    //
    //     // Кнопка отменить
    //     $('body').delegate('.on_comments__form__button-panel__button.cancel', 'click', function(){
    //         $('.on_comments__sub-form').addClass('hide');
    //         return false;
    //     });
    //
    // }
    //
    // setEvents(form)
    // {
    //     let coments = this;
    //
    //     // Кнопка отправить
    //     let button = form.querySelector('#buttonSendComment');
    //     button.addEventListener('click', function(e){
    //         event.target.setAttribute('disabled', 'disabled');
    //         coments.sendComment(event.target);
    //         e.preventDefault();
    //     });
    //
    //     // Слушаем ENTER
    //     form.addEventListener('submit', function(e){
    //         comments.sendComment(form.querySelector('.send'));
    //         e.preventDefault();
    //     });
    // }

    sendComment = () => {
        var comments = this;

        var form = button.closest('form');
        let formData = new FormData();
        let inputs = form.querySelectorAll(['input', 'textarea']);
        inputs.forEach(function(formItem) {
            formData.append(formItem.getAttribute('name'), formItem.value);
        });

        if(!this.beforeSend(form)) return false;

        onApp.ajax({
            'url' : form.getAttribute('action'),
            data: formData,
            response: function( response, textStatus ) {

                var recordData = response;

                if(typeof recordData == "object") {

                    comments.clearForm(form);

                    if(form.getAttribute('id') == 'commentsFormMain') {
                        form.classList.add('hide');
                    }

                    comments.appendItem(button, recordData);

                } else {
                    $('.ico.login').trigger('click');
                    //alert('Капча не прошла проверку');
                }

            }
        });
    }
    
    
    render() {

        return(
            <div className="on_comments">
                <div className="on_comments__form">
                    <input type="hidden" name="record_id" defaultValue="1"/>
                    <input type="hidden" defaultValue="docs"/>

                    <div className="on_comments__form__input-couple__wrap">

                        <label className="on_comments__form__input-couple__item__label first">
                            <input type="text"
                                   name="name"
                                   defaultValue="Максимов Денис"
                                   readOnly=""
                                   placeholder="Ваше имя"
                                   className="on_comments__form__input-couple__item first"
                            />
                        </label>
                        <label
                            className="on_comments__form__input-couple__textarea__label"
                            style={{height: `${this.state.txtHeight}px`}}
                        >
                            <textarea
                                value={this.state.comment}
                                type="text" 
                                name="msg"
                                placeholder="Напишите ваш комментарий"
                                className="on_comments__form__input-couple__item"
                                onChange={this.texareaChangeHandle}

                            >
                            </textarea>
                        </label>

                    </div>


                    <div className="on_comments__form__button-panel">

                        <button
                            type="button"
                            disabled={this.state.isSubmitReady ? false : true}
                            className="on_comments__form__button-panel__button  send"
                            id="buttonSendComment"
                            onClick={(e) => {
                                event.target.setAttribute('disabled', 'disabled');
                                this.sendComment(event.target);
                                e.preventDefault();
                            }}
                        >
                            Отправить
                        </button>
                    </div>

                </div>
            </div>
        )
    }
}

export default CommentForm