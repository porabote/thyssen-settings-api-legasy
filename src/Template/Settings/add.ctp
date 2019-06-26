<div class="sidebar-box" id="addModelmapID">

  <?=$this->Form->create( null, [
      'id' => 'addModelmapForm',
      'escape' => false
      ])?>
      
    <div class="sidebar-box-up">
       <span>Создание записи модели</span> 
    </div>
    <div class="sidebar-box-center">
      
      <div class="form-fieldset" style="grid-template-columns: 100%">
        
          <div class="form-item flex">
              <label class="form-item__label">Алиас *</label>	      
              <div class="form-item__input-wrap">	      
              <?= $this->Form->control('className', ['class' => 'form-item__text', 'type' => 'text']) ?>
            </div> 	       	            
          </div>
        
      </div>


      <div class="form-fieldset" style="grid-template-columns: 100%; ">
        
          <div class="form-item flex">
              <label class="form-item__label">Название на русском</label>	      
              <div class="form-item__input-wrap">	      
              <?= $this->Form->control('title', ['class' => 'form-item__text', 'type' => 'text']) ?>
            </div> 	       	            
          </div>
        
      </div>
      
      <div class="form-fieldset" style="grid-template-columns: 100%; ">
        
          <div class="form-item flex">
                <label class="form-item__label">Плагин:</label>	      
                <div class="form-item__select-wrap">	      
                    <?= $this->Form->control('plugin', [ 
	                    'id' => 'direction', 
	                    'class' => 'on-select__finder', 
	                    'type' => 'select',
	                    'empty' => false,
	                    'options' => $plugin_list,
	                    'data-params' => '{
		                   
	                    }'
	                ]) ?>            
	            </div> 	       
                <span class="form-item__info"></span>        
	        </div>
        
      </div>  


    <div class="sidebar-box-down">
      <button type="button" class="btn sb-close">Отмена</button>
      <?=$this->Form->button(__('Сохранить'), [ 
     	    'class' => 'btn btn-sea',
     	    'id' => 'addModelmap0Btn'					     
     	]);?>	
    </div>



  <?= $this->Form->end() ?>

    
</div>


  
  
<script>
$( document ).ready(function() {
  
 $('#addModelmapForm').onForm( 'set' );

  $('#addModelmapBtn').ajaxForm( 'setAjax', { model : 'companies' , frontend : 'afterSave', action : 'index' } );


  //$('#getPatientsContragent').sunAjaxList( 'getAjaxList', { model:'contractors', backend:'getJsonList', frontend :'setContragent', dom_parent :'.box-input' } );

  
 
  
//  $('#direction').sunform('selectList');
  
});  	
</script> 
