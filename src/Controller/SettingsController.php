<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

use Cake\Datasource\ConnectionManager;
use Cake\Database\Schema\Table;
use Cake\Database\Schema\Collection;
use ReflectionClass;
use ReflectionProperty;
use App\Component\MassiveComponent;
use App\Interfaces\ApiInterface;
use App\Traits\ApiTrait;
use Cake\Event\Event;

class SettingsController extends AppController
{
	use ApiTrait;


    public $mainModel = null;


    public function initialize()
    {
        parent::initialize();
    }

    public function beforeFilter(Event $event)
    {
        //$this->eventManager()->off($this->Csrf);
    }

    public function index()
    {
        $records = $this->Settings->find()->order(['className' => 'ASC'])->toArray();
        $this->viewBuilder()->setLayout('default_html');
        $this->set(compact('records'));
    }

    public function getDumpDefaultDb()
    {
        $connectionCreator = ConnectionManager::get('default');//debug($connectionCreator);
        $dumpPath = TMP.'dump.sql';
        $query = 'mysqldump -u'.DB_USER.' -p'.DB_PSW.' --skip-add-drop-table --skip-add-locks --skip-disable-keys --skip-set-charset --compact api_default > '.$dumpPath;
        exec($query);
        
        $dump = htmlentities(file_get_contents($dumpPath));
        $this->__outputJSON(['dump' => $dump]);
        
        $this->render(false);
    }


    function dbTest()
    {
	    $this->render(false);
	    
	    $test = \Porabote\ORM\TableRegistry::get();
    }


    /*
	 *  Добавление новой модели   
     */
    public function add()
    {	    	 
	    $this->viewBuilder()->setLayout('default_html');
	       
        if($this->request->getData()) {
	        
	        $className = $this->request->getData('plugin'). '.' .$this->request->getData('alias');
	        
            if(!$this->Settings->exists(['className' => $className])) { 
                
                $entity = $this->Settings->newEntity($this->request->getData());
                
                $this->Settings->save($entity);
            } else {
	          // $mm = $this->Settings->find()->where(['table_name' => $table_name])->first();
	           //$this->updateConfig($mm->className);
            }
        }
        
        $plugin_list = TableRegistry::get('Plugins')->find('list', ['keyField' => 'alias', 'valueField' => 'alias']);
        $this->set( compact('plugin_list') );
    }

    function getList()
    {
        $list = $this->Settings->find('list', [
            'keyField' => 'className',
            'valueField' => 'title'
        ])
        ->order(['Settings.title' => 'ASC']);

        $this->__outputJSON(['list' => $list]);
    }

    public function view($className)
    {
        $record = $this->loadModel('Settings')->find()->where([ 'className' => $className ])->first();
        $this->viewBuilder()->setLayout('default_html');
        $this->set(compact('record'));
    }


    public function getData( $className = null, $settings = [], $where = [] )
    {
	    if(!$className) return null;
	    $ns = $this->setNamespace( $className );

        $this->paginate = [
            'limit' => 25,
            'order' => [
              //'Articles.title' => 'asc'
            ]
        ];

        if($this->request->getData('render_view')) {        
            $this->loadDataTree();
        } else {

	        $model = $this->Settings->get($className);
            $model['settings'] = unserialize($model['settings']);
            
            // Get conditions 
           // $requestData =      
	        $where = (!$where) ? 
	            $this->Filter->handling_request_data( $this->request->getData('filter.self'), $model['settings'] ) : $this->Filter->handling_request_data( $where, $model['settings'] );

            // Get records          
            $query = TableRegistry::get($ns['className'])->find();

            // Устанавливаем индивидуальные параметры в контроллере
            if($this->request->getData('filter.join')) {        
                $where_extend = $this->setJoinConditions($query, $where, $this->request->getData('filter.join'));
            }
		  
            // Set OR
            if(!empty($where[str_replace('.', '_', $ns['className'])]['OR'])) {
	            $or_params = $where[str_replace('.', '_', $ns['className'])]['OR'];
		    
                $query->where(function (QueryExpression $exp) use ($or_params) {
                    return $exp->or_($or_params);
                });
            }
		    
            // Set AND
            if(!empty($where[str_replace('.', '_', $ns['className'])]['AND'])) {
	            $or_params = $where[str_replace('.', '_', $ns['className'])]['AND'];
		    
                $query->where(function (QueryExpression $exp) use ($or_params) {
                    return $exp->and_($or_params);
                });
            }
		    
            // debug($settings['settings']['contains']);
            if(isset($model['settings']['contains']))  $query->contain( $model['settings']['contains'] )->order([ $ns['alias'].'.id' => 'DESC' ]);        
	       
            $model['records'] = $query;
            // Output
            $this->paginate($model['records']);
            $this->set(compact( 'model' ));

            $this->render('/ModelSettings/get_data');         
        }                          
    }


