<?php
namespace App\Interfaces;

interface ApiInterface
{
    /*
	 *    
	 * return JSON list   
     */
    public function list();

    public function get();
    
    public function add();

    public function delete($type = null);
    	
}