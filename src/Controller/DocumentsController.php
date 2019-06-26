<?php
namespace Docs\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class DocumentsController extends AppController
{

    public $contract = [];
    public $document = [];

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Tree');           
    }


    
    function setContract($id)
    {
	    $this->contract = TableRegistry::get('Docs.Contracts')->get($id)->toArray();
	    $this->contract['cache_data'] = unserialize($this->contract['cache_data']);
	    $this->contract['cache_html'] = unserialize($this->contract['cache_html']);
	    return $this;
    }	

    function setDocument($where = [], $request = [])
    {
	    $where['contract_id'] = $this->contract['id'];
	    $this->document = TableRegistry::get('Docs.ContractExtantions')->find()->where($where)->toArray();
	    if($this->document) $this->document = array_shift($this->document)->toArray();

	    // Создаем новый или перезаписываем с новыми данными
	    $this->__setDocument($where, $request, $this->document);
	    
	    return $this;
    }	

    public function __setDocument($where, $requestData = [], $ext = [])
    {
	    
        $set = TableRegistry::get('ContractSets')->get($where['set_id'])->toArray();

        // Находим запись приложения
        $primaryDoc = TableRegistry::get('Api.PrimaryDocumentsKinds')->get($where['kind_id'])->toArray();
        // Находим шаблон для приложения
        $primaryPattern = TableRegistry::get('Docs.PrimaryDocumentsPatterns')->get($primaryDoc['pattern_default'])->toArray();
       
        $entity = ($ext) ? $ext : $where;
       
        if($requestData['date']) $requestData['date'] = $this->__setFormat('date', 'date', [], $requestData['date']);
      
	    $entity = array_merge($entity, $where, $requestData);
	    
        $entity['alias'] = $primaryDoc['alias'];
        $entity['name'] = $primaryDoc['name'];
        $entity['pattern_id'] = $primaryDoc['pattern_default'];
        
        $contract = $this->contract['cache_data'];
        $set['data_s'] = unserialize($set['data_s']);

        if(!isset($entity['cache_data']) || !$entity['cache_data'])$entity['cache_data'] = $this->contract['cache_data'];
        
        $entity['cache_data'] = compact('set', 'contract', 'primaryDoc', 'primaryPattern', 'requestData');
        $entity['cache_html'] = $this->__setHtml($entity, $entity['cache_data']);
        $entity['cache_data'] = serialize($entity['cache_data']);
        
        $entity['orientation'] = $primaryPattern['orientation'];
        $entity = TableRegistry::get('Docs.ContractExtantions')->save(TableRegistry::get('Docs.ContractExtantions')->newEntity($entity));
 
        $this->document = $entity->toArray();
        
        return $this;

    }

    /*
	 * Генерация или обновление печатей и подписей к документу   
     */
    public function setSignatures($option = [])
    {

        $peoplesObj = new \App\Controller\PeoplesController();
        $contractorsObj = new \App\Controller\ContractorsController();
      
        $left_position = '100';
        $top_position = '100';
        
        $this->document['cache_data'] = unserialize($this->document['cache_data']);
        
        foreach($this->document['cache_data']['contract']['contractors'] as $role_alias => &$contractors_list) {
	        foreach($contractors_list as $key_contractor => &$contractor) {

		        // Находим образцы печатей и клонируем
		        $stamp = $contractorsObj->getStamp($contractor['data']['id'], 'random');
		        $contractor['stamp'] = $this->__cloneStamp($stamp, [
			        'dst_name' => 'contract_extantions/'.$this->contract['id'].'/'.$this->document['alias']. '/' .$this->document['id'].'/' .$role_alias. '/' .$contractor['data']['id']. '/stamp.png'
		        ]);
		        $contractor['stamp']['position']['left'] = $left_position;
		        $contractor['stamp']['position']['top'] = $top_position - 50;
		        
		        // Находим подписи ответственных лиц
		        $facsimile = $peoplesObj->getFacsimiles($contractor['sign_persons']['gd']['people_id'], 'random');
		        $contractor['sign_persons']['gd']['facsimile'] = $this->__cloneFacsimile($facsimile, [
			        'dst_name' => 'contract_extantions/'.$this->contract['id'].'/'.$this->document['alias']. '/' .$this->document['id']. '/' .$role_alias. '/' .$contractor['data']['id']. '/gd_facsimile.png',
			        'label' => 'gd_facsimile'
		        ]);		        
		        $contractor['sign_persons']['gd']['facsimile']['position']['left'] = $left_position;
		        $contractor['sign_persons']['gd']['facsimile']['position']['top'] = $top_position;
		        
		      
		        //if( $contractor['model'] == 'Companies' || $contractor['model'] == 'Entrepreneurs' ) {
		            //$contractor = TableRegistry::get($contractor['model'])->get($contractor['id'], [ 'contain' => [] ]);//debug($contractor);
		        //}
		      
	            $left_position += 300;
 
	        }
	        
        }
        
        $this->document['cache_data'] = serialize($this->document['cache_data']);
        
        $contractExtantionsObj = TableRegistry::get('Docs.ContractExtantions');
        $contractExtantionsObj->save($contractExtantionsObj->newEntity($this->document));
       
    } 
   



    function __cloneStamp($src_img = [], $options = []) {
	    
	    if(!$src_img || !file_exists($src_img['path'])) return null;

        $dst_img_path = $this->request->getSession()->read('Configs.base_folder').$options['dst_name'];
        
        $imagesComponent = new \App\Controller\FilesController();
        $stamp = $imagesComponent->upload([	        
			'request_data' => [
			    'srcPath' => $src_img['path'],
			    'targetPath' => $dst_img_path,
			    'responseFormat' => 'array',
			    'label' => 'stamp_clone',
			    'file_info' => [
				    'module_alias' => 'Contracts',
				    'plugin' => 'Docs',
				    'record_id' => 99,
				    'label' => 'stamp_clone',
				    'request_data' => [ 'convertType' => 'image/png' ]
			    ]
			    
			]
        ]);
        if(!$stamp) return null;

        //создаем градиентную заливку        
        $gradient_path = pathinfo($stamp['path'])['dirname'].'/gradient.png';
        exec('convert \
            -size '.rand(230, 300).'x'.rand(230, 300).' \
            gradient:"rgba(255,255,255,0.05)"-"rgba(255,255,255,0.05)" \
            -distort SRT '.rand(0, 360).' '.$gradient_path.'');
        //'.rand(32, 32).'.'.rand(22, 45).'
        //уменьшаем печать и делаем разворот                
        exec('convert '.$stamp['path'].' \
            -resize 144 \
            -background none  \
            -rotate '.rand('-90','90').'  \
            -quality 10 '.$stamp['path']);

        // Crop
        exec('convert '.$stamp['path'].' -shave 0x0 -repage 146x146+10+10 '.$stamp['path']);
        exec('convert '.$stamp['path'].' -gravity center  -crop 146x146+10+10 '.$stamp['path']);

        
        list($stamp_w, $stamp_h) = getimagesize($stamp['path']);
        exec('convert '.$stamp['path'].' -background white -extent '.$stamp_w.'X'.$stamp_h.' -gravity center '.$stamp['path']);

       //накладываем градиент на изображение 
       if($gradient_path) exec('convert '.$stamp['path'].'   '.$gradient_path.'   -composite  '.$stamp['path'].'');       
           
        exec('convert '.$stamp['path'].' -unsharp 1.5×1.0+1.5+0.02 '.$stamp['path']);
        exec('convert '.$stamp['path'].' -unsharp 1.5×1.0+1.5+0.02 '.$stamp['path']);

     
        //убираем белый фон
        //$img_thread = 'convert '.$stamp_new.' -level 39%,99% -transparent white '.$stamp_new.'';
        $img_thread = 'convert '.$stamp['path'].' -level 5%,95% -transparent white '.$stamp['path'].'';
        exec($img_thread); 

	    return $stamp;
	    
    }

    function __cloneFacsimile($src_img = [], $options = []) {

	    if(!$src_img || !file_exists($src_img['path'])) return null;

        $dst_img_path = $this->request->getSession()->read('Configs.base_folder').$options['dst_name'];
        
        $imagesComponent = new \App\Controller\FilesController();
        $facsimile = $imagesComponent->upload([	        
			'request_data' => [
			    'srcPath' => $src_img['path'],
			    'targetPath' => $dst_img_path,
			    'responseFormat' => 'array',
			    'label' => 'stamp_clone',
			    'file_info' => [
				    'module_alias' => 'Contracts',
				    'plugin' => 'Docs',
				    'record_id' => 99,
				    'label' => $options['label'],
				    'request_data' => [ 'convertType' => 'image/png' ]
			    ]
			    
			]
        ]);
        if(!$facsimile) return null;
        
        
        exec('convert '.$facsimile['path'].' -unsharp 1.5×1.0+1.5+0.02   '.$facsimile['path']);

        list($facsimile_w, $facsimile_h) = getimagesize($facsimile['path']);        
        if($facsimile_h >180) {
	     exec('convert '.$facsimile['path'].' -resize 114 -background none   -quality 190 '.$facsimile['path']);   
        }
        
        chmod($facsimile['path'], 0777);

        //debug($facsimile);
        return $facsimile;	    
	
	} 

    /*
	 * Create sign area in Image format (for PDF SCANCOPY)   
     */
	public function __signAreaToImg($document, $path, $stamps = true) 
	{
		$this->viewBuilder()->setLayout('min');

        $html = unserialize($document['cache_html']);
        $cache_data = unserialize($document['cache_data']);
        $cache_data['output_format'] = 'ImagePdf';	 

        
        $pattern = (isset($cache_data['primaryPattern']['template_sign_area'])) ? $cache_data['primaryPattern']['template_sign_area'] : $cache_data['pattern']['details'].$cache_data['pattern']['sign_area'];
        
        // если нужен чистый бланк без печатей и подписей
        if(!$stamps) $cache_data['output_format'] = 'ImagePdfWithoutStamps';
        
        $html_area = $this->__fillingPattern($pattern, $cache_data); 

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8', 
            'format' => 'A4',
            'dpi' => '96',
            'shrink_tables_to_fit' => 1,
            'keep_table_proportions' => false,
           // 'ignore_table_widths' => true,
            //'aliasNbPg' => '{nb}',
            'dpi' => 96
        ]);
        //$mpdf->SetDisplayMode('real');
        $mpdf->AliasNbPages('[pagetotal]');
       
        $mpdf->AddPage($document['orientation'],'','','','',0,0,0,0,0,0);
        
        $html_area = str_replace('{nb}', $mpdf->page, $html_area);
        $mpdf->WriteHTML($html_area);        

        $this->__checkDirectory($path);
        $mpdf->Output($path . '/scan_img.pdf', \Mpdf\Output\Destination::FILE);
      
        $page_height = round($mpdf->h * $mpdf->dpi / 25.4);
        
        //Определяем размер вырезаемого изображения
        $height = $mpdf->y * $mpdf->dpi / 25.4; // нижнюю границу на листе умножаем на дюймы и делим на количество мм в дюймах
        $height = round($height);
        
        $width = ($mpdf->w * 96) / 25.4;
        $width = round($width);
       
        // создаем изображения из страниц PDF файла
        exec('convert \
            -density 400 \
            -colorspace CMYK \
            ' .$path. '/scan_img.pdf[0] \
            -scale '.$width.'x'.$page_height.' \
            -quality 95  \
            '. $path  .'/sign_area.jpg', $out, $error);
        exec('convert -crop '.$width.'x'.$height.'+0+0 '. $path  .'/sign_area.jpg '. $path  .'/sign_area.jpg' , $out, $error);//debug($out);debug($error);
        
        $out['path'] = $path  .'/sign_area.jpg';
        $out['uri'] = str_replace(USERFILES_PATH, '/userfiles/files/', $out['path']);

        return $out;

        /*
        $unusedSpaceH = $mpdf->h - $mpdf->y - $mpdf->bMargin; 
        debug($mpdf->y);
        debug($mpdf->h);
        $unusedSpaceW = $mpdf->w - $mpdf->lMargin - $mpdf->rMargin;
        $mpdf->Rect($mpdf->x, $mpdf->y, $unusedSpaceW, $unusedSpaceH);       
        debug($mpdf->Rect($mpdf->x, $mpdf->y, $unusedSpaceW, $unusedSpaceH)); 
        */
    }     



    /*
	 * Create sign area in Image format (from PDF SCANCOPY)   
     */