    /*
     * Настройка фильтра
     * string $className - name of class
    */
    public function setFilterParams($className)
    {
	    $model = $this->get($className, null);
        $this->set(compact('model'));
    }
    
    /*
     * Настройка отображения общих списков
     * string $className - name of class
    */
    public function setViewParams($className)
    {
	    $ns = $this->setNamespace($className);
	    $model = $this->get($className, null);
        $this->set(compact('model', 'ns'));
    }
    

    /* 
	 * Обновить все базовые модели
	 */ 
    public function dropMainAll()
    {
        $records = $this->Settings->find()->where([  ]);

        foreach($records as $record) {
	        $this->get($record->className);
        }
        
        $this->render(false);
    }

    /*
     * updateSettings - обновление одной модели	
     */
    function update($className, $drop = false)
    {
	    $this->render(false);
	    
	    $record = $this->Settings->find()->where(['className' => $className])->first();

	    $settings = $this->getSettings($className);
	    $record['settings'] = serialize($settings);
	    if( $this->Settings->save($record) ) { //debug(unserialize($record['settings']));
		    echo 'Model <b>ID:'.$record['id'].' ' .$className. '</b> has been update <br>'; 
		}	
	    
	    //return $record;    
    }

    /*
     * updateSettings - обновление одной модели	
     */
    function updateLinks($className)
    {
	    $this->render(false);
	    
	    $record = $this->Settings->find()->where(['className' => $className])->first();
	    $record['settings'] = unserialize($record['settings']);

	    $ns = (empty($this->ns)) ? $this->setNamespace($className) : $this->ns;	   	    
		$model = '\\'.ucfirst($ns['plugin']).'\Model\\Table\\'.$ns['alias'].'Table';
		
		$model = new $model;
		
		$record['settings']['links'] = $model->links;
		
		$record['settings'] = serialize($record['settings']);

	    if( $this->Settings->save($record) ) { echo 'Model <b>' .$className. '</b> has been update <br>'; }	  
    }

    /*
	 * Api - get full list   
     */
    public function getAll($options = [ 'response_format' => 'json' ])
    {
	    $models = $this->Settings->find();
		    
		if(!$options) { return $model; }
		elseif ($options['response_format'] == 'json') { $this->__outputJSON($models); }

    }



    /* 
	 * Обновить базовую модель
	 */ 
    public function getSettings($className, $association_list = null, $callClassName = null, $main_model = null )
    {       
        // Get Model
	    $ns = (empty($this->ns)) ? $this->setNamespace($className) : $this->ns;	   	    
		
		if(!$main_model) { 
			$model = '\\'.ucfirst($ns['plugin']).'\Model\\Table\\'.$ns['alias'].'Table';
		} else {
			//debug($main_model->getAssociation($ns['alias']));
			$className = $main_model->getAssociation($ns['alias'])->className();
			$model = '\\'.ucfirst($ns['plugin']).'\Model\\Table\\'.$className.'Table';
			$className = $ns['plugin'].'.'.$className;
		}

	    // Get record 
        $record = $this->Settings->find()->where([ 'className' => $className ])->first();
        
        $settings['className'] = $className;
        $settings['alias'] = $ns['alias'];
        $settings['flag'] = 'visible';
        $settings['plugin'] = $ns['plugin'];
        $settings['title'] = $record['title'];
        $settings['active'] = 1;
        $settings['filter'] = 1;
        $settings['associations'] = [];
        if($callClassName) $settings['parent_field'] = $callClassName;

	    if(class_exists($model)) {
		    
	        $model = new $model;
	        
	        
/*
	        $associations = $model->associations();//debug($associations);
foreach ($associations->getByType('HasMany') as $item) {debug($item->className());
    $options['name'] = $item->getName();             //ChildAcos
    $options['foreignKey'] = $item->getForeignKey(); //parent_id
    //$options['className'] = $item->?();         //Acos
    $hasMany[] = $options;
}
*/
	        
	        
	        if(!$main_model) { 
		        $main_model = $model;
		        $this->mainModel = $model;
		    }
	        //debug($model->getAssociation('Managers'));


	        $settings['cells'] = $this->getTableSchema($className);
	        
            if(!$association_list) { // If it basic model
		        $settings['links'] = $model->links;
				$settings['contains'] = [];
				$settings['basic_key'] = 0;
				$settings['associations'][0] = $settings;
				$settings['associations'][0]['basic_model'] = 1;
				unset($settings['cells']);
                    
		        foreach($model->contain_map as $field => $params) {

			        if(!isset($params['model']) && isset($params['leftJoin'])) {
				        if((is_string($params['leftJoin']))) {
					        $params['model'] = $params['leftJoin'];
					        $settings['contains'][] = $params['leftJoin'];
					    }
				        elseif(is_array($params['leftJoin'])) { 
					        $params['model'] = array_key_first($params['leftJoin']);
					        $settings['contains'][$params['model']] = $params['leftJoin'][array_key_first($params['leftJoin'])];
					        //debug($settings['contains']);
					    }
				        
				    }
			       
			        if(isset($params['model'])) {            
			            $params_className = (!isset($params['plugin'])) ? 'App.'.$params['model'] : $params['plugin'].'.'.$params['model'];
			            
			            if(!isset($params['leftJoin'])) $settings['contains'][$params['model']] = $params['model'];
			           
			            if(!empty($model->contain_map)) {
			                //$settings['associations'][] = $this->getSettings($params_className, $model->contain_map, $field, $main_model);
			            }
			        }
		        } 
	        }
	    } else {
		    echo 'Класс <b>' .$model. '</b> не найден <br>';
	    }
	       //debug($settings);       
        return $settings;	    
    }


