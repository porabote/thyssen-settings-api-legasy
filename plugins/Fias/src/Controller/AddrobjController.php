<?php
namespace Fias\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class AddrobjController extends AppController
{

    public function upload()
    {

        ini_set("upload_max_filesize","350");
        ini_set("post_max_size","400");
        ini_set("memory_limit","1956M");
        ini_set("max_execution_time","1000");


        $path = FDR.'fias/ADDR/';
        $i = 0;

        $files_list = scandir(FDR.'fias/ADDR/');
        foreach($files_list as $file_name){
	        if($file_name != '.' && $file_name != '..' ){ 
		        
		        $file_name_number = preg_replace("/[^0-9]/", '', $file_name);
		        
		        if($file_name_number > 0 && $file_name_number <= 0) {
		            $i += $this->getDBFData($path.$file_name);
		            debug($i);
		        }  
		        
		        
		    }   
        }
        echo 'конец '. $i;

    }
    
    function getDBFData($file_path)
    {
        $db = \dbase_open($file_path, 0);
     
        $db_header = dbase_get_header_info($db);
        $record_numbers = dbase_numrecords($db);
        $fields_numbers = dbase_numfields($db);
      
       // if($record_numbers > 10) $record_numbers = 3;

        for ($i = 1; $i <= $record_numbers; $i++) {
            $row = dbase_get_record_with_names($db, $i);
           
            if(!$row['ACTSTATUS']) continue;

            foreach($row as  &$val){
     	        $val = mb_convert_encoding($val,'utf-8','CP866');
     	        $val = str_replace('\'', '\'\'', trim($val));
            }
            $row['ENDDATE'] = date("Y-m-d", strtotime($row['ENDDATE']));
            $row['STARTDATE'] = date("Y-m-d", strtotime($row['STARTDATE']));
            $row['UPDATEDATE'] = date("Y-m-d", strtotime($row['UPDATEDATE']));
           // debug($row);
            $this->Addrobj->save($this->Addrobj->newEntity($row));
     
        }
        
        return $i;	    
    }
    

    function getParentBranch($name = 'москва')
    {
	    $this->render(false);
	    parse_str($this->request->getData('data'), $data);
	    if(isset($data['searshString'])) $name = $data['searshString'];

        $connectionCreator = ConnectionManager::get('api_fias'); 
	    
	    $query = '
            with recursive cte (AOGUID, OFFNAME, SHORTNAME, PARENTGUID, AOLEVEL, POSTALCODE, id) as (
              select     AOGUID,
                         OFFNAME,
                         SHORTNAME,
                         PARENTGUID,
                         AOLEVEL,
                         POSTALCODE,
                         id
              from       regions_cities
              where      FORMALNAME = \'санкт%\'
              union all
              select     rc.AOGUID,
                         rc.OFFNAME,
                         rc.SHORTNAME,
                         rc.PARENTGUID,
                         rc.AOLEVEL,
                         rc.POSTALCODE,
                         rc.id
              from       regions_cities rc              
              inner join cte
                      on rc.AOGUID = cte.PARENTGUID
            )
            select * from cte order by id ASC;	    
	    ';
	    
	    $result = $connectionCreator->query($query)->fetchAll('assoc');
	    //$result = array_reverse($result);
	    //debug($result);
	    $address = '';
	  // debug($result); 
	    if(isset($result[0])) { 
		    $recordBefore = $result[0];
		    $recordBefore['AOGUID'] = $recordBefore['PARENTGUID'];//debug($result);
		}
		    
	    foreach($result as $key => $part) {

            $break = ($part['PARENTGUID'] == $recordBefore['AOGUID']) ? '' : '|';

		    $address .=  $break . $part['SHORTNAME'] . ' ' . $part['OFFNAME'] . 
		        (($part['PARENTGUID'] == $recordBefore['AOGUID'] || $break) ? ', ' : '' );   
		    
		    
		    $recordBefore = $part;
	    }
	    if($address) {
		    $address = explode('|', $address);
		    $this->__outputJSON(['Addresses' => $address]); 
	    }
	    
    }

    function fillRegionsDb()
    {

        ini_set("memory_limit","1956M");
        ini_set("max_execution_time","1000");

	    $id = 0;
	    $regObj = TableRegistry::get('Fias.RegionsCities');
	    
/*
	    do {
		    
	        $regions = $this->Addrobj->find()
	            ->where(['AOLEVEL IN' => ['1', '3', '4', '6'], 'id >' => $id])
	            ->limit(1000)
	            ->order('id ASC')
	            ->toArray();
	            //->count();
		    if($regions) {
	            foreach($regions as $region) {
	                $regObj->save($regObj->newEntity($region->toArray()));
	                $id = $region['id'];
	            }
	        } else {//debug($id);
		        $id = 0;
	        }
		    debug($id);
	        
	    } while (
		    $id > 0
	    );
*/

	    
	    $this->render(false);
    }



/*
	
	1 Регионы
	2
	3 Районы, АО, поселения
	4 Города, села, поселки
    5 Район, территория
    6 Село, поселок, территория, станция
    7 Улица, проезд, проспект, переулок, тупик, шоссе


Условно выделены следующие уровни адресных объектов:
1 – уровень региона
2 – уровень автономного округа (устаревшее)
3 – уровень района
35 – уровень городских и сельских поселений
4 – уровень города
5 – уровень внутригородской территории (устаревшее)
6 – уровень населенного пункта
65 – планировочная структура
7 – уровень улицы
75 – земельный участок
8 – здания, сооружения, объекта незавершенного строительства
9 – уровень помещения в пределах здания, сооружения




	
	
    Субъект федерации
    Регион субъекта федерации
    Населенный пункт
    Улица
    Дом




    AOGUID — ID улицы в ADDROBXX, в которой находится дом.
    HOUSEGUID — ID дома.
    Сложность заключается в наименовании дома. Оно состоит из 4 полей:
    BUILDNUM — номер корпуса.
    HOUSENUM — номер дома.
    STRUCNUM — номер строения.
    STRSTATUS — признак строения (от 0 до 4, где 0 — никакого, 1 — строение, 2 — сооружение, 3 — литера).


*/


    

}