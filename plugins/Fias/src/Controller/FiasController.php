<?php
namespace Fias\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class FiasController extends AppController
{

    public function upload()
    {

        ini_set("upload_max_filesize","350");
        ini_set("post_max_size","400");
        ini_set("memory_limit","1956M");

        $bnkseekObj = TableRegistry::get('Bnkseek');

        if(!$this->request->getData()){

            $filePath = FDR.'fias/ADDR/ADDROB01.DBF';
            
            $file_Out_name = explode('.',$this->request->getData('file')['name']);
            $table_name = strtolower($file_Out_name[0]);
            
            $fileOut = USERFILES_PATH.$this->request->getData('dir').'/'.$table_name;
     

            $filename = $filePath;//$this->request->getData('file.tmp_name');
     
            $db = \dbase_open($filename, 0);
     
            $db_header = dbase_get_header_info($db);
            $record_numbers = dbase_numrecords($db);
            $fields_numbers = dbase_numfields($db);

debug($record_numbers);

//$socrbaseObj = TableRegistry::get('Fias.Socrbase');
//$socrbaseObj->find();

//if($record_numbers > 10) $record_numbers = 1000;
//$record_numbers
            for ($i = 1; $i <= $record_numbers; $i++) {
                $row = dbase_get_record_with_names($db, $i);

                foreach($row as  &$val){
     	            $val = mb_convert_encoding($val,'utf-8','CP866');
     	            $val = str_replace('\'', '\'\'', trim($val));
                }
debug($row);
/*                
                // conflict field name with mysql
                if(isset($row['REAL'])) {
                    $row['_REAL'] = $row['REAL'];
                    unset($row['REAL']);
                }
                
               if(isset($row['DT_IZM'])) $row['DT_IZM'] = $this->setFormat('DT_IZM', 'date', null, $row['DT_IZM']);
               if(isset($row['DT_IZMR'])) $row['DT_IZMR'] = $this->setFormat('DT_IZMR', 'date', null, $row['DT_IZMR']);  
               if(isset($row['DATE_CH'])) $row['DATE_CH'] = $this->setFormat('DATE_CH', 'date', null, $row['DATE_CH']);
               if(isset($row['DATE_IN'])) $row['DATE_IN'] = $this->setFormat('DATE_IN', 'date', null, $row['DATE_IN']);
               
               $row['deleted'] = 1;

               $entity = $bnkseekObj->newEntity($row);

               
               $bnkseekObj->save($entity);
*/
     
            }
     
        }   

    }

}