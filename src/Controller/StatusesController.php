<?php
namespace App\Controller;

use App\Controller\AppController;

class StatusesController extends AppController
{

    public function getAll()
    {
        $list = $this->Statuses->find()
            ->order(['Statuses.id' => 'ASC']);

        $resetedList = [];
        foreach($list as $item) $resetedList[$item['id']] = $item;
        $this->__outputJSON($resetedList);
    }

    public function getList()
    {
        $list = $this->Statuses->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])
            ->order(['Statuses.id' => 'ASC']);

        $this->__outputJSON($list);
    }

}