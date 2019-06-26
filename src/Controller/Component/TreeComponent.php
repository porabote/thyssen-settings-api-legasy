<?php
namespace App\Controller\Component;

use Cake\Controller\Component;


class TreeComponent extends Component
{

    public $newList = []; 
    public $linearData = [];
    public $outData = '';
    public $dataOriginal = [];

    /*
	 ** create nested list from linear array   
    */
    function buildTree(array $elements) 
    {
        $branch = array();
        $lastParentId = null;
        $parentArray = array();

        foreach ($elements as $key => $element) {
  
            $delta = $element['rght'] - $element['lft'];
        
            if($element['parent_id'] == null) {
            
                
	            $branch[$key] = $element;
	            
                if($delta > 1) {
                    $branch[$key]['children'] = array();
	                $link = &$branch[$key]['children'];
	                $lastParentId = $element['id'];
	            }
            } else {
                
                if($element['parent_id'] == $lastParentId) {
	                
                    if($delta > 1) {
                        $lastParentId = $element['id'];
                        
                        $link[$key] = $element;
                        $link[$key]['children'] = array();
	                    $link = &$link[$key]['children'];
	                } else {
		                $link[$key] = $element;
	                    $link = &$link;
	                }
	                
	            } else if($element['parent_id'] != $lastParentId) { 

	                foreach($parentArray as $level => $val) {	            
		                if($level == 1) { 
		                    $link = &$branch[$val['lft']]['children'];
		                } else {
			                $link = &$link[$val['lft']]['children'];    
		                }
		                
		                if($element['parent_id'] == $val['id']) {

                            if($delta > 1) {
                                $lastParentId = $element['id'];
                                
	                            $link[$key] = $element;
		                        $link[$key]['children'] = array();
		                        $link = &$link[$key]['children'];
	                        } else {
		                        $link[$element['lft']] = $element;
		                        $link = &$link;		                    
	                        }	
			                break;
		                }
		                
	                }
		            
	            }	            
            }
               
            $parentArray[$element['level']]['id'] = $element['id'];
            $parentArray[$element['level']]['lft'] = $element['lft'];           

        }
        return $branch;
    }



    /*
	 ** numbered nested list 
    */

    function __setNumbered($data, $type = null)
    {
	    return ['body_html' => $this->__numberedList($data, 'linear'), 'body_s' => $this->dataOriginal];
    }

    function __numberedList($data, $type = null) {
        if($type == 'linear') {
	        $nestedData = $this->buildTree($data);
	        foreach($data as $row) {
		        $this->linearData[$row['id']] = $row;
	        }
	        
        } else {
	        $nestedData = $data;
        }

        $key = 1;
        foreach($nestedData as $key_original => &$row) {
            if($row['parent_id'] == null) {
	            $this->linearData[$row['id']]['prefix'] = $key;
	            $prefix = $key;
	            $this->outData .= '<p class="parentNested" style="text-align: center;text-transform: uppercase;"><b>'.$prefix.' '.$row['text'].'</b></p>';

	            $this->dataOriginal[$key_original] = $row;
	            $this->dataOriginal[$key_original]['text'] = '<b>' .$row['text']. '</b>';
	            $this->dataOriginal[$key_original]['prefix'] = $prefix;
	            unset($this->dataOriginal[$key_original]['children']);

            } else {
                $this->linearData[$row['id']]['prefix'] = $this->linearData[$row['parent_id']]['prefix'].'.'.$key;
	            $prefix = $this->linearData[$row['parent_id']]['prefix'].'.'.$key; 
	            $this->outData .= '<p class="childNested"><b>'.$prefix.'</b> '.$row['text'].'</p>';   

	            $this->dataOriginal[$key_original] = $row;
	            $this->dataOriginal[$key_original]['text'] = $row['text'];
	            $this->dataOriginal[$key_original]['prefix'] = $prefix;
	            unset($this->dataOriginal[$key_original]['children']);

            }

	        if(isset($row['children'])) {
	            if($row['children']) {
		            $this->__numberedList($row['children']);
	            }
	        }
	        
	        $key++;
        }

        return $this->outData;
    }




}
