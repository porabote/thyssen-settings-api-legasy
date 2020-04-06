<?$this->assign('title', 'Создание пункта меню')?>

<div class="sidebar-box" id="addMenus">

    <?=$this->OnHtml->display('formStart', [
        'data' => $entity,
        'method' => 'POST',
        'url' => [ 'controller' => 'menus', 'action' => 'add'],
        'id' => 'addMenusForm'
    ])
    ?>


    <?= $this->OnHtml->display('input', [
        'name' => 'id',
        'type' => 'hidden',
        'value' => $entity->id
    ])
    ?>




    <div class="sidebar-box-up">
        <span>Добавление пункта меню</span>
    </div>

    <div class="sidebar-box-center">


        <?= $this->OnHtml->display('input', [
            'name' => 'name',
            'label' => 'Название пункта меню',
            'class' => 'form-item__text',
            'type' => 'text',
            'autocomplete' => 'off'
        ])
        ?>

        <?= $this->OnHtml->display('input', [
            'name' => 'link',
            'label' => 'URI пункта',
            'class' => 'form-item__text',
            'type' => 'text',
            'autocomplete' => 'off'
        ])
        ?>

        <?= $this->OnHtml->display('select', [
            'name' => 'parent_id',
            'label' => 'Относится к модулю:',
            'id' => 'selectSetting',
            'class' => 'on-select__finder',
            'type' => 'select',
            'options' => $settingsList,
            'escape' => false,
            'empty' => 'Корень',
            'data-params' => '{
		        "model" : "Menus"
	        }'
        ])
        ?>

        <?= $this->OnHtml->display('select', [
            'name' => 'parent_id',
            'label' => 'Подкатегория для:',
            'id' => 'parentMenusAdd',
            'class' => 'on-select__finder',
            'type' => 'select',
            'options' => $parentList,
            'escape' => false,
            'empty' => 'Корень',
            'data-params' => '{
		        "model" : "Menus"
	        }'
        ])
        ?>

        

        <?= $this->OnHtml->display('select', [
            'name' => 'flag',
            'label' => 'Состояние',
            'id' => 'flag',
            'class' => 'on-select__finder',
            'type' => 'select',
            'options' => ['Выключен', 'Включен'],
            'escape' => false,
            'empty' => false,
            'value' => 'App',
            'data-params' => '{
		        "model" : "Menus"
	        }'
        ])
        ?>



        <?= $this->OnHtml->display('input', [
            'name' => 'controller',
            'label' => 'Контроллер',
            'id' => 'controllerField',
            'class' => 'form-item__text',
            'type' => 'text',
            'autocomplete' => 'off'
        ])
        ?>

        <?= $this->OnHtml->display('input', [
            'name' => 'plugin',
            'label' => 'Плагин',
            'id' => 'pluginField',
            'class' => 'form-item__text',
            'type' => 'text',
            'autocomplete' => 'off'
        ])
        ?>


        <?= $this->OnHtml->display('input', [
            'name' => 'action',
            'label' => 'Функция',
            'class' => 'form-item__text',
            'type' => 'text',
            'autocomplete' => 'off'
        ])
        ?>



        <?= $this->OnHtml->display('input', [
            'name' => 'unic_id',
            'label' => 'Идентификатор (ID)',
            'class' => 'form-item__text',
            'type' => 'text',
            'autocomplete' => 'off'
        ])
        ?>


    </div>

    <div class="sidebar-box-down">

        <button type="button" class="btn sidebar-close">Отмена</button>
        <?=$this->OnHtml->display('button', [
            'type' => 'submit',
            'text' => 'Сохранить',
            'id' => 'addMenusBtn',
            'class' => 'btn btn-sea button-ajax-form',
            'param' => '{ "model" : "menus" , "callback" : "afterSave" }',
            'escape' => true
        ]);
        ?>

    </div>

    <?=$this->OnHtml->display('formEnd') ?>

</div>



<script>

    var selectSetting = document.getElementById('selectSetting');

    selectSetting.addEventListener('change', function(){

        var selectValue = selectSetting.options[selectSetting.selectedIndex].value;

        if(selectValue.length > 0) {
            var selectValueSplited = selectValue.split('.');
            document.getElementById('pluginField').setAttribute('value', selectValueSplited[0]);
            document.getElementById('controllerField').setAttribute('value', selectValueSplited[1]);
        } else {
            document.getElementById('pluginField').setAttribute('value', '');
            document.getElementById('controllerField').setAttribute('value', '');
        }
    });

    // $( document ).ready(function() {
    //
    //     onApp.addMenusForm = onApp.initClass('AppForms');
    //     onApp.addMenusForm.initForm('addMenusForm', {
    //         "afterResponse" : function(){
    //             onApp.sidebar.close({element : document.getElementById('addMenusBtn')});
    //         }
    //     });
    //
    // });
</script>
