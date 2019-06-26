<?php
namespace Porabote\Datasources;	

use Porabote\Configure\Configure;
/**
* 
*/
class ConnectionManager {//extends  {

    public static function connect()
    {
	    echo 'подключаемся к базе';
	    Configure::get('Datasources.default');
    }	

}
