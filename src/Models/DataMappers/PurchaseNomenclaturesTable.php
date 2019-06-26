<?php
namespace App\Models\DataMappers;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PurchaseNomenclaturesTable //extends Table 
{

    public $check_list = [
	    'name' => [ 'rules' => [ 'notEmpty' ] ]      
    ];

    public $contain_map = [
	    'manager_id' => [
            'leftJoin' => 'Managers',
            'pattern' => '{{manager.full_name}}'
	    ],
	    'unit_id' => [
		    'leftJoin' => 'Units',
	        'pattern' => '{{unit.rus_name1}}'
	    ],
	    'status_id' => [
		    'leftJoin' => 'Statuses',
	        'pattern' => '{{status.name}}'
	    ],
	    'transport_company_address_id' => [
		    'leftJoin' => [
		        'Addresses' =>  ['Contractors']
		    ],
	        'pattern' => '{{address.contractor.name}} - {{address.name}}',  
	    ]	    
    ];



	public $links = [
	    'fields' => [
		    'request_id' => [
			    'href' => '/purchaseRequest/view/{{record.request_id}}/',
			    'class' => 'list-grid__link request',
			    'check' => false
		    ],
		    'bill_id' => [
			    'href' => '/docs/contractExtantions/view/{{record.bill_id}}/',
			    'class' => 'list-grid__link bill',
			    'check' => false
		    ]		    
	    ],
	    'drop_panel' => [
		    [
			    'title' => 'Просмотр',
			    'href' => '/purchaseNomenclatures/view/{{record.id}}/',
			    'class' => 'drop-button__hide-blok__link',
			    'check' => false
		    ]		    
	    ],
	    'checkbox_panel' => [
		    'primaryKey' => 'id',
		    'selects' => [ 
		        [			    
                    'id' => 'checkboxPanelSelectPN', 
                    'name' => 'parent_id',
                    'label' => 'Действия с выделенным',
                    'options' => [
	                    '/purchaseNomenclatures/setPurchaseParams/' => 'Указать данные поставки'
                    ],
                    'data-params' => '{ 
	                    "model" : "PurchaseNomenclatures"
                    }',
                    'data-action' => '{ 
	                    "action" : "PurchaseNomenclatures.indexHandle"
                    }',
                    'class' => 'on-select__finder',
                    'escape' => false,
                    'empty' => 'Не выбрано',
                    'type' => 'select'
		        ]
		    ]
		    
	    ]
	];


}