    public function getTableSchema($className)
    {
	    $model = TableRegistry::get($className);

        $connectionCreator = ConnectionManager::get($model->defaultConnectionName()); 
        //$connectionCreator->config()['database'] 
        
        $shared_bases = ['api', 'api_default'];
        $db_name = (!in_array($connectionCreator->config()['database'], $shared_bases )) ? 'api_default' : $connectionCreator->config()['database'];

        $table_name = explode('.', $model->getTable());
        $table_name = end($table_name);

        $query = 'SELECT * 
        FROM information_schema.tables
        WHERE table_schema = \''.$db_name. '\' 
            AND table_name = \''.$table_name.'\'
        LIMIT 1;';

        if($result = $connectionCreator->execute($query)->fetchAll('assoc')) {

            $reflectionClass = new ReflectionProperty($model->getSchema(), '_columns');
            $reflectionClass->setAccessible(true);
            
            $columns_base = $reflectionClass->getValue($model->getSchema());
		    
            // Пересортировываем по порядку указания в моделе
            $resort_columns_base = [];
            foreach($model->contain_map as $column_name => $params) {
	            if(isset($columns_base[$column_name])) {
	                $resort_columns_base[$column_name] = $columns_base[$column_name];
	                unset($columns_base[$column_name]);
	            } else if(
	                isset($model->contain_map[$column_name]) && 
	                isset($model->contain_map[$column_name]['index']['show'])
	            ) 
	            {
		            $resort_columns_base[$column_name] = $model->contain_map[$column_name];
	            }
            }
            $columns_base = array_merge($resort_columns_base, $columns_base);
   

            // Добавляем к полям из базы поля которые соотносятся Многие ко Многим (данные берем из модели)
/*
            foreach($model->contain_map as $param_name => $virtual_field) {
	            if(isset($virtual_field['assoc_type']) && $virtual_field['assoc_type'] == 'belongsToMany') $columns_base[$param_name] = $virtual_field;
	        } 
*/   
            		    
		   
            $cells = [];
            foreach($columns_base as $field  => &$attrs) :
		
		
                if(!empty($attrs['comment']) || isset($model->contain_map[$field]['index']['show']) || isset($model->contain_map[$field]['filter']['show'])) { 
                    
                    $cells[$field] = [];
               // debug($model->contain_map[$field]);
                    // Приссваиваем все свойства из модели
                    if(isset($model->contain_map[$field]) && is_array($model->contain_map[$field])) { 
	                    $cells[$field] = $model->contain_map[$field];
	             
				        if(isset($cells[$field]['leftJoin'])) {
				            if((is_string($cells[$field]['leftJoin']))) {
					            $cells[$field]['filter']['modelAlias'] = $cells[$field]['leftJoin'];
					        }
				            elseif(is_array($cells[$field]['leftJoin'])) { 
					            $cells[$field]['filter']['modelAlias'] = array_key_first($cells[$field]['leftJoin']);
					        }
					    }
					   
					    if(isset($cells[$field]['filter']['modelAlias']) && !isset($cells[$field]['filter']['modelName'])) {

						    $cells[$field]['filter']['modelName'] = $this->mainModel->getAssociation($cells[$field]['filter']['modelAlias'])->className();
					   
					    }
					    

	                }
                    
                    
                    if(!isset($cells[$field]['filter']['hide'])) $cells[$field]['filter']['hide'] = 0;
                    if(!isset($cells[$field]['filter']['default_value'])) $cells[$field]['filter']['default_value'] = '';                    
                    if(!isset($cells[$field]['filter']['show'])) $cells[$field]['filter']['show'] = 0;

                    if(!isset($cells[$field]['index']['show'])) $cells[$field]['index']['show'] = 1;
                    $cells[$field]['view']['show'] = 1;
                    
                    $cells[$field]['db_params']['type'] = isset($attrs['type']) ? $attrs['type'] : '';
                    $cells[$field]['db_params']['length'] = isset($attrs['length']) ? $attrs['length'] : '';
             
                    $cells[$field]['db_params']['comment'] = (isset($cells[$field]['db_params']['comment'])) ? $cells[$field]['db_params']['comment'] : $attrs['comment'];
                    $cells[$field]['db_params']['name'] = $field; 
                    
                    $cells[$field]['index']['propertyName'] = (isset($model->contain_map[$field]['propertyName'])) ? $model->contain_map[$field]['propertyName'] : '';               

/*
                    if(mb_strripos($field, '_id')) {	               
		    			
	                    $cells[$field]['filter']['operator'] = 'IN';
	                    //$cells[$field] = 'tags';
                        $cells[$field]['filter']['output_type'] = 'tags';
                        $cells[$field]['index']['output_type'] = 'tags';
                        $cells[$field]['view']['output_type'] = 'tags';
		    
		    			if(isset($model->contain_map[$field]) && isset($model->contain_map[$field]['model'])) {
		    				
                            $className = (!isset($model->contain_map[$field]['plugin'])) 
                            ? 'App.'.$model->contain_map[$field]['model'] : $model->contain_map[$field]['plugin'].'.'.$model->contain_map[$field]['model'];
                            
	                
	                        $cells[$field] += $model->contain_map[$field];
	                    }
	                    
                    } elseif(mb_strripos($field, 'ate')) {
	                    $cells[$field]['filter']['operator'] = '=';
	                //    $cells[$field] = 'date';	                
                        $cells[$field]['filter']['output_type'] = 'date';
                        $cells[$field]['index']['output_type'] = 'date';
                        $cells[$field]['view']['output_type'] = 'date';
		    
                    } else {
	                    $cells[$field]['filter']['operator'] = 'LIKE';
	                   // $cells[$field] = 'text';
                        $cells[$field]['filter']['output_type'] = 'text';
                        $cells[$field]['index']['output_type'] = 'text';
                        $cells[$field]['view']['output_type'] = 'text';
                    }
*/
                    
                    if(isset($model->contain_map[$field]['model']) || isset($model->contain_map[$field]['className'])) {
                    	$cells[$field]['className'] = (isset($model->contain_map[$field]['className'])) ? $model->contain_map[$field]['className'] : $model->contain_map[$field]['model'];
                    } else {
	                    $cells[$field]['className'] = $className;
                    }
                    	
                    //$cells[$field]['filter']['assoc_type'] = isset($model->contain_map[$field]['assoc_type']) ? $model->contain_map[$field]['assoc_type'] : '';		    		
                    if(!isset($cells[$field]['filter']['operator_logical'])) $cells[$field]['filter']['operator_logical'] = 'AND';
                 
                    if(!isset($cells[$field]['index']['width'])) $cells[$field]['index']['width'] = '150px';
                    
                 
                }
                        
            endforeach;
            return $cells; 
        
        } else {
	        echo 'Не найдены таблицы для -- '.$model->getTable()."<br>";
        }
        
           
    }
 
   


