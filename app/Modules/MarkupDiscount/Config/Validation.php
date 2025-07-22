<?php

namespace Modules\MarkupDiscount\Config;


class Validation
{



    public $status = [

        'status' => [
            'label' => 'status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select status'
            ],
        ],
    ];



    public $visa_markup_validation = [

        'visa_country_id' => [
            'label' => 'country ',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select country'

            ],
        ],

        'visa_type_id.*' => [
            'label' => 'visa type id',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select visa type'

            ],
        ],

        'web_partner_class_id.*' => [
            'label' => 'web partner class',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select web partner class'
            ],
        ],

        'value' => [
            'label' => 'value',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter value'
            ],
        ],

        'max_limit' => [
            'label' => 'max limit',
            'rules' => 'trim|permit_empty|numeric',
        ],

        'display_markup' => [
            'label' => ' display markup',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  display markup'
            ],
        ],

        'markup_type' => [
            'label' => 'markup type',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select markup type'
            ],
        ],

        'status' => [
            'label' => ' Status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  status'
            ],
        ],
    ];

    public $visa_discount_validation = [

        'visa_country_id' => [
            'label' => 'country ',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select country'

            ],
        ],

        'visa_type_id.*' => [
            'label' => 'visa type id',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select visa type'

            ],
        ],

        'web_partner_class_id.*' => [
            'label' => 'web partner class',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select web partner class'
            ],
        ],

        'value' => [
            'label' => 'value',
            'rules' => 'trim|required|numeric',
            'errors' => [
                'required' => 'Please enter value'
            ],
        ],

        'max_limit' => [
            'label' => 'max limit',
            'rules' => 'trim|permit_empty|numeric',
        ],



        'discount_type' => [
            'label' => 'discount type',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select discount type'
            ],
        ],

        'status' => [
            'label' => ' Status',
            'rules' => 'trim|required',
            'errors' => [
                'required' => 'Please select  status'
            ],
        ],
    ];




}