/*
	public function __signAreaToImg($document, $path) 
	{
		$this->viewBuilder()->setLayout('min');

        $html = unserialize($document['cache_html']);
        $cache_data = unserialize($document['cache_data']);
        $cache_data['output_format'] = 'ImagePdf';	 
//debug($cache_data['primaryPattern']);
        $html_area = $this->__fillingPattern($cache_data['primaryPattern']['template_sign_area'], $cache_data); 

        $mpdf = new \Mpdf\Mpdf(['','', 0, '', 0, 0, 0, 0, 9, 9, $document['orientation']]); 
        
        $mpdf->AddPage($document['orientation'],'','','','',0,0,0,0,0,0);
        $mpdf->WriteHTML($html_area);

        $this->__checkDirectory($path);
        $mpdf->Output($path . '/scan_img.pdf', \Mpdf\Output\Destination::FILE);

        // создаем изображения из страниц PDF файла
        exec('convert \
            -density 400 \
            -colorspace CMYK \
            ' .$path. '/scan_img.pdf[0] \
            -scale 1123x1200 \
            -quality 95  \
            '. $path  .'/sign_area.png', $out, $error);
        exec('convert -crop 1123x250+0+0 '. $path  .'/sign_area.png '. $path  .'/sign_area.png' , $out, $error);//debug($out);debug($error);
        return $path  .'/sign_area.png';


    } 
*/



    public function __setHtml($entity, $data)
    {
        $document['cache_html'] = [];
	    
	    $document['cache_html']['head'] = $this->__fillingPattern($data['primaryPattern']['template_head'], $data);

	    $document['cache_html']['body_html'] = $this->__fillingPattern($data['primaryPattern']['template_body'], $data);
	    $document['cache_html']['nomenclatures_html'] = $this->__fillingPattern($data['primaryPattern']['template_nomenclatures'], $data);
	    $document['cache_html']['details'] = $this->__fillingPattern($data['primaryPattern']['template_details'], $data); 

	    $document['cache_html']['sign_area'] = $this->__fillingPattern($data['primaryPattern']['template_sign_area'], $data);
//debug($document['cache_html']['sign_area']);	    
	    $document['cache_html'] = serialize($document['cache_html']);

	    return $document['cache_html'];   
	}      

    function __setBody($data)
    {
	    $paragraphs = ($data['pattern']['parts_tree']) ? $data['pattern']['parts_tree'] : [];
	    foreach($paragraphs as &$paragraph) {
		    $paragraph['text'] = $this->__fillingPattern($paragraph['text'], $data);
		}
		$contract = $this->Tree->__setNumbered($paragraphs, 'linear');
	    
	    return $contract;
    }
    
    /*
	 * Заполнение бланков данными   
     */
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


/*
    function fillBlank($data)
    {
	    $blank = $data['primaryPattern'];

        $loader = new \Twig_Loader_Array( [
            'primary_pattern' => $blank['template_head'].$blank['template_body'].$blank['template_nomenclatures'].$blank['template_details'].$blank['template_sign_area'],
        ]);
        $twig = new \Twig_Environment($loader);
        
        return $twig->render('primary_pattern', $data);
    }
*/

    /*
	 * Форматирование даты и суммы   
     */
    function __setFormat($alias, $type, $options = [], $data = null)
    {
	    $data = (!$data) ? $this->request->getData($alias) : $data;
	    
	    switch($type) {
		    case 'summa' : 		         
		        return str_replace(',', '.', sprintf("%.2f", preg_replace('/([^\d\.]+)/', '', str_replace(',', '.', $data))));
		        break;
		    case 'date' :
	            $date = strtotime(str_replace(['/', '.'], '-', $data));
	            if($date) $date = new Time(date("Y-m-d", $date));		        
		        return $date;	        
			    break;
	    }
    }


}