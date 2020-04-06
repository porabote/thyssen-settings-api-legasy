<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class MenusController extends AppController
{

    public function index()
    {

    }

    public function getAll()
    {
        $list = $this->Menus->find()
            ->order(['Menus.id' => 'ASC']);

        $resetedList = [];
        foreach($list as $item) $resetedList[$item['id']] = $item;
        $this->__outputJSON($resetedList);
    }

    public function getList()
    {
        $list = $this->Menus->find('list', [
            'keyField' => 'className',
            'valueField' => 'title'
        ])
            ->order(['Settings.title' => 'ASC']);

        $this->__outputJSON(['list' => $list]);

    }

    public function add($id = null)
    {
        $this->viewBuilder()->setLayout('default_html');

        if(!$id) $entity = $this->Menus->newEntity();
        else $entity = $this->Menus->get($id);

        $this->set('parentList',$this->Menus->find('treeList'));
        $this->set('settingsList', TableRegistry::get('Settings')->find('list', [
            'keyField' => 'className'
        ]));
        $this->set(compact('entity'));

        if ($this->request->getData()) {
            debug($this->request->getData());
            $this->Menus->save($this->Menus->newEntity($this->request->getData()));
        }
    }
}