    /**
	 * Sortable rows in edit basemap record  
     */
    public function resortFields()
    {
	    $this->render(false);
	    
	   	$ns = (empty($this->ns)) ? $this->setNamespace($this->request->getData('className')) : $this->ns;	   		            
        $table = $this->loadModel($ns['className']);
        $record = $table->get($this->request->getData('record_id'));

        //$basemap = $this->getBaseOptions($this->request->getData('model'));
        
        $column = ($this->request->getData('column')) ? $this->request->getData('column') :  'data_s';
           
        $data_s = unserialize($record[$column]);

        $path = explode('-', $this->request->getData('path')); 

        foreach($path as $key) {
	        if(!isset($link)) {
	            $link = &$data_s[$key];
	        } else {
		        $link = &$link[$key];
	        }
        }

        $resort_array = [];
        $i = 0;
        $key_name = $this->request->getData('key');
        $delta = $this->request->getData('position_start') - $this->request->getData('position_end'); 
        
        foreach($link as $field => $values ) {

            if($delta >= 0) {
	            if($i == $this->request->getData('position_end')) {
		       	    $resort_array[$key_name] = $link[$key_name];
	            }
	        }
	        
	        if($key_name != $field) {
	            $resort_array[$field] = $values;
	        } 

            if($delta < 0) { 
	            if($i == $this->request->getData('position_end')) {
		       	    $resort_array[$key_name] = $link[$key_name];
	            }
	        }
	    
	    $i++;    
        } 
        $link =  $resort_array;
      
        $record[$column] = serialize($data_s);
        $table->save($record);
    }


}