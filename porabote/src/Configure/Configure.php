<?php
namespace Porabote\Configure;	

//use Porabote\Configure\Configure;
/**
* 
*/
class Configure {//extends  {

    public static $configs = [];

    private function __construct()
    {
	    self::$configs = include('../../app.php');
    }

    public static function get()
    {
	    self::$configs = include('../porabote/config/app.php');
	    echo 'привет';
	    print_r(self::$configs);
	    //Configure::get('Datasources.default');
    }	

}
