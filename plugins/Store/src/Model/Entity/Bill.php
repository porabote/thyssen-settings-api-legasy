<?php
namespace Store\Model\Entity;

use Cake\ORM\Entity;

class Bill extends Entity {

    protected $_accessible = [
        '*' => true
    ];


    protected $_virtual = ['full_name'];

    protected function _getFullName()
    {
        return $this->_properties['last_name']. ' ' .$this->_properties['name'].' '.$this->_properties['middle_name'];
    }
}
