<script src="/plugins/onResizer/onResizer.js"></script>
<link rel="stylesheet" href="/plugins/onResizer/onResizer.css"/>

<?php $this->assign('title', $model['title']) ?>

<div class="grid-block" style="grid-template-columns: 100%;">
	

<!-- Right.. -->	    
  <div class="box">	
	<div class="box-header">
      <span class="box-header__text">  
        <span class="title_bookmark">Настройка ширины столбцов</span>               
      </span>

<!--  
      <span>
      <?=$this->Form->button(__('+ Добавить'), [ 
             'class' => 'button-drop sidebar-open',
             'type' => 'button',
             'data-sidebar' => "{ 'server-action' : '/Companies/add/' }"						     
          ]); ?>                  
      </span>    	          
-->
	</div>        

	<div class="info-nodata" style="padding: 0 30px;">* Для сортировки вы можете перетащить поле в нужную позицию</div> 
     <div class="on-resizer__wrap" style="padding: 2%;width: 96%;">
     <? 	
     $config = unserialize($model['settings']);
     
     foreach($config['associations'] as $key => $model_assoc) {
         //debug($model);
     
         $head = '';
     	if(isset($model_assoc['cells']) && isset($model_assoc['basic_model'])) {
             
             $head = '<div id="alias_'.$model_assoc['alias'].'" class="on-resizer headList">';
     	        foreach($model_assoc['cells'] as $cell_key => $cell) {
	     	        
	     	        $checked_index = ($cell['index']['show']) ? 'checked="checked"' : '';
	     	        $checked_view = ($cell['view']['show']) ? 'checked="checked"' : '';
	     	        //"url" : "/'.strtolower(str_replace('App', '', $ns['plugin'])).'/'.$ns['alias'].'/upDataS/",
	     	
     	        	$head .= '

     	        	<div style="width: '.$cell['index']['width'].';min-width: '.$cell['index']['width'].';" id="'.$cell['db_params']['name'].'"
     	        	  
     	        	    data-params=\'{
     	        	        "url" : "/api/settings/upDataS/",
     	        	        "className" : "Api.Settings",
     	        	        "data_s_path" : "associations|'.$key.'|cells|'.$cell['db_params']['name'].'|index|width",
     	        	        "field_name" : "settings",
     	        	        "record_id" : "'.$ns['className'].'",
     	        	        "frontend" : "upDataS",            	        	        
     	        	        "cell_id": "'.$key.'", "key": "'.$cell_key.'"
     	        	    }	        	    
     	        	    \'>
            	        	    
            	        <div style="display: flex;"> 	    
                        <div class="drop-button relative">  		
                          	
                          	<a href="#" class="drop-button__title"></a>  
                          	<div class="drop-button hide-blok">
                        
                                <div class="form-item__checkbox-wrap hide-blok__link" style="padding: 10px;" id="'.$cell['db_params']['name'].'">
                                    <input
                                    data-params=\'{
                                        "url" : "/api/settings/upDataS/",
                                        "className" : "Api.Settings",
                                        "data_s_path" : "associations|'.$key.'|cells|'.$cell['db_params']['name'].'|index|show",
                                        "field_name" : "settings",
                                        "record_id" : "'.$model['className'].'",
                                        "frontend" : "upDataS"
                                    }\'
                                     name="show_index_'.$cell['db_params']['name'].'" type="checkbox" '.$checked_index.' class="form-item__checkbox" id="show_index_'.$cell['db_params']['name'].'" />
                                    <label for="show_index_'.$cell['db_params']['name'].'">Отображать в общем списке</label> 
                                </div>
                        
                                <div class="form-item__checkbox-wrap hide-blok__link" style="padding: 10px;" id="'.$cell['db_params']['name'].'">
                                    <input
                                    data-params=\'{
                                        "url" : "/api/settings/upDataS/",
                                        "className" : "Api.Settings",
                                        "data_s_path" : "associations|'.$key.'|cells|'.$cell['db_params']['name'].'|view|show",
                                        "field_name" : "settings",
                                        "record_id" : "'.$model['className'].'",
                                        "frontend" : "upDataS"
                                    }\'
                                     name="show_index_'.$cell['db_params']['name'].'" type="checkbox" '.$checked_view.' class="form-item__checkbox" id="show_index_'.$cell['db_params']['name'].'_view" />
                                    <label for="show_index_'.$cell['db_params']['name'].'_view">Отображать в сводной таблице данных</label> 
                                </div>
                                 
                        
                          	</div>           
                        </div>
                        
                                    	        	    
            	        '.$cell['db_params']['comment'].'
            	        </div>
            	        
            	        </div>';
            	        }
            	    $head .= '</div>';
            	    
            	}
            	
            	echo $head;
            }
            ?>
            </div>

   

  </div>

<!-- ..Right -->

</div>

<script>


    $('.on-resizer').each(function(){
    	$(this).onResizer('init');
    });	


  $('body').delegate('input:checkbox', 'click',function() { // если клинули по чекбоксу

    var status = this.checked;
    if(!status) {
	    status = '0';
    } else {
	    status = '1';
    }

    var params = $(this).app('getElementData');
    params['value'] = status;
	
    $("#ajax-load").load('/api/settings/upDataS/', params, function(){ 
	    $.fn.balloon( 'show', 'Данные сохранены', 'complete' );
    });

    });


  $( ".headList" ).sortable({
    containment : "parent",
    axis: "y",
    cursor: "move",
    start: function(evt, ui) {
       window.start = ui.item.index();
    },
    stop: function(evt, ui) {
      setTimeout(
          function(){ 

              var params = $('#'+ui.item.attr('id')).app('getElementData');

              $.ajax({
                url: '/api/settings/resortFields/',
                type:'POST',
                data: { "className" : "Api.Settings", "path" : "associations-"+params.cell_id+"-cells", "record_id":"<?=$model['className']?>", "key" : params.key, "position_start" : start, "position_end" : ui.item.index(), "column" : "settings" },
                success: function( resp, textStatus ) { 
                  //console.log(data); 
                }
              });
  
          },
              20
      )
    }
  }); 




</script>
