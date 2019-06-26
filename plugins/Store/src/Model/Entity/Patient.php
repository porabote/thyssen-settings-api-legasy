<?php
namespace Laboratory\Model\Entity;

use Cake\ORM\Entity;

class Patient extends Entity {

    protected $_accessible = [
        '*' => true
    ];


    protected $_virtual = ['full_name'];

    protected function _getFullName()
    {
        return $this->_properties['last_name']. ' ' .$this->_properties['name'].' '.$this->_properties['middle_name'];
    }
}
