<?php
namespace Modules\OnlineTransaction\Config;

class Validation
{
    public $search_validation = [
        'key' => [
            'label' => 'Key',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select key'
            ],
        ],
        'value' => [
            'label' => 'Value',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter value',
            ],
        ],
        'from_date' => [
            'label' => 'From Date',
            'rules' => 'trim',
            'errors' => [],
        ],
        'to_date' => [
            'label' => 'To Date',
            'rules' => 'trim',
            'errors' => [],
        ],
    ];

    public $transaction_status = [

        'payment_status' => [
            'label' => 'Status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select status'
            ],
        ],
        'web_partner_remark' => [
            'label' => 'remark',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter remark'
            ],
        ],

    ];
    public $transaction_update_remark_status = [ 
        'web_partner_remark' => [
            'label' => 'remark',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please enter remark'
            ],
        ],

    ];
}
