<?php
namespace Fias\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class SocrbaseController extends AppController
{

    public function upload()
    {

        ini_set("upload_max_filesize","350");
        ini_set("post_max_size","400");
        ini_set("memory_limit","1956M");

        $bnkseekObj = TableRegistry::get('Bnkseek');

        if(!$this->request->getData()){

            $filePath = FDR.'fias/SOCRBASE.DBF';
            
            $file_Out_name = explode('.',$this->request->getData('file')['name']);
            $table_name = strtolower($file_Out_name[0]);
            
            $fileOut = USERFILES_PATH.$this->request->getData('dir').'/'.$table_name;
     

            $filename = $filePath;//$this->request->getData('file.tmp_name');
     
            $db = \dbase_open($filename, 0);
     
            $db_header = dbase_get_header_info($db);
            $record_numbers = dbase_numrecords($db);
            $fields_numbers = dbase_numfields($db);

            for ($i = 1; $i <= $record_numbers; $i++) {
                $row = dbase_get_record_with_names($db, $i);

                foreach($row as  &$val){
     	            $val = mb_convert_encoding($val,'utf-8','CP866');
     	            $val = str_replace('\'', '\'\'', trim($val));
                }
                //$this->Socrbase->save($this->Socrbase->newEntity($row));

     
            }
     
        }   

    }

}