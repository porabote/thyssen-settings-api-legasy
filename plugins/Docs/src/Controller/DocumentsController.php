<?php
namespace Docs\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use App\Traits\ApiTrait;

class DocumentsController extends AppController
{
    use ApiTrait;

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Tree');
        $this->loadComponent('Words');
    }


    // Generate document text
    function setHtml()
    {

        $this->apiAuth();
	    
        $this->render(false);

        parse_str($_POST['data'], $requestData);

	    if ($requestData) {
		    

            $cache_data = unserialize($requestData['document']['cache_data']);
            $cache_html = [];
	    
	        $cache_html['head'] = $this->__fillingPattern($cache_data['pattern']['head'], $cache_data);
		        
	        $cache_html = array_merge($cache_html, $this->__setBody($cache_data));
	       
	        $cache_html['details'] = $this->__fillingPattern($cache_data['pattern']['details'], $cache_data);

	        $cache_html['sign_area'] = $this->__fillingPattern($cache_data['pattern']['sign_area'], $cache_data);
	        
	        
	        parse_str($this->request->getData('auth'), $auth_request);
	        TableRegistry::get('RequestLogs')->save(TableRegistry::get('RequestLogs')->newEntity([
		        'system_alias' => $auth_request['api_key_public'],
		        'record_id' => $requestData['document']['id'],
		        'class_name' => 'Contracts'
	        ]));

		    $this->__outputJSON($cache_html);	    
	    }

    }    

    function __setBody($data)
    {
	    $paragraphs = ($data['pattern']['parts_tree']) ? $data['pattern']['parts_tree'] : [];
	    foreach($paragraphs as &$paragraph) {//debug($paragraph['text']);
		    $paragraph['text'] = $this->__fillingPattern(htmlspecialchars_decode($paragraph['text'], ENT_QUOTES), $data);
		}
		$contract = $this->Tree->__setNumbered($paragraphs, 'linear');
	    
	    return $contract;
    }

    function __fillingPattern($pattern, &$data)
    {
        if($pattern) {
            $loader = new \Twig_Loader_Array( [
                'part_alias' => $pattern,
            ]);
            $twig = new \Twig_Environment($loader);        
            $twig->addExtension(new \Twig_Extensions_Extension_Intl());        
            $twig->getExtension('Twig_Extension_Core')->setTimezone('Europe/Moscow');
            
            return $twig->render('part_alias', $data);
        }
        
        return null;
    }


}