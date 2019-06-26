<?php
namespace Porabote\ORM;	

use Porabote\Datasources\ConnectionManager;
/**
* 
*/
class TableRegistry {//extends  {

    public static function get()
    {
	    echo 'регистрируем таблицу';
	    ConnectionManager::connect();
    }	

}
