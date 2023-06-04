<?php
namespace App\Traits;	

use Cake\ORM\TableRegistry;

# Загрузка методов класса по URL-у
trait ApiTrait
{   

	// Авторизация Api пользователя
	private function apiAuth()
	{
        parse_str($this->request->getData('auth'), $auth_request);
        parse_str($this->request->getData('data'), $data);

       // if(!$this->request->getData('data')) $this->__outputJSON(['error' => 'Нет данных для записи']);

        // Находим пользователя и сравниваем хэш
        $user = TableRegistry::get('Docs.ApiUsers')->find()->where(['api_key_public' => $auth_request['api_key_public']])->first();
        if($user){
	        $token = md5(json_encode($data, JSON_UNESCAPED_UNICODE).$user['api_key_private']);
	        if($token == $auth_request['token']) return true;
	        else $this->__outputJSON(['error' => 'Неверный ключ']);
        } else {
	        $this->__outputJSON(['error' => 'Пользователь не найден']);
        }

/*
		if ( $data = json_decode(file_get_contents('php://input')) ){}
*/

	}

	
    public function apiList()
    {
	    $this->render(false);
	    $modelName = $this->name;
	    $this->outputJSON( $this->$modelName->find()->toArray() );
    }

    public function apiGet()
    {   
	    parse_str($this->request->getData('data'), $data);
	    
	    $this->render(false);
	    
	    //if(!$data['field_name'] || !$data['field_value']) return null;
        $data['field_name'] = $_GET['field_name'];
        $data['field_value']= $_GET['field_value'];
	    	    
	    $modelName = $this->name;

	    if($model = $this->$modelName->exists([ $data['field_name'] => $data['field_value'] ])) {
		    
		    $this->outputJSON( $this->$modelName->find()->where([$data['field_name'] => $data['field_value']])->first()->toArray() );
		    
	    } else {
		    $this->outputJSON( ['errors' => 'Запись не найдена'] );
	    }
	    
	    $this->render(false);
	    
    }

    /*
	 * Set response as JSON   
     */ 
    public function outputJSON($data, $error = NULL) {
	    header('Content-Type: application/json; charset=UTF-8');
    
	    if(!$error) { 
		    $response = $data;
            die(json_encode( $response, JSON_NUMERIC_CHECK ));
        } else { 
	        $response['error'] = $error;
            die(json_encode( $response, JSON_NUMERIC_CHECK ));	        
        }
    }
    
}
?>