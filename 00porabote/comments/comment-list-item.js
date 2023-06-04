import React from 'react'
import avatar from './svg/user_no-photo.svg';

class CommentListItem extends React.Component {

    render() {

        return(
            <div className="on_comments__item on" parent-id="">
                <div className="on_comments__item-avatar">
                    <div className="on_comments__item-avatar-img"
                         style={{backgroundImage: `url(${avatar})`}}
                    >

                    </div>
                </div>
                <div className="on_comments__item-fio">
                    <span className="on_comments__item-fio__sender"></span>
                    <span className="on_comments__listener-fio hide"></span>
                </div>
                <div className="on_comments__item-date">
                    <time
                        data-params="{&quot;mask&quot; : &quot;hh:mm, DD MMMM YYYY&quot;, &quot;declension&quot; : true, &quot;datetime&quot; : &quot;&quot;}">
                        21.07.2021
                    </time>
                </div>
                <div className="on_comments__item-title">
                    Этого не может быть
                </div>

                <div href="#" className="on_comments__item-response">
                    <div href="#" className="on_comments__item-response-link"
                         data-form-token="87f877e960e4d2a13b3bfd552d89db">Ответить
                    </div>
                    <div href="#" className="on_comments__item-response-form"></div>
                </div>
            </div>
        )
    }
}

export default CommentListItem